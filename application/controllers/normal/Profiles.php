<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Profiles extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('validator/validator');
            $this->load->model('normal/profile');
            $this->load->model('normal/product');
            $this->load->model('normal/cart');
        }

        public function settings_page()
        {
            $this->load->view('normal/edit_profile');
        }

        public function settings_page_load()
        {
            $result['shipping_data'] = $this->profile->get_shipping_address();
            $result['billing_form'] = $this->profile->get_billing_address();
            $data = array(
                'count' => count($this->cart->shopping_cart()),
                'shipping_form' => $this->load->view('normal/partials/shipping_form', $result, true),
                'billing_form' => $this->load->view('normal/partials/billing_form', $result, true)
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        public function update_password()
        {
            $result['error'] = '';
            if($this->profile->match_password($this->input->post('old_password', true)) == true)
            {
                if($this->validator->change_password() == 'valid')
                {
                    $this->profile->change_password($this->input->post(null, true));
                    $result['error'] .= '<p>Password change success</p>';
                }
                else
                {
                    foreach($this->validator->change_password() as $error)
                    {
                        $result['error'] .= $error . '<br>';
                    }
                }
            }
            else
            {
                $result['error'] .= "<p>Incorrect password</p>";
            }

            $data = array(
                'message-dialog' => $result['error']
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));            
        }

        public function update_default_shipping()
        {
            $result['shipping_data'] = $this->profile->get_shipping_address();
            $result['error'] = '';
            if($this->validator->update_default_shipping() == 'valid')
            {
                $this->profile->update_default_shipping($this->input->post(null, true));
                $result['shipping_data'] = $this->profile->get_shipping_address();
                $result['error'] .= '<p>Default shipping address updated</p>';
            }
            else
            {
                foreach($this->validator->update_default_shipping() as $error)
                {
                    $result['error'] .= $error . '<br>';
                }
            }
            $data = array(
                'message-dialog' => $result['error'],
                'shipping_form' => $this->load->view('normal/partials/shipping_form', $result, true),
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));  
        }

        public function update_default_billing()
        {
            $result['billing_form'] = $this->profile->get_billing_address();
            $result['error'] = '';
            if($this->validator->update_default_billing() == 'valid')
            {
                $this->profile->update_default_billing($this->input->post(null, true));
                $result['billing_form'] = $this->profile->get_billing_address();
                $result['error'] .= '<p>Default billing address updated</p>';
            }
            else
            {
                foreach($this->validator->update_default_billing() as $error)
                {
                    $result['error'] .= $error . '<br>';
                }
            }
            $data = array(
                'message-dialog' => $result['error'],
                'billing_form' => $this->load->view('normal/partials/billing_form', $result, true)
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));  
        }
    }
?>