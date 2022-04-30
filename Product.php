<?php

class Product
{
    private $title;
    private $price;
    private $desc;
    private $picture;


    public function __construct($title, $price, $desc, $picture)
    {
        $this->title = $title;
        $this->price = $price;
        $this->desc = $desc;
        $this->picture = $picture;
    }
}
