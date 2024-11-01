<?php
class YMTP_Order
{
    public $currency;
    public $subtotal;
    public $shipping;
    public $total;
    public $tax;
    public $discount;
    public $discountDesc;
    /** @var YMTP_Product[] */
    public $items;

    public function setItems(
        $items
    ) {
        $this->items = $items;
    }

    private function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    public function setTotal($total) {
        $this->total = (float)$total;
        $this->subtotal = (float)$total;
    }
}
