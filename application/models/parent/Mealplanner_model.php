<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Mealplanner_model extends CI_Model {

    public function schoolType(){

        $this->db->select("cl.school_type");

        $this->db->from("child c");

        $this->db->join("class cl","c.childclass = cl.id","LEFT");

        $this->db->where("c.id",$this->token->student_id);

        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            return $query->row()->school_type;
        }else{
            return false;
        }
    }

    public function getSchoolMeal($date){
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->select("id,for_date,breakfast,snacks,meal");        

        $this->emojidb->where('student_id',$this->token->student_id);

        $this->emojidb->where('for_date',$date);

        $query = $this->emojidb->get('school_meal');

        //echo $this->db->last_query();die;
        if($query->num_rows() > 0)
        {
            $data =  $query->row();
            $data->breakfast = array($data->breakfast,"Other");
            $data->snacks = array($data->snacks,"Other");
            $data->meal = array($data->meal,"Other");
            return $data;
        }else{
            return array();
        }
    }
    public function getHomeMeal($date){
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->select("*");
        $this->emojidb->where('student_id',$this->token->student_id);
        $this->emojidb->where('for_date',$date);
        $query = $this->emojidb->get('home_meal_report');
        // lq();
        if($query->num_rows() > 0)
        {
            $res =  $query->row();                        
            return $res;
        }else{
            return array();
        }
    }
}