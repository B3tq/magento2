<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Catalog\Test\Unit\Block\Adminhtml\Product\Helper\Form;

class GalleryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\Framework\Registry|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $registryMock;

    /**
     * @var \Magento\Catalog\Block\Adminhtml\Product\Helper\Form\Gallery|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $gallery;

    /**
     * @var \Magento\Catalog\Model\Product|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $productMock;

    /**
     * @var \Magento\Framework\Data\Form|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $formMock;

    /**
     * @var \Magento\Framework\TestFramework\Unit\Helper\ObjectManager
     */
    protected $objectManager;

    public function setUp()
    {
        $this->registryMock = $this->getMock('Magento\Framework\Registry', [], [], '', false);
        $this->productMock = $this->getMock('Magento\Catalog\Model\Product', ['getData'], [], '', false);
        $this->formMock = $this->getMock('Magento\Framework\Data\Form', [], [], '', false);

        $this->objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->gallery = $this->objectManager->getObject(
            'Magento\Catalog\Block\Adminhtml\Product\Helper\Form\Gallery',
            [
                'registry' => $this->registryMock,
                'form' => $this->formMock
            ]
        );
    }

    public function testGetImages()
    {
        $mediaGallery = [
            'images' => [
                [
                    'value_id' => '1',
                    'file' => 'image_1.jpg',
                    'media_type' => 'image',
                ] ,
                [
                    'value_id' => '2',
                    'file' => 'image_2.jpg',
                    'media_type' => 'image',
                ]
            ]
        ];
        $this->registryMock->expects($this->once())->method('registry')->willReturn($this->productMock);
        $this->productMock->expects($this->once())->method('getData')->willReturn($mediaGallery);

        $this->assertSame($mediaGallery, $this->gallery->getImages());
    }

    public function testGetDataObject()
    {
        $this->registryMock->expects($this->once())->method('registry')->willReturn($this->productMock);

        $this->assertSame($this->productMock, $this->gallery->getDataObject());
    }

    public function testGetAttributeFieldName()
    {
        $name = 'product[image]';

        $attribute = $this->getMock('Magento\Catalog\Model\ResourceModel\Eav\Attribute', [], [], '', false);
        $attribute->expects($this->once())->method('getAttributeCode')->willReturn('image');

        $this->formMock->expects($this->once())->method('addSuffixToName')->willReturn($name);

        $this->assertSame($name, $this->gallery->getAttributeFieldName($attribute));
    }
}
