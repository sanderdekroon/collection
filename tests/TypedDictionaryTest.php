<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 4/5/2018
 * Time: 9:21 AM
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
        $this->assertEquals(1, $dictionary->size());
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
        $this->assertEquals(2, $dictionary->size());
    }

    public function testExceptionThrownCreatingDictionaryWithBadValue()
    {
        $this->expectException(CollectionException::class);
        $items = ['foo' => new \stdClass()];
        new TypedDictionary(CrashTestDummy::class, $items);
    }
}