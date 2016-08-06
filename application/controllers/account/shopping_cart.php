<?php

class Shopping_Cart extends CI_Controller{

    public $data = [];

    function add(){
        $this->load->library('cart');

        $this->cart->insert($this->data);
    }

    function show(){
        $cart = $this->cart->contents();

        return $cart;
    }

    function update(){
        $this->cart->update($this->data);
    }

    function destroy(){
        $this->cart->destroy();
    }

    function total(){

        return $this->cart->total();
    }

    function remove(){
        /*Remove Item by setting up "quantity = 0"*/
        $this->cart->update($this->data);
    }
}