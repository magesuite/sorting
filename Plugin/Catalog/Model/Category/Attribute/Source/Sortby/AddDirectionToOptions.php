<?php

namespace MageSuite\Sorting\Plugin\Catalog\Model\Category\Attribute\Source\Sortby;

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

    public function aroundGetAllOptions(\Magento\Catalog\Model\Category\Attribute\Source\Sortby $subject, callable $proceed)
    {
        return $this->options->getOptions();
    }
}