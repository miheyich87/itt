<?php



//autoload всех используемых классов
spl_autoload_register(function ($class) {
    $class = str_replace('_', '/', $class);
    include $class . '.class.php';
});


$productA = new Product('A', 100);
$productB = new Product('B', 100);
$productC = new Product('C', 100);
$productD = new Product('D', 100);
$productE = new Product('E', 100);
$productF = new Product('F', 100);
$productG = new Product('G', 100);
$productH = new Product('H', 100);
$productI = new Product('I', 100);
$productJ = new Product('J', 100);
$productK = new Product('K', 100);
$productL = new Product('L', 100);
$productM = new Product('M', 100);


//Формируем заказ
$order = new Order();

$order->addProduct($productA);
$order->addProduct($productA);
$order->addProduct($productB);
$order->addProduct($productD);
$order->addProduct($productC);
$order->addProduct($productE);
$order->addProduct($productF);
$order->addProduct($productG);
$order->addProduct($productH);
$order->addProduct($productI);
$order->addProduct($productJ);
$order->addProduct($productD);
$order->addProduct($productE);
$order->addProduct($productK);
$order->addProduct($productL);
$order->addProduct($productM);
$order->addProduct($productD);
$order->addProduct($productD);
$order->addProduct($productE);


//Скидка для связанных продуктов
//1 правило
$discount1 = new Discount_ProductSet();
$discount1->setProductSet($productA, $productB);
$discount1->setDiscount(10);

//2 правило
$discount2 = new Discount_ProductSet();
$discount2->setProductSet($productD, $productE);
$discount2->setDiscount(5);

//3 правило
$discount3 = new Discount_ProductSet();
$discount3->setProductSet($productE, $productF, $productG);
$discount3->setDiscount(5);


//Скидка для зависимых продуктов
//4 правило
$discount4 = new Discount_DependentProductSet();
$discount4->setMainProduct($productA);
$discount4->setDependentProduct($productK);
$discount4->setDependentProduct($productL);
$discount4->setDependentProduct($productM);
$discount4->setDiscount(5);


//Скидка по количеству
$discount5 = new Discount_CountProductSet();
$discount5->addExpectedProduct($productA);
$discount5->addExpectedProduct($productC);
//Правило 7
$discount5->addDiscountRule(3, 5);
//Правило 6
$discount5->addDiscountRule(4, 10);
//Правило 5
$discount5->addDiscountRule(5, 20);


//Создаем discount manager, набиваем в него скидки
$discountManager = new Discount_Manager();
$discountManager->addDiscount($discount1);
$discountManager->addDiscount($discount2);
$discountManager->addDiscount($discount3);
$discountManager->addDiscount($discount4);
$discountManager->addDiscount($discount5);


//Считаем
$calculator = new Calculator();
$calculator->setOrder($order);
$calculator->setDiscountManager($discountManager);
$amount = $calculator->doCalculation();



echo $amount;