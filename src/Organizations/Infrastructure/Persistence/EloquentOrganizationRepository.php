<?php

declare(strict_types = 1);

namespace Hexa\Organizations\Infrastructure\Persistence;

use Hexa\Organizations\Domain\{ Organization, OrganizationRepository};
use App\Models\Organization as OrganizationEloquentModel;

final class EloquentOrganizationRepository implements OrganizationRepository
{
    public function save(Organization $organization): void
    {
        $model = new OrganizationEloquentModel;
        $model->parent_id = $organization->parent_id();
        $model->above_id = $organization->above_id();
        $model->user_id = $organization->user_id();
        $model->level = $organization->level();
        $model->host_id = $organization->host_id();

        $model->save();
    }

    public function find(int $id): ?Organization
    {
        $model = OrganizationEloquentModel::find($id);

        if( null === $model ) return null;

        return new Organization($model->id, $model->parent_id,$model->above_id, $model->user_id, $model->level, $model->host_id);
    }

    public function update(Organization $organization): ?Organization
    {
        $model = OrganizationEloquentModel::find($organization->id());

        $model->parent_id = $organization->parent_id();
        $model->above_id = $organization->above_id();
        $model->user_id = $organization->user_id();
        $model->level = $organization->level();
        $model->host_id = $organization->host_id();

        $model->save();

        if( null === $model ) return null;

        return new Organization($model->id, $model->parent_id,$model->above_id, $model->user_id, $model->level, $model->host_id);
    }

    public function searchAll(): array
    {
        return OrganizationEloquentModel::all()->toArray();
    }

    public function get(int $host_id): array
    {
        return OrganizationEloquentModel::where('host_id', $host_id)
            ->where('parent_id','!=', null)
            ->with(['user','parent','host'])
            ->get()
            ->toArray();
    }

    

    public function getSubordinate(array $user_ids,int $host_id): array
    {
        return OrganizationEloquentModel::select('users.id')
                                        ->join('users','users.id','organizations.user_id')
                                        ->where('organizations.host_id', $host_id)
                                        ->whereIn('organizations.above_id',$user_ids)
                                        ->get()
                                        ->toArray();
    }

    public function getParent(int $user_id,int $host_id): ?Organization
    {
        $model = OrganizationEloquentModel::select('organizations.*')
                                        ->join('users','users.id','organizations.user_id')
                                        ->where('organizations.host_id', $host_id)
                                        ->where('organizations.user_id',$user_id)
                                        ->where('parent_id','!=', null)
                                        ->first();

        return new Organization($model->id, $model->parent_id,$model->above_id, $model->user_id, $model->level, $model->host_id);
    }

    public function findByUser(int $id): array
    {
        return OrganizationEloquentModel::where('user_id', $id)->with(['user','parent','host'])->get()->toArray();
    }

    public function delete(int $id): void
    {
        OrganizationEloquentModel::destroy($id);
    }
}
