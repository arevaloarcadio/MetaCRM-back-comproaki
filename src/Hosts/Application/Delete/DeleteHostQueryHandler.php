<?php

declare(strict_types = 1);

namespace Hexa\Hosts\Application\Delete;

use Hexa\Hosts\Application\HostResponse;
use Hexa\Hosts\Domain\{ HostNotExist, HostRepository };
use Hexa\Shared\Domain\Bus\Query\QueryHandler;

final class DeleteHostQueryHandler implements QueryHandler
{
    private $repository;

    public function __construct(HostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DeleteHostQuery $query): void
    {
        $host = $this->repository->find($query->id());

        $this->ensureHostExists($query->id(), $host);

        $this->repository->delete($query->id());
    }

    private function ensureHostExists($id, $host)
    {
        if ( null === $host ) throw new HostNotExist($id);
    }
}

