<?php

declare(strict_types = 1);

namespace Hexa\Organizations\Application\Find;

use Hexa\Organizations\Application\OrganizationResponse;
use Hexa\Organizations\Domain\{ OrganizationNotExist, OrganizationRepository };
use Hexa\Shared\Domain\Bus\Query\QueryHandler;

final class FindOrganizationQueryHandler implements QueryHandler
{
    private $repository;

    public function __construct(OrganizationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FindOrganizationQuery $query): OrganizationResponse
    {
        $organization = $this->repository->find($query->id());

        $this->ensureOrganizationExists($query->id(), $organization);

        return new OrganizationResponse(
            $organization->id(),
            $organization->parent_id(),
            $organization->above_id(),
            $organization->user_id(),
            $organization->level(),
            $organization->unit_id()
        );
    }

    private function ensureOrganizationExists($id, $organization)
    {
        if ( null === $organization ) throw new OrganizationNotExist($id);
    }
}

