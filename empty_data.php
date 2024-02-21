<?php
if(in_array( $_SERVER['REMOTE_ADDR'], array( '127.0.0.1', '::1' ))) {
$conn = new mysqli("localhost","root","","kidyview");       
}
else {
$conn = new mysqli("localhost","chawtech_kidyview","xxbvCPstxgww","chawtech_kiddyVewDevlopment");
}
if ($conn -> connect_errno) {
  echo "Failed to connect to MySQL: " . $conn -> connect_error;
  exit();
}

if(isset($_GET['user']) && $_GET['user']!=""){
$count = 0;    
$sql = "SELECT * from driver where driveremail='".$_GET['user']."'";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0)
{
$data = mysqli_fetch_assoc($result);
$driverID = $data['id'];
if($driverID!="") {
    
   if(mysqli_query($conn,"delete from daily_driver_journey where driverId='".$driverID."'")){
    $count++;   
   } 
   
   if(mysqli_query($conn,"delete from daily_student_journey where driverid='".$driverID."'")){
    $count++;   
   } 
   
    if(mysqli_query($conn,"delete from journey_status where driverid='".$driverID."'")){
    $count++;   
   }
   
    if(mysqli_query($conn,"delete from latlong_log where driverid='".$driverID."'")){
    $count++;   
   } 
   
    if(mysqli_query($conn,"delete from daily_vehicle_log where driverid='".$driverID."'")){
    $count++;   
   }
  
   echo 'Data Deleted from '.$count.' Table';
}
}
else {
echo 'User Not Found';    
}
}
else {
    echo 'email not pass by you';
}

