<?php

declare(strict_types = 1);

namespace Hexa\Users\Application\SearchAll;

use Hexa\Shared\Domain\Bus\Query\QueryHandler;
use Hexa\Users\Application\UsersResponse;

final class SearchAllUsersQueryHandler implements QueryHandler
{
    private $searcher;

    public function __construct(AllUsersSearcher $searcher)
    {
        $this->searcher = $searcher;
    }

    public function __invoke(SearchAllUsersQuery $query): UsersResponse
    {
        return $this->searcher->searchAll();
    }
}
