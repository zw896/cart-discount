<?php
require_once ("Cart.php");

$pricingRules = array(
	0 => array(
		'9325336130810' => array(
			'orderNum'		=> 	1, 
			'discountMethod'=>	'complementary', 
			'rule'		=>	array(
				'9325336028278' => 1 
			)
		)
	),
);

$cart = new Cart($pricingRules);
$cart->addProduct('9780201835953', 10);
$cart->addProduct('9325336028278');
$cart->printCart();
// $cart->getTotal();

$cart = new Cart($pricingRules);
$cart->addProduct('9781430219484', 3);
$cart->addProduct('9780132071482');
$cart->printCart();
// $cart->getTotal();

$cart = new Cart($pricingRules);
$cart->addProduct('9325336028278');
$cart->addProduct('9780201835953');
$cart->addProduct('9325336130810');
$cart->printCart();
// $cart->getTotal();
?>