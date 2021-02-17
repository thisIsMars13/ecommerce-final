<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Carts extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('normal/cart');
            $this->load->model('normal/profile');
        }
        public function cart()
        {
            $this->load->view("normal/shopping_cart");
        }

        public function cart_load()
        {
            $carts['products'] = $this->cart->shopping_cart();
            $carts['shipping_data'] = $this->profile->get_shipping_address();
            $carts['billing_form'] = $this->profile->get_billing_address();
            $data = array(
                'products_table' => $this->load->view('normal/partials/carts_products', $carts, true),
                'count' => count($this->cart->shopping_cart()),
                'shipping_billing_form' => $this->load->view('normal/partials/shipping_billing_form_checkout', $carts, true)
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        public function update_quantity()
        {
            $this->cart->update_quantity($this->input->post(null, true));
            $carts['products'] = $this->cart->shopping_cart();
            $data = array(
                'products_table' => $this->load->view('normal/partials/carts_products', $carts, true),
                'count' => count($this->cart->shopping_cart())
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        public function delete()
        {
            $this->cart->delete($this->input->post(null, true));
            $carts['products'] = $this->cart->shopping_cart();
            $data = array(
                'products_table' => $this->load->view('normal/partials/carts_products', $carts, true),
                'count' => count($this->cart->shopping_cart())
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }
?>