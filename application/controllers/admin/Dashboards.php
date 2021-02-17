<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Dashboards extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('admin/dashboard');
            $this->load->model('validator/validator');
            if($this->session->userdata('is_admin') != 1)
            {
                redirect(base_url()."products");
            }
        }

        public function update_status($id)
        {
            $this->dashboard->update_status($this->input->post(null, true), $id);
            $orders['tables'] = $this->dashboard->get_all_orders();
            $data = array(
                'tbody' => $this->load->view('admin/partials/orders_table', $orders, true),
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        public function order_details($order_id)
        {
            $id['id'] = $order_id;
            $this->load->view("admin/order_details", $id);
        }

        public function order_details_load($id)
        {
            $order['data'] = $this->dashboard->get_order_by_id($id);
            $order['questions_count'] = count($this->dashboard->get_no_answer_questions());
            $data = array(
                'summary' => $this->load->view('admin/partials/summary_order_details', $order, true),
                'section' => $this->load->view('admin/partials/section_order_details', $order, true),
                '#question_notif' => $this->load->view('admin/partials/questions_notif', $order, true),
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        public function orders()
        {
            $this->load->view('admin/dashboard_orders');
        }

        public function orders_load()
        {
            $orders['curr_page'] = 1;
            $orders['tables'] = $this->dashboard->get_all_orders();
            $orders['pagination'] = count($this->dashboard->orders_pagination());
            $orders['questions_count'] = count($this->dashboard->get_no_answer_questions());
            $data = array(
                'tbody' => $this->load->view('admin/partials/orders_table', $orders, true),
                'footer' => $this->load->view('admin/partials/orders_pagination', $orders, true),
                '#question_notif' => $this->load->view('admin/partials/questions_notif', $orders, true),
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        public function get_orders_by_filter()
        {
            $orders['curr_page'] = 1;
            if($this->input->post('pagination', true) != null)
            {
                $orders['curr_page'] = $this->input->post('pagination', true);
            }
            $result = $this->dashboard->get_orders_by_filter($this->input->post(null, true));
            $orders['tables'] = $result[0];
            $orders['pagination'] =  $result[1];
            $data = array(
                'tbody' => $this->load->view('admin/partials/orders_table', $orders, true),
                'footer' => $this->load->view('admin/partials/orders_pagination', $orders, true)
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        public function products($page)
        {
            $this->load->view('admin/dashboard_products');
        }

        public function products_load()
        {
            $result['curr_page'] = 1;
            $result['pagination'] = count($this->dashboard->products_pagination());
            $result['tables'] = $this->dashboard->get_all_products();
            $result['questions_count'] = count($this->dashboard->get_no_answer_questions());
            $data = array(
                '#table' => $this->load->view('admin/partials/table', $result, true),
                '#pagination' => $this->load->view('admin/partials/products_pagination', $result, true),
                '#question_notif' => $this->load->view('admin/partials/questions_notif', $result, true),
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        public function get_products_by_filter()
        {
            $result['curr_page'] = 1;
            if($this->input->post('pagination', true) != null)
            {
                $result['curr_page'] = $this->input->post('pagination', true);
            }
            $results = $this->dashboard->get_products_by_filter($this->input->post(null, true));
            $result['pagination'] = $results[1];
            $result['tables'] = $results[0];
            $result['categories'] = $this->dashboard->get_all_categories();
            $data = array(
                '#table' => $this->load->view('admin/partials/table', $result, true),
                '#pagination' => $this->load->view('admin/partials/products_pagination', $result, true)
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        public function load_edit_form($id)
        {
            $result['product'] = $this->dashboard->get_products_by_id($id);
            $result['categories'] = $this->dashboard->get_all_categories();
            $data = array(
                '#form-edit-dialog' => $this->load->view('admin/partials/form_edit', $result, true),
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        public function load_add_form()
        {
            $result['categories'] = $this->dashboard->get_all_categories();
            $data = array(
                '#form-add-dialog' => $this->load->view('admin/partials/form_add', $result, true),
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        public function add_products()
        {
            
            $validated = $this->validator->validate_add_edit_form();
            if($validated == 'valid')
            {
                if($this->input->post('is_preview') != '1')
                {
                    var_dump($this->input->post(null, true));
                    $posts = array();
                    foreach($this->input->post(null, true) as $key => $post)
                    {
                        $posts[$key] = $post;
                    }
                    if($this->input->post('new_category', true) != '')
                    {
                        $posts['category_id'] = $this->dashboard->add_category($this->input->post('new_category', true));
                    }
                    $id = $this->dashboard->add_products($posts);

                    $images = '';
                    $image_names = $this->upload_files($id);
                    foreach($image_names as $image)
                    {
                        $images .= $image . ',';
                    }
                    $this->dashboard->add_image($images, $id);

                    $result['product'] = $this->dashboard->get_products_by_id($id);
                    $result['tables'] = $this->dashboard->get_all_products();
                    $result['categories'] = $this->dashboard->get_all_categories();
                    $result['success'] = "Product succesfully added";
                    $data = array(
                        '#table' => $this->load->view('admin/partials/table', $result, true),
                        '.dropdown' => $this->load->view('admin/partials/dropdown', $result, true),
                        '#notification' => $this->load->view('admin/partials/success', $result, true)
                    );
                    $this->output->set_content_type('application/json')->set_output(json_encode($data));
                }
                else
                {
                    $this->preview();
                }
            }
            else
            {
                $errors = '';
                foreach($validated as $error)
                {
                    $errors .= $error . '<br>';
                }
                $result['errors'] = $errors;
                $data = array(
                    '#notification' => $this->load->view('admin/partials/errors', $result, true)
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }
            
        }

        public function preview($current_images = null)
        {
            if($current_images['img_src'] != null)
            {
                $result['current_images'] = $current_images;
            }
            for($i = 0; $i < count($_FILES['files']['tmp_name']); $i++)
            {
                if($_FILES['files']['name'][$i] != '')
                {
                    move_uploaded_file($_FILES['files']['tmp_name'][$i], "preview/" . $_FILES['files']['name'][$i]);
                    $result['images'][] = base_url() . "preview/" . $_FILES['files']['name'][$i];
                }
            }
            $result['post'] = $this->input->post(null, true);
            $data = array(
                '#previews' => $this->load->view('admin/partials/preview', $result, true),
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        
        public function edit_products($id)
        {
            $validated = $this->validator->validate_add_edit_form();
            if($validated == 'valid')
            {
                if($this->input->post('is_preview', true) != '1')
                {
                    $images = '';
                    $posts = array();
                    $image_names = $this->upload_files($id);
                    foreach($image_names as $image)
                    {
                        $images .= $image . ',';
                    }
                    foreach($this->input->post(null, true) as $key => $post)
                    {
                        $posts[$key] = $post;
                    }
                    if($this->input->post('new_category', true) != '')
                    {
                        $posts['category_id'] = $this->dashboard->add_category($this->input->post('new_category', true));
                    }
                    $this->dashboard->edit_products($posts, $id, $images);
                    $result['product'] = $this->dashboard->get_products_by_id($id);
                    $result['sortable'] = $this->dashboard->get_all_images($id);
                    $result['tables'] = $this->dashboard->get_all_products();
                    $result['categories'] = $this->dashboard->get_all_categories();
                    $result['success'] = "Product was updated";
                    $data = array(
                        '#table' => $this->load->view('admin/partials/table', $result, true),
                        '#sortable' => $this->load->view('admin/partials/sortable', $result, true),
                        '#notification' => $this->load->view('admin/partials/success', $result, true)
                    );
                    $this->output->set_content_type('application/json')->set_output(json_encode($data));
                }
                else
                {
                    $this->preview($this->dashboard->get_all_images($id));
                }
                
            }
            else
            {
                $errors = '';
                foreach($validated as $error)
                {
                    $errors .= $error . '<br>';
                }
                $result['errors'] = $errors;
                $data = array(
                    '#notification' => $this->load->view('admin/partials/errors', $result, true)
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }
        }

        public function delete_image($id, $image)
        {
            $this->dashboard->delete_image($id, $image);

            if(file_exists('uploads/' . $image))
            {
                unlink('uploads/' . $image);
            }

            $result['sortable'] = $this->dashboard->get_all_images($id);
            $result['tables'] = $this->dashboard->get_all_products();
            $data = array(
                '#table' => $this->load->view('admin/partials/table', $result, true),
                '#sortable' => $this->load->view('admin/partials/sortable', $result, true)
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        public function delete_product($id)
        {
            $this->dashboard->delete_product($id);
            $result['tables'] = $this->dashboard->get_all_products();
            $data = array(
                '#table' => $this->load->view('admin/partials/table', $result, true)
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        public function organize_img($id)
        {
            $this->dashboard->update_img_by_id($this->input->post(null, true), $id);
            
            $result['tables'] = $this->dashboard->get_all_products();
            $result['sortable'] = $this->dashboard->get_all_images($id);
            $data = array(
                '#table' => $this->load->view('admin/partials/table', $result, true),
                '#sortable' => $this->load->view('admin/partials/sortable', $result, true)
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        public function update_category()
        {
            $this->dashboard->update_category($this->input->post(null, true));
            $result['categories'] = $this->dashboard->get_all_categories();
            $data = array(
                '#category_dropdown' => $this->load->view('admin/partials/categories', $result, true),
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        public function get_categories()
        {
            $result['categories'] = $this->dashboard->get_all_categories();
            $data = array(
                '#category_dropdown' => $this->load->view('admin/partials/categories', $result, true),
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        public function load_questions()
        {
            $result['questions'] = $this->dashboard->get_no_answer_questions();
            $data = array(
                '#customer_questions' => $this->load->view('admin/partials/modal_questions', $result, true),
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        
        public function answer($id)
        {
            $this->dashboard->answer_question($this->input->post(null, true), $id);
            $questions = $this->dashboard->get_no_answer_questions();
            $result['questions'] = $questions;
            $orders['questions_count'] = count($questions);
            $data = array(
                '#customer_questions div ul' => $this->load->view('admin/partials/questions_list', $result, true),
                '#question_notif' => $this->load->view('admin/partials/questions_notif', $orders, true),
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        
        private function upload_files($id)
        {
            $data = array();

            $config['upload_path'] = 'uploads/'; 
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = '50000';
            $config['overwrite'] = 1;

            
            $this->load->library('upload',$config); 

            foreach($_FILES['files']['name'] as $key => $value)
            {
                $_FILES['file']['name'] = $_FILES['files']['name'][$key];
                $_FILES['file']['type'] = $_FILES['files']['type'][$key];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$key];
                $_FILES['file']['error'] = $_FILES['files']['error'][$key];
                $_FILES['file']['size'] = $_FILES['files']['size'][$key];

                $config['file_name'] = $id . md5($value);

                $this->upload->initialize($config);

                
                if($this->upload->do_upload('file'))
                {
                    $uploadData = $this->upload->data();
                    $filename = $uploadData['file_name'];
        
                    $data[] = $filename;
                }
            }

            return $data;
        }
    }
?>