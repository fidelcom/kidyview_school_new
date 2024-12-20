<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    $studentsData = isset($result['studentsList']) ? $result['studentsList'] : "";
    $termsList = isset($result['termsList']) ? $result['termsList'] : "";
    
    
    $termsList = "";
    if(isset($result['termsList']) && (!empty($result['termsList']))){
    $termsList  = $result['termsList'];   
    }
    
    $termListData = "";
    if(isset($result['studentsList']->termListData) && (!empty($result['studentsList']->termListData))){
    $termListData  = $result['studentsList']->termListData;   
    }
    
    $subjectTerm = "";
    if(isset($result['subjectTerm']) && (!empty($result['subjectTerm']))){
    $subjectTerm  = $result['subjectTerm'];   
    }
    
    
    $finalDataArr = "";
    if(isset($result['final']['finalDataArr']) && (!empty($result['final']['finalDataArr']))){
    $finalDataArr  = $result['final']['finalDataArr'];   
    }
    
    $grandTotal = "";
    if(isset($result['final']['grandTotal']) && (!empty($result['final']['grandTotal']))){
    $grandTotal  = $result['final']['grandTotal'];   
    }
   
     //print_r($finalDataArr);
     //echo $finalDataArr[0]['subject'];
     //exit;
   
    
    $add=""; 
    if(isset($studentsData->location) && $studentsData->location!="")
    $add.=$studentsData->location.",";
    if(isset($studentsData->city) && $studentsData->city!="")
    $add.=$studentsData->city.",";
    if(isset($studentsData->state) && $studentsData->state!="")
    $add.=$studentsData->state;
   
    
    $pincode = isset($studentsData->pincode) ? $studentsData->pincode : "";
    $school_name = isset($studentsData->school_name) ? $studentsData->school_name : "";
    $email = isset($studentsData->email) ? $studentsData->email : "";
    $phone = isset($studentsData->phone) ? $studentsData->phone : "";
    
    $stud_name = isset($studentsData->stud_name) ? $studentsData->stud_name : "";
    $childgender = isset($studentsData->childgender) ? $studentsData->childgender : "";
    $father_name = isset($studentsData->father_name) ? $studentsData->father_name : "";
    $mother_name = isset($studentsData->mother_name) ? $studentsData->mother_name : "";
    $teacher_name = isset($studentsData->teacher_name) ? $studentsData->teacher_name : "";
    $std_class = isset($studentsData->class) ? $studentsData->class : "";
    $std_session = isset($studentsData->std_session) ? $studentsData->std_session : "";
    $childRegisterId = isset($studentsData->childRegisterId) ? $studentsData->childRegisterId : "";
    
    $childphoto = isset($studentsData->childphoto) ? $studentsData->childphoto : "";
    $school_photo = isset($studentsData->school_photo) ? $studentsData->school_photo : "";
    
    if($childphoto!="")
    {
        if(file_exists('./img/child/'.$childphoto))
          $childphoto = $childphoto;  
        else
       $childphoto = "no_student_available.png";     
    }
      
    else {
     $childphoto = "no_student_available.png";  
    }
    
    
      
     if($school_photo!="")
     {
         if(file_exists('./img/school/'.$school_photo))
         $school_photo = $school_photo;  
         else 
         $school_photo = "no_school_available.png";      
     }
     else 
     {
     $school_photo = "no_school_available.png"; 
     } 
    
    
//   $data  = termData($termListData,1);
//   print_r($data);
//   exit;

