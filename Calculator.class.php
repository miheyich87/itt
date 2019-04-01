<?php

/**
 * Class Calculator
 * Класс расчета финальной стоимости заказа
 * Через discount manager рассчитывает стоимость всех товаров, попадающих под условия скидок
 * doCalculateWithoutDiscount суммирует стоимость всех товаров, которые под скидку не попали
 * doCalculation возвращает сумму doCalculation от менеджера + сумма товаров без скидки
 */


class Calculator
{
    protected $order;
    protected $discountManager;

    public function setOrder(Order $order)
    {
        $this->order = $order;
    }

    public function setDiscountManager(Discount_Manager $discountManager)
    {
        $this->discountManager = $discountManager;
    }

    public function doCalculation()
    {
        $sum = 0;
        $this->discountManager->setOrder($this->order);
        $sum = $this->discountManager->doCalculation();
        $sum += $this->doCalculateWithoutDiscount();
        return $sum;
    }

    protected function doCalculateWithoutDiscount()
    {
        $sum = 0;
        foreach($this->order->getProducts() as $product) {
            if($product['isDiscounted'] == 0) {
                $sum += $product['product']->getPrice();
            }
        }
        return $sum;
    }
}
