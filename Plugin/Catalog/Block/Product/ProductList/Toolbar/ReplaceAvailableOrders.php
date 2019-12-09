<?php

namespace MageSuite\Sorting\Plugin\Catalog\Block\Product\ProductList\Toolbar;


class ReplaceAvailableOrders
{
    /**
     * @var \MageSuite\Sorting\Model\Sorting\Options
     */
    protected $options;

    public function __construct(\MageSuite\Sorting\Model\Sorting\Options $options)
    {
        $this->options = $options;
    }

    public function aroundGetAvailableOrders(\Magento\Catalog\Block\Product\ProductList\Toolbar $subject, callable $proceed)
    {
        $options = [];
        foreach ($this->options->getOptions() as $option) {
            $options[$option['value']] = $option['label'];
        }
        return $options;
    }
}