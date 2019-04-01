<?php

/**
 * Class Order
 * Класс заказа
 */


class Order
{
    public $products = array();

    public function addProduct(Product $product)
    {
        $this->products[] = array(
            'product' => $product,
            'isDiscounted' => 0,
        );
    }

    public function getProducts() {
        return $this->products;
    }

    public function getCount() {
        return count($this->products);
    }
}
