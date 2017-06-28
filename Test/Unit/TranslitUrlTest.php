<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace SR\UnicodeUrl\Test\Unit;

class TranslitUrlTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\Framework\Filter\TranslitUrl
     */
    protected $model;

    protected function setUp()
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->model = $objectManager->getObject('SR\UnicodeUrl\Filter\AbstractTranslitUrl');
    }

    /**
     * @param string $testString
     * @param string $result
     * @dataProvider filterDataProvider
     */
    public function testFilter($testString, $result)
    {
        $this->assertEquals($result, $this->model->filter($testString));
    }

    /**
     * @return array
     */
    public function filterDataProvider()
    {
        return [
            ['test', 'test'],
            ['привет мир', 'привет-мир'],
            ['Weiß, Goldmann, Göbel, Weiss, Göthe, Goethe und Götz', 'weiß-goldmann-göbel-weiss-göthe-goethe-und-götz'],
            ['my-product-❤', 'my-product-❤'],
            ['החולצה המהממת שלנו!','החולצה-המהממת-שלנו']
        ];
    }
}
