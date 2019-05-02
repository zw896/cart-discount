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
        	'price'		=> $this->productList[$sku], 
        	'quantity'	=> $quantity + $number, 
        	'totalPrice'=> 0
        );
    }

    public function printCart()
    {
    	$result = array();
        echo "Products in cart: ";
        foreach($this->cart as $sku => $detail)
        {
            if($detail['quantity'] > 1) 
            	$result[] = $sku . " x " . $detail['quantity'];
            else
            	$result[] = $sku;            
        }
        echo implode(', ', $result);
        echo "\n";
    }

    public function total()
    {
    	$totalPrice = 0;
    	foreach($this->cart as $sku => $detail)
        {
            $totalPrice += $this->afterDiscount($sku, $detail);
        }
        echo "Expected total: " . $totalPrice . "\n\n";
    }

    private function afterDiscount($sku, $detail)
    {
        $rules = $this->getPricingRules($sku);
        $offerDetail = $this->pricingRules[$sku];

        // buy 10 or more copies of The Mythical Man-Month, and receive them at the discounted price of $21.99
        if ($rules == 'lowerPrice' && $detail['quantity'] >= 10) {
        	return $this->lowerPriceTotal($detail['quantity'], $offerDetail);
        }
        // buy 1 Game of Thrones: Season 1, will get 1 The Fresh Prince of Bel-Air free
        elseif ($rules == 'buyOneGetOneFree') {
        	$price = $this->noDiscountPriceTotal($detail);
        	$offerSku = $offerDetail['offer'];
        	$freeQuantity = $detail['quantity'];

        	// if there are 9325336028278 in the cart
        	if (isset($this->cart[$offerSku])) {
        		// case 1: customer bought more Game of Thrones: Season 1 than The Fresh Prince of Bel-Air
    			if ($freeQuantity > $this->cart[$offerSku]['quantity']) {
    				$diff = $freeQuantity - $this->cart[$offerSku]['quantity'];
    				$price -= $this->cart[$offerSku]['quantity'] * $this->cart[$offerSku]['price'];
    				for ($i = 0; $i < $diff; $i++) {
	    				$this->addProduct('9325336028278');
	    			}
    			}
    			// case 2: customer bought Game of Thrones: Season 1 less than The Fresh Prince of Bel-Air
    			else {
    				$price -= $freeQuantity * $this->cart[$offerSku]['price'];
    			}
    		}
    		// case 3: if there are no 9325336028278 in the cart, just add
    		else {
    			for ($i = 0; $i < $detail['quantity']; $i++) {
    				$this->addProduct('9325336028278');
    			}
    		}

    		echo "Cart after added free The Fresh Prince of Bel-Air \n";
        	$this->printCart();

        	return $price;
        }
        // 3 for the price of 2 deal on Coders at Work. (Buy 3 get 1 free);
        elseif ($rules == 'buyThreeGetOneFree' && $detail['quantity'] >= 3) {
        	return $this->buyThreeGetOneFreeTotal($sku, $detail);
        }
        else
        	return $this->noDiscountPriceTotal($detail);
        
    }

    /**
     * @param $detail: [price], [quantity]
     * @param $rules
     * @return float || int
     */
    private function lowerPriceTotal($quantity, $sku)
    {
        $lowerPrice = $sku['offer'];
        return $quantity * $lowerPrice;
    }

    // 3 for the price of 2 deal on Coders at Work. (Buy 3 get 1 free);
    private function buyThreeGetOneFreeTotal($sku, $detail)
    {
        // echo floor($detail['quantity'] / 3);
        $freeQuantity = floor($detail['quantity'] / 3);
        $totalQuantity = $detail['quantity'];
        $price = $detail['price'];
        return $price * ($totalQuantity - $freeQuantity);
    }

    private function noDiscountPriceTotal($detail)
    {
        return $detail['price'] * $detail['quantity'];
    }

	private function getPricingRules($sku)
    {
        foreach ($this->pricingRules as $index=>$detail)
        {
        	if ($index == $sku)
        		return $detail['discount'];
        }
        return -1;
    }    
}
?>