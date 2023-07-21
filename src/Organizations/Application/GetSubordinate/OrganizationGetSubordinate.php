<?php

declare(strict_types = 1);

namespace Hexa\Organizations\Application\GetSubordinate;

use function \Lambdish\Phunctional\map;
use Hexa\Organizations\Domain\OrganizationRepository;
use Hexa\Organizations\Application\{ OrganizationSubordinateResponse, OrganizationsSubordinateResponse };

final class OrganizationGetSubordinate
{
    private $repository;

    public function __construct(OrganizationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getSubordinate($user_ids,$unit_id): OrganizationsSubordinateResponse
    {
        return new OrganizationsSubordinateResponse(...map($this->toResponse(), $this->repository->getSubordinate($user_ids,$unit_id)));
    }

    private function toResponse(): callable
    {
        return static function ($organization) {
            return new OrganizationSubordinateResponse($organization['id']);
        };
    }
}
