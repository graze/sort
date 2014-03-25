<?php
namespace Graze\Sort;

class CSortCallbackTest extends \PHPUnit_Framework_TestCase
{
    public function testAlphaSort()
    {
        $list = ['f', 'h', 'd', 'g', 'j', 'e', 'i', 'c', 'a', 'b'];

        usort($list, csort_callback(function ($v) {
            return $v;
        }));

        $this->assertEquals(['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'], $list);
    }

    public function testNumericSort()
    {
        $list = [5, 7, 3, 6, 9, 4, 8, 2, 0, 1];

        usort($list, csort_callback(function ($v) {
            return $v;
        }));

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

        usort($list, csort_callback(function ($v) {
            return $v->id;
        }));

        $this->assertEquals([$l[8], $l[9], $l[7], $l[2], $l[5], $l[0], $l[3], $l[1], $l[6], $l[4]], $list);
    }

    public function testDescSort()
    {
        $list = [5, 7, 3, 6, 9, 4, 8, 2, 0, 1];

        usort($list, csort_callback(function ($v) {
            return $v;
        }, \Graze\Sort\DESC));

        $this->assertEquals([9, 8, 7, 6, 5, 4, 3, 2, 1, 0],  $list);
    }

    public function testDuplicateValues()
    {
        $list = [2, 1, 3, 2, 3, 2, 2, 1, 3, 1, 2, 3, 1, 1, 1, 3, 3, 2];

        usort($list, csort_callback(function ($v) {
            return $v;
        }));

        $this->assertEquals([1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 3, 3], $list);
    }

    public function testCallbackIsCalledOnceForEachItem()
    {
        $calls = [1 => 0, 2 => 0, 3 => 0];
        $list = [2, 1, 3, 2, 3, 2, 2, 1, 3, 1, 2, 3, 1, 1, 1, 3, 3, 2];

        usort($list, csort_callback(function ($v) use (&$calls) {
            $calls[$v] += 1;
            return $v;
        }));

        $this->assertEquals([1 => 1, 2 => 1, 3 => 1], $calls);
    }
}
