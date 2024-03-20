<?php
/**
 * Copyright © MagestyApps. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MagestyApps\HoverImage\Plugin;

use Magento\Catalog\Block\Product\Image as ImageBlock;
use Magento\Catalog\Block\Product\ImageFactory;
use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Image\ParamsBuilder;
use Magento\Catalog\Model\View\Asset\ImageFactory as AssetImageFactory;
use Magento\Framework\View\ConfigInterface;
use MagestyApps\HoverImage\Helper\Data;

class ImageFactoryPlugin
{
    /**
     * @var Data
     */
    private $helper;

    /**
     * @var ConfigInterface
     */
    private $presentationConfig;

    /**
     * @var AssetImageFactory
     */
    private $viewAssetImageFactory;

    /**
     * @var ParamsBuilder
     */
    private $imageParamsBuilder;

    /**
     * @param Data $helper
     * @param ConfigInterface $presentationConfig
     * @param AssetImageFactory $viewAssetImageFactory
     * @param ParamsBuilder $imageParamsBuilder
     */
    public function __construct(
        Data $helper,
        ConfigInterface $presentationConfig,
        AssetImageFactory $viewAssetImageFactory,
        ParamsBuilder $imageParamsBuilder
    ) {
        $this->helper = $helper;
        $this->presentationConfig = $presentationConfig;
        $this->viewAssetImageFactory = $viewAssetImageFactory;
        $this->imageParamsBuilder = $imageParamsBuilder;
    }

    /**
     * Add hover image URL and label to the original image's block data
     *
     * @param ImageFactory $subject
     * @param ImageBlock $imageBlock
     * @param Product $product
     * @param string $imageId
     * @param array|null $attributes
     * @return ImageBlock
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function afterCreate(
        ImageFactory $subject,
        ImageBlock $imageBlock,
        Product $product,
        string $imageId,
        array $attributes = null
    ) {
        if ($this->helper->isEnabled()) {
            if ($hoverImage = $this->helper->getProductHoverImage($product)) {
                // Prepare original image's config
                $viewImageConfig = $this->presentationConfig->getViewConfig()->getMediaAttributes(
                    'Magento_Catalog',
                    ImageHelper::MEDIA_TYPE_CONFIG_NODE,
                    $imageId
                );

                $imageMiscParams = $this->imageParamsBuilder->build($viewImageConfig);

                // Create an asset with original image's parameters but with the hover image path
                $imageAsset = $this->viewAssetImageFactory->create(
                    [
                        'miscParams' => $imageMiscParams,
                        'filePath' => $hoverImage->getFile(),
                    ]
                );

                $imageBlock->addData([
                    'hover_image_url' => $imageAsset->getUrl(),
                    'hover_image_label' => $hoverImage->getLabel()
                ]);
            }
        }

        return $imageBlock;
    }
}
