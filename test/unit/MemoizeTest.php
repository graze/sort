<?php
namespace Graze\Sort;

class MemoizeTest extends \PHPUnit_Framework_TestCase
{
    public function testMemoizeReturnsClosure()
    {
        $fn = memoize(function(){});

        $this->assertInstanceOf('Closure', $fn);
    }

    public function testMemoizeReturnsClosureFromCallableArray()
    {
        $fn = memoize([$this, __FUNCTION__]);

        $this->assertInstanceOf('Closure', $fn);
    }

    public function testMemoizeReturnsClosureArray()
    {
        $fn = memoize([function(){}]);

        $this->assertInstanceOf('Closure', $fn);
    }

    public function testCallbackIsCalledOnceForEachItem()
    {
        $calls = [1 => 0, 2 => 0, 3 => 0];
        $list  = [2, 1, 3, 2, 3, 2, 2, 1, 3, 1, 2, 3, 1, 1, 1, 3, 3, 2];

        $fn = memoize(function ($v) use (&$calls) {
            $calls[$v] += 1;
            return $v;
        });

        foreach ($list as $item) {
            $fn($item);
        }

        $this->assertEquals([1 => 1, 2 => 1, 3 => 1], $calls);
    }

    public function testCallbacksAreCalledOnceForEachItem()
    {
        $calls = [1 => 0, 2 => 0, 3 => 0];
        $list  = [2, 1, 3, 2, 3, 2, 2, 1, 3, 1, 2, 3, 1, 1, 1, 3, 3, 2];

        $fns = memoize([
            function ($v) use (&$calls) {
                $calls[$v] += 1;
                return $v;
            },
            function ($v) use (&$calls) {
                $calls[$v] += 1;
                return $v;
            }
        ]);

        foreach ($list as $item) {
            foreach ($fns as $fn) {
                $fn($item);
            }
        }

        $this->assertEquals([1 => 2, 2 => 2, 3 => 2], $calls);
    }
}
