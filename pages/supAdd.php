<?php 
   include '../include/config.php';
    
   
   extract($_POST);

   if (isset($_POST['CompNameSend']) && isset($_POST['ContactSend']) ){
   
      $sql="INSERT INTO suppliers(companyName,contact)
      VALUES ('$CompNameSend','$ContactSend')";
      $result=mysqli_query($conn,$sql);
   };
?>