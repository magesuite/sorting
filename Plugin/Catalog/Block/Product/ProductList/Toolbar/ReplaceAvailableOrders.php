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

    /**
     * @var \Magento\Store\Model\StoreManager
     */
    protected $storeManager;

    /**
     * @var \Magento\Catalog\Model\CategoryRepository
     */
    protected $categoryRepository;

    public function __construct(
        \MageSuite\Sorting\Model\Sorting\Options $options,
        \Magento\Framework\Registry $registry,
        \Magento\Store\Model\StoreManager $storeManager,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository
    )
    {
        $this->options = $options;
        $this->registry = $registry;
        $this->storeManager = $storeManager;
        $this->categoryRepository = $categoryRepository;
    }

    public function aroundGetAvailableOrders(\Magento\Catalog\Block\Product\ProductList\Toolbar $subject, callable $proceed)
    {
        $sortingAttributes = $this->getAllSortableAttributes();

        $category = $this->registry->registry('current_category') ?: $this->getDefaultCategory();
        $availableSortingAttributes = $category->getAvailableSortBy();

        if($availableSortingAttributes) {
            $sortingAttributes = $this->filterAttributes($sortingAttributes, $availableSortingAttributes);
        }

        return $sortingAttributes;
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

    protected function getDefaultCategory()
    {
        $categoryId = $this->storeManager->getStore()->getRootCategoryId();
        return $this->categoryRepository->get($categoryId);
    }

    protected function filterAttributes($sortingAttributes, $availableSortingAttributes)
    {
        $filtered = [];
        foreach($availableSortingAttributes as $sortBy) {
            $filtered[$sortBy] = $sortingAttributes[$sortBy];
        }

        return $filtered;
    }
}