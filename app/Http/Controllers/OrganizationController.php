<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Requests\Organization\OrginizactionPostRequest;
use Hexa\Shared\Infrastructure\Api\Controller\BaseController;
use Hexa\Organizations\Domain\OrganizationNotExist;
use Hexa\Organizations\Application\Find\FindOrganizationQuery;
use Hexa\Organizations\Application\Get\GetOrganizationQuery;
use Hexa\Organizations\Application\GetParent\GetParentOrganizationQuery;
use Hexa\Organizations\Application\GetSubordinate\GetSubordinateOrganizationQuery;
use Hexa\Organizations\Application\FindByUser\FindByUserOrganizationQuery;
use Hexa\Organizations\Application\Delete\DeleteOrganizationQuery;
use Hexa\Organizations\Application\Update\UpdateOrganizationCommand;
use Hexa\Organizations\Application\Create\CreateOrganizationCommand;
use Hexa\Organizations\Application\SearchAll\SearchAllOrganizationsQuery;
use Hexa\Timelines\Application\SearchAll\SearchAllTimelinesQuery;
use App\Models\User;
use Auth;

class OrganizationController extends BaseController
{
    protected function exceptions(): array
    {
        return [
            OrganizationNotExist::class => Response::HTTP_NOT_FOUND,
        ];
    }

    public function all(){
        $response = $this->ask(new SearchAllOrganizationsQuery);
        return response()->json($response->organizations());
    }

    public function create(OrginizactionPostRequest $request)
    {

        $validated = $request->validated();

        $command = new CreateOrganizationCommand(
            $validated['parent_id'],
            $validated['above_id'],
            $validated['user_id'],
            $validated['level'],
            $validated['host_id']
        );

        $this->execute($command);

        return response()
            ->json(['result' => 'Organization created successfully'], Response::HTTP_CREATED);
    }

    public function update(OrginizactionPostRequest $request, int $id)
    {

        $validated = $request->validated();

        $command = new UpdateOrganizationCommand(
            $id,
            $validated['parent_id'],
            $validated['above_id'],
            $validated['user_id'],
            $validated['level'],
            $validated['host_id']
        );

        $this->execute($command);

        return response()
            ->json(['result' => 'Organization Update successfully'], Response::HTTP_OK);
    }

    public function find(int $id)
    {
        $response = $this->ask(new FindOrganizationQuery($id));
        return response()->json($response);
    }

    public function findByUser(int $id)
    {
        $response = $this->ask(new FindByUserOrganizationQuery($id));
        return response()->json($response->organizations());
    }

    public function mine()
    {
        $response = $this->ask(new FindByUserOrganizationQuery(Auth::user()->id));
        return response()->json($response->organizations());
    }

    public function get(int $host_id)
    {
        $response = $this->ask(new GetOrganizationQuery($host_id));
        $organizations_ = json_decode(json_encode($response->organizations()), true);
        $organizations = $this->setNames($organizations_);
        $tree = $this->groupTree($organizations);
        return response()->json($tree);
    }
    
    public function getSubordinates(Request $request, int $user_id,int $unit_id)
    {   $i = 0; 
        $cycle = true;
        $subordinate = [];
        $user_ids = [ 
            'id' => $user_id
        ];

        while ($cycle) {
            
            $response = $this->ask(new GetSubordinateOrganizationQuery($user_ids,$unit_id));

            $user_ids = json_decode(json_encode($response->organizations()), true);

            if(empty($user_ids)){
                $cycle = false;
            }else{
                $user = User::whereIn('id', $user_ids)->get();
                 array_push($subordinate,...$user);
            }
        }
        return response()->json($subordinate);
    }

    public function getParent(Request $request, int $user_id,int $unit_id)
    {   $cycle = true;
        $parent_unit = null;
        $user_id_unit = $user_id;

        while ($cycle) {
            
            $response = $this->ask(new GetParentOrganizationQuery($user_id_unit,$unit_id));
            $parent = json_decode(json_encode($response), true);

            if(is_null($parent['above_id'])){
                $cycle = false;
                $parent_unit = $parent['user_id'];
            }else{
                $user_id_unit = $parent['above_id'];
                $parent_unit = $parent['above_id'];
            }
        }
        return response()->json(['parent_id' => $parent_unit]);
    }

    public function delete(int $id)
    {
        $response = $this->ask(new DeleteOrganizationQuery($id));
        return response()
            ->json(['result' => 'Organization deleted successfully'], Response::HTTP_OK);
    }

    public function setNames($organizations)
    {
        foreach ($organizations as $key => $organization) {
            if (!is_null($organization['user'])) {
                $organizations[$key]['name'] = $organization['user']['firstname'].' '.$organization['user']['lastname'];
                $organizations[$key]['title'] = $organization['user']['email'];
            }
        }
        
        return $organizations;
    }

    public function groupTree($data)
    {
        $grouped = [];

        foreach ($data as $node){
            $grouped[$node['above_id'] == "" ? 0 :$node['above_id']][] = $node;
        }

        $fnBuilder = function($siblings) use (&$fnBuilder, $grouped) {
            foreach ($siblings as $k => $sibling) {
                if (!is_null($sibling['user'])) {
                    $id = $sibling['user']['id'];
                    if(isset($grouped[$id])) {
                        $sibling['children'] = $fnBuilder($grouped[$id]);
                    }
                    $siblings[$k] = $sibling;
                }
            }
            return $siblings;
        };
        
        $tree_data = $fnBuilder($grouped[0]);

        return $tree_data[0];
    }
}
