<?php

namespace XmasTTD\Day2;

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

    public function getRow(): int {
        return $this->row;
    }

    public function getColumn(): int {
        return $this->column;
    }
}