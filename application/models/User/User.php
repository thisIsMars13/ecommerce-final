<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class User extends CI_Model
    {
        public function signin_process($post)
        {
            $email = $post['email'];
            $enc_password = md5($post['password']);
            $result = $this->db->query('select id, first_name, last_name, email, password, is_admin from users where email = ?', $email)->row_array();
            if($result)
            {
                if($result['password'] == $enc_password)
                {
                    return $result;
                }
                else
                {
                    return 'Invalid Email or Password';
                }
            }
            else
            {
                return 'Unregistered Email';
            }
        }

        public function add_user($post)
        {
            $is_admin = 0;
            $check_admin = $this->db->get_where('users', array('is_admin' => '1'));
            if(!$check_admin->result())
            {
                $is_admin = 1;
            }
            $data = array(
                $post['first_name'],
                $post['last_name'],
                $post['email'],
                md5($post['password']),
                $is_admin,
                date("Y-m-d, H:i:s,"),
                date("Y-m-d, H:i:s,")
            );
            $query = "insert into users (first_name, last_name, email, password, is_admin, created_at, updated_at) value(?, ?, ?, ?, ?, ?, ?)";
            $this->db->query($query, $data);
            $inserted_user_id = $this->db->insert_id();
            $this->db->query("insert into addresses (address1, address2, city, state, zipcode, created_at, updated_at) value('', '', '', '', '', ?, ?)", array(date("Y-m-d, H:i:s,"), date("Y-m-d, H:i:s,")));
            $inserted_shipping_id = $this->db->insert_id();
            $this->db->query("insert into addresses (address1, address2, city, state, zipcode, created_at, updated_at) value('', '', '', '', '', ?, ?)", array(date("Y-m-d, H:i:s,"), date("Y-m-d, H:i:s,")));
            $inserted_billing_id = $this->db->insert_id();
            $this->db->query("insert into transaction_names (first_name, last_name) value ('', '')");
            $inserted_shipping_transaction_name_id = $this->db->insert_id();
            $this->db->query("insert into transaction_names (first_name, last_name) value ('', '')");
            $inserted_billing_transaction_name_id = $this->db->insert_id();
            $this->db->query("insert into cards (card_number, security_code, card_expiration, created_at, updated_at) value ('', '', '', ?, ?)", array(date("Y-m-d, H:i:s,"), date("Y-m-d, H:i:s,")));
            $inserted_billing_cards_id = $this->db->insert_id();
            $this->db->query("insert into shipping_addresses (address_id, user_id, transaction_name_id, created_at, updated_at) value (?, ?, ?, ?, ?)", array($inserted_shipping_id, $inserted_user_id, $inserted_shipping_transaction_name_id, date("Y-m-d, H:i:s,"), date("Y-m-d, H:i:s,")));
            $this->db->query("insert into billing_addresses (address_id, user_id, transaction_name_id, card_id, created_at,  updated_at) value (?, ?, ?, ?, ?, ?)", array($inserted_billing_id, $inserted_user_id, $inserted_billing_transaction_name_id, $inserted_billing_cards_id, date("Y-m-d, H:i:s,"), date("Y-m-d, H:i:s,")));

            return true;
        }
    }
?>