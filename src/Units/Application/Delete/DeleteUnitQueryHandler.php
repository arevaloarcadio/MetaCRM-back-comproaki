<?php

declare(strict_types = 1);

namespace Hexa\Units\Application\Delete;

use Hexa\Units\Application\UnitResponse;
use Hexa\Units\Domain\{ UnitNotExist, UnitRepository };
use Hexa\Shared\Domain\Bus\Query\QueryHandler;

final class DeleteUnitQueryHandler implements QueryHandler
{
    private $repository;

    public function __construct(UnitRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DeleteUnitQuery $query): void
    {
        $unit = $this->repository->find($query->id());

        $this->ensureUnitExists($query->id(), $unit);

        $this->repository->delete($query->id());
    }

    private function ensureUnitExists($id, $unit)
    {
        if ( null === $unit ) throw new UnitNotExist($id);
    }
}

