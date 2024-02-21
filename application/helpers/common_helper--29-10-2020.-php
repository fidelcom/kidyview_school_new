<?php
if(!function_exists('send_email'))
{
	function send_email($mail_data)
	{
			$ci = &get_instance();
			$ci->load->library('email');
			$ci->email->set_newline("\r\n");
			$ci->email->set_mailtype("html");
			$ci->email->clear();
			$ci->email->from($mail_data['from']);
			$ci->email->to($mail_data['to']);
			//$ci->email->to('jyotappan@gmail.com');
			$ci->email->subject($mail_data['subject']);
			$ci->email->message($mail_data['message']);

			if ($ci->email->send())
			{
			  
				return true;
		    }else {
				
				return false;
			}
		
	}
}

if(!function_exists('getAdminEmail'))
{
	function getAdminEmail(){
		$ci = &get_instance();
		$ci->load->database();
		$ci->db->select('email');
		$ci->db->from('ics_admin');
		$ci->db->where('role','admin');
		$query =  $ci->db->get();
		return $query->row();
		
	}
}
if(!function_exists('time_elapsed_string'))
{
    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}
if(!function_exists('prd'))
{
    function prd($array) {
		if(count($array)>0){
			echo "<pre>"; print_r($array); die;
		}
    }
}
if(!function_exists('pr'))
{
    function pr($array) {
		if(count($array)){
			echo "<pre>"; print_r($array);
		}
    }
}
if(!function_exists('lq'))
{
    function lq() {
        $ci = &get_instance();
        echo $ci->db->last_query(); die;
    }
}
function get_time_ago($date) {
    $timestamp = $date;
    
    $strTime = array("second", "minute", "hour", "day", "month", "year");
    $length = array("60","60","24","30","12","10");

    $currentTime = time();
    if($currentTime >= $timestamp) {
         $diff     = time()- $timestamp;
         for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
         $diff = $diff / $length[$i];
         }

         $diff = round($diff);
         return $diff . " " . $strTime[$i] . "(s) ago ";
    }
 }
?>