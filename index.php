<?php
require_once ("Cart.php");

$pricingRules = array(
	// buy 1 get 1 free
	'9325336130810' => array(
		'minAmount'	=> 	1, 
		'discount'	=>	'buyOneGetOneFree', 
		'offer'		=>	'9325336028278'
	),
	// $21.99
	'9780201835953' => array(
		'minAmount'	=> 	10, 
		'discount'	=>	'lowerPrice', 
		'offer'		=>	21.99
	),
	'9781430219484' => array(
		'minAmount'	=> 	3, 
		'discount'	=>	'buyThreeGetOneFree'
	)
);

$cart = new Cart($pricingRules);
$cart->addProduct('9780201835953', 10);
$cart->addProduct('9325336028278');
$cart->printCart();
$cart->total();

// 3 for the price of 2 deal on Coders at Work. (Buy 3 get 1 free);
$cart = new Cart($pricingRules);
$cart->addProduct('9781430219484', 3);
$cart->addProduct('9780132071482');
$cart->printCart();
$cart->total();

// buy one Game of Thrones: Season 1, will get one The Fresh Prince of Bel-Air free
$cart = new Cart($pricingRules);
$cart->addProduct('9325336130810');
$cart->addProduct('9325336028278');
$cart->addProduct('9780201835953');
$cart->printCart();
$cart->total();

// buy one Game of Thrones: Season 1, will get one The Fresh Prince of Bel-Air free
$cart = new Cart($pricingRules);
$cart->addProduct('9325336028278', 3);
$cart->addProduct('9780201835953');
$cart->addProduct('9325336130810', 2);
$cart->printCart();
$cart->total();
?>