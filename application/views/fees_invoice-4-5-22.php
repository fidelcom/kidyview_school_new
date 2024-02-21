<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    
     $school_photo = isset($result[0]['school_pic']) ? $result[0]['school_pic'] : "";
    
    if($school_photo!="")
     {
         if(file_exists('./img/school/'.$school_photo))
         $school_photo = $school_photo;  
         else 
         $school_photo = "no_school_available.png";      
     }
    
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

    h1{
       font-size: 20px;
       font-weight: bold;
       font-family:sans-serif;  
    }
     
    h2{
       font-size: 16px;
       font-weight: bold;
       font-family:sans-serif;  
    }
    
     h3{
       font-size: 13px;
       font-family:sans-serif;  
    }
     h4{
       font-size: 13px;
       font-family:sans-serif; 
       font-weight: bold;
    }
    
    
    .tdpad td{
        padding: 3px;
    }
    .contentdata td{
        text-align: center;
        padding: 10px;
        border: #ccc solid 1px;
    }
    

    </style>
</head>
<body>
    

<div id="container">
    

    <div id="body">

      
        <table style="width:100%;">
            
            <tr><td style="text-align:center;"><h1><u>INVOICE</u></h1></td></tr>
            <tr><td>&nbsp;</td></tr>
             <tr><td>&nbsp;</td></tr>
              <tr><td>&nbsp;</td></tr>
            
            
            
                <tr>
                <td>
                        <table style="width:100%; padding: 10px; height:100px">
                            
                            <tr>
                            <td style="width:20%;text-align:left;"><img src="<?php echo './img/school/'.$school_photo; ?>" alt="School Photo" style="height:130px;width: 100px;"></td>
                            <td style="width:50%;text-align: center; vertical-align: middle; vertical-align:top; border: #ccc 0px  solid;">
                                <table style="width:100%;border: #777 0px  solid;" class="tdpad">
                                        <tr><td><h2><?php echo isset($result[0]['school_name']) ? $result[0]['school_name'] :  "NA";?></h2></td></tr>
                                        <tr><td><h3>
                                            <?php 
                                           echo isset($result[0]['school_pincode']) ? $result[0]['school_pincode'] .',' : " ";
                                           echo isset($result[0]['school_city']) ? $result[0]['school_city'] .',' : " ";
                                           echo isset($result[0]['school_state']) ? $result[0]['school_state'] .',' : " ";
                                           echo isset($result[0]['countryname']) ? $result[0]['countryname']  : " ";
                                           ?>
                                                </h3>
                                            </td></tr>
                                        <tr><td><h3><?php echo  $result[0]['phone'];?></h3></td></tr>
                                        <tr><td><h3><?php echo  'Website: kidyview.com';?></h3></td></tr>
                                         <tr><td><h3><?php echo  'Email: kidyview@example.com';?></h3></td></tr>
                                    </table>
                            </td>
                            <td style="width:30%; text-align: right; vertical-align: middle;vertical-align: top;">
                                <table style="width:90%;" class="tdpad">
                                    <tr><td><h3>Slip Number : <?php echo isset($result[0]['tx_ref']) ? $result[0]['tx_ref']  : " "; ?> </h3></td></tr>
                                    <tr><td><h3>Session : <?php echo isset($result[0]['academicsession']) ? $result[0]['academicsession'] : " "; ?></h3></td></tr>
                                      <tr><td><h3>Date : <?php echo isset($result[0]['created_at']) ? date('Y-m-d',strtotime($result[0]['created_at'])) : " "; ?></h3></td></tr>
                                </table>
                            </td>
                            </tr>
                            
                            
                        </table>
                </td>
                </tr>
            
            <tr><td>&nbsp;</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                
                
            <td style="text-align: center; vertical-align: middle; vertical-align:top;" >
                <table class="contentdata" style="width:100%">
                <thead>
                    <tr>
                         <td><h4>Student Name </h4> </td>
                          <td><h4>Payee </h4> </td>
                          <td><h4>Class </h4> </td>
                          <td><h4>Bank Name </h4> </td>
                          <td><h4>Bank Code </h4> </td>
                          <td><h4>Account Number </h4> </td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><h3><?php echo isset($result[0]['childname']) ? $result[0]['childname'] : " "; ?></h3></td>
                        <td><h3><?php echo isset($result[0]['fathername']) ? $result[0]['fathername'] : " "; ?></h3></td>
                        <td><h3><?php echo isset($result[0]['student_class']) ? $result[0]['student_class']." ".$result['student_section'] : " "; ?></h3></td>
                    <td><h3><?php echo isset($result[0]['bank_name']) ? $result[0]['bank_name'] : " "; ?></h3></td>
                        <td><h3><?php echo isset($result[0]['sort_code']) ? $result[0]['sort_code'] : " "; ?></h3></td>
                        <td><h3><?php echo isset($result[0]['sub_acc_number']) ? $result[0]['sub_acc_number'] : " "; ?></h3></td>
                    </tr>
                        </tbody>
                </table>    
                            
            </td>
            </tr>
            
            <tr>
            <td colspan="6">
                <table class="contentdata" style="width:100%">
                    <tr>
                        <td>s.no</td>
                        <td>Fee Description</td>
                        <td>Currency</td>
                        <td>Unit Price</td>
                    </tr>
                    <?php 
                    if(!empty($result)){
                        $i=1;
                        foreach($result as $feeData){
                    ?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo isset($feeData['fee_type']) ? $feeData['fee_type'] : " ";
                        if(!empty($feeData['categories'])){
                            echo ':<br/>';
                            echo $feeData['categories'];
                        }
                        ?>
                        
                        </td>
                        <td><?php echo isset($feeData['currency']) ? $feeData['currency'] : " "; ?></td>
                        <td><?php echo isset($feeData['amount']) ? $feeData['amount'] : " "; ?></td>
                    </tr>
                    <?php $i++;}
                } ?>
                    <tr>
                        <td colspan="4" style="text-align: right;"><h2>Gross Total : <?php echo isset($totalFee) ? $totalFee : " "; ?></h2></td>
                    <tr>   
                </table>  
                            
            </td>
            </tr>
            
            
            
        </table>
        
        <br/>
        <div><h2>Comment:</h2> <?php echo isset($result['comment']) && $result['comment']!='' ? $result['comment'] : "N/A"; ?> </div>

       

        
    </div>

    
</div>

</body>
</html>
