<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Feedback_model extends CI_Model {
    
    function add($data) {
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->insert('feedback', $data);
        return $this->emojidb->insert_id();
    }
    
}
