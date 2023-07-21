<?php

declare(strict_types = 1);

namespace Hexa\Hosts\Application\FindByName;

use Hexa\Hosts\Application\HostResponse;
use Hexa\Hosts\Domain\{ HostNotExist, HostRepository };
use Hexa\Shared\Domain\Bus\Query\QueryHandler;

final class FindByNameHostQueryHandler implements QueryHandler
{
    private $repository;

    public function __construct(HostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FindByNameHostQuery $query): HostResponse
    {
        $host = $this->repository->findByName($query->name());

        $this->ensureHostExists($query->name(), $host);

        return new HostResponse(
            $host->id(),
            $host->domain()
        );
    }

    private function ensureHostExists($name, $host)
    {
        if ( null === $host ) throw new HostNotExist($name);
    }
}

