<?php

declare(strict_types = 1);

namespace Hexa\Organizations\Application\GetSubordinate;

use Hexa\Shared\Domain\Bus\Query\QueryHandler;
use Hexa\Organizations\Application\OrganizationsSubordinateResponse;

final class GetSubordinateOrganizationQueryHandler implements QueryHandler
{
    private $searcher;

    public function __construct(OrganizationGetSubordinate $searcher)
    {
        $this->searcher = $searcher;
    }

    public function __invoke(GetSubordinateOrganizationQuery $query): OrganizationsSubordinateResponse
    {
        return $this->searcher->getSubordinate($query->user_ids(),$query->unit_id());
    }
}
