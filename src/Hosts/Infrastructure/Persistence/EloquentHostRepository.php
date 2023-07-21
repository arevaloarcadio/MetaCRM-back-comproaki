<?php

declare(strict_types = 1);

namespace Hexa\Hosts\Infrastructure\Persistence;

use Hexa\Hosts\Domain\{ Host, HostRepository};
use App\Models\Host as HostEloquentModel;

final class EloquentHostRepository implements HostRepository
{
    public function save(Host $host): void
    {
        $model = new HostEloquentModel;
        $model->domain = $host->domain();
        $model->save();
    }

    public function find(int $id): ?Host
    {
        $model = HostEloquentModel::find($id);

        if( null === $model ) return null;

        return new Host($model->id, $model->domain);
    }

    public function findByName(string $name): ?Host
    {
        $model = HostEloquentModel::where('domain',$name)->first();

        if( null === $model ) return null;

        return new Host($model->id, $model->domain);
    }

    public function update(Host $host): ?Host
    {
        $model = HostEloquentModel::find($host->id());
        $model->domain = $host->domain();
        $model->save();

        if( null === $model ) return null;

        return new Host($model->id, $model->domain);
    }

    public function searchAll(): array
    {
        return HostEloquentModel::all()->toArray();
    }

    public function delete(int $id): void
    {
        HostEloquentModel::destroy($id);
    }
}
