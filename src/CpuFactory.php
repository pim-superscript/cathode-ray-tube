<?php
declare(strict_types=1);

namespace Pim\CathodeRayTube;

use LogicException;
use Pim\CathodeRayTube\CpuState\Adding;
use Pim\CathodeRayTube\CpuState\Cpu;
use Pim\CathodeRayTube\CpuState\Halted;
use Pim\CathodeRayTube\CpuState\Ready;
use Pim\CathodeRayTube\Instruction\Addx;
use Pim\CathodeRayTube\Instruction\Instruction;
use Pim\CathodeRayTube\Instruction\Noop;

final readonly class CpuFactory
{
    public static function fromStringContaining(string $instructions): Cpu
    {
        return new Ready(Register::fresh(), new Instructions(array_map(self::instructionFrom(...), explode(PHP_EOL, $instructions))));
    }

    private static function instructionFrom(string $instruction): Instruction
    {
        return match (true) {
            $instruction === 'noop' => new Noop(),
            str_starts_with($instruction, 'addx') => new Addx(intval(substr($instruction, 5))),
            default => throw new LogicException('unknown instruction'),
        };
    }
}