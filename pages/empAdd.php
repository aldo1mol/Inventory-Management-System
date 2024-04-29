<?php 
   include '../include/config.php';
    
   
   extract($_POST);

   if (isset($_POST['EmpNameSend']) && isset($_POST['genderSend']) 
    && isset($_POST['addressSend']) && isset($_POST['phoneSend'])
    && isset($_POST['hiredateSend'])&& isset($_POST['roleSend'])
    && isset($_POST['salarySend']) && isset($_POST['emailSend'])){
   
      $sql="INSERT INTO employees(EmpName,Gender,`Address`,Phone,
      Hire_date,`Role`,`SalaryPerMonth`,Email
      )
      VALUES ('$EmpNameSend','$genderSend','$addressSend','$phoneSend','$hiredateSend'
      ,'$roleSend','$salarySend','$emailSend'
      )";

      $result=mysqli_query($conn,$sql);
   };
?>