<?php

namespace XmasTTD\Day2;

use PHPUnit\Framework\TestCase;

class StringGridCheckerTest extends TestCase
{
    /**
     * @test
     */
    public function rowCount_returns(): void
    {
        $data = [
            "*...",
            "*..."
        ];

        $checker = new StringGridChecker(...$data);
        self::assertEquals(2, $checker->rowCount());
    }

    /**
     * @test
     */
    public function columnCount_returns(): void
    {
        $data = [
            "*...",
            "*..."
        ];

        $checker = new StringGridChecker(...$data);
        self::assertEquals(4, $checker->columnCount());
    }

    /**
     * @test
     */
    public function previousElementIsKnot_nextElementIsKnot_returns_expected(): void
    {
        $data = [
            "*..*",
        ];

        $checker = new StringGridChecker(...$data);
        self::assertTrue($checker->previousElementIsKnot(IndexSet::make(0,1)));
        self::assertFalse($checker->previousElementIsKnot(IndexSet::make(0,0)));
        self::assertFalse($checker->previousElementIsKnot(IndexSet::make(0,-1)));
        self::assertFalse($checker->nextElementIsKnot(IndexSet::make(0,0)));
        self::assertTrue($checker->nextElementIsKnot(IndexSet::make(0,2)));
        self::assertFalse($checker->nextElementIsKnot(IndexSet::make(0,3)));
        self::assertFalse($checker->nextElementIsKnot(IndexSet::make(0,5)));
        self::assertFalse($checker->nextElementIsKnot(IndexSet::make(2,5)));
    }

    /**
     * @test
     */
    public function getCountOfKnotsTouchedBy_retuns_expected()
    {
        $input = [
            "*...",
            "....",
            "....",
            "*..."
        ];

        $checker = new StringGridChecker(...$input);

        $index_set = IndexSet::make(0,0);
        self::assertEquals(0, $checker->getCountOfKnotsTouchedBy($index_set, $index_set));
        $index_set = IndexSet::make(0,1);
        self::assertEquals(1, $checker->getCountOfKnotsTouchedBy($index_set, $index_set));
    }

    public function testBasicInputOutput()
    {
        $input = [
            "*..."
        ];
        $expected_output = [
            "*100"
        ];
        $checker = new StringGridChecker(...$input);
        self::assertEquals($expected_output, $checker->getOutput());
    }

    public function provideGridData(): \Generator
    {
        yield "test 1" => [
            [
                "*...",
                "*..."
            ],
            [
                "*200",
                "*200"
            ]
        ];


        yield "test 2" => [
            [
                "*...",
                "..*.",
                "...."
            ],
            [
                "*211",
                "12*1",
                "0111"
            ]
        ];

        yield "test 3" => [
            [
                "***.",
                ".***",
            ],
            [
                "***3",
                "3***",
            ]
        ];

        yield "test 4" => [
            [
                "***.",
                ".***",
                "****",
            ],
            [
                "***3",
                "5***",
                "****",
            ]
        ];

    }

    /**
     * @test
     * @dataProvider provideGridData
     */
    public function getOutput_returns_expected(array $input, array $expected_output): void
    {
        $checker = new StringGridChecker(...$input);
        self::assertEquals($expected_output, $checker->getOutput());
    }
}
