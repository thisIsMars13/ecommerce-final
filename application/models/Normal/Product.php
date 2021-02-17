<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Product extends CI_Model
    {
        public function category_prod_count($product = null)
        {
            if($product != null)
            {
                return $this->db->query("select categories.category, count(products.id) as prod_count 
                                    from categories
                                    left join products on products.category_id = categories.id
                                    where products.id in ?
                                    group by categories.category", array($product))->result_array();
            }
            return $this->db->query("select categories.id, categories.category, count(products.id) as prod_count 
                                    from categories
                                    left join products on products.category_id = categories.id
                                    group by categories.category")->result_array();
        }

        public function get_all_categories()
        {
            return $this->db->query("select * from categories")->result_array();
        }

        public function get_products_by_id($id)
        {
            return $this->db->query("select products.*, categories.category from products 
                                    left join categories on categories.id = products.category_id 
                                    where products.id = ?", $id)->row_array();
        }

        public function get_reviews_by_id($id)
        {
            $review_rating = array();
            $sum = 0;
            $average = 0.0;
            $results = $this->db->query("select rating, review from reviews where product_id = ?", $id)->result_array();
            if($results != null){
                foreach($results as $result)
                {
                    $sum += intval($result['rating']);
                }
                $average = $sum / count($results);
                $review_rating[] = floor($average);
                $review_rating[] = $average - floor($average);
            }
            return array($results, $review_rating);
        }
        
        public function add_cart($post)
        {
            if($this->check_stock_count($post))
            {
                $check_for_dup = $this->db->query("select * from carts where user_id = ? and products_id = ?", array($this->session->userdata('id'), $post['product_id']))->row_array();
                if($check_for_dup != null)
                {
                    $check_for_dup['quantity'] += $post['quantity'];
                    $this->db->query("update carts set quantity = ? where user_id = ? and products_id = ?", array($check_for_dup['quantity'], $this->session->userdata('id'), $post['product_id']));
                }
                else
                {
                    $value = array(
                        $post['quantity'],
                        $this->session->userdata('id'),
                        $post['product_id'],
                        date("Y-m-d, H:i:s,"),
                        date("Y-m-d, H:i:s,") 
                    );
                    $this->db->query("insert into carts (quantity, user_id, products_id, created_at, updated_at) value (?, ?, ?, ?, ?)", $value);
                }
            }
        }
        
        private function check_stock_count($post)
        {
            $count = $this->db->query("select stock_count from products where id = ?", $post['product_id'])->row_array();
            if($post['quantity'] > $count['stock_count'])
            {
                return false;
            }
            return true;
        }

        public function get_products_by_category($category, $id)
        {
            return $this->db->query("select products.* from products left join categories on categories.id = products.category_id where products.category_id = ? and not products.id = ? limit 0, 6", array($category['category_id'], $id))->result_array();
        }

        public function get_all_products()
        {
            return $this->db->query("select * from products order by price limit 0, 18")->result_array();
        }

        public function pagination()
        {
            return $this->db->query("select * from products")->result_array();
        }

        public function get_products_by_filter($post)
        {
            $offset = 18;
            $limit = ($post['pagination'] - 1) * $offset;
            $query = '';
            $values = array();
            if(isset($post['categories']))
            {
                $query = 'select products.* from products
                          left join categories
                          on products.category_id = categories.id
                          where categories.id in (';
                for($i = 0; $i < count($post['categories']); $i++)
                {
                    if($i != count($post['categories']) - 1)
                    {
                        $query .= '?,';
                        $values[] = $post['categories'][$i];
                    }
                    else
                    {
                        $query .= '?) and products.name like ? order by ' . $post['sorted_by'];
                        $values[] = $post['categories'][$i];
                        $values[] = '%' . $post['keyword'] . '%';
                    }
                }
            }
            else
            {
                $query = "select * from products where name like ? order by " . $post['sorted_by'];
                $values[] = '%' . $post['keyword'] . '%';
            }

            $data = $this->db->query($query, $values)->result_array();
            // var_dump($post);

            $count = count($data);
            $products = array();

            foreach($data as $product)
            {
                $products[] = $product['id'];
            }
            $category_count = $this->category_prod_count($products);

            $query .= ' limit ?, ?';
            $values[] = $limit;
            $values[] = $offset;
            return array($this->db->query($query, $values)->result_array(), $count, $category_count);
        }
    }
?>