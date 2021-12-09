<?php

namespace XmasTTD\Day2;

use function PHPUnit\Framework\throwException;

class IndexSet
{
    private int $row;
    private int $column;

    public function __construct( int $row, int $column)
    {
        $this->row = $row;
        $this->column = $column;
    }

    public static function make(int $row, int $column): self
    {
        return new self($row, $column);
    }

    public static function makeFromString(string $index_set_string): self
    {
        $row_column = explode(":", $index_set_string);
        if(count($row_column) < 2) {
            throwException(new \Exception("UH OH! bad input index set string: $index_set_string"));
        }

        return new self((int)$row_column[0], (int)$row_column[1]);
    }

    public function getRow(): int {
        return $this->row;
    }

    public function getColumn(): int {
        return $this->column;
    }
}