<?php

declare(strict_types = 1);

namespace Hexa\Users\Infrastructure\Persistence;

use Hexa\Users\Domain\{ User, UserRepository};
use App\Models\User as UserEloquentModel;
use Log;

final class EloquentUserRepository implements UserRepository
{
    public function save(User $user): ?User
    {
        $model = new UserEloquentModel;
        $model->firstname = $user->firstname();
        $model->lastname  = $user->lastname();
        $model->email     = $user->email();
        $model->password  = $user->password();
        $model->image     = '/storage/profiles/default.png';
        $model->admin     = false;
        $model->active    = true;
        $model->save();

        return new User(
            $model->id,
            $model->firstname,
            $model->lastname,
            $model->email,
            $model->password,
            $model->image,
            $model->admin,
            $model->active,
            $model->auth_provider 
        );
    }

    public function saveAuthProvider(User $user): ?User
    {
        $model = new UserEloquentModel;
        $model->firstname = $user->firstname();
        $model->lastname  = $user->lastname();
        $model->email     = $user->email();
        $model->password  = null;
        $model->auth_provider = $user->auth_provider();
        $model->image     = '/storage/profiles/default.png';
        $model->admin     = false;
        $model->active    = true;
        $model->save();

        return new User(
            $model->id,
            $model->firstname,
            $model->lastname,
            $model->email,
            $model->password,
            $model->image,
            $model->admin,
            $model->active,
            $model->auth_provider 
        );
    }

    public function find(int $id): ?User
    {
        $model = UserEloquentModel::find($id);

        if( null === $model ) return null;

        return new User(
            $model->id,
            $model->firstname,
            $model->lastname,
            $model->email,
            $model->password,
            $model->image,
            $model->admin,
            $model->active,
            $model->auth_provider  
        );
    }

    public function findByEmail(string $email): ?User
    {
        $model = UserEloquentModel::where('email',$email)->first();

        if( null === $model ) return null;

        return new User(
            $model->id,
            $model->firstname,
            $model->lastname,
            $model->email,
            $model->password,
            $model->image,
            $model->admin,
            $model->active,
            $model->auth_provider  
        );
    }
    public function search(string $firstname,string $lastname,string $email): ?User
    {
        $model = UserEloquentModel::where('firstname',$firstname)
                                  ->where('lastname',$lastname)
                                  ->where('email',$email)
                                  ->first();

        if( null === $model ) return null;

        return new User(
            $model->id,
            $model->firstname,
            $model->lastname,
            $model->email,
            $model->password,
            $model->image,
            $model->admin,
            $model->active,
            $model->auth_provider  
        );
    }
    
    public function updatePassword(User $user): void
    {
        $query = UserEloquentModel::query();
        $query->where('id', $user->id());
        $query->update(['password' => $user->password()]);
    }

    public function updateActive(User $user): void
    {
        $query = UserEloquentModel::query();
        $query->where('id', $user->id());
        $query->update([
            'active' => $user->active(),
        ]);
    }

    public function update(User $user): void
    {
        $query = UserEloquentModel::query();
        $query->where('id', $user->id());
        $query->update([
            'firstname' => $user->firstname(),
            'lastname'  => $user->lastname(),
            'email'     => $user->email(),
        ]);
    }

    public function updateImage(User $user): void
    {
        $query = UserEloquentModel::query();
        $query->where('id', $user->id());
        $query->update([
            'image' => $user->image(),
        ]);
    }

    public function searchAll(): array
    {
		return UserEloquentModel::select('users.email','users.firstname','users.id','users.image','users.lastname','users.admin','users.active')
                                ->groupBy('users.email','users.firstname','users.id','users.image','users.lastname','users.admin','users.active')
                                ->get()
                                ->toArray();
    }

    public function searchNoParent($host_id): array
    {	
    	return UserEloquentModel::select('users.email','users.firstname','users.id','users.image','users.lastname','users.admin','users.active','hosts.domain','hosts.id as host_id')
            ->join('organizations','organizations.user_id','users.id')
            ->join('hosts','hosts.id','organizations.host_id')
            //->whereColumn('organizations.parent_id','!=','organizations.user_id')
            ->where('above_id',null)
            ->where('hosts.id',$host_id)
            ->with('organizations')
            ->get()
            ->toArray();
    }

    public function searchByHostAll($host_id = null): array
    {   
        $users = UserEloquentModel::select('users.email','users.firstname','users.id','users.image','users.lastname','users.admin','users.active','hosts.domain','hosts.id as host_id')
            ->join('organizations','organizations.user_id','users.id')
            ->join('hosts','hosts.id','organizations.host_id');
    
        if (!is_null($host_id)) {
            $users = $users->where('organizations.host_id',$host_id);
        }                   
                                
        return $users->groupBy(
                'users.email',
                'users.firstname',
                'users.id',
                'users.image',
                'users.lastname',
                'users.admin',
                'users.active',
                'hosts.domain',
                'hosts.id'
            )
            ->get()
            ->toArray();
    }

    public function delete(int $id): void
    {
        UserEloquentModel::destroy($id);
    }
}
