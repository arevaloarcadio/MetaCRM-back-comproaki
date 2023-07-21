<?php

declare(strict_types = 1);

namespace Hexa\Users\Application\SearchByHostAll;

use Hexa\Shared\Domain\Bus\Query\QueryHandler;
use Hexa\Users\Application\UsersResponse;

final class SearchByHostAllUsersQueryHandler implements QueryHandler
{
    private $searcher;

    public function __construct(ByHostAllUsersSearcher $searcher)
    {
        $this->searcher = $searcher;
    }

    public function __invoke(SearchByHostAllUsersQuery $query): UsersResponse
    {
        return $this->searcher->searchByHostAll($query->host_id());
    }
}
