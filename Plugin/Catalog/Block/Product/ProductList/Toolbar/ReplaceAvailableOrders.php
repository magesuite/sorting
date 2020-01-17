<?php

namespace MageSuite\Sorting\Plugin\Catalog\Block\Product\ProductList\Toolbar;


class ReplaceAvailableOrders
{
    /**
     * @var \MageSuite\Sorting\Model\Sorting\Options
     */
    protected $options;
    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    public function __construct(
        \MageSuite\Sorting\Model\Sorting\Options $options,
        \Magento\Framework\Registry $registry
    )
    {
        $this->options = $options;
        $this->registry = $registry;
    }

    public function aroundGetAvailableOrders(\Magento\Catalog\Block\Product\ProductList\Toolbar $subject, callable $proceed)
    {
        $availableSortBy = [];

        $allSortableAttributes = $this->getAllSortableAttributes();

        $currentCategory = $this->registry->registry('current_category');
        if (!$currentCategory->getAvailableSortBy()) {
            return $allSortableAttributes;
        }

        foreach ($currentCategory->getAvailableSortBy() as $sortBy) {
            if (!isset($allSortableAttributes[$sortBy])) {
                continue;
            }

            $availableSortBy[$sortBy] = $allSortableAttributes[$sortBy];
        }

        if (empty($availableSortBy)) {
            return $allSortableAttributes;
        }

        return $availableSortBy;
    }

    protected function getAllSortableAttributes()
    {
        $options = [];

        /* @var $attribute \Magento\Eav\Model\Entity\Attribute\AbstractAttribute */
        foreach ($this->options->getOptions() as $option) {
            $options[$option['value']] = $option['label'];
        }

        return $options;
    }
}