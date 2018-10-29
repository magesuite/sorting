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

        $allSortableAttributes = $this->getAllSortableAttributes();

        if (!$subject->getAvailableSortBy()) {
            return $allSortableAttributes;
        }

        foreach ($subject->getAvailableSortBy() as $sortBy) {
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