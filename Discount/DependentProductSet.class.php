<?php

/**
 * Class Discount_DependentProductSet
 * Класс скидки зависимых продуктов (правило 4)
 */


class Discount_DependentProductSet extends Discount
{
    protected $main_product = null;
    protected $dependent_products = array();

    public function setMainProduct(Product $product)
    {
        $this->main_product = $product;
    }

    public function setDependentProduct(Product $product)
    {
        $this->dependent_products[] = $product;
    }

    public function doCalculation()
    {
        $sum = 0;
        $main_product = false;

        if(!is_object($this->main_product) || count($this->dependent_products) == 0) {
            return $sum;
        }
        $products = &$this->order->products;

        //Ищем ведущий продукт в заказе
        foreach($products as $product) {
            if($product['product'] == $this->main_product) {
                $main_product = true;
            }
        }
        reset($products);
        if(!$main_product) return $sum;

        //Ищем любой из зависимых продуктов
        foreach($products as &$product) {
            if(in_array($product['product'], $this->dependent_products) && $product['isDiscounted'] == 0) {
                $sum += $product['product']->getPrice();
                $product['isDiscounted'] = 1;
            }
        }
        return $sum * $this->getDiscount();
    }
}