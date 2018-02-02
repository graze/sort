<?php
namespace Graze\Sort;

use PHPUnit_Framework_TestCase as TestCase;

class SortTransformTest extends TestCase
{
    public function testAlphaSort()
    {
        $list = ['f', 'h', 'd', 'g', 'j', 'e', 'i', 'c', 'a', 'b'];

        usort($list, comparison_fn(function ($v) {
            return $v;
        }));

        $this->assertEquals(['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'], $list);
    }

    public function testAlphaMultisort()
    {
        $list = ['f', 'h', 'd', 'g', 'j', 'e', 'i', 'c', 'a', 'b'];

        usort($list, comparison_fn([function ($v) {
            return $v;
        }]));

        $this->assertEquals(['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'], $list);
    }

    public function testNumericSort()
    {
        $list = [5, 7, 3, 6, 9, 4, 8, 2, 0, 1];

        usort($list, comparison_fn(function ($v) {
            return $v;
        }));

        $this->assertEquals([0, 1, 2, 3, 4, 5, 6, 7, 8, 9], $list);
    }

    public function testNumericMultisort()
    {
        $list = [5, 7, 3, 6, 9, 4, 8, 2, 0, 1];

        usort($list, comparison_fn([function ($v) {
            return $v;
        }]));

        $this->assertEquals([0, 1, 2, 3, 4, 5, 6, 7, 8, 9], $list);
    }

    public function testObjectSort()
    {
        $list = $l = [
            (object) ['id' => 5],
            (object) ['id' => 7],
            (object) ['id' => 3],
            (object) ['id' => 6],
            (object) ['id' => 9],
            (object) ['id' => 4],
            (object) ['id' => 8],
            (object) ['id' => 2],
            (object) ['id' => 0],
            (object) ['id' => 1]
        ];

        usort($list, comparison_fn(function ($v) {
            return $v->id;
        }));

        $this->assertEquals([$l[8], $l[9], $l[7], $l[2], $l[5], $l[0], $l[3], $l[1], $l[6], $l[4]], $list);
    }

    public function testObjectMultiSort()
    {
        $list = $l = [
            (object) ['id' => 5],
            (object) ['id' => 7],
            (object) ['id' => 3],
            (object) ['id' => 6],
            (object) ['id' => 9],
            (object) ['id' => 4],
            (object) ['id' => 8],
            (object) ['id' => 2],
            (object) ['id' => 0],
            (object) ['id' => 1]
        ];

        usort($list, comparison_fn([function ($v) {
            return $v->id;
        }]));

        $this->assertEquals([$l[8], $l[9], $l[7], $l[2], $l[5], $l[0], $l[3], $l[1], $l[6], $l[4]], $list);
    }

    public function testDescSort()
    {
        $list = [5, 7, 3, 6, 9, 4, 8, 2, 0, 1];

        usort($list, comparison_fn(function ($v) {
            return $v;
        }, \Graze\Sort\DESC));

        $this->assertEquals([9, 8, 7, 6, 5, 4, 3, 2, 1, 0], $list);
    }

    public function testDuplicateValues()
    {
        $list = [2, 1, 3, 2, 3, 2, 2, 1, 3, 1, 2, 3, 1, 1, 1, 3, 3, 2];

        usort($list, comparison_fn(function ($v) {
            return $v;
        }));

        $this->assertEquals([1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 3, 3], $list);
    }

    public function testDuplicateValuesMulti()
    {
        $list = [2, 1, 3, 2, 3, 2, 2, 1, 3, 1, 2, 3, 1, 1, 1, 3, 3, 2];

        usort($list, comparison_fn([function ($v) {
            return $v;
        }]));

        $this->assertEquals([1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 3, 3], $list);
    }

    public function testStackedCallbacks()
    {
        $list = $l = [
            (object) ['foo' => 1, 'bar' => 3],
            (object) ['foo' => 3, 'bar' => 2],
            (object) ['foo' => 2, 'bar' => 1],
            (object) ['foo' => 2, 'bar' => 2],
            (object) ['foo' => 3, 'bar' => 3],
            (object) ['foo' => 1, 'bar' => 1],
            (object) ['foo' => 2, 'bar' => 3],
            (object) ['foo' => 3, 'bar' => 1],
            (object) ['foo' => 1, 'bar' => 2]
        ];

        $byFoo = function ($v) {
            return $v->foo;
        };
        $byBar = function ($v) {
            return $v->bar;
        };

        usort($list, comparison_fn([$byFoo, $byBar]));

        $this->assertEquals([$l[5], $l[8], $l[0], $l[2], $l[3], $l[6], $l[7], $l[1], $l[4]], $list);
    }
}
