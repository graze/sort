<?php
namespace Graze\Sort;

use PHPUnit_Framework_TestCase as TestCase;

class SchwartzianSortTest extends TestCase
{
    public function testAlphaSort()
    {
        $list = array('f', 'h', 'd', 'g', 'j', 'e', 'i', 'c', 'a', 'b');

        $list = schwartzian($list, function ($v) {
            return $v;
        });

        $this->assertEquals(array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'), $list);
    }

    public function testAlphaMultisort()
    {
        $list = array('f', 'h', 'd', 'g', 'j', 'e', 'i', 'c', 'a', 'b');

        $list = schwartzian($list, array(function ($v) {
            return $v;
        }));

        $this->assertEquals(array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'), $list);
    }

    public function testNumericSort()
    {
        $list = array(5, 7, 3, 6, 9, 4, 8, 2, 0, 1);

        $list = schwartzian($list, function ($v) {
            return $v;
        });

        $this->assertEquals(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9), $list);
    }

    public function testNumericMultisort()
    {
        $list = array(5, 7, 3, 6, 9, 4, 8, 2, 0, 1);

        $list = schwartzian($list, array(function ($v) {
            return $v;
        }));

        $this->assertEquals(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9), $list);
    }

    public function testObjectSort()
    {
        $list = $l = array(
            (object) array('id' => 5),
            (object) array('id' => 7),
            (object) array('id' => 3),
            (object) array('id' => 6),
            (object) array('id' => 9),
            (object) array('id' => 4),
            (object) array('id' => 8),
            (object) array('id' => 2),
            (object) array('id' => 0),
            (object) array('id' => 1)
        );

        $list = schwartzian($list, function ($v) {
            return $v->id;
        });

        $this->assertEquals(array($l[8], $l[9], $l[7], $l[2], $l[5], $l[0], $l[3], $l[1], $l[6], $l[4]), $list);
    }

    public function testObjectMultiSort()
    {
        $list = $l = array(
            (object) array('id' => 5),
            (object) array('id' => 7),
            (object) array('id' => 3),
            (object) array('id' => 6),
            (object) array('id' => 9),
            (object) array('id' => 4),
            (object) array('id' => 8),
            (object) array('id' => 2),
            (object) array('id' => 0),
            (object) array('id' => 1)
        );

        $list = schwartzian($list, array(function ($v) {
            return $v->id;
        }));

        $this->assertEquals(array($l[8], $l[9], $l[7], $l[2], $l[5], $l[0], $l[3], $l[1], $l[6], $l[4]), $list);
    }

    public function testDescSort()
    {
        $list = array(5, 7, 3, 6, 9, 4, 8, 2, 0, 1);

        $list = schwartzian($list, function ($v) {
            return $v;
        }, \Graze\Sort\DESC);

        $this->assertEquals(array(9, 8, 7, 6, 5, 4, 3, 2, 1, 0),  $list);
    }

    public function testDuplicateValues()
    {
        $list = array(2, 1, 3, 2, 3, 2, 2, 1, 3, 1, 2, 3, 1, 1, 1, 3, 3, 2);

        $list = schwartzian($list, function ($v) {
            return $v;
        });

        $this->assertEquals(array(1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 3, 3), $list);
    }

    public function testDuplicateValuesMulti()
    {
        $list = array(2, 1, 3, 2, 3, 2, 2, 1, 3, 1, 2, 3, 1, 1, 1, 3, 3, 2);

        $list = schwartzian($list, array(function ($v) {
            return $v;
        }));

        $this->assertEquals(array(1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 3, 3), $list);
    }

    public function testStackedCallbacks()
    {
        $list = $l = array(
            (object) array('foo' => 1, 'bar' => 3),
            (object) array('foo' => 3, 'bar' => 2),
            (object) array('foo' => 2, 'bar' => 1),
            (object) array('foo' => 2, 'bar' => 2),
            (object) array('foo' => 3, 'bar' => 3),
            (object) array('foo' => 1, 'bar' => 1),
            (object) array('foo' => 2, 'bar' => 3),
            (object) array('foo' => 3, 'bar' => 1),
            (object) array('foo' => 1, 'bar' => 2)
        );

        $byFoo = function ($v) { return $v->foo; };
        $byBar = function ($v) { return $v->bar; };

        $list = schwartzian($list, array($byFoo, $byBar));

        $this->assertEquals(array($l[5], $l[8], $l[0], $l[2], $l[3], $l[6], $l[7], $l[1], $l[4]), $list);
    }

    public function testCallbackIsCalledOnceForEachItem()
    {
        $calls = array(1 => 0, 2 => 0, 3 => 0);
        $list  = array(2, 1, 3, 2, 3, 2, 2, 1, 3, 1, 2, 3, 1, 1, 1, 3, 3, 2);

        $list = schwartzian($list, function ($v) use (&$calls) {
            $calls[$v] += 1;
            return $v;
        });

        $this->assertEquals(array(1 => 6, 2 => 6, 3 => 6), $calls);
    }

    public function testCallbacksAreCalledOnceForEachItem()
    {
        $calls = array('foo' => array(1 => 0, 2 => 0, 3 => 0), 'bar' => array(1 => 0, 2 => 0, 3 => 0));
        $list = array(
            (object) array('foo' => 1, 'bar' => 3),
            (object) array('foo' => 3, 'bar' => 2),
            (object) array('foo' => 2, 'bar' => 1),
            (object) array('foo' => 2, 'bar' => 2),
            (object) array('foo' => 3, 'bar' => 3),
            (object) array('foo' => 1, 'bar' => 1),
            (object) array('foo' => 2, 'bar' => 3),
            (object) array('foo' => 3, 'bar' => 1),
            (object) array('foo' => 1, 'bar' => 2)
        );

        $byFoo = function ($v) use (&$calls) { $calls['foo'][$v->foo] += 1; return $v->foo; };
        $byBar = function ($v) use (&$calls) { $calls['bar'][$v->bar] += 1; return $v->bar; };

        $list = schwartzian($list, array($byFoo, $byBar));

        $this->assertEquals(array('foo' => array(1 => 3, 2 => 3, 3 => 3), 'bar' => array(1 => 3, 2 => 3, 3 => 3)), $calls);
    }
}
