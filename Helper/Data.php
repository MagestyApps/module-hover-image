<?php
/**
 * Copyright © MagestyApps. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MagestyApps\HoverImage\Helper;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Gallery\ReadHandler as GalleryReadHandler;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\DataObject;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const ATTR_HOVER_IMAGE = 'hover_image';

    const XML_PATH_ENABLED = 'magestyapps_hover_image/general/enabled';
    const XML_PATH_HOVER_STYLE = 'magestyapps_hover_image/general/hover_style';

    /**
     * @var GalleryReadHandler
     */
    private $galleryReadHandler;

    /**
     * Data constructor.
     * @param Context $context
     * @param GalleryReadHandler $galleryReadHandler
     */
    public function __construct(
        Context $context,
        GalleryReadHandler $galleryReadHandler
    ) {
        parent::__construct($context);
        $this->galleryReadHandler = $galleryReadHandler;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLED, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getHoverStyle()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_HOVER_STYLE, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get hover image for the product
     * If there is no hover image assigned, use the second image
     *
     * @param Product $product
     * @return bool|DataObject
     */
    public function getProductHoverImage(Product $product)
    {
        $hoverImage = $product->getData(Data::ATTR_HOVER_IMAGE);
        $hasHoverImage = ($hoverImage && $hoverImage !== 'no_selection');

        // Exclude 'small_image' because it is usually used in product listings
        $mainImages = [
            $product->getData('small_image'),
        ];

        $this->galleryReadHandler->execute($product);
        foreach ($product->getMediaGalleryImages() as $image) {
            if ($image->getMediaType() !== 'image' || !file_exists($image->getPath())) {
                continue;
            }

            if (($hasHoverImage && $image->getFile() === $hoverImage)
                || (!$hasHoverImage && !in_array($image->getFile(), $mainImages))
            ) {
                return $image;
            }
        }

        return false;
    }
}
