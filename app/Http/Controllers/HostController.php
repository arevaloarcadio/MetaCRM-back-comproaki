<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Host\HostPostRequest;
use Hexa\Shared\Infrastructure\Api\Controller\BaseController;
use Hexa\Hosts\Domain\HostNotExist;
use Hexa\Hosts\Application\Find\FindHostQuery;
use Hexa\Hosts\Application\Delete\DeleteHostQuery;
use Hexa\Hosts\Application\Update\UpdateHostCommand;
use Hexa\Hosts\Application\Create\CreateHostCommand;
use Hexa\Hosts\Application\SearchAll\SearchAllHostsQuery;

class HostController extends BaseController
{
    protected function exceptions(): array
    {
        return [
            HostNotExist::class => Response::HTTP_NOT_FOUND,
        ];
    }


    public function all()
    {
        $user_id = auth('api')->user()->getAuthIdentifier();
        $response = $this->ask(new SearchAllHostsQuery($user_id));
        return response()->json($response->Hosts());
    }

    public function create(HostPostRequest $request)
    {   
        $validated = $request->validated();

        $command = new CreateHostCommand(
            $validated['name']
        );

        $this->execute($command);

        return response()
            ->json(['result' => 'Host created successfully'], Response::HTTP_CREATED);
    }

    public function update(HostPostRequest $request, int $id)
    {
        $validated = $request->validated();

        $command = new UpdateHostCommand(
            $id,
            $validated['name']
        );

        $this->execute($command);

        return response()
            ->json(['result' => 'Host Update successfully'], Response::HTTP_OK);
    }

    public function find(int $id)
    {
        $response = $this->ask(new FindHostQuery($id));
        return response()->json($response);
    }

    public function delete(int $id)
    {
        $response = $this->ask(new DeleteHostQuery($id));
        return response()
            ->json(['result' => 'Host deleted successfully'], Response::HTTP_OK);
    }
}
