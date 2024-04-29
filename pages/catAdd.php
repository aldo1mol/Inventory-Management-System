<?php 
   include '../include/config.php';
    
   
   extract($_POST);

   if (isset($_POST['categoryNameSend']) 
    
    ){
   
      $sql="INSERT INTO categories(CategoryName)
      VALUES ('$categoryNameSend')";

      $result=mysqli_query($conn,$sql);
   };
?>