<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Feedback_model extends CI_Model {
    function add($data) {
        $this->db->insert('feedback', $data);
        return $this->db->insert_id();
    }
    
}
