<?php

namespace MageSuite\Sorting\Plugin\Catalog\Model\Config\Source\ListSort;

class AddDirectionToOptions
{
    /**
     * @var \MageSuite\Sorting\Model\Sorting\Options
     */
    protected $options;

    public function __construct(\MageSuite\Sorting\Model\Sorting\Options $options)
    {
        $this->options = $options;
    }

    public function aroundToOptionArray(\Magento\Catalog\Model\Config\Source\ListSort $subject, callable $proceed)
    {
        return $this->options->getOptions();
    }
}