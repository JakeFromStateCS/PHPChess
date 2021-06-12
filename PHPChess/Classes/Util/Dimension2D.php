<?php

declare(strict_types=1);

namespace PHPChess\Util;

use JetBrains\PhpStorm\Pure;

/**
 * Just a wrapper for the Vector2D to represent width and height
 * Class Dimension2D
 * @package PHPChess\Util
 */
final class Dimension2D
{
    private Vector2D $vector2D;

    #[Pure]
    public function __construct(int $w, int $h)
    {
        $this->vector2D = new Vector2D($w, $h);
    }

    public function getWidth(): int
    {
        return $this->vector2D->getX();
    }

    public function getHeight(): int
    {
        return $this->vector2D->getY();
    }

    public function setWidth(int $w): void
    {
        $this->vector2D->setX($w);
    }

    public function setHeight(int $h): void
    {
        $this->vector2D->setY($h);
    }

    public function add(Dimension2D $dimension2D): void
    {
        $this->vector2D = $this->vector2D->add(new Vector2D($dimension2D->getHeight(), $dimension2D->getWidth()));
    }
}
