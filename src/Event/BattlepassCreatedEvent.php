<?php

namespace App\Event;

use App\Entity\Battlepass;
use Symfony\Contracts\EventDispatcher\Event;

class BattlepassCreatedEvent extends Event
{
    public const NAME = 'battlepass.created';

    public function __construct(
        private Battlepass $battlepass
    ) {}

    public function getBattlepass(): Battlepass
    {
        return $this->battlepass;
    }
}
