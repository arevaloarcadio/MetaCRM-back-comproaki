<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Hexa\Users\Domain\UserNotExist;
use Hexa\Users\Application\Find\FindUserQuery;
use Hexa\Users\Application\Delete\DeleteUserQuery;
use Hexa\Users\Application\Create\CreateUserQuery;
use Hexa\Users\Application\CreateAuthProvider\CreateAuthProviderUserQuery;
use Hexa\Users\Application\Update\UpdateUserCommand;
use Hexa\Hosts\Application\FindByName\FindByNameHostQuery;
use Hexa\Users\Application\SearchAll\SearchAllUsersQuery;
use Hexa\Users\Application\SearchNoParent\SearchNoParentUsersQuery;
use Hexa\Users\Application\SearchByHostAll\SearchByHostAllUsersQuery;
use Hexa\Users\Application\Search\SearchUserQuery;
use Hexa\Users\Application\Update\UpdateUserPasswordCommand;
use Hexa\Users\Application\Update\UpdateUserImageCommand;
use Hexa\Timelines\Application\Create\CreateTimelineCommand;
use Hexa\Users\Application\Update\UpdateUserActiveCommand;
use Hexa\Shared\Infrastructure\Api\Controller\BaseController;
use Hexa\Organizations\Application\Create\CreateOrganizationCommand;
use App\Http\Requests\Users\{ 
    UserActivePutRequest,
    UserPutRequest,
    UserGetRequest, 
    UserPostRequest, 
    UserPasswordPutRequest,
    UserImagePutRequest,
    UserAuthProviderPostRequest 
};

class UserController extends BaseController
{

    protected function exceptions(): array
    {
        return [
            UserNotExist::class => Response::HTTP_NOT_FOUND,
        ];
    }

    public function all(Request $request)
    {   
        $response = $this->ask(new SearchAllUsersQuery());
        return response()->json($response->users());
    }

    public function byHost(Request $request)
    {   
        $host_id = $request->host_id;
        $response = $this->ask(new SearchByHostAllUsersQuery($host_id));
        return response()->json($response->users());
    }

    public function noParent(Request $request)
    {   
        $host_id = $request->host_id;
        $response = $this->ask(new SearchNoParentUsersQuery($host_id));
        return response()->json($response->users());
    }

    public function create(UserPostRequest $request)
    {
        $validated = $request->validated();
        
        $user = $this->ask(
            new CreateUserQuery(
                $validated['firstname'],
                $validated['lastname'],
                $validated['email'],
                Hash::make($validated['password'])
            )
        );  
        
        $response = $this->ask(new FindByNameHostQuery($request->header('Domain')));

        $command_organization = new CreateOrganizationCommand(
            null,
            null,
            $user->id,
            1,
            $response->id
        );

        $this->execute($command_organization);

        return response()
            ->json([
                'message' => 'User created successfully!', 
                'user' => $user 
            ], Response::HTTP_CREATED);
    }

    public function createAuthProvider(UserAuthProviderPostRequest $request)
    {
        $validated = $request->validated();
        
        $user = $this->ask(
            new CreateAuthProviderUserQuery(
                $validated['firstname'],
                $validated['lastname'],
                $validated['email'],
                $validated['auth_provider']
            )
        );
        
        $response = $this->ask(new FindByNameHostQuery($request->header('Domain')));

        $command_organization = new CreateOrganizationCommand(
            null,
            null,
            $user->id,
            1,
            $response->id
        );

        $this->execute($command_organization);
        
        return response()
            ->json([
                'message' => 'User created successfully!', 
                'user' => $user 
            ], Response::HTTP_CREATED);
    }

    public function find(int $id)
    {
        $response = $this->ask(new FindUserQuery($id));
        return response()->json($response);
    }

    public function update(UserPutRequest $request, int $userId)
    {
        $validated = $request->validated();

        $command = new UpdateUserCommand(
            $userId,
            $validated['firstname'],
            $validated['lastname'],
            $validated['email']
        );

        $this->execute($command);

        return response()
            ->json(['message' => 'User updated successfully!'], Response::HTTP_OK);
    }

    public function updateActive(UserActivePutRequest $request, int $userId)
    {
        $validated = $request->validated();

        $command = new UpdateUserActiveCommand(
            $userId,
            $validated['active']
        );

        $this->execute($command);
        
        $response = $this->ask(new FindUserQuery($userId));
        
        $user = json_decode(json_encode($response), true);

        return response()
            ->json(['message' => 'User '.($validated['active'] ?  'enable' : 'disabled').' successfully!'], Response::HTTP_OK);
    }

    public function updateImage(UserImagePutRequest $request, int $userId)
    {
        $validated = $request->validated();
 
        $file = $request->file('image');
        $image = $file->getClientOriginalName();
        $destinationPath = public_path('/img/profiles/');
        $move = $file->move($destinationPath, $image);
     
        $command = new UpdateUserImageCommand(
            $userId,
            $image 
        );

        $this->execute($command);

        return response()
            ->json(['message' => 'User Imagen upload successfully!'], Response::HTTP_OK);
    }

    public function updatePassword(UserPasswordPutRequest $request, int $userId)
    {
        $validated = $request->validated();

        $command = new UpdateUserPasswordCommand(
            $userId,
            Hash::make($validated['password'])
        );

        $this->execute($command);

        return response()
            ->json(['message' => 'Password updated successfully!'], Response::HTTP_OK);
    }

    public function delete(int $id)
    {
        $response = $this->ask(new DeleteUserQuery($id));

        return response()
            ->json(['message' => 'User deleted successfully'], Response::HTTP_OK);
    }
}
