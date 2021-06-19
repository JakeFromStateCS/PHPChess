<?php

declare(strict_types=1);

namespace PHPChess\Util\Spacial;

use JetBrains\PhpStorm\ArrayShape;

final class Vector2D
{
    public function __construct(private int $x, private int $y)
    {
    }

    private function __clone()
    {
        return new self($this->x, $this->y);
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function setX(int $x): void
    {
        $this->x = $x;
    }

    public function setY(int $y): void
    {
        $this->y = $y;
    }

    public function add(Vector2D $vector2D): self
    {
        return new self(
            $this->x + $vector2D->getX(),
            $this->y + $vector2D->getY(),
        );
    }

    public function mul($value): self
    {
        $x = $this->x;
        $y = $this->y;
        if ($value instanceof self) {
            $x *= $value->getX();
            $y *= $value->getY();
        } elseif (is_int($value)) {
            $x *= $value;
            $y *= $value;
        } else {
            throw new \Exception('Invalid Value');
        }
        return new self($x, $y);
    }

    #[ArrayShape(['x' => "int", 'y' => "int"])]
    public function toArray(): array
    {
        return [
            'x' => $this->x,
            'y' => $this->y,
        ];
    }
}
