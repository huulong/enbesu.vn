<?php
class Cart {
    public $id;
    public $name;
    public $image;
    public $price;
    public $quantity;

    public function __construct($id = null, $name = null, $image = null, $price = null, $quantity = 1) {
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getTotal() {
        return (float)str_replace(',', '', $this->price) * $this->quantity;
    }
}
?>
