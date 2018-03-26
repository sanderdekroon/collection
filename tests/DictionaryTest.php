<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 4/22/2016
 * Time: 10:30 AM
 */

namespace Fusion\Collection\Tests;


use Fusion\Collection\Dictionary;
use PHPUnit\Framework\TestCase;

class DictionaryTest extends TestCase
{
    /** @var  Dictionary */
    private $dictionary;

    public function setUp()
    {
        $this->dictionary = new Dictionary();
    }

    public function tearDown()
    {
        unset($this->dictionary);
    }

    public function testAddingItemToDictionary()
    {
        $this->dictionary->add('foo', 'bar');

        $expected = 1;
        $this->assertEquals($expected, $this->dictionary->size());
    }

    public function testRemovingItemFromDictionary()
    {
        $this->dictionary->add('foo', 'bar');

        $expected = 1;
        $this->assertEquals($expected, $this->dictionary->size());

        $this->dictionary->remove('bar');

        $expected = 0;
        $this->assertEquals($expected, $this->dictionary->size());
    }

    public function testReplacingExistingItem()
    {
        $this->dictionary->add('foo', 'bar');
        $this->dictionary->replace('foo', 'quam');

        $expected = 'quam';
        $this->assertEquals($expected, $this->dictionary->find('foo'));
    }

    public function testExceptionThrownAddingNullItem()
    {
        $this->expectException('\InvalidArgumentException');
        $this->dictionary->add('foo', null);
    }

    public function testExceptionThrownTryingToRemoveNullValue()
    {
        $this->expectException('\InvalidArgumentException');
        $this->dictionary->remove(null);
    }

    public function testExceptionThrownWhenKeyDoesNotExist()
    {
        $this->expectException('\OutOfBoundsException');
        $this->dictionary->find('foo');
    }

    public function testIteratingOverDictionary()
    {
        $this->dictionary
            ->add('foo', 'bar')
            ->add('baz', 'quam')
            ->add('qux', 'flam');

        foreach ($this->dictionary as $key => $value)
        {
            $this->assertTrue($this->dictionary->valid());
        }
    }

    public function testExceptionThrownFindingValueWithKeyThatDoesNotExist()
    {
        $this->expectException('\OutOfBoundsException');
        $this->dictionary->find('foo');
    }

    public function testExceptionThrownAccessingKeyThatDoesNotExist()
    {
        $this->expectException('\OutOfBoundsException');
        $this->dictionary['foo'];
    }

    public function testGettingValueAtGivenKey()
    {
        $key = 'foo';
        $expected = 'bar';
        $this->dictionary->add($key, $expected);
        $this->assertEquals($expected, $this->dictionary[$key]);
    }

    public function testSettingValueAtOffset()
    {
        $key = 'foo';
        $expected = 'bar';
        $this->dictionary[$key] = $expected;
        $this->assertEquals($expected, $this->dictionary->find($key));
    }

    public function testExceptionThrownGettingOffsetWithNonStringKey()
    {
        $this->expectException('\TypeError');
        $this->dictionary->add('foo', 'bar');
        $this->dictionary[0];
    }

    public function testExceptionThrownSettingValueWithNonStringKey()
    {
        $this->expectException('\InvalidArgumentException');
        $this->dictionary[0] = 'bar';
    }

    public function testRemovingItemAtOffset()
    {
        $this->dictionary->add('foo', 'bar');
        unset($this->dictionary['foo']);

        $expected = 0;
        $this->assertEquals($expected, $this->dictionary->size());
    }

}