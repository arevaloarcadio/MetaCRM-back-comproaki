<?php

declare(strict_types = 1);

namespace Hexa\Organizations\Application\Get;

use function \Lambdish\Phunctional\map;
use Hexa\Organizations\Domain\OrganizationRepository;
use Hexa\Organizations\Application\{ OrganizationResponse, OrganizationsResponse };

final class OrganizationGet
{
    private $repository;

    public function __construct(OrganizationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function get($id): OrganizationsResponse
    {
        return new OrganizationsResponse(...map($this->toResponse(), $this->repository->get($id)));
    }

    private function toResponse(): callable
    {
        return static function ($organization) {
            return new OrganizationResponse($organization['id'], $organization['parent_id'],$organization['above_id'], $organization['user_id'], $organization['level'], $organization['host_id'], $organization['user'], $organization['parent'], $organization['host']);
        };
    }
}
