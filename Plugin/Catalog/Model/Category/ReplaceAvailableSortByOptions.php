<?php

namespace MageSuite\Sorting\Plugin\Catalog\Model\Category;

class ReplaceAvailableSortByOptions
{
    /**
     * @var \MageSuite\Sorting\Model\Sorting\Options
     */
    protected $options;

    public function __construct(\MageSuite\Sorting\Model\Sorting\Options $options)
    {
        $this->options = $options;
    }

    public function aroundGetAvailableSortByOptions(\Magento\Catalog\Model\Category $subject, callable $proceed)
    {
        $availableSortBy = [];
        $defaultSortBy = $this->getAttributeUsedForSortByArray();
        if ($subject->getAvailableSortBy()) {
            foreach ($subject->getAvailableSortBy() as $sortBy) {
                if (isset($defaultSortBy[$sortBy])) {
                    $availableSortBy[$sortBy] = $defaultSortBy[$sortBy];
                }
            }
        }

        if (!$availableSortBy) {
            $availableSortBy = $defaultSortBy;
        }

        return $availableSortBy;
    }

    protected function getAttributeUsedForSortByArray()
    {
        $options = [];

        /* @var $attribute \Magento\Eav\Model\Entity\Attribute\AbstractAttribute */
        foreach ($this->options->getOptions() as $option) {
            $options[$option['value']] = $option['label'];
        }

        return $options;
    }
}