<?php

declare(strict_types = 1);

namespace Hexa\Organizations\Application\SearchAll;

use Hexa\Shared\Domain\Bus\Query\QueryHandler;
use Hexa\Organizations\Application\OrganizationsResponse;

final class SearchAllOrganizationsQueryHandler implements QueryHandler
{
    private $searcher;

    public function __construct(AllOrganizationsSearcher $searcher)
    {
        $this->searcher = $searcher;
    }

    public function __invoke(SearchAllOrganizationsQuery $query): OrganizationsResponse
    {
        return $this->searcher->searchAll();
    }
}
