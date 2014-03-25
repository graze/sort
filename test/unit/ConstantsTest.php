<?php
namespace Graze\Sort;

class ConstantsTest extends \PHPUnit_Framework_TestCase
{
    public function testAsc()
    {
        return $this->assertSame(1, \Graze\Sort\ASC);
    }

    public function testDesc()
    {
        return $this->assertSame(-1, \Graze\Sort\DESC);
    }
}
