<?php

namespace XmasTTD\Day3;

use XmasTTD\Day2\IndexSet;
use function PHPUnit\Framework\throwException;

class GridRange
{
    private IndexSet $start_index_set;
    private IndexSet $end_index_set;
    private string $string_command;

    public function __construct(IndexSet $start_index_set, IndexSet $end_index_set, string $string_command = "")
    {
        $this->start_index_set = $start_index_set;
        $this->end_index_set = $end_index_set;
        $this->string_command = $string_command;
    }

    public static function make(IndexSet $start_index_set, IndexSet $end_index_set): self
    {
        return new self($start_index_set, $end_index_set);
    }

    //$range_string 0:0-2:2
    public static function makeFromString(string $range_string): self
    {
        $start_end_def = explode("-", $range_string);

        if(count($start_end_def) < 2) {
            throwException(new \Exception("UH OH! bad input range string: $range_string"));
        }

        return new self(
            IndexSet::makeFromString($start_end_def[0]),
            IndexSet::makeFromString($start_end_def[1]),
            $range_string
        );
    }

    public function getStringCommand(): string
    {
        return $this->string_command;
    }

    public function startIndexSet(): IndexSet
    {
        return $this->start_index_set;
    }

    public function x1(): int
    {
        return $this->start_index_set->getRow();
    }

    public function y1(): int
    {
        return $this->start_index_set->getColumn();
    }

    public function endIndexSet(): IndexSet
    {
        return $this->end_index_set;
    }

    public function x2(): int
    {
        return $this->end_index_set->getRow();
    }

    public function y2(): int
    {
        return $this->end_index_set->getColumn();
    }
}