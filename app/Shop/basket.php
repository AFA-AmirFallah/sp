<?php

namespace App\Shop;

use App\Http\Controllers\woocommerce\product;
use App\Models\tashim;

class BasketItem
{
    private $product_id;
    private $warehouse_good_id;
    private $quantity;
    private $unit_price;
    private $tasim;
    private $total_price;

    private function get_default_tashim()
    {
        $default_tashim_src = tashim::where('extra', 'defualt')->first();
        if($default_tashim_src == null){ // if the default tashim is not set
            return 0;
        }
        return $default_tashim_src->id ;
    }

    public function __construct($product_id, $warehouse_good_id, $quantity, $unit_price, $tasim = null, $total_price = null)
    {
        $this->product_id = $product_id;
        $this->warehouse_good_id = $warehouse_good_id;
        $this->quantity = $quantity;
        $this->unit_price = $unit_price;
        if ($tasim == null) { // If tashim not set from caller side use default tashim 
            $tasim = $this->tasim = $this->get_default_tashim();
        }
        $product = new product;
        


    }
}

class ShopBasket
{
    public $items = [];

    public function addItem($item)
    {
        $this->items[] = $item;
    }

    public function removeItem($item)
    {
        $key = array_search($item, $this->items);
        if ($key !== false) {
            unset($this->items[$key]);
        }
    }

    public function calculateTotal()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->price * $item->quantity;
        }
        return $total;
    }
}

// Usage example
$item1 = new BasketItem("Product 1", 10, 2);
$item2 = new BasketItem("Product 2", 20, 1);

$basket = new ShopBasket();
$basket->addItem($item1);
$basket->addItem($item2);

echo "Total cost: $" . $basket->calculateTotal();
