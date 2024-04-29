<?php 
   include '../include/config.php';
    
   
   extract($_POST);

   if (isset($_POST['todoSend']) && isset($_POST['statusSend']) 
    ){
   
      $sql="INSERT INTO todo_list(todo,`status`)
      VALUES ('$todoSend','$statusSend')";

      $result=mysqli_query($conn,$sql);
   };
?>