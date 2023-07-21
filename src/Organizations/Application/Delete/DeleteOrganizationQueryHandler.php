<?php

declare(strict_types = 1);

namespace Hexa\Organizations\Application\Delete;

use Hexa\Organizations\Application\OrganizationResponse;
use Hexa\Organizations\Domain\{ OrganizationNotExist, OrganizationRepository };
use Hexa\Shared\Domain\Bus\Query\QueryHandler;

final class DeleteOrganizationQueryHandler implements QueryHandler
{
    private $repository;

    public function __construct(OrganizationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DeleteOrganizationQuery $query): void
    {
        $task = $this->repository->find($query->id());

        $this->ensureOrganizationExists($query->id(), $task);

        $this->repository->delete($query->id());
    }

    private function ensureOrganizationExists($id, $task)
    {
        if ( null === $task ) throw new OrganizationNotExist($id);
    }
}

