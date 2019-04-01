<?php

/**
 * Class Discount_CountProductSet
 * Класс скидки по количеству
 */

class Discount_CountProductSet extends Discount
{
    protected $discountRule = array();
    protected $exceptedProducts = array();

    public function addExpectedProduct(Product $exceptedProduct)
    {
        $this->exceptedProducts[] = $exceptedProduct;
    }

    public function addDiscountRule($count, $discount)
    {
        $this->discountRule[$count] = 1- $discount/100;
    }

    public function doCalculation()
    {
        $sum = 0;
        $cnt = 0;
        $products = &$this->order->products;
        foreach($products as &$product) {
            if(!in_array($product['product'], $this->exceptedProducts) && $product['isDiscounted'] == 0) {
                $sum += $product['product']->getPrice();
                $product['isDiscounted'] = 1;
                $cnt++;
            }
        }

        if(array_key_exists($cnt, $this->discountRule)) {
            $sum *= $this->discountRule[$cnt];
        }
        return $sum;
    }
}