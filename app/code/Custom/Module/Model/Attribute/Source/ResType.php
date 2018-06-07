<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Custom\Module\Model\Attribute\Source;

/**
 * @api
 * @since 100.0.2
 */
class ResType extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        $this->_options = [
            ['label' => __('Select Option'), 'value' => ''],
            ['label' => __('Residential'), 'value' => 'Residential'],
            ['label' => __('Business'), 'value' => 'Business'],
        ];
        return $this->_options;
    }

    /**
     * Get a text for option value
     *
     * @param string|integer $value
     * @return string|bool
     */
    public function getOptionText($value)
    {
        foreach ($this->getAllOptions() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }
}