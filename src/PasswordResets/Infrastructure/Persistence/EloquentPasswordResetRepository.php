<?php

declare(strict_types = 1);

namespace Hexa\PasswordResets\Infrastructure\Persistence;

use Hexa\PasswordResets\Domain\{ PasswordReset, PasswordResetRepository};
use App\Models\PasswordReset as PasswordResetEloquentModel;

final class EloquentPasswordResetRepository implements PasswordResetRepository
{
    public function save(PasswordReset $password_reset): ?PasswordReset
    {
        $model = new PasswordResetEloquentModel;
        $model->token  = $password_reset->token();
        $model->email  = $password_reset->email();
        $model->save();

        return new PasswordReset(
            $model->email,
            $model->token,
        );
    }

    public function find(string $token): ?PasswordReset
    {
        $model = PasswordResetEloquentModel::where('token',$token)->first();

        if( null === $model ) return null;

        return new PasswordReset(
            $model->email,
            $model->token,
        );
    }


    public function findByEmail(string $email): ?PasswordReset
    {
        $model = PasswordResetEloquentModel::where('email',$email)->first();

        if( null === $model ) return null;

        return new PasswordReset(
            $model->email,
            $model->token,
        );
    }

    public function delete(string $email): void
    {
        PasswordResetEloquentModel::where('email',$email)->delete();
    }
}
