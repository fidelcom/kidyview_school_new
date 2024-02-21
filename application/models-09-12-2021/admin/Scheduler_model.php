<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Scheduler_model extends CI_Model {
    public function schoolTypeList()
    {
        $schoolDetail 	= $this->session->all_userdata();
        if($this->session->userdata('user_role')=='schoolsubadmin'){
            $schoolID 	= $schoolDetail['user_data']['school_id']; 
        }elseif($this->session->userdata('user_role')=='school'){
            $schoolID 	= $schoolDetail['user_data']['id'];
        }
        
        
        //print_r($schoolDetail);
        $this->db->select("st.value,st.name");
        $this->db->from("schooltype st, school s");
        $this->db->where("FIND_IN_SET(st.value,s.schoolType) AND 1");
        $this->db->where("st.status",1);             
        $this->db->where("s.id",$schoolID);             
        $query = $this->db->get();
        // lq();
        //echo $this->db->last_query();die;
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }
    }
    
    public function data()
    {
        $schoolDetail 	= $this->session->all_userdata();
        // prd($schoolDetail);
        //print_r($schoolDetail);die;
        if($this->session->userdata('user_role')=='schoolsubadmin'){
            $schoolID 	= $schoolDetail['user_data']['school_id']; 
        }elseif($this->session->userdata('user_role')=='school'){
            $schoolID 	= $schoolDetail['user_data']['id'];
        }
        $this->db->select("s.id,s.school_type,s.no_periods,st.name");
        $this->db->from("schedule s");
        // $this->db->join("schedule_periods sp","sp.schedule_id = s.id","LEFT");
        $this->db->join("schooltype st","st.value = s.school_type","LEFT");
        $this->db->where(["s.school_id"=>$schoolDetail['user_data']['school_id'],'s.status'=>'1']);
        $query = $this->db->order_by('created_at','desc')->get();
         // lq();
        if($query->num_rows() > 0)
        {
            $data = $query->result();
            
            for($i =0; $i < count($data); $i++)
            {
                $data[$i]->detail = $this->scheduleDetail($data[$i]->id);
            }
            return $data;
        }
        else
        {
            return array();
        }
    }
    public function detail($scheduleID)
    {
        $this->db->select("s.id,s.no_periods,st.name");
        $this->db->from("schedule s");
        $this->db->join("schedule_periods sp","sp.schedule_id = s.id","LEFT");
        $this->db->join("schooltype st","st.value = s.school_type","LEFT");
        $this->db->where("s.id",$scheduleID);

        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            $data = $query->row();            
            $data->detailList = $this->scheduleDetail($scheduleID);
            return $data;
        }
        else
        {
            return array();
        }
    }
    public function getLecturesData($schoolTypeID)
    {
        $this->db->select("s.id as schedule_id,s.no_periods,s.school_type,st.name,sp.id as period_id,sp.start_time,sp.end_time");
        $this->db->from("schedule s");
        $this->db->join("schedule_periods sp","sp.schedule_id = s.id","LEFT");
        $this->db->join("schooltype st","st.value = s.school_type","LEFT");
        $this->db->where("s.school_type",$schoolTypeID);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            $data = $query->result();
            return $data;
        }
        else
        {
            return array();
        }
    }
    public function getClasses($dataArray)
    {
        $where = array('schoolId'=>$dataArray['school_id'],'school_type'=>$dataArray['school_type'],'status'=>1);
        $this->db->select('*')->where($where);
        $query = $this->db->get('class');
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }
    }
    public function checkClassTimeTable($dataArray)
    {
           $status='';
           $where = ['school_type'=>$dataArray['school_type'] ];
           $res = $this->db->select('school_type,status')->where($where)->order_by('created_at','desc')->get('schedule')->row();
           $status = $res->status ? $res->status : $status; 
          if( ($status==  0) && ($res->school_type == $dataArray['school_type']) )
          {
            return 'deleted';
            exit;
           }
        $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        $school_id = $dataArray['id'];
        $class_id = $dataArray['class_id'];
        $school_type = $dataArray['school_type'];

        $this->db->select("tt.*,CONCAT(tc.teacherfname,' ',tc.teacherlname) as teacher_name,sb.subject");
        $this->db->from("time_table tt");
        $this->db->join("teacher tc","tc.id = tt.teacher_id","LEFT");
        $this->db->join("subjects sb","sb.id = tt.subject_id","LEFT");
        $this->db->where([ 'tt.class_id'=> $class_id ,'tt.school_id'=>$school_id]);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            $data = $query->result();
            // prd($data);
            $responseData = array();
            foreach ($data as  $value) {
            
            $timeData = $this->getLectureTime($value->period_id,$value->school_id);
            $value->start_time=$timeData->start_time;
            $value->end_time=$timeData->end_time;

                if( isset($responseData[$value->day_name]) ){
                    array_push($responseData[$value->day_name], $value);
                }else{
                    $responseData[$value->day_name] = array();
                    array_push($responseData[$value->day_name], $value);
                }
            }
            // prd($responseData);
            return $responseData;
        }
        else
        {
            $res = $this->scheduleExist($school_id,$school_type);
            if($res){
                 // prd($res);
                $timetableList = array();
                foreach ($days as  $day) {
                    foreach ($res as $schedule) {
                            $timetableData = array(
                                'school_id'     => $school_id,
                                'schedule_id'   => $schedule->schedule_id,
                                'period_id'   => $schedule->period_id,
                                'day_name'   => $day,
                                'class_id'   =>  $class_id,
                                'schooltype_id'   =>  $school_type
                            );
                   array_push($timetableList, $timetableData);
                    }
                }
                    $this->db->insert_batch('time_table',$timetableList);  
                    if($this->db->affected_rows() > 0)
                    {
                        $this->db->select("tt.*,CONCAT(tc.teacherfname,' ',tc.teacherlname) as teacher_name,sb.subject");
                        $this->db->from("time_table tt");
                        $this->db->join("teacher tc","tc.id = tt.teacher_id","LEFT");
                        $this->db->join("subjects sb","sb.id = tt.subject_id","LEFT");
                        $this->db->where([ 'tt.class_id'=> $class_id ,'tt.school_id'=>$school_id ]);
                        $data = $this->db->get()->result();
                        // prd($data);
                        $responseData = array();
                        foreach ($data as  $value) {
                            $timeData = $this->getLectureTime($value->period_id,$value->school_id);
                            $value->start_time=$timeData->start_time;
                            $value->end_time=$timeData->end_time;

                            if( isset($responseData[$value->day_name]) ){
                                array_push($responseData[$value->day_name], $value);
                            }else{
                                $responseData[$value->day_name] = array();
                                array_push($responseData[$value->day_name], $value);
                            }
                        }
                        return $responseData;
                    }
                    else
                    {
                        return false;
                    }
            }else{
                return 'schedule_required';
            }
        }
    }
    protected function scheduleExist($school_id,$school_type)
    {
        $this->db->select("s.id as schedule_id,s.no_periods,s.school_type,sp.id as period_id,sp.*");
        $this->db->from("schedule s");
        $this->db->join("schedule_periods sp","sp.schedule_id = s.id","LEFT");
        $this->db->join("schooltype st","st.value = s.school_type","LEFT");
        $this->db->where([ 's.school_type'=> $school_type ,'s.school_id'=> $school_id,'s.status'=>'1']);
        $query = $this->db->get();
        if($query->num_rows()>0)
        {
           return  $query->result();
        }else{
            return false;
        }
    }
     protected function getLectureTime($period_id,$school_id)
    {

        $this->db->select("sp.id as period_id,sp.start_time,sp.end_time");
        $this->db->from("schedule_periods sp");
        // $this->db->join("schedule_periods sp","sp.schedule_id = s.id","LEFT");
        // $this->db->join("schooltype st","st.value = s.school_type","LEFT");
        $this->db->where([ 'sp.id'=> $period_id ,'sp.school_id'=> $school_id]);
        $query = $this->db->get();
       // lq();
        if($query->num_rows()>0)
        {
             $result = $query->result();
             return $result[0];
        }else{
            return false;
        }
    }
    protected function getLectureList($school_id,$school_type)
    {
        $this->db->select("s.id as schedule_id,s.no_periods,s.school_type,sp.id as period_id,sp.start_time,sp.end_time");
        $this->db->from("schedule s");
        $this->db->join("schedule_periods sp","sp.schedule_id = s.id","LEFT");
        $this->db->join("schooltype st","st.value = s.school_type","LEFT");
        $this->db->where([ 's.school_type'=> $school_type ,'s.school_id'=> $school_id]);
        $query = $this->db->get();
        
        if($query->num_rows()>0)
        {
           return  $query->result();
        }else{
            return false;
        }
    }
    public function getAllSubjectForClass($dataArray)
    {
        $where = array('schoolId'=>$dataArray['school_id'],'status'=>1);
        $this->db->select('id as subject_id,subject')->where($where);
        $query = $this->db->get('subjects');
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }   
    }
    public function updateTimeTable($dataArray,$checkAssigned)
    {
        // prd($checkAssigned);
     //   $where = array('teacher_id'=>$checkAssigned['teacher_id'],'day_name'=>$checkAssigned['day_name'],'period_id'=>$checkAssigned['period_id']);  // Period id checking means allow multiple time for same teacher.
        //$where = array('teacher_id'=>$checkAssigned['teacher_id'],'day_name'=>$checkAssigned['day_name'],'schooltype_id'=>$checkAssigned['schooltype_id'],'period_id'=>$checkAssigned['period_id']);
        $this->db->select('id');
         $this->db->where('id',$dataArray['id']);
        $num_rows = $this->db->get('time_table')->num_rows();
        if($num_rows>0){
            $data = array('subject_id'=>$dataArray['subject_id'] ,'teacher_id'=>$dataArray['teacher_id'],'updated_at'=>$dataArray['updated_at'],'zoom_link'=>$checkAssigned['zoom_link'],'other_info'=>$checkAssigned['other_info']);
            $this->db->where('id',$dataArray['id']);
            $this->db->update("time_table",$data);
            if($this->db->affected_rows() == 1)
            {
                return 1;
            }
            else
            {
                return false;
            }
        }else{
           return false;
        }
    }
    private function scheduleDetail($id)
    {
        $this->db->select('id as period_id,name,start_time,end_time')->where('schedule_id',$id);
        $query = $this->db->get('schedule_periods');
        // lq();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }
    }

    public function add($data)
    {
        $num_rows = $this->db->where(['school_type'=> $data['school_type'],'school_id' => $data['school_id'],'status'=>'1'])->get('schedule')->num_rows();
        // lq();
        if($num_rows>0)
        {
            return 'exist';
            exit;
        }
        $this->db->insert("schedule",$data);
        if($this->db->affected_rows() == 1)
        {
            return $this->db->insert_id();
        }
        else
        {
            return false;
        }
    }
    public function addDetail($data)
    {
        $this->db->insert_batch("schedule_periods",$data);
        
        if($this->db->affected_rows() > 0)
        {
            return $this->db->affected_rows();
        }
        else
        {
            return 0;
        }
    }
    public function deleteSchedule($id)
    {
            $status = array('status'=>'0');
            $this->db->where('id',$id);
            $this->db->update('schedule',$status);
            if($this->db->affected_rows())
            {
                 $this->db->where('schedule_id',$id)->delete('schedule_periods');
                 $this->db->where('schedule_id',$id)->delete('time_table');
                 return 1;
            }else{
                return 0;
            }
    }
    public function updateSchedule($dataArray)
    {
        foreach ($dataArray as $value) {
                $this->db->where('id', $value['period_id']);
                unset($value['period_id']);
                $updated = $this->db->update('schedule_periods',$value);
        }
        if($this->db->affected_rows() > 0)
        {
            return $this->db->affected_rows();
        }else{
            return 0;
        }

    }
}
