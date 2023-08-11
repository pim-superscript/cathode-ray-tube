<?php
declare(strict_types=1);

namespace Pim\CathodeRayTube;

use Pim\CathodeRayTube\Instruction\Instruction;

final readonly class Instructions
{
    /**
     * @param Instruction[] $instructions
     */
    public function __construct(private array $instructions)
    {
    }

    /**
     * @return [Instruction, Instruction[]]
     */
    public function next(): array
    {
        return [$this->instructions[0], new Instructions(array_slice($this->instructions, 1))];
    }
}