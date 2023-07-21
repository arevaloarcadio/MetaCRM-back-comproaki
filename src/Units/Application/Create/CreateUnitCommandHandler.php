<?php

namespace Hexa\Units\Application\Create;

use Hexa\Shared\Domain\Bus\Command\CommandHandler;
use Hexa\Units\Domain\{ Unit, UnitRepository };

final class CreateUnitCommandHandler implements CommandHandler
{
    private $repository;

    public function __construct(UnitRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreateUnitCommand $command)
    {
        $unit = Unit::create(
            $command->name()
        );

        $this->repository->save($unit);
    }
}
