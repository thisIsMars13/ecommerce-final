<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Users extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('user/user');
            $this->load->model('validator/validator');
            if($this->session->userdata('logged_in') == TRUE)
            {
                redirect(base_url() . "dashboards/orders");
            }
        }

        public function signin_page()
        {
            $this->load->view('users_view/login');
        }

        public function register_page()
        {
            $this->load->view('users_view/register');
        }

        public function signin_process()
        {
            $validate = $this->validator->signin_validate();
            if($this->validator->signin_validate() ==  'valid')
            {
                $results = $this->user->signin_process($this->input->post(null, true));
                if($results == 'Invalid Email or Password' or $results == 'Unregistered Email')
                {
                    $this->session->set_flashdata('error', array('signin_err' => $results));
                }
                else
                {
                    $user_data = array();
                    foreach($results as $key => $result)
                    {
                        if($key != 'password')
                        {
                            $user_data[$key] = $result;
                        }
                    }
                    $user_data['logged_in'] = TRUE;
                    $this->session->set_userdata($user_data);
                    redirect(base_url().'dashboards/orders');
                }
            }
            else
            {
                $this->session->set_flashdata('error', $validate);
            }
            redirect('signin');
        }
        
        public function register_process()
        {
            $validate = $this->validator->register_validate();
            if($validate == 'valid')
            {
                if($this->user->add_user($this->input->post(null, true)))
                {
                    $this->session->set_flashdata('success', 'Registration sucessful');
                    redirect('signin');
                }
                else
                {
                    $this->session->set_flashdata('error', array('db_err' => 'Unable to add user'));
                }
            }
            else
            {
                $this->session->set_flashdata('error', $validate);
            }
            redirect('register');
        }
    }
?>