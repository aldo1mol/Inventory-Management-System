<?php 
   include '../include/config.php';
    
   
   extract($_POST);

   if (isset($_POST['FNameSend']) && isset($_POST['RoleSend']) 
    && isset($_POST['UNameSend']) && isset($_POST['PasswordSend'])
    ){
   
      $sql="INSERT INTO users(EmpName,`role`,username,`password`)
      VALUES ('$FNameSend','$RoleSend','$UNameSend','$PasswordSend')";

      $result=mysqli_query($conn,$sql);
   };
?>