<?php

/**
 * Class Discount
 * Абстрактный класс скидки описывающий основные свойства и методы, свойственные всем потомкам
 */


abstract class Discount
{
    protected $discount = 1;
    protected $order;

    abstract function doCalculation();

    public function  setDiscount($discount)
    {
        $this->discount = 1 - $discount/100;
    }

    public function getDiscount()
    {
        return $this->discount;
    }

    public function setOrder(Order $order)
    {
        $this->order = $order;
    }
}
