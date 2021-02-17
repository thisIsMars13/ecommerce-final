<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Question extends CI_Model
    {
        public function ask_question($post, $id)
        {
            $values = array(
                $post['question'],
                $id,
                $this->session->userdata('id'),
                date("Y-m-d, H:i:s,"),
                date("Y-m-d, H:i:s,")
            );
            $this->db->query("insert into questions (question, product_id, user_id, created_at, updated_at) value (?, ?, ?, ?, ?)", $values);
        }
        
        public function get_questions_and_answers_by_id($id)
        {
            $query = "select question, answer, users.first_name as asker from questions 
                      left join answers on answers.question_id = questions.id 
                      left join users on questions.user_id = users.id 
                      where questions.product_id = ?";
            return $this->db->query($query, $id)->result_array();
        }
    }
?>