<?php

namespace XmasTTD\Day3;

use XmasTTD\Day2\IndexSet;
use function DusanKasan\Knapsack\values;

class LedManager
{
    private int $gridSize;
    private array $led_grid;

    private $leds_on = 0;

    public function __construct($gridSize = 1000)
    {
        $this->gridSize = $gridSize;

        for($i=0; $i<$this->gridSize; $i++) {
            $this->led_grid[] = array_fill(0,$gridSize, 0);
        }
    }

    public function getLedGrid(): array
    {
        return $this->led_grid;
    }

    private function turnLed(IndexSet $index_set, int $value)
    {
        if($this->led_grid[$index_set->getRow()][$index_set->getColumn()] !== $value) {
            $this->led_grid[$index_set->getRow()][$index_set->getColumn()] = $value;
            $this->leds_on += $value ? 1 : -1;
        }
    }

    public function getLedOnCount(bool $do_work = false): int {
        if(!$do_work) {
            return $this->leds_on;
        }

        $on = 0;
        foreach($this->led_grid as $row) {
            $on += array_count_values($row)[1] ?? 0;
        }
        return $on;
    }

    public function processCommand(Command $command)
    {
        $value = $command->isOnAction() ? 1 : 0;

        $range = $command->getRange();

        $start_index_set = $range->startIndexSet();
        $end_index_set = $range->endIndexSet();

        $update_array = [];

        /**
        only works based on criteria in task.. some data sets could cause issues if we wanted to go backward. or say
        turn on from start to end - and hit ALL lights betweeen
         */
        for($r=$start_index_set->getRow(); $r<=$end_index_set->getRow(); $r++) {
            for($c=$start_index_set->getColumn(); $c<=$end_index_set->getColumn(); $c++) {
                $this->turnLed(IndexSet::make($r, $c), $value);
            }
        }
    }

    public function processCommands(Command ...$commands)
    {
        foreach($commands as $command) {
            $this->processCommand($command);
        }
    }

}