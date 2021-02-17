<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Questions extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('normal/question');
        }
        public function ask_question($id)
        {
            $this->question->ask_question($this->input->post(null, true), $id);
            $results['questions_and_answers'] = $this->question->get_questions_and_answers_by_id($id);
            $data = array(
                'questions_and_answers_list' => $this->load->view('normal/partials/questions_and_answers_list', $results, true)
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }
?>