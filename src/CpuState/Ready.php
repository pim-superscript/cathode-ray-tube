<?php
declare(strict_types=1);

namespace Pim\CathodeRayTube\CpuState;

use LogicException;
use Pim\CathodeRayTube\Instructions;
use Pim\CathodeRayTube\Register;

final readonly class Ready implements Cpu
{
    public function __construct(private Register $register, private Instructions $instructions)
    {
    }

    public function tick(): Cpu
    {
        [$instruction, $instructions] = $this->instructions->next();
        return $instruction
            ? $instruction->executeOn($this->register, $instructions)
            : new Halted($this->register);
    }

    public function registerX(): int
    {
        return $this->register->x();
    }

    public function signalStrength(): int
    {
        return $this->register->signalStrength();
    }
}