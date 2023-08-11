<?php
declare(strict_types=1);

namespace Pim\CathodeRayTube\Instruction;

use Pim\CathodeRayTube\CpuState\Cpu;
use Pim\CathodeRayTube\CpuState\Ready;
use Pim\CathodeRayTube\Instructions;
use Pim\CathodeRayTube\Register;

final readonly class Noop implements Instruction
{
    public function executeOn(Register $register, Instructions $instructions): Cpu
    {
        return new Ready($register->advance(), $instructions);
    }
}