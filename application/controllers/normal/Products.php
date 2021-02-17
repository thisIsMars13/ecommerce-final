<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Products extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('normal/product');
            $this->load->model('normal/cart');
            $this->load->model('normal/question');
        }

        public function index()
        {
            $this->load->view('normal/catalog');
        }

        public function catalog_load()
        {
            
            $catalog['curr_page'] = 1;
            $catalog['checked'] = array();
            if($this->input->post('categories') != null)
            {
                $catalog['checked'] = $this->input->post('categories');
            }
            $catalog['products'] = $this->product->get_all_products();
            $catalog['pagination'] = count($this->product->pagination());
            $catalog['data'] = $this->product->category_prod_count();
            $catalog['categories'] = $this->product->get_all_categories();
            $data = array(
                'count' => count($this->cart->shopping_cart()),
                'categories' => $this->load->view('normal/partials/categories', $catalog, true),
                'section' => $this->load->view('normal/partials/section', $catalog, true),
                'pagination' => $this->load->view('normal/partials/pagination', $catalog, true),
                'current_page' => $this->load->view('normal/partials/current_page', $catalog, true)
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        public function search()
        {
            $catalog['curr_page'] = 1;
            $catalog['checked'] = array();
            if($this->input->post('categories') != null)
            {
                $catalog['checked'] = $this->input->post('categories');
            }
            if($this->input->post('pagination', true) != null)
            {
                $catalog['curr_page'] = $this->input->post('pagination', true);
            }
            $result = $this->product->get_products_by_filter($this->input->post(null, true));
            $catalog['categories'] = $this->product->get_all_categories();
            $catalog['products'] = $result[0];
            $catalog['pagination'] =  $result[1];
            $catalog['data'] = $result[2];
            $data = array(
                'section' => $this->load->view('normal/partials/section', $catalog, true),
                'categories' => $this->load->view('normal/partials/categories', $catalog, true),
                'pagination' => $this->load->view('normal/partials/pagination', $catalog, true),
                'current_page' => $this->load->view('normal/partials/current_page', $catalog, true)
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        public function show($id)
        {
            $data['id'] = $id;
            $this->load->view('normal/product_overview', $data);
        }

        public function show_load($id)
        {
            $results['main'] =  $this->product->get_products_by_id($id);
            $results['related'] = $this->product->get_products_by_category($results['main'], $id);
            $results['questions_and_answers'] = $this->question->get_questions_and_answers_by_id($id);
            $results['reviews'] = $this->product->get_reviews_by_id($id);
            // var_dump($results['reviews']);
            $data = array(
                'product_overview' => $this->load->view('normal/partials/product_description', $results, true),
                'related_items' => $this->load->view('normal/partials/products_related', $results, true),
                'count' => count($this->cart->shopping_cart()),
                'questions_and_answers' => $this->load->view('normal/partials/questions_and_answers', $results, true)
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        
        public function add_cart()
        {
            $this->product->add_cart($this->input->post(null, true));
            $data = array(
                'count' => count($this->cart->shopping_cart()),
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
            
        }
    }
?>