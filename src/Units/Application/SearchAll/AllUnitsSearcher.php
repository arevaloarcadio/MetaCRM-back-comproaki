<?php

declare(strict_types = 1);

namespace Hexa\Units\Application\SearchAll;

use function \Lambdish\Phunctional\map;
use Hexa\Units\Domain\UnitRepository;
use Hexa\Units\Application\{ UnitResponse, UnitsResponse };

final class AllUnitsSearcher
{
    private $repository;

    public function __construct(UnitRepository $repository)
    {
        $this->repository = $repository;
    }

    public function searchAll($user_id): UnitsResponse
    {
        return new UnitsResponse(...map($this->toResponse(), $this->repository->searchAll($user_id)));
    }

    private function toResponse(): callable
    {
        return static function ($unit) {
            return new UnitResponse($unit['id'], $unit['name']);
        };
    }
}
