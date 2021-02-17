<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Dashboard extends CI_Model
    {
        public function get_all_products()
        {
            return $this->db->query('select * from products limit 0,10')->result_array();
        }

        public function products_pagination()
        {
            return $this->db->query('select * from products')->result_array();
        }

        public function get_products_by_filter($post)
        {
            $offset = 10;
            $limit = ($post['pagination'] - 1) * $offset;
            $query = "select * from products where name like ?";
            $values = array();
            
            $values[] = '%' . $post['keyword'] . '%';

            $count = count($this->db->query($query, $values)->result_array());

            $query .= ' limit ?, ?';
            $values[] = $limit;
            $values[] = $offset;
            return array($this->db->query($query, $values)->result_array(), $count);
        }


        public function get_all_categories()
        {
            return $this->db->query('select * from categories')->result_array();
        }

        public function get_products_by_id($id)
        {
            return $this->db->query("select products.*, categories.category from products left join categories on products.category_id = categories.id  where products.id = ?", $id)->row_array();
        }

        public function get_all_images($id)
        {
            return $this->db->query("select id, img_src from products where id = ?", $id)->row_array();
        }

        public function get_products_like($post)
        {
            return $this->db->query("select * from products where name like ?", '%' . $post['search_keyword'] . '%')->result_array();
        }

        public function delete_product($id)
        {
            $this->db->query("delete from products where id = ?" , $id);
        }

        public function delete_image($id, $image)
        {
            $image = $image . ',';
            $product = $this->get_all_images($id);
            $product['img_src'] = str_replace($image, '', $product['img_src']);

            $this->db->query("update products set img_src = ? where id = ?", array($product['img_src'], $id));
        }

        public function edit_products($post, $id, $images)
        {
            $current_images = $this->get_all_images($id);
            if($images != '')
            {
                if($current_images['img_src'] == '' or $current_images['img_src'] == null)
                {
                    $current_images['img_src'] .= $images;
                }
                else
                {
                    $current_images['img_src'] .= ',' . $images;
                }
            }

            $value = array(
                $post['category_id'],
                $post['name'],
                $post['price'],
                $post['description'],
                $current_images['img_src'],
                $post['stock_count'],
                $id
            );
            $query = "update products set category_id = ?, name = ?, price = ?, description = ?, img_src = ?, stock_count = ? where id = ?";
            return $this->db->query($query, $value);
        }

        public function add_products($post)
        {
            $query = "insert into products (category_id, name, price, description, stock_count, created_at, updated_at) value (?, ?, ?, ?, ?, ?, ?)";
            $value = array(
                $post['category_id'],
                $post['name'],
                $post['price'],
                $post['description'],
                $post['stock_count'],
                date("Y-m-d, H:i:s,"),
                date("Y-m-d, H:i:s,"),
            );

            $this->db->query($query, $value);
            return $this->db->insert_id();
        }

        public function add_image($images, $id)
        {
            $this->db->query("update products set img_src = ? where id = ?", array($images, $id));
        }

        public function update_img_by_id($post, $id)
        {
            $img_src = '';
            for($i = 0; $i < count($post['images']); $i++)
            {
                $img_src .= $post['images'][$i] . ',';
            }
            $this->db->query("update products set img_src = ? where id = ?", array($img_src, $id));
        }

        public function update_category($post)
        {
            $query = "update categories set category = ? where id = ?";
            $this->db->query($query, array($post['category'], $post['id']));
        }

        public function get_all_orders()
        {
            $query = "select order_details.id, order_details.created_at, order_status.status, order_status.id as status_id, order_billing_addresses.address1, order_billing_addresses.address2, order_billing_addresses.city, order_billing_addresses.state, order_billing_addresses.zipcode, order_shipping_addresses.first_name, order_shipping_addresses.last_name, sum(ordered_products.quantity  * products.price) as total from order_details
                      left join order_status on order_details.order_status_id = order_status.id
                      left join order_billing_addresses on order_details.order_billing_address_id = order_billing_addresses.id
                      left join order_shipping_addresses on order_details.order_shipping_address_id = order_shipping_addresses.id
                      left join ordered_products on order_details.id = ordered_products.order_detail_id
                      left join products on ordered_products.products_id = products.id
                      group by order_details.id limit 0,3";
                      
            return $this->db->query($query)->result_array();
        }

        public function orders_pagination()
        {
            $query = "select order_details.id, order_details.created_at, order_status.status, order_status.id as status_id, order_billing_addresses.address1, order_billing_addresses.address2, order_billing_addresses.city, order_billing_addresses.state, order_billing_addresses.zipcode, order_shipping_addresses.first_name, order_shipping_addresses.last_name, sum(ordered_products.quantity  * products.price) as total from order_details
                      left join order_status on order_details.order_status_id = order_status.id
                      left join order_billing_addresses on order_details.order_billing_address_id = order_billing_addresses.id
                      left join order_shipping_addresses on order_details.order_shipping_address_id = order_shipping_addresses.id
                      left join ordered_products on order_details.id = ordered_products.order_detail_id
                      left join products on ordered_products.products_id = products.id
                      group by order_details.id";
                      
            return $this->db->query($query)->result_array();
        }
        public function get_orders_by_filter($post)
        {
            $offset = 3;
            $limit = ($post['pagination'] - 1) * $offset;
            $query = "select order_details.id, order_details.created_at, order_status.status, order_status.id as status_id, order_billing_addresses.address1, order_billing_addresses.address2, order_billing_addresses.city, order_billing_addresses.state, order_billing_addresses.zipcode, order_shipping_addresses.first_name, order_shipping_addresses.last_name, sum(ordered_products.quantity  * products.price) as total from order_details
                      left join order_status on order_details.order_status_id = order_status.id
                      left join order_billing_addresses on order_details.order_billing_address_id = order_billing_addresses.id
                      left join order_shipping_addresses on order_details.order_shipping_address_id = order_shipping_addresses.id
                      left join ordered_products on order_details.id = ordered_products.order_detail_id
                      left join products on ordered_products.products_id = products.id where ";
            $values = array();
            if($post['status'] != 'all')
            {
                $query .= "order_status.id = ? and ";
                $values[] = $post['status'];
            }

            $query .= "order_shipping_addresses.first_name like ? group by order_details.id";
            $values[] = '%' . $post['keyword'] . '%';

            $count = count($this->db->query($query, $values)->result_array());

            $query .= ' limit ?, ?';
            $values[] = $limit;
            $values[] = $offset;
            return array($this->db->query($query, $values)->result_array(), $count);
        }

        public function update_status($post, $id)
        {
            $this->db->query("update order_details set order_status_id = ? where id = ?", array($post['status'], $id));
            if($post['status'] == '2')
            {
                $this->update_stock_sold($id);
            }

        }
        private function update_stock_sold($id)
        {
            $products = $this->db->query("select quantity, products_id from ordered_products where order_detail_id = ?", $id)->result_array();
            foreach($products as $product)
            {
                $stocks_sold = $this->db->query("select stock_count, sold_count from products where id = ?", $product['products_id'])->row_array();
                $stocks_sold['stock_count'] -= $product['quantity'];
                $stocks_sold['sold_count'] += $product['quantity'];
                $this->db->query("update products set stock_count = ?, sold_count = ? where id =?", array($stocks_sold['stock_count'], $stocks_sold['sold_count'], $product['products_id']));
            }
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
        
        public function get_no_answer_questions()
        {
            $query = "select questions.id, questions.question, questions.product_id, products.name, answers.answer from questions
            left join products on questions.product_id = products.id
            left join answers on questions.id = answers.question_id
            where answers.answer is NULL";

            return $this->db->query($query)->result_array();
        }

        public function answer_question($post, $id)
        {
            $values = array(
                $id,
                $post['answer'],
                date("Y-m-d, H:i:s,"),
                date("Y-m-d, H:i:s,")
            );
            $this->db->query("insert into answers (question_id, answer, created_at, updated_at) value (?, ?, ?, ?)", $values);
        }

        public function add_category($category)
        {
            $category = ucfirst(trim($category));
            $this->db->query("insert into categories (category, created_at, updated_at) value (?, ?, ?)", array($category, date("Y-m-d, H:i:s,"), date("Y-m-d, H:i:s,")));
            return $this->db->insert_id();
        }
    }
?>