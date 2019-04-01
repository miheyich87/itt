<?php

/**
 * Class Discount_Manager
 * Менеджер скидок, объединяет все продукты заказа, попадающие под скидку
 */


class Discount_Manager
{
    protected $discounts = array();
    protected $order;

    public function setOrder(Order $order)
    {
        $this->order = $order;
    }

    public function addDiscount($discount)
    {
        $this->discounts[] = $discount;
    }

    public function getDiscount()
    {
        return $this->discounts;
    }

    public function doCalculation()
    {
        $sum = 0;
        foreach ($this->discounts as $discount) {
            $discount->setOrder($this->order);
            $sum += $discount->doCalculation();
        }
        return $sum;
    }
}