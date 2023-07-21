<?php

declare(strict_types = 1);

namespace Hexa\Hosts\Application\SearchAll;

use Hexa\Shared\Domain\Bus\Query\QueryHandler;
use Hexa\Hosts\Application\HostsResponse;

final class SearchAllHostsQueryHandler implements QueryHandler
{
    private $searcher;

    public function __construct(AllHostsSearcher $searcher)
    {
        $this->searcher = $searcher;
    }

    public function __invoke(SearchAllHostsQuery $query): HostsResponse
    {
        return $this->searcher->searchAll();
    }
}
