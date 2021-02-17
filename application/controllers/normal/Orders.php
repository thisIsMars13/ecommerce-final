<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Orders extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('normal/order');
            $this->load->model('normal/cart');
            $this->load->model('validator/validator');
        }

        public function process_order()
        {
            if($this->input->post('validate') == '0')
            {
                $result['status'] = '';
                $this->order->process_order($this->input->post(null, true));
                $result['status'] = 'Order has been processed!';
                $data = array(
                    'message_dialog' => $result['status']
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }
            else
            {
                $this->validate_address();
            }
        }

        public function validate_address()
        {
            $valid = true;
            $result['status']  = '';
            $validate = $this->validator->payment_validate_address();
            if($validate != 'valid')
            {
                $valid = false;
                foreach($validate as $error)
                {
                    $result['status'] .= $error . '<br>';
                }
            }
            else
            {
                $total = $this->order->get_cart_total_by_userid()['total'];
            }
            $data = array(
                'message_dialog' => $result['status'],
                'valid' => $valid,
                'total' => $total
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        public function orders_history()
        {
            $this->load->view("normal/order_history");
        }

        public function orders_history_load()
        {
            $orders['data'] = $this->order->get_all_orders_by_user();
            $data = array(
                'tbody' => $this->load->view('normal/partials/order_history_table', $orders, true),
                '#count' => count($this->cart->shopping_cart())
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        
        public function order_details($order_id)
        {
            $id['id'] = $order_id;
            $this->load->view("normal/order_history_details", $id);
        }

        public function order_details_load($id)
        {
            $order['data'] = $this->order->get_order_by_id($id);
            $data = array(
                'summary' => $this->load->view('normal/partials/summary_order_details', $order, true),
                'section' => $this->load->view('normal/partials/section_order_details', $order, true),
                '#count' => count($this->cart->shopping_cart())
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        public function load_form_review($order_id)
        {
            
            $current_review = $this->order->get_current_review_by_order($order_id);
            if($current_review != null)
            {
                $result['reviews'] = $this->order->get_reviews_without_review($order_id, $current_review);
            }
            else
            {
                $result['reviews'] = $this->order->load_form_review($order_id);
            }
            
            $data = array(
                '#leave_review' => $this->load->view('normal/partials/leave_review', $result, true)
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        public function add_review($order_id, $product_id)
        {
            $this->order->add_review($this->input->post(null, true), $order_id, $product_id);
            $current_review = $this->order->get_current_review_by_order($order_id);
            if($current_review != null)
            {
                $result['reviews'] = $this->order->get_reviews_without_review($order_id, $current_review);
            }
            else
            {
                $result['reviews'] = $this->order->load_form_review($order_id);
            }
            $data = array(
                '#leave_review ul' => $this->load->view('normal/partials/leave_review_list', $result, true)
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        
        public function done_review($order_id)
        {
            $this->order->done_review($order_id);
            $orders['data'] = $this->order->get_all_orders_by_user();
            $data = array(
                'tbody' => $this->load->view('normal/partials/order_history_table', $orders, true),
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));

        }
    }
?>