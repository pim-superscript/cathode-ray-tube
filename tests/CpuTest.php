<?php
declare(strict_types=1);

namespace Pim\CathodeRayTube\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Pim\CathodeRayTube\CpuState\Adding;
use Pim\CathodeRayTube\CpuState\Halted;
use Pim\CathodeRayTube\CpuState\Ready;
use Pim\CathodeRayTube\Cursor;
use Pim\CathodeRayTube\CpuFactory;
use Pim\CathodeRayTube\Instruction\Addx;
use Pim\CathodeRayTube\Instruction\Noop;
use Pim\CathodeRayTube\Instructions;
use Pim\CathodeRayTube\Register;

final class CpuTest extends TestCase
{
    #[Test]
    function can_execute_a_noop(): void
    {
        $before = new Ready(Register::fresh(), new Instructions([new Noop()]));
        $expected = new Ready(Register::atCycleAndXOf(2, 1), new Instructions([]));

        $actual = $before->tick();

        $this->assertEquals($expected, $actual);
    }

    #[Test]
    function can_tick_an_add(): void
    {
        $before = new Ready(Register::fresh(), new Instructions([new Addx(1)]));
        $expected = new Adding(Register::atCycleAndXOf(2, 1), new Instructions([]), 1);

        $actual = $before->tick();

        $this->assertEquals($expected, $actual);
    }

    #[Test]
    function can_tock_an_add(): void
    {
        $before = new Ready(Register::fresh(), new Instructions([new Addx(1)]));
        $expected = new Ready(Register::atCycleAndXOf(3, 2), new Instructions([]));

        $actual = $before->tick()->tick();

        $this->assertEquals($expected, $actual);
    }

    #[Test]
    function can_run_to_a_halt(): void
    {
        $before = new Ready(Register::atCycleAndXOf(1, 1), new Instructions([new Addx(1)]));
        $expected = new Halted(Register::atCycleAndXOf(3, 2));

        $actual = $before->tick()->tick()->tick();

        $this->assertEquals($expected, $actual);
    }

    #[Test]
    function can_execute_a_list_of_instructions(): void
    {
        $instructions = $this->shortProgram();
        $cursor = new Cursor(CpuFactory::fromStringContaining($instructions));
        $cpu = $cursor->execute();
        $expected = -1;

        $actual = $cpu->registerX();

        $this->assertEquals($expected, $actual);
    }

    #[Test]
    function cpu_determine_signal_strength(): void
    {
        $instructions = $this->longProgram();
        $cursor = new Cursor(CpuFactory::fromStringContaining($instructions));
        $interestingCycles = [20 => 420, 60 => 1140, 100 => 1800, 140 => 2940, 180 => 2880, 220 => 3960];
        foreach ($interestingCycles as $cycle => $expectedSignalStrength) {
            $cpu = $cursor->runTo($cycle);
            $actualSignalStrength = $cpu->signalStrength();
            $this->assertEquals($expectedSignalStrength, $actualSignalStrength);
        }
    }

    private function shortProgram(): string
    {
        return 'noop
addx 3
addx -5';
    }

    private function longProgram(): string
    {
        return 'addx 15
addx -11
addx 6
addx -3
addx 5
addx -1
addx -8
addx 13
addx 4
noop
addx -1
addx 5
addx -1
addx 5
addx -1
addx 5
addx -1
addx 5
addx -1
addx -35
addx 1
addx 24
addx -19
addx 1
addx 16
addx -11
noop
noop
addx 21
addx -15
noop
noop
addx -3
addx 9
addx 1
addx -3
addx 8
addx 1
addx 5
noop
noop
noop
noop
noop
addx -36
noop
addx 1
addx 7
noop
noop
noop
addx 2
addx 6
noop
noop
noop
noop
noop
addx 1
noop
noop
addx 7
addx 1
noop
addx -13
addx 13
addx 7
noop
addx 1
addx -33
noop
noop
noop
addx 2
noop
noop
noop
addx 8
noop
addx -1
addx 2
addx 1
noop
addx 17
addx -9
addx 1
addx 1
addx -3
addx 11
noop
noop
addx 1
noop
addx 1
noop
noop
addx -13
addx -19
addx 1
addx 3
addx 26
addx -30
addx 12
addx -1
addx 3
addx 1
noop
noop
noop
addx -9
addx 18
addx 1
addx 2
noop
noop
addx 9
noop
noop
noop
addx -1
addx 2
addx -37
addx 1
addx 3
noop
addx 15
addx -21
addx 22
addx -6
addx 1
noop
addx 2
addx 1
noop
addx -10
noop
noop
addx 20
addx 1
addx 2
addx 2
addx -6
addx -11
noop
noop
noop';
    }
}