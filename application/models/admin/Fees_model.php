<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Fees_model extends CI_Model {
    
    public function addFeesCategory($postData)
    {
        $userDetail = $this->session->all_userdata();
        $id         = $userDetail['user_data']['id'];
        $postData['user_id']    = $id;
        $postData['created_at'] = date('Y-m-d H:i:s');
        $postData['created_by'] = $id;
        
        $this->db->insert('fees_category',$postData);
        return ( $this->db->affected_rows() ) ? $this->db->insert_id() : 0;
    }
    public function feesCategories($postData)
    {
        if(!empty($postData['type'] == 'school') )
        {
                $this->db->where('user_id',$postData['school_id']);
        }
        $res =  $this->db->select('id,category,description')->where([ 'status' => '1'])->get('fees_category')->result_array();
        return ( count($res) > 0 ) ? $res : 0; 
    }  
    public function getCategoryDetails($postData)
    {
        $res =  $this->db->select('id,category,description')->where('id',$postData['id'])->order_by('id','desc')->get('fees_category')->row();
        return ( $res ) ? (array)$res : 0; 
    }
    public function deleteCategory($postData)
    {
         $this->db->where('id',$postData['id'])->delete('fees_category');
         return $this->db->affected_rows() ? 1 : 0 ;
    }
     public function feeDelete($postData)
    {
         $this->db->where('id',$postData['id'])->delete('fees');
         return $this->db->affected_rows() ? 1 : 0 ;
    }
    public function updateFeesCategory($postData)
    {
        $userDetail = $this->session->all_userdata();
        $id         = $userDetail['user_data']['id'];
        $postData['user_id']    = $id;
        $postData['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id',$postData['id']);
        unset($postData['id']);
        $this->db->update('fees_category',$postData);
        return ($this->db->affected_rows()) ? $this->db->affected_rows() : 0;
    }
    public function getAllFeesCategories()
    {
        $this->db->select('id,category');
        $this->db->where('status','1');
        $query = $this->db->get('fees_category');
        if($query->num_rows() > 0)
            return $query->result();
        else
            return false;
    }
    public function getsubscriptionAmount($postData)
    {
        $this->db->select('*');
        $this->db->where(['class_id'=>$postData['class_id'], 'school_id' => $postData['school_id'] ]);
        $query = $this->db->get('fee_suscription_amount');
        if($query->num_rows() > 0)
            return $query->row_array();
        else
            return false; 
    }
    public function getSession($school_id)
    {
        $where = array('status'=>'1', 'current_sesion'=>'1','schoolId'=>$school_id);
        $result = $this->db->select('*')->where($where)->get('sessions')->result();
        return !empty($result) ? $result : false; 
    }
    public function addFees($postData)
    {
        if(  count($postData['category_ids']) > 0 )
        {
            $category_ids = implode(',', array_column( $postData['category_ids'], 'id') );
            $postData['category_id'] = $category_ids;
            $postData['created_at'] = date('Y-m-d H:i:s');
            $postData['created_by'] = $postData['school_id'];
            unset($postData['category_ids']);
            // prd($postData);
            $result = $this->db->insert('fees',$postData);
            return !empty($this->db->affected_rows()) ? $this->db->affected_rows() : false;
            // return !empty($result) ? $result : false;
        }
    }
     public function updateFees($postData)
    {
        //if(count($postData['category_ids']) > 0 )
        //{
            //$category_ids = implode(',', $postData['category_ids']);
            $daatArray = array(
            'class_id' => $postData['class_id'], 
            'fee_amount' => $postData['fee_amount'],
            'fee_type' => $postData['fee_type'],     
            'school_type' => $postData['school_type'], 
            'session_id' => $postData['session_id'],
            'suscription_fee' => $postData['suscription_fee'], 
            'description' => $postData['description']  
           // 'category_id' => $category_ids 
            );
          
             $this->db->where('id',$postData['feesID']);
             $this->db->update('fees',$daatArray);
             //echo $this->db->last_query(); die;
             unset($postData['category_ids']);
             //echo $this->db->affected_rows();die;
            return ($this->db->affected_rows()) ? $this->db->affected_rows() : 0;
            
        //}
    }
    public function feesList($school_id,$session_id='',$class_id='')
    {
        //$currentSession = get_current_session($school_id);
        //$session_id = $currentSession->id;
        if($class_id!=''){
            $this->db->where('f.class_id',$class_id);
        }
        $where = array('f.session_id' => $session_id, 'school_id' => $school_id);
        $this->db->select('f.*,CONCAT( c.class," ",c.section) as class,curr.currency_name,curr.currency_symbol,curr.currency_code');
        $this->db->from('fees as f');
        $this->db->join('class as c','c.id=f.class_id','left');
        $this->db->join('school as school','school.id='.$school_id.'','left');
        $this->db->join('admin_currency as curr','curr.id=school.currency_id','left');
        $this->db->where($where);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return array();
        } 
    }
    public function feesDetails($id)
    {
        // $currentSession = get_current_session($school_id);
        // $session_id = $currentSession->id;

        $where = array('f.id' => $id);
        $this->db->select('f.*,CONCAT( c.class," ",c.section) as class,st.name as schooltype');
        $this->db->from('fees as f');
        $this->db->join('class as c','c.id=f.class_id','left');
        $this->db->join('schooltype as st','st.value = f.school_type','left');
        $this->db->where($where);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            $feeData = $query->row_array();

            $feesCategories = $this->feesMyCategories($feeData['category_id']);
            $feeData['categories'] = $feesCategories;
            // prd($feeData);
             return (count($feeData) > 0 ) ? $feeData : false;
        }
        else
        {
            return array();
        }
    }
    public function feesMyCategories($category_id)
    {
        if(!empty($category_id))
        {
           $cat_ids = explode(",", $category_id);
           $categories = array();
           foreach ($cat_ids as  $id) {
                $where = array('f.id' => $id,'status'=> '1');
                $this->db->select('f.*');
                $this->db->from('fees_category as f');
                $this->db->where($where);
                $query = $this->db->get();
                if($query->num_rows() > 0)
                {
                    $categoriesData = $query->row_array();
                     array_push($categories, $categoriesData['category']);
                }
                else
                {
                    return false;
                }
            }
                    // prd($categories);
            return (count($categories) > 0 ) ? implode("," , $categories) : false;
                     
        }else{
            return false;
        }
    }
    public function classList($postData)
    {
        $where = array('schoolId' => $postData['school_id'], 'school_type' => $postData['schoolType'], 'status'=>1);
        $this->db->select('*');
        $this->db->from('class');
        $this->db->where($where);
        $query = $this->db->get();
        // lq();
        if($query->num_rows() > 0)
            return $query->result();
        else
            return array();
    }
    
    
    public function paymentHistory($classID,$School_ID,$session_id='')
    {
        //$student_id = $this->token->student_id;
        if(empty($classID))
        return false;
        
        $this->db->select(
         'sf.*,
         c.class as className,
         c.section as classSection,
         date(sf.created_at) as transaction_date,
         c.section as classSection,
         CONCAT(child.childfname," ",child.childmname, " ",child.childlname ) as studentName,
         CONCAT(parent.fatherfname," ",parent.fatherlname) as fatherlname,
         feescat.category as feescategory
          ');
        $this->db->from('student_fees as sf');
        $this->db->join('class as c','c.id=sf.class_id','left');
        $this->db->join('child as child','child.id=sf.student_id','left');
        $this->db->join('parent as parent','parent.id=sf.parent_id','left'); 
        $this->db->join('fees_category as feescat','feescat.id=sf.feeType_id','left');
        $where = array('class_id'=>$classID,'school_id'=>$School_ID,'sf.session_id'=>$session_id);
        $this->db->where($where);
        $query = $this->db->get();
         if($query->num_rows() > 0)
            return $query->result();
        else
            return array();
    }

    public function getClassStudentBySession($school_id='',$session_id='',$class_id=''){
        $this->db->select('CONCAT(ch.childfname," ",ch.childmname, " ",ch.childlname ) as studentName,ch.id');
        $this->db->from('child as ch');
        $this->db->join('child_class as chc','ch.id=chc.child_id','left');
        $this->db->where(array('chc.school_id'=>$school_id,'chc.session_id'=>$session_id,'chc.class_id'=>$class_id));
        $this->db->where("ch.id IN (SELECT student_id FROM student_fees where school_id=$school_id AND session_id=$session_id AND class_id=$class_id)", NULL, FALSE);
        $query = $this->db->get();
         if($query->num_rows() > 0)
            return $query->result_array();
        else
            return array();
    }
}