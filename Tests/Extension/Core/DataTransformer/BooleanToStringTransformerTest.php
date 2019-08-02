<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Form\Tests\Extension\Core\DataTransformer;

use PHPUnit\Framework\TestCase;
use Symfony\Bridge\PhpUnit\ForwardCompatTestTrait;
use Symfony\Component\Form\Extension\Core\DataTransformer\BooleanToStringTransformer;

class BooleanToStringTransformerTest extends TestCase
{
    use ForwardCompatTestTrait;

    const TRUE_VALUE = '1';

    /**
     * @var BooleanToStringTransformer
     */
    protected $transformer;

    private function doSetUp()
    {
        $this->transformer = new BooleanToStringTransformer(self::TRUE_VALUE);
    }

    private function doTearDown()
    {
        $this->transformer = null;
    }

    public function testTransform()
    {
        $this->assertEquals(self::TRUE_VALUE, $this->transformer->transform(true));
        $this->assertNull($this->transformer->transform(false));
    }

    // https://github.com/symfony/symfony/issues/8989
    public function testTransformAcceptsNull()
    {
        $this->assertNull($this->transformer->transform(null));
    }

    public function testTransformFailsIfString()
    {
        $this->expectException('Symfony\Component\Form\Exception\TransformationFailedException');
        $this->transformer->transform('1');
    }

    public function testReverseTransformFailsIfInteger()
    {
        $this->expectException('Symfony\Component\Form\Exception\TransformationFailedException');
        $this->transformer->reverseTransform(1);
    }

    public function testReverseTransform()
    {
        $this->assertTrue($this->transformer->reverseTransform(self::TRUE_VALUE));
        $this->assertTrue($this->transformer->reverseTransform('foobar'));
        $this->assertTrue($this->transformer->reverseTransform(''));
        $this->assertFalse($this->transformer->reverseTransform(null));
    }
}
