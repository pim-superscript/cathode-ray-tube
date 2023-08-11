<?php
declare(strict_types=1);

namespace Pim\CathodeRayTube;

final readonly class Register
{
    private function __construct(private int $cycle, private int $x)
    {
    }

    public static function fresh(): self
    {
        return new self(1, 1);
    }

    public static function atCycleAndXOf(int $cycle, int $x): self
    {
        return new self($cycle, $x);
    }

    public function advance(int $xDiff = 0): self
    {
        return new Register($this->cycle + 1, $this->x + $xDiff);
    }

    public function x(): int
    {
        return $this->x;
    }

    public function signalStrength(): int
    {
        return $this->cycle * $this->x;
    }
}