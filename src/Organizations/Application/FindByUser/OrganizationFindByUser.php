<?php

declare(strict_types = 1);

namespace Hexa\Organizations\Application\FindByUser;

use function \Lambdish\Phunctional\map;
use Hexa\Organizations\Domain\OrganizationRepository;
use Hexa\Organizations\Application\{ OrganizationResponse, OrganizationsResponse };

final class OrganizationFindByUser
{
    private $repository;

    public function __construct(OrganizationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findByUser($id): OrganizationsResponse
    {
        return new OrganizationsResponse(...map($this->toResponse(), $this->repository->findByUser($id)));
    }

    private function toResponse(): callable
    {
        return static function ($organization) {
            return new OrganizationResponse($organization['id'], $organization['parent_id'],  $organization['above_id'],$organization['user_id'], $organization['level'], $organization['unit_id'], $organization['user'], $organization['parent'], $organization['unit']);
        };
    }
}
