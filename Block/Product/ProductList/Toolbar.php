<?php

namespace MageSuite\Sorting\Block\Product\ProductList;

/**
 * Class had to be overwritten because original getCurrentOrder and getCurrentDirection methods access protected
 * properties. It was not possible to implement new logic using plugins
 */
class Toolbar extends \Magento\Catalog\Block\Product\ProductList\Toolbar
{
    public function getCurrentOrder()
    {
        $order = $this->_getData('_current_grid_order');
        if ($order) {
            return $order;
        }

        $availableOrders = $this->getAvailableOrders();

        $orders = [];

        foreach($availableOrders as $identifier => $label) {
            $orders[$this->getSortingFieldFromIdentifier($identifier)] = $label;
        }

        $defaultOrder = $this->getSortingFieldFromIdentifier($this->getOrderField());

        if (!isset($orders[$defaultOrder])) {
            $keys = array_keys($orders);
            $defaultOrder = $keys[0];
        }

        $order = $this->_toolbarModel->getOrder();
        if (!$order || !isset($orders[$order])) {
            $order = $defaultOrder;
        }

        if ($order != $defaultOrder) {
            $this->_memorizeParam('sort_order', $order);
        }

        $this->setData('_current_grid_order', $order);
        return $order;
    }

    /**
     * Retrieve current direction
     *
     * @return string
     */
    public function getCurrentDirection()
    {
        $dir = $this->_getData('_current_grid_direction');
        if ($dir) {
            return $dir;
        }

        $directions = ['asc', 'desc'];
        $dir = strtolower($this->_toolbarModel->getDirection());

        if (!$dir || !in_array($dir, $directions)) {
            $dir = $this->getSortingDirectionFromIdentifier($this->getOrderField());
        }

        if ($dir != $this->_direction) {
            $this->_memorizeParam('sort_direction', $dir);
        }

        $this->setData('_current_grid_direction', $dir);
        return $dir;
    }

    public function getSortingFieldFromIdentifier($identifier) {
        $parts = explode('_direction_', $identifier);

        return $parts[0];
    }

    public function getSortingDirectionFromIdentifier($identifier) {
        $parts = explode('_direction_', $identifier);

        return isset($parts[1]) ? $parts[1] : 'asc';
    }
}