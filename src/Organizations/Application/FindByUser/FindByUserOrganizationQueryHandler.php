<?php

declare(strict_types = 1);

namespace Hexa\Organizations\Application\FindByUser;

use Hexa\Shared\Domain\Bus\Query\QueryHandler;
use Hexa\Organizations\Application\OrganizationsResponse;

final class FindByUserOrganizationQueryHandler implements QueryHandler
{
    private $searcher;

    public function __construct(OrganizationFindByUser $searcher)
    {
        $this->searcher = $searcher;
    }

    public function __invoke(FindByUserOrganizationQuery $query): OrganizationsResponse
    {
        return $this->searcher->findByUser($query->id());
    }
}