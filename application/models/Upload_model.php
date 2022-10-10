<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 //put your code here 
 class Upload_model extends CI_Model{

    // upload file
    public function uploadGame($array, $filename, $path) {
        $this->db->insert('games', $array);
        $game_id = $this->db->insert_id();
        $this->uploadImg($game_id, $filename, $path);
    }

    public function uploadImg($game_id, $filename, $path) {
        $data = array(
            'img_id'    => 'NULL',
            'image_name' => $filename,
            'path' => $path,
            'game_id' => $game_id
        );
        $this->db->insert('images', $data);
    }
}