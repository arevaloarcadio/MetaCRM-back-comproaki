<?php

declare(strict_types = 1);

namespace Hexa\Users\Application\SearchNoParent;

use Hexa\Shared\Domain\Bus\Query\QueryHandler;
use Hexa\Users\Application\UsersResponse;

final class SearchNoParentUsersQueryHandler implements QueryHandler
{
    private $searcher;

    public function __construct(NoParentUsersSearcher $searcher)
    {
        $this->searcher = $searcher;
    }

    public function __invoke(SearchNoParentUsersQuery $query): UsersResponse
    {
        return $this->searcher->searchNoParent($query->host_id());
    }
}
