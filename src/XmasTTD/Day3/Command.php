<?php

namespace XmasTTD\Day3;

use function PHPUnit\Framework\throwException;

class Command
{
    //should make enum for action
    private string $action;

    private GridRange $range;

    public function __construct(string $action, GridRange $range)
    {
        $this->action = $action;
        $this->range = $range;
    }

    public static function makeWithString(string $command_string): self
    {
        $command_string = trim($command_string);
        $action = strtok($command_string, " ");

        if ($action !== "on, off") {
            throwException(new \Exception("UH OH! bad action from command: $command_string action: $action"));
        }

        $range = GridRange::makeFromString(str_replace("$action ", "", $command_string));
        return new self($action, $range);
    }

    public function action(): string
    {
        return $this->action;
    }

    public function isOnAction(): bool
    {
        return $this->action === "on";
    }

    public function isOffAction(): bool
    {
        return $this->action === "off";
    }

    public function getRange(): GridRange
    {
        return $this->range;
    }

}