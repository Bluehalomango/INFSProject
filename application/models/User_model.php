<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 //put your code here
 class User_model extends CI_Model{

    // Log in
    public function login($username, $password){
        // Validate
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $result = $this->db->get('users');

        if($result->num_rows() == 1){
            return true;
        } else {
            return false;
        }
    }

    public function create($username, $password, $salt, $encryptedPassword){
        if (strlen($password) < 7 || ctype_alnum($password)) {
            return 2;
        } 
        if($username != NULL) {
            if (strlen($username) < 7) {
                return 1;
            } 
            $this->db->where('username', $username);
            $result = $this->db->get('users');
            if($result->num_rows() == 0){
                $data = array(
                    'username' => $username,
                    'password' => $encryptedPassword,
                    'salt' => $salt
                );
                $query = $this->db->insert('users', $data);
                return 0;
            } else {
                return 3;
            }
        }
        return 4;
    }

    public function check_user($username) {
        $this->db->where('username', $username);
        $result = $this->db->get('users');
        if($result->num_rows() == 1){
            return true;
        } else {
            return false;
        }
    }

    public function account($user) {
        $this->db->select("*");
        $this->db->from("users");
        $this->db->like('username', $user);
        $this->db->limit(1);
        $result = $this->db->get();
        if($result->num_rows() == 1){
            return ($this->parse_account($result));
        } else {
            return NULL;
        }
    }

    function parse_account($results) {
        $user = [];
        foreach ($results->result_array() as $row)
        {
            $user = array($row['username'], $row['password'], $row['phone_number'], $row['address'], $row['email'], $row['verify'], $row['secret_question'], $row['secret_answer'], $row['hidden'], $row['phone_verified'] );
        }
        return ($user);
    }

    function change($type, $info, $user) {
        $account = $this->account($user);
        $this->db->set($type, $info);
        $this->db->where('username', $user);
        $this->db->update('users'); // gives UPDATE `mytable` SET `field` = 'field+1' WHERE `id` = 2
    }

    function get_single($type, $user) {
        $this->db->select($type);
        $this->db->from("users");
        $this->db->where('username', $user);
        return $this->parse_single($type, $this->db->get());
    }

    function parse_single($type, $results) {
        $return = '';
        foreach ($results->result_array() as $row)
        {
            $return = $row[$type];
        }
        return ($return);
    }

    function question($question, $answer, $user) {
        $account = $this->account($user);
        $this->db->set('secret_question', $question);
        $this->db->set('secret_answer', $answer);
        $this->db->where('username', $user);
        $this->db->update('users');
    }

    function check_question($user, $answer) {
        $this->db->where('username', $user);
        $this->db->where('secret_answer', $answer);
        $result = $this->db->get('users');
        if($result->num_rows() == 1){
            return true;
        } else {
            return false;
        }
    }

    function check_anonymous($user) {
        $this->db->select("hidden");
        $this->db->from("users");
        $this->db->where('username', $user);
        return $this->db->get();
    }

    function check_code($inputCode, $user) {
        $this->db->from("users");
        $this->db->where('username', $user);
        $this->db->where("verify_code", $inputCode);
        $result = $this->db->get();
        if($result->num_rows() == 1){
            return true;
        } else {
            return false;
        }
        
        $savedCode = $this->parse_single("verify_code", $this->db->get());
        if ($savedCode[0] == 0) {
            return 0;
        } else if ($savedCode[0] == $inputCode) {
            return 1;
        } else {
            return 2;
        }
    }
}
?>
