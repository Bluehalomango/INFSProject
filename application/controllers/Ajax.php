<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ajax extends CI_Controller
{
    public function game()
    {
        $this->load->model('game_model'); // load model
        $output = '';
        $query = '';
        if($this->input->get('game')){
            $query = $this->input->get('game'); // get search query from ajax form
        }
        $data = $this->game_model->fetch_data($query); // send query to file model and get res
        if(!$data == null){
            echo json_encode($data->result()); // send res
        }else{
            echo "";
            }
    }

    public function search()
    {
        $this->load->model('game_model'); // load model
        $output = '';
        $query = '';
        if($this->input->get('search')){
            $query = $this->input->get('search'); // get search query from ajax form
        }
        $components = explode(".", $query);
        $data = $this->game_model->search_page($components[2], $components[0], $components[1]); // send query to file model and get res
        if(!$data == null){
            echo json_encode($data->result()); // send res
        }else{
            echo "";
        }
    }  

    public function autocomplete()
    {
        $this->load->model('game_model'); // load model
        $output = '';
        $query = '';
        if($this->input->get('search')){
            $query = $this->input->get('search'); // get search query from ajax form
            if($query != '') {
                $components = explode(".", $query);
                $data = $this->game_model->search_page($components[2], $components[0], $components[1]); // send query to file model and get res
                if(!$data == null){
                    echo json_encode($data->result()); // send res
                }else{
                    echo "";
                }
            }
        }
    }  

}


