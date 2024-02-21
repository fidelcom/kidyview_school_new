<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invoicedownload extends CI_Controller {
    
   public function feesinvoice($tx_ref='',$school_id='',$session_id='',$class_id='',$student_id=''){
        error_reporting(0);
        $this->db->select(
       'sf.*,
        s.school_name as school_name,
        s.phone as phone,
        s.bank_name as bank_name,
        s.sub_acc_number as sub_acc_number,
        s.sort_code as sort_code,
        s.location as school_location,
        s.city as school_city,
        s.state as school_state,
        s.country as school_country,
        s.pincode as school_pincode,
        s.pic as school_pic,
        st.name as schooltype,
        country.name as countryname,
        c.section as student_section,
        c.class as student_class,
        CONCAT(child.childfname," ",child.childmname," ",child.childlname) AS childname,
        child.childgender as childgender,
        child.childdob as childdob,
        child.childemail as childemail,
        child.childgender as studentgender,
        CONCAT(p.fatherfname," ",p.fatherlname) AS fathername,
        p.fatherphone as fatherphone,
        p.fatheremail as fatheremail,
        p.fatheraddress as fatheraddress,
        ft.fee_type as fee_type,
        sessions.academicsession as academicsession,
        sessions.id as academicsessionID,
        terms.termname as termname,
        f.category_id as cat_id,
        f.description as comment
       ');
       $this->db->from('student_fees as sf');
       $this->db->join('school as s', ' s.id = sf.school_id','left');
       $this->db->join('country_codes as country', ' country.id = s.country','left');
       $this->db->join('class as c', ' c.id = sf.class_id','left');
       $this->db->join('fees as f', ' f.class_id = c.id','left');
       $this->db->join('schooltype as st', ' st.id = c.school_type','left');
       $this->db->join('child as child ', ' child.id = sf.student_id','left');
       $this->db->join('parent as p ', ' p.id = sf.parent_id','left');
       $this->db->join('fee_types as ft', ' ft.id = sf.feeType_id','left');
       $this->db->join('sessions as sessions', 'sessions.id = sf.session_id','left');
       $this->db->join('terms as terms', '(terms.academicsession = sf.session_id And terms.termstart=sessions.sessionstart And terms.termend=sessions.sessionend And terms.schoolId=sf.school_id)','left');
        
       if ($tx_ref!=0) 
       {
        $this->db->where('sf.tx_ref', $tx_ref);
        $this->db->where('sf.is_paid', 'paid');
        $this->db->where('sf.transaction_status', 'successful');
       }
       if ($school_id!='' && $session_id!='' && $class_id!='' && $student_id!='' ) 
       {
       $this->db->where('sf.school_id', $school_id);
       $this->db->where('sf.session_id', $session_id);
       $this->db->where('sf.class_id', $class_id);
       $this->db->where('sf.student_id', $student_id);
       $this->db->where('sf.is_paid', 'paid');
       $this->db->where('sf.transaction_status', 'successful');
       }
       $this->db->group_by('sf.tx_ref');
       //$this->db->limit(12);
        $query = $this->db->get();
         //echo $this->db->last_query(); exit;
        if ($query->num_rows() >0) {
         $rowData= $query->result();
         //print_r($rowData);
         $totalfee=0;
         for($i=0;$i<count($rowData);$i++){
         $totalfee=$totalfee+$rowData[$i]->amount;
         $feesCategories = $this->feesMyCategories($rowData[$i]->cat_id);
         $rowData[$i]->categories = $feesCategories;;
         }
         $data['totalFee']=$totalfee;
         $data['result']=   json_decode(json_encode($rowData), true);
         
            $mpdf = new \Mpdf\Mpdf(['format' => 'A4','autoPageBreak' => false]);
            $mpdf->autoPageBreak = true;
            //$mpdf->shrink_tables_to_fit = 1;
            //$mpdf->AddPage();
            $html = $this->load->view('fees_invoice', $data, true);
            $mpdf->WriteHTML($html);
            if($session_id!=''){
               $filename = $data['result'][0]['academicsession'].'_'.$data['result'][0]['childname'].'_'.substr(md5(date('Y-m-d')),-10).'_fees_invoice.pdf';
            }else{
               $filename = $tx_ref.'_'.substr(md5(date('Y-m-d')),-10).'_fees_invoice.pdf';
            
            }
            $mpdf->Output($filename, 'D');
            exit;
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
}