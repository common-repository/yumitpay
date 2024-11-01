<?php
class YMTP_Product
{
    public $sku;
    public $description;
    public $price;
    public $quantity;
    public $total_tax;
    public $name;

    public function __construct($sku, $description, $price, $quantity, $total_tax, $name)
    {
        $this->sku = $sku;
        $this->description = $description;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->total_tax = $total_tax;
        $this->name = $name;
    }
}
