<?php

declare(strict_types = 1);

namespace Hexa\Hosts\Application\SearchAll;

use function \Lambdish\Phunctional\map;
use Hexa\Hosts\Domain\HostRepository;
use Hexa\Hosts\Application\{ HostResponse, HostsResponse };

final class AllHostsSearcher
{
    private $repository;

    public function __construct(HostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function searchAll(): HostsResponse
    {
        return new HostsResponse(...map($this->toResponse(), $this->repository->searchAll()));
    }

    private function toResponse(): callable
    {
        return static function ($host) {
            return new HostResponse($host['id'], $host['domain']);
        };
    }
}
