<?php

namespace XmasTTD\Day2;

/**
 * Could break out into some nice classes that have ->next ->prev.. so on. but didnt want to spend all that time for the idea of creating tests
 */
class StringGridChecker
{
    public const KNOT_INDICATOR = "*";
    /**
     * @var String[]
     */
    private array $data;

    public function __construct(string ...$data)
    {
        $this->data = $data;
    }

    public function rowCount(): int
    {
        return count($this->data);
    }

    //assuming always is x X x grid
    public function columnCount(): int
    {
        return strlen($this->data[0]);
    }

    public function getOutput(): array
    {
        $output = [];
        foreach($this->data as $row_index => $row) {
            $output[] = $this->getRowOutputForIndexSet($row_index);
        }

        return $output;
    }

    private function getRowOutputForIndexSet(int $row): string
    {
        $row_string = $this->data[$row];

        $output = [];

        foreach(array_keys(str_split($row_string)) as $column) {
            $index_set = IndexSet::make($row, $column);
            //2 lines, just incase we wanted to store the # of knots next to knots.. but for now not requirements
            $count = $this->getCountOfKnotsTouchedBy($index_set, $index_set);
            $output[] = $this->elementIsKnot($index_set) ? self::KNOT_INDICATOR : $count;
        }

        return implode($output);
    }

    public function getCountOfKnotsTouchedBy(IndexSet $index_set, IndexSet $start_index_set): int
    {
        $touching_count = (!($index_set === $start_index_set) && $this->elementIsKnot($index_set)) ? 1 : 0;
        $touching_count += $this->previousElementIsKnot($index_set) ? 1 : 0;
        $touching_count += $this->nextElementIsKnot($index_set) ? 1 : 0;

        if($index_set === $start_index_set) {
            $prev = IndexSet::make($index_set->getRow()-1, $index_set->getColumn());
            $next = IndexSet::make($index_set->getRow()+1, $index_set->getColumn());
            $touching_count += $this->getCountOfKnotsTouchedBy($prev, $start_index_set) + $this->getCountOfKnotsTouchedBy($next, $start_index_set);
        }

        return $touching_count;
    }

    public function getCountOfKnotsTouchedBy_bu(IndexSet $index_set): int
    {
        $touching_count = $this->checkIndexPathTouchCount(IndexSet::make($index_set->getRow(), $index_set->getColumn()), true);
        $touching_count += $this->checkIndexPathTouchCount(IndexSet::make($index_set->getRow()-1, $index_set->getColumn()), false);
        $touching_count += $this->checkIndexPathTouchCount(IndexSet::make($index_set->getRow()+1, $index_set->getColumn()), false);
        return $touching_count;
    }

    public function checkIndexPathTouchCount(IndexSet $index_set, bool $ignore_self = true): int
    {
        $touching_count = (!$ignore_self && $this->elementIsKnot($index_set)) ? 1 : 0;
        $touching_count += $this->previousElementIsKnot($index_set) ? 1 : 0;
        $touching_count += $this->nextElementIsKnot($index_set) ? 1 : 0;
        return $touching_count;
    }

    public function elementIsKnot(IndexSet $index_set): bool
    {
        $element = $this->data[$index_set->getRow()][$index_set->getColumn()] ?? null;
        return $element === self::KNOT_INDICATOR;
    }

    public function nextElementIsKnot(IndexSet $index_set): bool
    {
        $element = $this->data[$index_set->getRow()][$index_set->getColumn()+1] ?? null;
        return $element === self::KNOT_INDICATOR;
    }

    public function previousElementIsKnot(IndexSet $index_set): bool
    {
        if ($index_set->getColumn() <= 0) {
            return false;
        }
        $element = $this->data[$index_set->getRow()][$index_set->getColumn() - 1] ?? null;
        return $element === self::KNOT_INDICATOR;
    }

}