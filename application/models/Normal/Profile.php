<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Profile extends CI_Model
    {
        public function match_password($post)
        {
            $current_password = $this->db->query('select password from users where id = ?', $this->session->userdata('id'))->row_array();
            
            if(md5($post) == $current_password['password'])
            {
                return true;
            }
            return false;
        }

        public function change_password($post)
        {
            $this->db->query("update users set password = ? where id =?", array(md5($post['password']), $this->session->userdata('id')));
        }

        public function get_shipping_address()
        {
            $query = "select addresses.*, transaction_names.* from users
                      left join shipping_addresses on users.id = shipping_addresses.user_id
                      left join addresses on shipping_addresses.address_id = addresses.id
                      left join transaction_names on shipping_addresses.transaction_name_id = transaction_names.id
                      where users.id = ?";
            return $this->db->query($query, $this->session->userdata('id'))->row_array();
        }

        public function get_billing_address()
        {
            $query = "select addresses.*, transaction_names.* from users
                      left join billing_addresses on users.id = billing_addresses.user_id
                      left join addresses on billing_addresses.address_id = addresses.id
                      left join transaction_names on billing_addresses.transaction_name_id = transaction_names.id
                      where users.id = ?";
            return $this->db->query($query, $this->session->userdata('id'))->row_array();
        }

        public function update_default_billing($post)
        {
            $query = "update transaction_names, addresses
                      inner join billing_addresses on billing_addresses.address_id = addresses.id 
                      set addresses.address1 = ?, addresses.address2 = ?, addresses.city = ?, addresses.state = ?, addresses.zipcode = ?, transaction_names.first_name = ?, transaction_names.last_name = ?
                      where billing_addresses.user_id = ? and billing_addresses.transaction_name_id = transaction_names.id and billing_addresses.transaction_name_id = transaction_names.id";
            $values = array(
                $post['address1'],
                $post['address2'],
                $post['city'],
                $post['state'],
                $post['zipcode'],
                $post['first_name'],
                $post['last_name'],
                $this->session->userdata('id')
            );
            $this->db->query($query, $values);
        }

        public function update_default_shipping($post)
        {
            $query = "update transaction_names, addresses
                      inner join shipping_addresses on shipping_addresses.address_id = addresses.id 
                      set addresses.address1 = ?, addresses.address2 = ?, addresses.city = ?, addresses.state = ?, addresses.zipcode = ?, transaction_names.first_name = ?, transaction_names.last_name = ?
                      where shipping_addresses.user_id = ? and shipping_addresses.transaction_name_id = transaction_names.id and shipping_addresses.transaction_name_id = transaction_names.id";
            $values = array(
                $post['address1'],
                $post['address2'],
                $post['city'],
                $post['state'],
                $post['zipcode'],
                $post['first_name'],
                $post['last_name'],
                $this->session->userdata('id')
            );
            $this->db->query($query, $values);
        }
    }
?>