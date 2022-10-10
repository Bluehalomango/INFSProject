<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Store extends CI_Controller
{
    public function index()
    {
        $data ['collection'] = $this->get_info(); 
		$this->load->view('template/header'); 
		$this->load->view('store', $data);
        $this->load->view('template/footer');
    }

    function get_info() {
        $this->load->model('game_model');
        $results = $this->game_model->store_page();
        return ($results);
    }

    public function add_review($game_id) {   
		$this->load->helper('form');
		$rating = $this->input->post('rating');
        $review = $this->input->post('review'); 
        $this->load->model('game_model');
        $this->load->model('user_model');
        if($this->user_model->get_single("hidden", $_SESSION["username"])) {
            $this->game_model->add_review($game_id, $rating, $review, "Anonymous User");
        } else {
            $this->game_model->add_review($game_id, $rating, $review, $_SESSION["username"]);
        }
        $this->game($game_id);
    }

    public function game($id) {
        $this->load->model('game_model');
        $this->game_model->update_popularity($id);
        $game = $this->game_model->id_fetch($id);
        if($this->session->userdata('logged_in')){ 
            $data ['user_status'] = true;
            $data ['has_reviewed'] = $this->game_model->check_user_review($id, $_SESSION["username"]);
        } else {
            $data ['user_status'] = false;
            $data ['has_reviewed'] = NULL;
        }
        $data ['game_info'] = $game;
        $data ['reviews'] = $this->game_model->reviews($id);
        $data ['images'] = $this->game_model->slideshow($id);
        if ($this->game_model->check_for_reviews($id)) {
            $rating = number_format($this->game_model->game_rating($id), 1);
            $data ['rating'] = $rating."/10";
        } else {
            $data ['rating'] = "Not Yet Rated";
        }
		$this->load->view('template/header'); 
		$this->load->view('game', $data);
        $this->load->view('template/footer');
    }

    public function search()
    {
		$this->load->view('template/header'); 
		$this->load->view('search');
        $this->load->view('template/footer');
    }

    function get_search() {
        $this->load->model('forum_model');
        $results = $this->forum_model->forum_page();
        return ($results);
        if(!$results == null){
            echo json_encode($results->result());
        }else{
            echo "";
        }
    }
}
?>


