<?php

declare(strict_types = 1);

namespace Hexa\Units\Infrastructure\Persistence;

use Hexa\Units\Domain\{ Unit, UnitRepository};
use App\Models\Unit as UnitEloquentModel;

final class EloquentUnitRepository implements UnitRepository
{
    public function save(Unit $unit): void
    {
        $model = new UnitEloquentModel;
        $model->name = $unit->name();
        $model->save();
    }

    public function find(int $id): ?Unit
    {
        $model = UnitEloquentModel::find($id);

        if( null === $model ) return null;

        return new Unit($model->id, $model->name, $model->img);
    }

    public function update(Unit $unit): ?Unit
    {
        $model = UnitEloquentModel::find($unit->id());

        $model->name = $unit->name();
        $model->save();

        if( null === $model ) return null;

        return new Unit($model->id, $model->name, $model->img);
    }

    public function searchAll(int $user_id): array
    {
        return UnitEloquentModel::select('units.*')
                                ->join('organizations','organizations.unit_id','units.id')
                                ->where('organizations.user_id',$user_id)
                                ->get()
                                ->toArray();
    }

    public function delete(int $id): void
    {
        UnitEloquentModel::destroy($id);
    }
}
