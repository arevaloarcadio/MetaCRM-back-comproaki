<?php

namespace Hexa\Units\Application\Update;

use Hexa\Shared\Domain\Bus\Command\CommandHandler;
use Hexa\Units\Domain\{ Unit, UnitRepository };

final class UpdateUnitCommandHandler implements CommandHandler
{
    private $repository;

    public function __construct(UnitRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UpdateUnitCommand $command)
    {
        $unit = Unit::update(
            $command->id(),
            $command->name()
        );

        $this->repository->update($unit);
    }
}
