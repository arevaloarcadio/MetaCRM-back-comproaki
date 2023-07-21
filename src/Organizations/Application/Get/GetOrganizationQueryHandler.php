<?php

declare(strict_types = 1);

namespace Hexa\Organizations\Application\Get;

use Hexa\Shared\Domain\Bus\Query\QueryHandler;
use Hexa\Organizations\Application\OrganizationsResponse;

final class GetOrganizationQueryHandler implements QueryHandler
{
    private $searcher;

    public function __construct(OrganizationGet $searcher)
    {
        $this->searcher = $searcher;
    }

    public function __invoke(GetOrganizationQuery $query): OrganizationsResponse
    {
        return $this->searcher->get($query->host_id());
    }
}
