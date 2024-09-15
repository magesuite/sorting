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
            'label' => __('Relevance'),
            'value' => 'relevance_direction_desc'
        ];

        $options[] = [
            'label' => __('Position - Ascending'),
            'value' => 'position_direction_asc'
        ];

        $options[] = [
            'label' => __('Position - Descending'),
            'value' => 'position_direction_desc'
        ];

        foreach ($this->catalogConfig->getAttributesUsedForSortBy() as $attribute) {
            $ascendingLabel = $attribute['frontend_label'] . __(' - Ascending');
            $descendingLabel = $attribute['frontend_label'] . __(' - Descending');

            $options[] = [
                'label' => $ascendingLabel,
                'value' => sprintf('%s_direction_asc', $attribute['attribute_code'])
            ];

            $options[] = [
                'label' => $descendingLabel,
                'value' => sprintf('%s_direction_desc', $attribute['attribute_code'])
            ];
        }

        return $options;
    }
}
