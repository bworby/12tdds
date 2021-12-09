<?php

namespace XmasTTD\Day3;

use XmasTTD\Day2\IndexSet;
use XmasTTD\Day3\LedManager as SUT;
use PHPUnit\Framework\TestCase;

class LedManagerTest extends TestCase
{

    public function getSUT(int $grid_size = 20) : SUT
    {
        return new SUT($grid_size);
    }

    /**
     * @test
     * @testWith [20]
     *           [50]
     *           [150]
     */
    public function getLedGrid_returns(int $grid_size): void
    {
        $sut = $this->getSUT($grid_size);
        $grid = $sut->getLedGrid();
        self::assertCount($grid_size, $grid);
        self::assertCount($grid_size, $grid[0]);
        self::assertEquals($grid_size, array_count_values($grid[0])[0]);
    }

    /**
     * @test
     */
    public function getLedCountOn_returns_expected(): void
    {
        $sut = $this->getSUT(20);
        self::assertEquals(0, $sut->getLedOnCount());
    }

    /**
     * @test
     */
    public function processCommand_works_as_expected():void
    {
        $sut = $this->getSUT(50);
        self::assertEquals(0, $sut->getLedOnCount());

        $sut->processCommand(
            new Command(
                "on",
                new GridRange(
                    IndexSet::make(0,0),
                    IndexSet::make(0,0)
                )
            )
        );

        self::assertEquals(1, $sut->getLedOnCount());

        $sut->processCommand(
            new Command(
                "on",
                new GridRange(
                    IndexSet::make(0,0),
                    IndexSet::make(0,3)
                )
            )
        );

        self::assertEquals(4, $sut->getLedOnCount());
    }


    public function provideCommandAndExpectedResponseData(): \Generator
    {
        $string_command = "
            on 0:0-2:2,
            off 1:1-3:3,
            on 0:4-9:4,
            on 4:0-4:9,
            off 3:3-4:4,
            on 1:1-1:1,
            on 0:0-4:4,
            off 0:0-9:9   
        ";

        $expected_counts = [
            9,
            5,
            15,
            24,
            21,
            22,
            35,
            0
        ];

        yield "test 1" => [
            $string_command,
            $expected_counts
        ];
    }

    /**
     * @test
     * @dataProvider provideCommandAndExpectedResponseData
     *
     * $expected_counts - the expected count after the command matching that index is run
     */
    public function processCommands_works_as_expected(string $input, array $expected_counts):void
    {
        $sut = $this->getSUT(255);

        $command_strings = explode(",", $input);

        /** @var Command[] $commands */
        $commands = [];
        foreach ($command_strings as $command) {
            $commands[] = Command::makeWithString($command);
        }

        foreach($commands as $index => $command) {
            $sut->processCommand($command);
            self::assertEquals($sut->getLedOnCount(), $sut->getLedOnCount(true));
            self::assertEquals($expected_counts[$index], $sut->getLedOnCount());
        }
    }
}
