<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
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

    #container {
        
        border: #000 1px solid ;
        
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
     text-align: center;
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
       padding: 5px;
       
    }
    
    
    
     hr{
        height: 1px;
        background-color: #000;
        border: #000 1px solid ;
    }
    .table{
        margin-bottom:  0px;
    }
    </style>
</head>
<body>

<div id="container">
    

    <div id="body">

      
             
        <table class="table" >
    
    <tbody>
      <tr>
          <td style="width:20%" >
              <table style="margin:20px 0px 0px 20px;" >
                  <tr><td><img src="./img/driver/fa88d55925046b0a214dfa21fac8d7d3.jpg" style="height:130px;width: 100px;"> </td></tr>
                  
              </table>
              
          </td>
          <td style="width:70%;">
              <table style="margin:20px 10px 10px 10px; width: 80%;" class="school"  >
                  <tr><td><h2>ABC School </h2></td></tr>
                  <tr><td> Address : </td></tr>
                  <tr><td>Email  : </td></tr>
                  <tr><td> Contact Number :  </td></tr>
              </table> 
              
          </td>
      </tr>
      
      <tr><td colspan="2"><hr></td></tr>
      
      <tr>
          <td colspan="2">
          
              <table style="margin:0px 0px 0px 20px;"  >
                  <tr>
                      <td ><img src="./img/driver/fa88d55925046b0a214dfa21fac8d7d3.jpg" style="height:130px;width: 100px;"> </td>
                       <td style="width:40%; padding:10px;vertical-align:top;"  >
                           <table  class="stdDetails">
                               <tr><td><span class="hd">Student Name : </span> </td><td> <span class="det">Anil Kumar</span></td></tr>
                               <tr><td><span class="hd">Father Name : </span></td><td> <span class="det"> Sunil Sheety</span></td></tr>
                               <tr><td><span class="hd">Mother Name : </span></td><td> <span class="det">Alka  Kumari</span></td></tr>
                               <tr><td><span class="hd">Teacher Name : </span></td><td><span class="det"> Madam Sushila Kumari</span></td></tr>
                           </table>
                       </td>
                       <td style="width:40%; padding:10px;vertical-align:top;">
                           <table  class="stdDetails">
                               <tr><td><span class="hd">Gender : </span> </td><td> <span class="det">Anil Kumar</span></td></tr>
                               <tr><td><span class="hd">Class & Section :</span> </td><td><span class="det"> Sunil Sheety</span></td></tr>
                               <tr><td><span class="hd">Session  : </span></td><td> <span class="det">Alka  Kumari</span></td></tr>
                               <tr><td><span class="hd">Registration ID : </span></td><td><span class="det">  Madam Sushila Kumari</span></td></tr>
                           </table>
                           
                       </td>
                  </tr>
                 
                  
              </table>
             
          </td>
      </tr>
      
      
      <tr><td colspan="2"><hr></td></tr>
      <tr><td colspan="2"><h3><center>Progrees Report</center></h3></td></tr>
      
      <tr>
          <td colspan="2">
              <table class="marks" style="width:100%;">
                  <tr>
                      <td style="width:10%;  border-left:none;"></td>
                      <td style="width:15%;"><h4> Subject </h4></td>
                       <td style="width:15%;"><h4> Exam </h4></td>
                       <td style="width:15%;"><h4> Test </h4></td>
                       <td style="width:15%;"><h4> Assignment </h4></td>
                       <td style="width:8%;"><h4> Project </h4></td>
                       <td style="width:8%;"><h4> Total Mark </h4></td>
                       <td style="width:8%;"><h4> Obtained Mark </h4></td>
                       <td style="border-right:none;"><h4> Grade </h4></td>
                      
                  </tr>
                  
                 <tr>
                    <td style="border-left:none;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="border-right:none;"></td>
                  </tr>
                  
              </table>
          </td>
      </tr>
      
      <tr>
          <td colspan="2" align="right" style="vertical-align:bottom;">
              
        <table style="width:30%;" class="grade">
            
            <tr><td style="border-right:none;">Percentage : fdsf fsdf f</td> </tr>
             <tr><td style="border-right:none;">Grade :  ff fdf fff f</td> </tr>
              <tr><td style="border-right:none;border-bottom:none;">Remarks :  fdfff fsf</td> </tr>
            
        </table>
              
     </td>
    </tr>
      
      
      
    </tbody>
  </table>

        

       

        
    </div>

    
</div>

</body>
</html>