//   $datas = 0;
// if(!empty($termsList)) {
//                   $CI =& get_instance();
//                   for($t=0;$t<count($termsList);$t++)   
//                   {
//                    
//                   $termContent   =  $CI->getTermData($termListData,$termsList[$t]->term_id);
//                    if(!empty($termContent)) 
//                    {
//                        $datas++;
//                        
//                    }
//                    } 
// }   
//echo  $datas;
// exit;
    
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Result</title>

    <style type="text/css">

    ::selection { background-color: #E13300; color: white; }
    ::-moz-selection { background-color: #E13300; color: white; }

    body {
        background-color: #FFF;
        word-wrap: break-word;
    }

    a {
        color: #003399;
        background-color: transparent;
        font-weight: normal;
    }

    h3{
       font-size: 14px;
       font-weight: bold;
       font-family:sans-serif;  
    }
    
     h4{
       font-size: 12px;
       font-weight: bold;
       font-family:sans-serif;  
    }

   
   

    p.footer {
        text-align: right;
        font-size: 16px;
        border-top: 1px solid #D0D0D0;
        line-height: 32px;
        padding: 0 10px 0 10px;
        margin: 20px 0 0 0;
    }

    
    .stdDetails{
        font-size: 13px;
        font-family:sans-serif;
    }
    .stdDetails td{
       padding: 5px;
       
    }
    .marks{
     margin: 10px 0px 10px 0px;
     
    }
    
    .marks td{
     padding:5px;
     text-align: center;
     border: #777 solid 1px;
   
    }
    
    .grade {
        margin-top: 10px;
    }
    .grade td{
     padding:5px;
     border: #777 solid 1px;
     text-align: left;
    }
    .hd{
        font-size: 13px;
        font-weight: bold;
    }
    .det{
        font-size: 13px;
    }
    .school td{
       font-weight: bold; 
       text-align: center;
       padding: 10px;
       
    }
    
    
    
     hr{
        height: 1px;
        background-color: #000;
        border: #000 1px solid ;
    }
    .table{
        margin-bottom:  0px;
    }
    .bottom_text{
        text-align: left !important;
    }
    .bottom_head {
      font-size: 13px;
      font-weight: bold;   
    }
    .floating td {
        text-align: left !important;
    }
	.tablebg {
		background:#08daf4 !important;
	}
    </style>
</head>
<body>
    

<div id="container">
    

    <div id="body" style="border:3px solid #08daf4">
        <table class="table" cellpadding="10" border="0">
    
    <tbody>
		<tr>
			<td colspan="2" >
				<table class="tablebg" bgcolor="#08daf4" width="100%" cellpadding="10" cellspacing="0" border="0" >
					<tr style="background:#08daf4;">
					  <td bgcolor="red" align="left" valign="top" style="width:20%; background-color:#08daf4;" >
						  <table bgcolor="#08daf4" style="margin:20px 0px 0px 20px;" >
							  <tr><td style="background-color:#08daf4;"><img src="<?php echo './img/school/'.$school_photo; ?>" alt="School Photo" style="height:130px;width: 100px;"> </td></tr>
							  
						  </table>
						  
					  </td>
					  <td align="left" valign="top" style="width:70%; background-color:#08daf4;">
						  <table style="background-color:#08daf4;" style="margin:20px 10px 10px 10px; width: 80%;" class="school"  >
							  <tr><td style="background-color:#08daf4;"><h2 style="color:#fff"><?php echo $school_name;?> </h2></td></tr>
							 
							  <tr><td style="background-color:#08daf4;color:#fff">Address : <?php  echo $add;?> </td></tr>
							  <tr><td style="background-color:#08daf4;color:#fff">Pincode : <?php echo $pincode;?> </td></tr>
							  <tr><td style="background-color:#08daf4;color:#fff">Email  : <?php echo $email;?></td></tr>
							  <tr><td style="background-color:#08daf4;color:#fff">Contact Number : <?php echo $phone;?> </td></tr>
						  </table> 
						  
					  </td>
				  </tr>
				</table>
			</td>
		</tr>
      
      
      <tr><td colspan="2">&nbsp;</td></tr>
      
      <tr>
          <td colspan="2">
            <table style="margin:0px 0px 0px 20px;"  >
                  <tr>
                      <td align="left" valign="top"><img src="<?php echo './img/child/'.$childphoto; ?>"  alt="Student Photo" style="height:130px;width: 100px;"> </td>
                       <td style="width:40%; padding:10px;vertical-align:top;"  >
                           <table  class="stdDetails">
                               <tr>
									<td align="left" valign="top"><span class="hd">Student Name  </span> </td>
									<td align="left" valign="top">:</td>
									<td align="left" valign="top"> <span class="det"><?php echo $stud_name;?></span></td>
								</tr>
                               <tr>
									<td align="left" valign="top"><span class="hd">Father Name  </span></td>
									<td align="left" valign="top">:</td>
									<td align="left" valign="top"> <span class="det"> <?php echo $father_name;?></span></td>
								</tr>
                               <tr>
								<td align="left" valign="top"><span class="hd">Mother Name  </span></td>
								<td align="left" valign="top">:</td>
								<td align="left" valign="top"> <span class="det"><?php echo $mother_name;?></span></td>
								</tr>
                               <tr>
							   <td align="left" valign="top"><span class="hd">Teacher Name  </span></td>
							   <td align="left" valign="top">:</td>
							   <td align="left" valign="top"><span class="det"> <?php echo $teacher_name;?></span></td>
							   </tr>
                           </table>
                       </td>
                       <td style="width:40%; padding:10px;vertical-align:top;">
                           <table  class="stdDetails">
                               <tr>
							   <td align="left" valign="top"><span class="hd">Gender</span> </td>
							   <td align="left" valign="top">:</td>
							   <td align="left" valign="top"> <span class="det"><?php echo $childgender;?></span></td>
							   </tr>
                               <tr>
							   <td align="left" valign="top"><span class="hd">Class & Section</span> </td>
							   <td align="left" valign="top">:</td>
							   <td align="left" valign="top"><span class="det"> <?php echo $std_class;?></span></td>
							   </tr>
                               <tr>
							   <td align="left" valign="top"><span class="hd">Session </span></td>
							   <td align="left" valign="top">:</td>
							   <td align="left" valign="top"> <span class="det"><?php echo $std_session;?></span></td>
							   </tr>
                               <tr>
							   <td align="left" valign="top"><span class="hd">Registration ID </span></td>
							   <td align="left" valign="top">:</td>
							   <td align="left" valign="top"><span class="det"><?php echo $childRegisterId;?></span></td></tr>
                           </table>
                           
                       </td>
                  </tr>
                 
                  
              </table>
             
          </td>
      </tr>
      
      
      <tr><td align="left" valign="top" colspan="2"><hr></td></tr>
      <tr><td colspan="2"><h3><center>Progress Report</center></h3></td></tr>
      
      <tr>
          <td colspan="2">
              <table class="marks" style="width:100%;background:#f00;">
                  
                  
                  <?php 
                  if(!empty($termsList)) {
                   $CI =& get_instance();
                   for($t=0;$t<count($termsList);$t++)   
                   {
                   $termContent = "" ;      
                   $termContent   =  $CI->getTermData($termListData,$termsList[$t]->term_id);
                    if(!empty($termContent)) 
                    {
                    ?>
                  
                  <tr><td colspan="8" style="border-left:none;border-right:none;border-bottom:none;" ><h3>Term <?php echo $termsList[$t]->term_id;?></h3></td></tr>
                  <tr>
                      
                      <td align="left" valign="top" style="width:25%; border-left:none;"><h4> Subject </h4></td>
                       <td align="left" valign="top" style="width:15%;"><h4> Exam</h4></td>
                       <td align="left" valign="top" style="width:15%;"><h4> Test </h4></td>
                       <td align="left" valign="top" style="width:15%;"><h4> Assignment </h4></td>
                       <td align="left" valign="top" style="width:8%;"><h4> Project </h4></td>
                       <td align="left" valign="top" style="width:8%;"><h4> Max Marks </h4></td>
                       <td align="left" valign="top" style="width:8%;"><h4> Obtained Marks </h4></td>
                       <td align="left" valign="top" style="border-right:none;"><h4> Grade </h4></td>
                      
                  </tr>
                  <?php  for($i=0;$i<count($termContent);$i++) { ?>
                  <tr>
                    <td align="left" valign="top" style="border-left:none;"><?php echo $termContent[$i]->subject;?></td>
                    
                    <td align="left" valign="top">
                     <?php 
                     if($termContent[$i]->obtain_exam_marks!=0) 
                     echo $termContent[$i]->obtain_exam_marks;
                     else 
                     echo '-';
                     ?>
                    </td>
                    
                     <td align="left" valign="top">
                    <?php 
                     if($termContent[$i]->obtain_test_marks!=0) 
                     echo $termContent[$i]->obtain_test_marks;
                     else 
                     echo '-';
                     ?>    
                    </td>
                    
                    <td align="left" valign="top">
                     <?php 
                     if($termContent[$i]->obtain_assignment_marks!=0) 
                     echo $termContent[$i]->obtain_assignment_marks;
                     else 
                     echo '-';
                     ?>
                    </td>
                   
                    <td align="left" valign="top">
                     <?php 
                     if($termContent[$i]->obtain_project_marks!=0) 
                     echo $termContent[$i]->obtain_project_marks;
                     else 
                     echo '-';
                     ?>      
                    </td>
                    
                    <td align="left" valign="top">  <?php echo isset($termContent[$i]->total_assessment_marks) ? $termContent[$i]->total_assessment_marks : '-';  ?>  </td>
                    <td align="left" valign="top"> <?php echo isset($termContent[$i]->obtain_assessment_marks) ? $termContent[$i]->obtain_assessment_marks : '-';?>  </td> 
                    <td align="left" valign="top" style="border-right:none;"><?php echo isset($termContent[$i]->assessment_grade) ? $termContent[$i]->assessment_grade : '-';?> </td>
                  </tr>
                 <?php 
                     }
                     ////// Start IF ////////////// 
                     if(!empty($subjectTerm)) {
                      for($s=0;$s<count($subjectTerm);$s++) {
                       if($termsList[$t]->term_id == $subjectTerm[$s]['term_id'] ){
                        echo '<tr>';
                        echo '<td align="left" valign="top" style="border-left:none;"><h3>Grand Total</h3></td>'; 
                        echo '<td align="left" valign="top">'.($subjectTerm[$s]['totalTermObtainExam'] == '0' ? '-' : $subjectTerm[$s]['totalTermObtainExam']."/".$subjectTerm[$s]['totalTermExam']).'</td>';
                        echo '<td align="left" valign="top">'.($subjectTerm[$s]['totalTermTestObtain'] == '0' ? '-' : $subjectTerm[$s]['totalTermTestObtain']."/".$subjectTerm[$s]['totalTermTest']).'</td>'; 
                        echo '<td align="left" valign="top">'.($subjectTerm[$s]['totalTermAssignObtain'] == '0' ? '-' : $subjectTerm[$s]['totalTermAssignObtain']."/".$subjectTerm[$s]['totalTermAssign']).'</td>';
                        echo '<td align="left" valign="top">'.($subjectTerm[$s]['totalTermProjObtain'] =='0' ? '-' :$subjectTerm[$s]['totalTermProjObtain']."/".$subjectTerm[$s]['totalTermProj']).'</td>';
                        echo '<td align="left" valign="top">'.($subjectTerm[$s]['totalTermAssesment'] =='0' ? '-' : $subjectTerm[$s]['totalTermAssesment']).'</td>'; 
                        echo '<td align="left" valign="top">'.($subjectTerm[$s]['totalObtainAssesment'] =='0'? '-' : $subjectTerm[$s]['totalObtainAssesment']).'</td>'; 
                        echo '<td align="left" valign="top" style="border-right:none;">'.($subjectTerm[$s]['grade']).'</td>'; 
                        echo '</tr>'; 
                        break;
                       }   
                      }    
                     }
                    ?>
                    <?php 
                    } ?>
                    <?php if(empty($termContent) && !empty($result['getStudentsActivityTermsResult'])) 
                    {  
                            $ret=0;
                            foreach($result['getStudentsActivityTermsResult']['result'] as $activityDatas){
                                if($termsList[$t]->term_id == $activityDatas['term_id'] ){ 
                                    $ret=1;
                                }
                            }
                            if($ret==1){
                    ?>
                  
                  <tr><td colspan="8" style="border-left:none;border-right:none;border-bottom:none;" ><h3>Term <?php echo $termsList[$t]->term_id;?></h3></td></tr>
                    <?php 
                            }
                } ?>
                    <tr>
                        <td colspan="8" style="padding:0"><?php //print_r($result['getStudentsActivityTermsResult']['result'][0]);die;?>
                            <table cellpadding="10" cellspacing="0" border="0" width="100%">
                                <?php if(isset($ret) && $ret==1){?>
                                <tr>
                                    <td align="center" colspan="6" style="width:100%;padding:10px;text-align:center;border-left:0;border-right:0;border-bottom:0;"><h3>Activities</h3></td>
                                </tr>
                                <tr> 
                                    <td align="left" style="border-left:none;"><h4><?php echo $result['getStudentsActivityTermsResult']['result'][0]['subject'];?></h4></td>
                                    <td align="left"><h4><?php echo $result['getStudentsActivityTermsResult']['result'][0]['is_beginner'];?></h4></td>
                                    <td align="left"><h4><?php echo $result['getStudentsActivityTermsResult']['result'][0]['is_intermediate'];?></h4></td>
                                    <td align="left"><h4><?php echo $result['getStudentsActivityTermsResult']['result'][0]['is_advanced'];?></h4></td>
                                    <td align="left"><h4><?php echo $result['getStudentsActivityTermsResult']['result'][0]['is_expert'];?></h4></td>
                                    <td align="left" style="border-right:none;"><h4><?php echo $result['getStudentsActivityTermsResult']['result'][0]['remarks'];?></h4></td>
                                    </tr>

                                <?php } 
                                if(!empty($result['getStudentsActivityTermsResult']['result'])){
                                foreach($result['getStudentsActivityTermsResult']['result'] as $activityData){
                                if($termsList[$t]->term_id == $activityData['term_id'] ){  // print_r($activityData);die;
                                ?>
                                <tr>
                                    <td align="left" style="border-left:none;"><?php echo $activityData['subject'];?></td>
                                    <td align="left">
                                    <?php if($activityData['is_beginner']=='1'){?>
                                        <img src="assets/img/Pright.png">
                                    <?php }else{?>
                                        <img src="assets/img/Pclose.png">
                                    <?php } ?> 
                                    </td>
                                    <td align="left">
                                    <?php if($activityData['is_intermediate']=='1'){?>
                                        <img src="assets/img/Pright.png">
                                    <?php }else{?>
                                        <img src="assets/img/Pclose.png">
                                    <?php } ?> 
                                    </td>
                                    <td align="left">
                                    <?php if($activityData['is_advanced']=='1'){?>
                                        <img src="assets/img/Pright.png">
                                    <?php }else{?>
                                        <img src="assets/img/Pclose.png">
                                    <?php } ?> 
                                    </td>
                                    <td align="left">
                                    <?php if($activityData['is_expert']=='1'){?>
                                        <img src="assets/img/Pright.png">
                                    <?php }else{?>
                                        <img src="assets/img/Pclose.png">
                                    <?php } ?> 
                                    </td>
                                    <td align="left" style="border-right:none;"><?php echo $activityData['remarks'];?></td>
                                </tr>
                                <?php }
                        } 
                    }?>
                            </table>                
                        </td>
                    </tr>
                    <?php
                    }
                   
                  }
                  
                  //////////////// Final Result //////////////////////////////
                  if(!empty($finalDataArr)){
                  echo '<tr><td align="left" valign="top" colspan="8" style="border:none;">&nbsp;</td></tr>';     
                  echo '<tr><td align="center" valign="top" colspan="8" style="border:none;border-top:2px solid #000;"><h3>Final Term</h3></td></tr>';  
                  echo '<tr>';
                  echo '<td align="left" valign="top" style="width:25%; border-left:none;"><h4> Subject </h4></td>';
                  echo '<td align="left" valign="top" style="width:15%;"><h4> Exam </h4></td>';
                  echo '<td align="left" valign="top" style="width:15%;"><h4> Test </h4></td>';
                  echo '<td align="left" valign="top" style="width:15%;"><h4> Assignment </h4></td>';
                  echo '<td align="left" valign="top" style="width:8%;"><h4> Project </h4></td>';
                  echo '<td align="left" valign="top" style="width:8%;"><h4> Max Marks </h4></td>';
                  echo '<td align="left" valign="top" style="width:8%;"><h4> Obtained Marks </h4></td>';
                  echo '<td align="left" valign="top" style="border-right:none;"><h4> Grade </h4></td>';
                  echo '</tr>';    
                 
                  $totalSubject = 0;
                  for($j=0;$j<count($finalDataArr);$j++){ $totalSubject++;
                  echo '<tr>';
                  echo '<td align="left" valign="top" style="border-left:none;">'.(isset($finalDataArr[$j]['subject']) ? $finalDataArr[$j]['subject'] : 'NA').'</td>';
                  echo '<td align="left" valign="top">'.($finalDataArr[$j]['totalTermObtainExam']!='0' ?  $finalDataArr[$j]['totalTermObtainExam'] : '-').'</td>';
                  echo '<td align="left" valign="top">'.($finalDataArr[$j]['totalTermTestObtain']!='0' ?  $finalDataArr[$j]['totalTermTestObtain'] : '-').'</td>';
                  echo '<td align="left" valign="top">'.($finalDataArr[$j]['totalTermAssignObtain']!='0' ?  $finalDataArr[$j]['totalTermAssignObtain']: '-').'</td>';
                  echo '<td align="left" valign="top">'.($finalDataArr[$j]['totalTermProjObtain']!='0' ?  $finalDataArr[$j]['totalTermProjObtain'] : '-').'</td>';
                  echo '<td align="left" valign="top">'.(isset($finalDataArr[$j]['totalTermAssesment']) ?  $finalDataArr[$j]['totalTermAssesment'] : '-').'</td>';
                  echo '<td align="left" valign="top">'.(isset($finalDataArr[$j]['totalObtainAssesment']) ?  $finalDataArr[$j]['totalObtainAssesment'] : '-').'</td>';
                  echo '<td align="left" valign="top" style="border-right:none;">'.(isset($finalDataArr[$j]['grade']) ?  $finalDataArr[$j]['grade'] : '-').'</td>';
                  echo '</tr>';
                  }
                  if(!empty($grandTotal)){
                  echo '<tr>';
                  echo '<td align="left" valign="top" style="border-left:none;"><h3>Grand Total </h3></td>'; 
                  echo '<td align="left" valign="top">'.($grandTotal['grandObtainExam'] == '0' ? '-' : $grandTotal['grandObtainExam']."/".$grandTotal['grandExam']).'</td>';
                  echo '<td align="left" valign="top">'.($grandTotal['grandTestObtain'] == '0' ? '-' : $grandTotal['grandTestObtain']."/".$grandTotal['grandTest']).'</td>';
                  echo '<td align="left" valign="top">'.($grandTotal['grandAssignObtain'] == '0' ? '-' : $grandTotal['grandAssignObtain']."/".$grandTotal['grandAssign']).'</td>';
                  echo '<td align="left" valign="top">'.($grandTotal['grandProjObtain'] == '0' ? '-' : $grandTotal['grandProjObtain']."/".$grandTotal['grandProject']).'</td>';
                  echo '<td align="left" valign="top">'.($grandTotal['grandAssesment'] == '0' ? '-' : $grandTotal['grandAssesment']).'</td>';
                  echo '<td align="left" valign="top">'.($grandTotal['grandObtainAssesment'] == '0' ? '-' : $grandTotal['grandObtainAssesment']).'</td>';
                  echo '<td align="left" valign="top" style="border-right:none;">'.($grandTotal['grade'] == '0' ? '-' : $grandTotal['grade']).'</td>';
                  echo '</tr>';    
                      
                  }
                  }
                  ?>  
              </table>

          </td>
      </tr>
      
      <?php if(!empty($result['getStudentsActivityFinalResult'])){?>  
      <tr>
                <td colspan="2">
                    <table class="marks" style="width:100%;">
                        <tr>
                            <td align="center" colspan="6" style="width:100%;padding:10px;text-align:center;border-left:0;border-right:0;"><h3>Activities</h3></td>
                        </tr>
                        <tr>
                            <td align="left" style="border-left:0;"><h4><?php echo $result['getStudentsActivityFinalResult']['result'][0]['subject'];?></h4></td>
                            <td align="left"><h4><?php echo $result['getStudentsActivityFinalResult']['result'][0]['is_beginner'];?></h4></td>
                            <td align="left"><h4><?php echo $result['getStudentsActivityFinalResult']['result'][0]['is_intermediate'];?></h4></td>
                            <td align="left"><h4><?php echo $result['getStudentsActivityFinalResult']['result'][0]['is_advanced'];?></h4></td>
                            <td align="left"><h4><?php echo $result['getStudentsActivityFinalResult']['result'][0]['is_expert'];?></h4></td>
                            <td align="left" style="border-right:0;"><h4><?php echo $result['getStudentsActivityTermsResult']['result'][0]['remarks'];?></h4></td>
                        </tr>
                        <?php 
                        if(!empty($result['getStudentsActivityFinalResult'])){
                        $kk=0;
                        foreach($result['getStudentsActivityFinalResult']['result'] as $activityData){
                        if($kk>0){;
                        ?>
                        <tr>
                            <td align="left" style="border-left:0;"><?php echo $activityData['subject'];?></td>
                            <td align="left">
                            <?php if($activityData['is_beginner']=='1'){?>
                                <img src="assets/img/Pright.png">
                            <?php }else{?>
                                <img src="assets/img/Pclose.png">
                            <?php } ?> 
                            </td>
                            <td align="left">
                            <?php if($activityData['is_intermediate']=='1'){?>
                                <img src="assets/img/Pright.png">
                            <?php }else{?>
                                <img src="assets/img/Pclose.png">
                            <?php } ?> 
                            </td>
                            <td align="left">
                            <?php if($activityData['is_advanced']=='1'){?>
                                <img src="assets/img/Pright.png">
                            <?php }else{?>
                                <img src="assets/img/Pclose.png">
                            <?php } ?> 
                            </td>
                            <td align="left">
                            <?php if($activityData['is_expert']=='1'){?>
                                <img src="assets/img/Pright.png">
                            <?php }else{?>
                                <img src="assets/img/Pclose.png">
                            <?php } ?> 
                            </td>
                            <td align="left" style="border-right:0;"><?php echo $activityData['remarks'];?></td>
                        </tr>
                            <?php  }
                            $kk++; } 
                        }
                        ?> 
                    </table>                
                </td>
            </tr>
            <?php } ?>
      <tr><td colspan="2">&nbsp;</td></tr>
      <?php 
      if(!empty($grandTotal)){ 
        $persentage = "";  
        if($totalSubject>0){
        $persentage    = ($grandTotal['grandObtainAssesment']*100)/$grandTotal['grandAssesment']; 
        $persentage = number_format((float)$persentage, 2, '.', '').'%';
        }
      ?>
      <tr>
      <td colspan="2" valign="top" align="right" style="vertical-align:bottom;">
        <table style="width:50%;" class="grade">
            
<!--            <tr><td colspan="2" style="border-right:none;border-bottom:none;" class="floating"><span class="hd">Remarks :  </span>  This is the dummy text. </td> </tr>-->
            <tr>
                <td align="left" valign="top" style="border-right:none;"><span class="hd">Percentage :</span> <?php echo $persentage;?></td> 
               <td align="left" valign="top" style="border-right:none;"><span class="hd">Grade : </span> <?php echo $grandTotal['grade'];?></td>
            </tr>
            <tr>
                        
            <tr><td align="left" valign="top" colspan="2" style="border-top:none;border-right:none;border-bottom:none;" class="floating"><span class="hd">Teacher Signature :  </span>  
                 
                  <?php if(isset($studentsData->signatureImg) && file_exists('./img/teacher/'.$studentsData->signatureImg)) {?> 
                  <img src="./img/teacher/<?php echo $studentsData->signatureImg;?>" width="100" height="50"> 
                  <?php } else {
                  echo 'No Signature Available';
                   } ?>
                </td> </tr>
            
            
            <tr><td align="left" valign="top" colspan="2" style="border-right:none;" class="floating"><span class="hd">Principal Signature :  </span>  
                 
                  <?php if(isset($studentsData->principalSign) && file_exists('./img/school/'.$studentsData->principalSign)) {?> 
                  <img src="./img/school/<?php echo $studentsData->principalSign;?>" width="100" height="50"> 
                  <?php } else {
                  echo 'No Signature Available';
                   } ?>
                </td> </tr>
            
            
            
<!--             <tr>
                 <td style="border-bottom:none;border-right:none;"><span class="hd">Rank : </span> fdsf fsdf f</td> 
               <td style="border-bottom:none;border-right:none;"><span class="hd">Signature : </span> ff fdf fff f</td> 
            </tr>-->
             
              
            
        </table>
     </td>
     </tr>
      <?php } ?>
      <tr><td colspan="2">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
       <tr>
		<td colspan="2">
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr><td valign="middle" colspan="2" height="40" style="background-color:#08daf4;"><h3 style="margin:0; line-height:40px;color:#fff"><center>Powered by www.kidyview.com</center></h3></td></tr>
			</table>
		</td>
	   </tr>
       
    </tbody>
  </table>

        

       

        
    </div>

    
</div>

</body>
</html>