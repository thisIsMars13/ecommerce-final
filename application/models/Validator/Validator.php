<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Validator extends CI_Model
    {
        public function signin_validate()
        {
            $this->form_validation->set_rules('email','Email', "trim|required|valid_email");
            $this->form_validation->set_rules('password','Password', "trim|required");

            if($this->form_validation->run() == FALSE)
            {
                return $this->form_validation->error_array();
            }
            else
            {
                return 'valid';
            }
        }

        public function register_validate()
        {
            $this->form_validation->set_rules('first_name','First name', "trim|required|alpha");
            $this->form_validation->set_rules('last_name','Last name', "trim|required|alpha");
            $this->form_validation->set_rules('email','Email', "trim|required|valid_email|is_unique[users.email]");
            $this->form_validation->set_rules('password','Password', "trim|required|min_length[5]");
            $this->form_validation->set_rules('confirm_password','Confirm Password', "trim|required|matches[password]");
            if($this->form_validation->run() == FALSE)
            {
                return $this->form_validation->error_array();
            }
            else
            {
                return 'valid';
            }
        }

        public function change_password()
        {
            $this->form_validation->set_rules('password','New password', "trim|required|min_length[5]");
            $this->form_validation->set_rules('confirm_password','Confirm Password', "trim|required|matches[password]");
            if($this->form_validation->run() == FALSE)
            {
                return $this->form_validation->error_array();
            }
            else
            {
                return 'valid';
            }
        }

        public function update_default_shipping()
        {
            $this->form_validation->set_rules('address1','Address 1', "required");
            $this->form_validation->set_rules('city','City', "required");
            $this->form_validation->set_rules('state','State', "required");
            $this->form_validation->set_rules('zipcode','zipcode', "required");
            $this->form_validation->set_rules('first_name','First name', "trim|required");
            $this->form_validation->set_rules('last_name','Last name', "trim|required");
            if($this->form_validation->run() == FALSE)
            {
                return $this->form_validation->error_array();
            }
            else
            {
                return 'valid';
            }
        }

        public function update_default_billing()
        {
            $this->form_validation->set_rules('address1','Address 1', "required");
            $this->form_validation->set_rules('city','City', "required");
            $this->form_validation->set_rules('state','State', "required");
            $this->form_validation->set_rules('zipcode','zipcode', "required");
            $this->form_validation->set_rules('first_name','First name', "trim|required");
            $this->form_validation->set_rules('last_name','Last name', "trim|required");
            if($this->form_validation->run() == FALSE)
            {
                return $this->form_validation->error_array();
            }
            else
            {
                return 'valid';
            }
        }

        public function payment_validate_address()
        {
            $this->form_validation->set_rules('shipping_address1','Address 1', "required");
            $this->form_validation->set_rules('shipping_city','City', "required");
            $this->form_validation->set_rules('shipping_state','State', "required");
            $this->form_validation->set_rules('shipping_zipcode','zipcode', "required");
            $this->form_validation->set_rules('shipping_first_name','First name', "trim|required");
            $this->form_validation->set_rules('shipping_last_name','Last name', "trim|required");
            $this->form_validation->set_rules('billing_address1','Address 1', "required");
            $this->form_validation->set_rules('billing_city','City', "required");
            $this->form_validation->set_rules('billing_state','State', "required");
            $this->form_validation->set_rules('billing_zipcode','zipcode', "required");
            $this->form_validation->set_rules('billing_first_name','First name', "trim|required");
            $this->form_validation->set_rules('billing_last_name','Last name', "trim|required");
            if($this->form_validation->run() == FALSE)
            {
                return $this->form_validation->error_array();
            }
            else
            {
                return 'valid';
            }
        }

        public function validate_add_edit_form()
        {
            if($this->input->post('new_category', true) != '')
            {
                $this->form_validation->set_rules('new_category','New category', "is_unique[categories.category]");
            }
            $this->form_validation->set_rules('name','Product name', "required");
            $this->form_validation->set_rules('price','Price', "required|decimal|greater_than[0]");
            $this->form_validation->set_rules('stock_count','Stock count', "required|is_natural|greater_than[0]");
            $this->form_validation->set_rules('description','Description', "required");
            if($this->form_validation->run() == FALSE)
            {
                return $this->form_validation->error_array();
            }
            else
            {
                return 'valid';
            }
        }
    }
?>