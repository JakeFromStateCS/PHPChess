<?php

declare(strict_types=1);

namespace PHPChess\Enum;

final class Constants
{
    private function __construct(){}
    final public function __sleep(){}
    final public function __wakeup(): void{}

    public const TEAM_LIGHT = 0;
    public const TEAM_DARK = 1;

    public const DEFAULT_BOARD_WIDTH = 8;
    public const DEFAULT_BOARD_HEIGHT = 8;

    public const DEFAULT_TEAM_TURN = self::TEAM_LIGHT;
}
