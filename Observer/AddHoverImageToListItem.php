<?php
/**
 * Copyright © MagestyApps. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MagestyApps\HoverImage\Observer;

use Magento\Catalog\Block\Product\Image;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Element\Template;
use MagestyApps\HoverImage\Helper\Data;

class AddHoverImageToListItem implements ObserverInterface
{
    /**
     * @var string
     */
    protected $pattern = '|(.*<img [^>]*>)(.*)|i';

    /**
     * @var Data
     */
    private $helper;

    /**
     * @param Data $helper
     */
    public function __construct(
        Data $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * Insert hover image HTML into the output of image_with_border.phtml template
     *
     * @param Observer $observer
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(Observer $observer)
    {
        $block = $observer->getEvent()->getBlock();
        if ($block instanceof Image
            && $block->getHoverImageUrl()
        ) {
            $transport = $observer->getEvent()->getTransport();

            $hoverImageBlock = $block->getLayout()->createBlock(Template::class);
            $hoverImageBlock->setTemplate('MagestyApps_HoverImage::hover_image.phtml');
            $hoverImageBlock->setData($block->getData());
            $hoverImageHtml = $hoverImageBlock->toHtml();

            // Add hover image HTML to the output
            $html = preg_replace($this->pattern, '$1' . $hoverImageHtml . '$2', $transport->getHtml());

            // Add related CSS classes to the image container
            $html = str_replace(
                'class="product-image-wrapper',
                'class="product-image-wrapper has-hover-image hover-style-' . $this->helper->getHoverStyle(),
                $html
            );

            $transport->setHtml($html);
        }
    }
}
