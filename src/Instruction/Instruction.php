<?php
declare(strict_types=1);

namespace Pim\CathodeRayTube\Instruction;

use Pim\CathodeRayTube\CpuState\Cpu;
use Pim\CathodeRayTube\Instructions;
use Pim\CathodeRayTube\Register;

interface Instruction
{
    public function executeOn(Register $register, Instructions $instructions): Cpu;
}