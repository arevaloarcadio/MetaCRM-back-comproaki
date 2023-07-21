<?php

declare(strict_types = 1);

namespace Hexa\Organizations\Application\GetParent;

use Hexa\Organizations\Application\OrganizationResponse;
use Hexa\Organizations\Domain\{ OrganizationNotExist, OrganizationRepository };
use Hexa\Shared\Domain\Bus\Query\QueryHandler;

final class GetParentOrganizationQueryHandler implements QueryHandler
{
    private $repository;

    public function __construct(OrganizationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetParentOrganizationQuery $query): OrganizationResponse
    {
        $organization = $this->repository->getParent($query->user_id(),$query->unit_id());
       
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

