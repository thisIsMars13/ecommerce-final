<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Order extends CI_Model
    {
        public function process_order($post)
        {
            $carts = $this->db->query("select * from carts where user_id = ?", $this->session->userdata("id"))->result_array();
            $value_billing = array(
                $post['billing_first_name'],
                $post['billing_last_name'],
                $post['billing_address1'],
                $post['billing_address2'],
                $post['billing_city'],
                $post['billing_state'],
                $post['billing_zipcode'],
                date("Y-m-d, H:i:s,"),
                date("Y-m-d, H:i:s,")
            ); 

            $value_shipping = array(
                $post['shipping_first_name'],
                $post['shipping_last_name'],
                $post['shipping_address1'],
                $post['shipping_address2'],
                $post['shipping_city'],
                $post['shipping_state'],
                $post['shipping_zipcode'],
                date("Y-m-d, H:i:s,"),
                date("Y-m-d, H:i:s,")
            );

            $this->db->query("insert into order_billing_addresses (first_name, last_name, address1, address2, city, state, zipcode, created_at, updated_at) value(?, ?, ?, ?, ?, ?, ?, ?, ?)", $value_billing);
            $inserted_billing_id = $this->db->insert_id();
            $this->db->query("insert into order_shipping_addresses (first_name, last_name, address1, address2, city, state, zipcode, created_at, updated_at) value(?, ?, ?, ?, ?, ?, ?, ?, ?)", $value_shipping);
            $inserted_shipping_id = $this->db->insert_id();

            $value_order = array(
                1,
                $inserted_billing_id,
                $inserted_shipping_id,
                $this->session->userdata('id'),
                $post['token'],
                $post['charge'],
                date("Y-m-d, H:i:s,"),
                date("Y-m-d, H:i:s,")
            );

            $this->db->query("insert into order_details (order_status_id, order_billing_address_id, order_shipping_address_id, user_id, token, charge, created_at, updated_at) value (?, ?, ?, ?, ?, ?, ?, ?)", $value_order);
            $inserted_order_id = $this->db->insert_id();

            foreach($carts as $cart)
            {
                $value_cart = array(
                    $cart['quantity'],
                    $cart['products_id'],
                    $inserted_order_id,
                    date("Y-m-d, H:i:s,"),
                    date("Y-m-d, H:i:s,")
                );
                $this->db->query("insert into ordered_products (quantity, products_id, order_detail_id, created_at, updated_at) value (?, ?, ?, ?, ?)", $value_cart);
            }

            $this->db->query("delete from carts where user_id = ?", $this->session->userdata('id'));
        }

        public function get_all_orders_by_user()
        {
            $query = "select order_details.id, order_details.is_review, order_details.created_at, order_status.status, order_billing_addresses.address1, order_billing_addresses.address2, order_billing_addresses.city, order_billing_addresses.state, order_billing_addresses.zipcode, order_shipping_addresses.first_name, order_shipping_addresses.last_name, sum(ordered_products.quantity  * products.price) as total from order_details
                      left join order_status on order_details.order_status_id = order_status.id
                      left join order_billing_addresses on order_details.order_billing_address_id = order_billing_addresses.id
                      left join order_shipping_addresses on order_details.order_shipping_address_id = order_shipping_addresses.id
                      left join ordered_products on order_details.id = ordered_products.order_detail_id
                      left join products on ordered_products.products_id = products.id
                      where order_details.user_id = ?
                      group by order_details.id";
                      
            return $this->db->query($query, $this->session->userdata('id'))->result_array();
        }

        public function get_order_by_id($id)
        {
            $query = "select order_details.id, order_status.status, order_billing_addresses.address1 as billing_add1, order_billing_addresses.address2 billing_add2, order_billing_addresses.city billing_city, order_billing_addresses.state as billing_state, order_billing_addresses.zipcode as billing_zipcode, order_billing_addresses.first_name as billing_first_name, order_billing_addresses.last_name as billing_last_name, order_shipping_addresses.address1 as shipping_add1, order_shipping_addresses.address2 shipping_add2, order_shipping_addresses.city shipping_city, order_shipping_addresses.state as shipping_state, order_shipping_addresses.zipcode as shipping_zipcode, order_shipping_addresses.first_name as shipping_first_name, order_shipping_addresses.last_name as shipping_last_name, products.id as product_id, products.name as product_name, products.price as product_price, ordered_products.quantity from order_details
                      left join order_status on order_details.order_status_id = order_status.id
                      left join order_billing_addresses on order_details.order_billing_address_id = order_billing_addresses.id
                      left join order_shipping_addresses on order_details.order_shipping_address_id = order_shipping_addresses.id
                      left join ordered_products on order_details.id = ordered_products.order_detail_id
                      left join products on ordered_products.products_id = products.id
                      where order_details.id = ?";

            return $this->db->query($query, $id)->result_array();
        }

        public function get_reviews_without_review($order_id, $products_id)
        {
            foreach($products_id as $product_id)
            {
                $ids[] = $product_id['product_id'];
            }         
            return $this->db->query("select products.name, ordered_products.products_id, ordered_products.order_detail_id from ordered_products
                                     left join products on ordered_products.products_id = products.id
                                     where ordered_products.order_detail_id = ? and ordered_products.products_id not in ?", array($order_id, $ids))->result_array();
        }

        public function get_current_review_by_order($order_id)
        {
            return $this->db->query("select product_id from reviews where order_detail_id = ?", $order_id)->result_array();
        }

        public function load_form_review($id)
        {
            return $this->db->query("select products.name, ordered_products.products_id, ordered_products.order_detail_id from ordered_products
                                     left join products on ordered_products.products_id = products.id
                                     where ordered_products.order_detail_id = ?", $id)->result_array();
        }

        public function get_cart_total_by_userid()
        {
            return $this->db->query("select sum(carts.quantity * products.price) as total from carts left join products on products.id = carts.products_id where carts.user_id = ? group by carts.user_id", $this->session->userdata('id'))->row_array();
        }

        public function add_review($post, $order_id, $product_id)
        {
            $values = array(
                $order_id,
                $product_id,
                $post['rating'],
                $post['review'],
                date("Y-m-d, H:i:s,"),
                date("Y-m-d, H:i:s,")
            );
            $this->db->query("insert into reviews (order_detail_id, product_id, rating, review, created_at, updated_at) value (?, ?, ?, ?, ?, ?)", $values);
        }
        public function done_review($order_id)
        {
            $this->db->query("update order_details set is_review = 1 where order_details.id = ?", $order_id);
        }
    } 
?>