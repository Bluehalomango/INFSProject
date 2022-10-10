<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 //put your code here 
 class Game_model extends CI_Model{

    // upload file
    public function upload($filename, $path, $username){

        $data = array(
            'game_id' => $id,
            'name' => $name,
            'dor' => $dor,
            'description' => $description
        );
        $query = $this->db->insert('games', $data);

    }

    function fetch_data($query)
    {
        if($query == '')
        {
            return null;
        }else{
            $this->db->select("*");
            $this->db->from("games");
            $this->db->like('name', $query);
            $this->db->order_by('name', 'DESC');
            return $this->db->get();
        }
    }

    function id_fetch($id) {
        $this->db->select("*");
        $this->db->from("games");
        $this->db->like('game_id', $id);
        $this->db->limit(1);
        $results = $this->db->get();
        return ($this->parse_single($results));
    }

    function parse_single($results) {
        $game = [];
        foreach ($results->result_array() as $row)
        {
            $filename = base_url() . "uploads/" . $row['filename'];
            $game = array($row['name'], $row['game_id'], $filename, $row['description'], $row['popularity']);
        }
        return ($game);
    }

    function store_page()
    {
            $this->db->select("*");
            $this->db->from("games");
            $this->db->order_by('popularity', 'DESC');
            $this->db->limit(5);
            $results = $this->db->get();    
            return ($this->parse_array($results));
    }

    function parse_array($results)
    {        
        $collection = [];
        $game = [];
        foreach ($results->result_array() as $row) {
            $filename = base_url() . "uploads/" . $row['filename'];
            $game = array($row['name'], $row['game_id'], $filename, $row['description'], $row['popularity']);
            array_push($collection, $game);
        }
        return ($collection);
    }

    function add_review($game_id, $rating, $review, $user) {
        $data = array(
            'review_id'    => 'NULL',
            'game_id' => $game_id,
            'user' => $user,
            'rating' => $rating,
            'review' => $review
        );
        $this->db->insert('reviews', $data);
    }

    function reviews($id)
    {
            $this->db->select("*");
            $this->db->from("reviews");
            $this->db->like('game_id', $id);
            $this->db->order_by('review_id', 'DESC');
            $results = $this->db->get();    
            return ($this->parse_review($results));
    }

    function parse_review($results)
    {        
        $collection = [];
        $review = [];
        foreach ($results->result_array() as $row) {
            $review = array($row['user'], $row['rating'], $row['review']);
            array_push($collection, $review);
        }
        return ($collection);
    }

    function search_page($query, $filter, $order)
    {
        $this->db->select("*");
        $this->db->from("games");
        $this->db->like('name', $query);
        $this->db->order_by($filter, $order);
        return $this->db->get();    
    }

    function update_popularity($game_id) {
        $game = $this->id_fetch($game_id);
        $oldPop = $game[4];
        $newPop = $oldPop + 1;
        $this->db->set('popularity', $newPop);
        $this->db->where('game_id', $game_id);
        $this->db->update('games'); 
    }

    function slideshow($game_id) {
        $this->db->select("*");
        $this->db->from("images");
        $this->db->where('game_id', $game_id);
        $images = $this->db->get();    
        return ($this->parse_slideshow($images));
    }

    function parse_slideshow($images)
    {        
        $collection = [];
        $review = [];
        foreach ($images->result_array() as $row) {
            $image = base_url() . "uploads/" . $row['image_name'];
            array_push($collection, $image);
        }
        return ($collection);
    }

    function check_user_review($game_id, $user) {
        $this->db->where('game_id', $game_id);
        $this->db->where('user_id', $user);
        $result = $this->db->get('reviews');
        if($result->num_rows() == 1){
            return true;
        } else {
            return false;
        }
    }
    
    function game_rating($game_id) {
        $this->db->select_avg('rating');
        $this->db->from("reviews");
        $this->db->where('game_id', $game_id);
        $result = $this->db->get();  
        foreach ($result->result_array() as $row)
        {
            $return = $row['rating'];
        }
        return ($return);  
    }

    function check_for_reviews($game_id) {
        $this->db->select("*");
        $this->db->from("reviews");
        $this->db->like('game_id', $game_id);
        $result = $this->db->get();    
        if($result->num_rows() >= 1){
            return true;
        } else {
            return false;
        }
    }
}
