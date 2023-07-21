<?php

declare(strict_types = 1);

namespace Hexa\Hosts\Application\Find;

use Hexa\Hosts\Application\HostResponse;
use Hexa\Hosts\Domain\{ HostNotExist, HostRepository };
use Hexa\Shared\Domain\Bus\Query\QueryHandler;

final class FindHostQueryHandler implements QueryHandler
{
    private $repository;

    public function __construct(HostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FindHostQuery $query): HostResponse
    {
        $host = $this->repository->find($query->id());

        $this->ensureHostExists($query->id(), $host);

        return new HostResponse(
            $host->id(),
            $host->domain()
        );
    }

    private function ensureHostExists($id, $host)
    {
        if ( null === $host ) throw new HostNotExist($id);
    }
}

