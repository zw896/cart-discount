<?php
class Cart {
	protected $productList;
    protected $pricingRules;
    protected $cart;

    public function __construct($pricingRules)
    {
        $this->productList = array(
			'9325336130810' => 39.49,
			'9325336028278' => 19.99,
			'9780201835953' => 31.87,
			'9781430219484' => 28.72,
			'9780132071482' => 119.92,
	 	);
        $this->pricingRules = $pricingRules;
        $this->cart = array();
    }

    public function addProduct($sku, $number = 1)
    {
    	// if there already has $sku product in cart
    	$quantity = 0;
        if(isset($this->cart[$sku]))
            $quantity = $this->cart[$sku]['quantity'];
        // add to cart
        $this->cart[$sku] = array(
        	'sku'		=> $sku,
        	'price'		=> $this->productList[$productID], 
        	'quantity'	=> $quantity + $number, 
        	'totalPrice'=> 0
        );
    }

    public function printCart()
    {
    	$result = array();
        echo "Products in cart: ";
        foreach ($this->cart as $sku => $detail)
        {
            if($detail['quantity'] > 1) 
            	$result[] = $sku . " x " . $detail['quantity'];
            else
            	$result[] = $sku;            
        }
        echo implode(', ', $result);
        echo "\n";
    }
}
?>