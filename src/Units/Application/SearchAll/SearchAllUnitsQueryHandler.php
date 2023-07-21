<?php

declare(strict_types = 1);

namespace Hexa\Units\Application\SearchAll;

use Hexa\Shared\Domain\Bus\Query\QueryHandler;
use Hexa\Units\Application\UnitsResponse;

final class SearchAllUnitsQueryHandler implements QueryHandler
{
    private $searcher;

    public function __construct(AllUnitsSearcher $searcher)
    {
        $this->searcher = $searcher;
    }

    public function __invoke(SearchAllUnitsQuery $query): UnitsResponse
    {
        return $this->searcher->searchAll($query->user_id());
    }
}
