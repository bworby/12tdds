<?php

namespace XmasTTD\Day1;

use XmasTTD\Day1\SessionData as SUT;
use PHPUnit\Framework\TestCase;

class SessionDataTest extends TestCase
{
    public function intProvider(): \Generator
    {
        yield 'test 1' => [[0,5,2,15]];
        yield 'test 2' => [[1,58,10,-215]];
        yield 'test 3' => [[-10,5,10,15]];
        yield 'test 4' => [[-90,5,120,55]];
    }

    /**
     * @test
     * @dataProvider intProvider
     */
    public function getValueCount_returns_expected(array $data): void {
        $sut = new SUT($data);
        self::assertEquals(count($data), $sut->getValueCount());
    }

    /**
     * @test
     * @dataProvider intProvider
     */
    public function getMinValue_returns_expected(array $data): void {
        $sut = new SUT($data);
        self::assertEquals(min($data), $sut->getMinValue());
    }

    /**
     * @test
     * @dataProvider intProvider
     */
    public function getMaxValue_returns_expected(array $data): void {
        $sut = new SUT($data);
        self::assertEquals(max($data), $sut->getMaxValue());
    }

    /**
     * @test
     * @dataProvider intProvider
     */
    public function getValuesAverage_returns_expected(array $data): void {
        $sut = new SUT($data);
        $average = array_sum($data) / count($data);
        self::assertEquals($average, $sut->getValuesAverage());
    }
}