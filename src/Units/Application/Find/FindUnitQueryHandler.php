<?php

declare(strict_types = 1);

namespace Hexa\Units\Application\Find;

use Hexa\Units\Application\UnitResponse;
use Hexa\Units\Domain\{ UnitNotExist, UnitRepository };
use Hexa\Shared\Domain\Bus\Query\QueryHandler;

final class FindUnitQueryHandler implements QueryHandler
{
    private $repository;

    public function __construct(UnitRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FindUnitQuery $query): UnitResponse
    {
        $unit = $this->repository->find($query->id());

        $this->ensureUnitExists($query->id(), $unit);

        return new UnitResponse(
            $unit->id(),
            $unit->name()
        );
    }

    private function ensureUnitExists($id, $unit)
    {
        if ( null === $unit ) throw new UnitNotExist($id);
    }
}

