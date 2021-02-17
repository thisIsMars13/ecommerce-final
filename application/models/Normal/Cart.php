<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Cart extends CI_Model
    {
        public function shopping_cart()
        {
            $query = "select products.stock_count, products.name, products.price, carts.quantity, carts.id from products
                      left join carts on carts.products_id = products.id
                      left join users on carts.user_id = users.id
                      where carts.user_id = ?";
            return $this->db->query($query, $this->session->userdata('id'))->result_array();
        }

        public function update_quantity($post)
        {
            $this->db->query("update carts set quantity = ? where user_id = ? and id = ?", array($post['quantity'], $this->session->userdata('id'), $post['carts_id']));
        }

        public function delete($post)
        {
            $this->db->query("delete from carts where user_id = ? and id = ?", array($this->session->userdata('id'), $post['carts_id']));
        }
    }
?>