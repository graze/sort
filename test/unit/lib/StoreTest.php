<?php
namespace Graze\Sort;

class StoreTest extends \PHPUnit_Framework_TestCase
{
    public function dataGetValue()
    {
        return [
            [1, 1],
            [2, 4],
            [3, 9],
            [4, 16],
            [5, 25]
        ];
    }

    /**
     * @dataProvider dataGetValue
     * @param integer $val
     * @param integer $expected
     */
    public function testGetValue($val, $expected)
    {
        $store = new Store(function ($v) {
            return $v * $v;
        });

        $this->assertEquals($expected, $store->getValue($val));
    }
}
