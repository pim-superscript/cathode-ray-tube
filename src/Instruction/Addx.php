<?php
declare(strict_types=1);

namespace Pim\CathodeRayTube\Instruction;

use Pim\CathodeRayTube\CpuState\Adding;
use Pim\CathodeRayTube\CpuState\Cpu;
use Pim\CathodeRayTube\Instructions;
use Pim\CathodeRayTube\Register;

final readonly class Addx implements Instruction
{
    public function __construct(private int $toAdd)
    {
    }

    public function executeOn(Register $register, Instructions $instructions): Cpu
    {
        return new Adding($register->advance(), $instructions, $this->toAdd);
    }
}