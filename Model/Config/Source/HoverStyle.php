<?php
/**
 * Copyright © MagestyApps. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MagestyApps\HoverImage\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class HoverStyle implements OptionSourceInterface
{
    const SLIDE_LEFT = 'slide-left';
    const SLIDE_RIGHT = 'slide-right';
    const SLIDE_UP = 'slide-up';
    const SLIDE_DOWN = 'slide-down';
    const FADE = 'fade';

    /**
     * @return array[]
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::SLIDE_LEFT, 'label' => __('Slide Left')],
            ['value' => self::SLIDE_RIGHT, 'label' => __('Slide Right')],
            ['value' => self::SLIDE_UP, 'label' => __('Slide Up')],
            ['value' => self::SLIDE_DOWN, 'label' => __('Slide Down')],
            ['value' => self::FADE, 'label' => __('Fade')],
        ];
    }
}
