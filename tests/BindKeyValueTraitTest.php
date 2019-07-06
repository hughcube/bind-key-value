<?php

namespace HughCube\BindKeyValue\Tests;

use HughCube\BindKeyValueInterface;
use HughCube\BindKeyValueTrait;
use Mockery;
use PHPUnit\Framework\TestCase;

class BindKeyValueTraitTest extends TestCase
{
    protected $bindValue = null;

    /**
     * @throws
     */
    protected function randBindValue()
    {
        $this->bindValue = microtime() . '-' . rand(1, 99999999999);
    }

    public function testInstance()
    {
        /** @var BindKeyValueTest $instance */
        $instance = Mockery::mock(BindKeyValueTest::class)->makePartial();

        $this->assertInstanceOf(BindKeyValueInterface::class, $instance);

        $test1Count = 0;
        $this->randBindValue();

        $key = 'test1';
        $getValueCallable = function () use (&$test1Count){
            $test1Count++;

            return $this->bindValue;
        };

        /**
         * 设置
         */
        $value1 = $instance->getOrSetKeyBoundValue($key, $getValueCallable);
        $this->assertSame($value1, $this->bindValue);

        /**
         * 是否走缓存了
         */
        $this->randBindValue();
        $value2 = $instance->getOrSetKeyBoundValue($key, $getValueCallable);
        $this->assertSame($test1Count, 1);
        $this->assertSame($value2, $value1);

        /**
         * 不严格比对 false == null, 走缓存
         */
        $this->randBindValue();
        $value3 = $instance->getOrSetKeyBoundValue($key, $getValueCallable, false, false);
        $this->assertSame($test1Count, 1);
        $this->assertSame($value3, $value1);

        /**
         * 严格比对 false !== null, 不走缓存
         */
        $this->randBindValue();
        $value4 = $instance->getOrSetKeyBoundValue($key, $getValueCallable, false, true);
        $this->assertSame($test1Count, 2);
        $this->assertSame($value4, $this->bindValue);
        $this->assertNotSame($value4, $value1);

        /**
         * 参照值发生变化, 不走缓存
         */
        $this->randBindValue();
        $value5 = $instance->getOrSetKeyBoundValue($key, $getValueCallable, 123);
        $this->assertSame($test1Count, 3);
        $this->assertSame($value5, $this->bindValue);
        $this->assertNotSame($value5, $value4);
    }
}

class BindKeyValueTest implements BindKeyValueInterface
{
    use BindKeyValueTrait;
}
