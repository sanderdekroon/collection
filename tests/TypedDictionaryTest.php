<?php

/**
 * Part of the Fusion.Collection package test suite.
 *
 * @license MIT
 */

namespace Fusion\Collection\Tests;

use Fusion\Collection\Exceptions\CollectionException;
use Fusion\Collection\TypedDictionary;
use PHPUnit\Framework\TestCase;

class TypedDictionaryTest extends TestCase
{
    public function testCreateTypedDictionary()
    {
        $dictionary = new TypedDictionary(CrashTestDummy::class);
        $dictionary->add('foo', new CrashTestDummy());
        $this->assertEquals(1, $dictionary->count());
    }

    public function testExceptionThrownCreatingDictionaryWithEmptyStringForClassName()
    {
        $this->expectException(CollectionException::class);
        new TypedDictionary('');
    }

    public function testCreatingDictionaryWithItems()
    {
        $items = ['foo' => new CrashTestDummy(), 'bar' => new CrashTestDummy()];
        $dictionary = new TypedDictionary(CrashTestDummy::class, $items);
        $this->assertEquals(2, $dictionary->count());
    }

    public function testExceptionThrownCreatingDictionaryWithBadValue()
    {
        $this->expectException(CollectionException::class);
        $items = ['foo' => new \stdClass()];
        new TypedDictionary(CrashTestDummy::class, $items);
    }

    public function testExceptionThrownSendingNullValue()
    {
        $this->expectException(CollectionException::class);
        $items = ['foo' => null];
        new TypedDictionary(CrashTestDummy::class, $items);
    }

    public function testExceptionThrownReplacingValueWithNull()
    {
        $this->expectException(CollectionException::class);
        $dictionary = new TypedDictionary(CrashTestDummy::class, ['crash' => new CrashTestDummy()]);
        $dictionary->replace('crash', null);
    }

    public function testExceptionThrownReplacingValueWithIncorrectType()
    {
        $this->expectException(CollectionException::class);
        $dictionary = new TypedDictionary(CrashTestDummy::class, ['crash' => new CrashTestDummy()]);
        $dictionary->replace('crash', new \stdClass());
    }

    public function testExceptionThrownSettingOffsetWithNullValue()
    {
        $this->expectException(CollectionException::class);
        $dictionary = new TypedDictionary(CrashTestDummy::class);
        $dictionary['foo'] = new \stdClass();
    }

    public function testSettingValueAtOffset()
    {
        $first = new CrashTestDummy();
        $second = new CrashTestDummy();

        $dictionary = new TypedDictionary(CrashTestDummy::class);
        $dictionary['foo'] = $first;

        $this->assertEquals(1, $dictionary->count());

        $dictionary['foo'] = $second;

        $this->assertEquals(1, $dictionary->count());
        $this->assertSame($second, $dictionary->find('foo'));
    }

}
