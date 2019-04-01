<?php

/**
 * Class Discount_ProductSet
 * Класс скидки связанных продуктов (для правил 1, 2, 3)
 */


class Discount_ProductSet extends Discount
{
    protected $productsSet = array();

    public function setProductSet(Product $pr1, Product $pr2, Product $pr3 = null)
    {
        $this->productsSet = func_get_args();
    }

    public function getProductSet()
    {
        return $this->productsSet;
    }

    public function doCalculation()
    {
        $sum = 0;
        $productsOrder = &$this->order->products;

        $sum = $this->doRecursive($productsOrder, $sum);
        return $sum;
    }

    //Функция для рекурсивного поиска сетов товаров и применения соответствующей скидки
    //Работает до тех пор, пока в заказе встречается соответствующий сет
    private  function doRecursive(&$productsOrder, $sum) {
        $discountProducts = array();
        foreach($this->productsSet as $productSet) {
            foreach($productsOrder as &$productOrder) {
                if($productOrder['product'] == $productSet && $productOrder['isDiscounted'] == 0) {
                    $discountProducts[] = &$productOrder;
                    break;
                }
            }
        }

        if(count($discountProducts) == count($this->productsSet)) {
            foreach($discountProducts as &$discountProduct) {
                $discountProduct['isDiscounted'] = 1;
                $sum += $discountProduct['product']->getPrice();
            }
            return $this->doRecursive($productsOrder, $sum);
        }
        return $sum * $this->getDiscount();
    }
}