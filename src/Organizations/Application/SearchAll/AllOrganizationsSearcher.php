<?php

declare(strict_types = 1);

namespace Hexa\Organizations\Application\SearchAll;

use function \Lambdish\Phunctional\map;
use Hexa\Organizations\Domain\OrganizationRepository;
use Hexa\Organizations\Application\{ OrganizationResponse, OrganizationsResponse };

final class AllOrganizationsSearcher
{
    private $repository;

    public function __construct(OrganizationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function searchAll(): OrganizationsResponse
    {
        return new OrganizationsResponse(...map($this->toResponse(), $this->repository->searchAll()));
    }

    private function toResponse(): callable
    {
        return static function ($organization) {
            return new OrganizationResponse($organization['id'], $organization['parent_id'],$organization['above_id'], $organization['user_id'], $organization['level'], $organization['unit_id']);
        };
    }
}
