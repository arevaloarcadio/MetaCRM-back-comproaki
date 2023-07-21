<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Hexa\Shared\Infrastructure\Api\Controller\BaseController;
use Hexa\PassowrResetss\Domain\PasswordResetNotExist;
use App\Http\Requests\PasswordReset\{PasswordResetCodePostRequest,PasswordResetPostRequest};
use Hexa\PasswordResets\Application\Create\CreatePasswordResetQuery;
use Hexa\PasswordResets\Application\Find\FindPasswordResetQuery;
use Hexa\PasswordResets\Application\Delete\DeletePasswordResetQuery;
use Hexa\Users\Application\Find\FindUserQuery;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RecoveryPassword;
use Symfony\Component\HttpFoundation\Response;
use Hexa\Users\Application\FindByEmail\FindByEmailUserQuery;
use Hexa\Users\Application\Update\UpdateUserPasswordCommand;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends BaseController
{
    protected function exceptions(): array
    {
        return [
            PasswordResetNotExist::class => Response::HTTP_NOT_FOUND,
        ];
    }

    public function create(PasswordResetPostRequest $request)
    {
		$validated = $request->validated();
	
        $password_reset = $this->ask(new CreatePasswordResetQuery($validated['email'],random_int(100000,999999)));

        Notification::route('mail',$validated['email'])
                    ->notify(new RecoveryPassword($password_reset->token));

        return response()
            ->json(['result' => 'Password Reset created successfully'], Response::HTTP_CREATED);
    }

    public function recovery(PasswordResetCodePostRequest $request)
    {
        $validated = $request->validated();
    
        $password_reset = $this->ask(new FindPasswordResetQuery($validated['token']));

        $user = $this->ask(new FindByEmailUserQuery($password_reset->email));
        
        $command = new UpdateUserPasswordCommand($user->id,Hash::make($validated['password']));

        $this->execute($command);
        
        $this->ask(new DeletePasswordResetQuery($user->email));

        return response()
            ->json(['result' => 'Password reseted successfully'], Response::HTTP_OK);
    }

}
