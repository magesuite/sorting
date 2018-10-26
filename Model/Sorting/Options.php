<?php

namespace MageSuite\Sorting\Model\Sorting;

class Options
{
    /**
     * @var \Magento\Catalog\Model\Config
     */
    protected $catalogConfig;

    public function __construct(\Magento\Catalog\Model\Config $catalogConfig)
    {
        $this->catalogConfig = $catalogConfig;
    }

    public function getOptions()
    {
        $options = [];

        $options[] = [
            'label' => __('Position - Ascending'),
            'value' => 'position_direction_asc'
        ];

        $options[] = [
            'label' => __('Position - Descending'),
            'value' => 'position_direction_desc'
        ];

        foreach ($this->catalogConfig->getAttributesUsedForSortBy() as $attribute) {
            $ascendingLabel = $attribute['frontend_label'].' - Ascending';
            $descendingLabel = $attribute['frontend_label'].' - Descending';

            $options[] = [
                'label' => __($ascendingLabel),
                'value' => $attribute['attribute_code'].'_direction_asc'
            ];

            $options[] = [
                'label' => __($descendingLabel),
                'value' => $attribute['attribute_code'].'_direction_desc'
            ];
        }

        return $options;
    }
}