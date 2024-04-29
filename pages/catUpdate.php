<?php 
   include '../include/config.php';

   if(isset($_POST['updateCatid'])){
      $user_id=$_POST['updateCatid'];

      $sql="SELECT * FROM categories WHERE ID=$user_id";
      $result=mysqli_query($conn,$sql);
      $response=array();
      while($row=mysqli_fetch_assoc($result)){
          $response=$row;
      }
      echo json_encode($response);
      }else{
          $response['status']=200;
          $response['message']="Invalid or data not found";
      }
      

      // update query
        if(isset($_POST['hiddenCatdata'])){
            $uniqueid=$_POST['hiddenCatdata'];
            $categoryName=$_POST['updatecatName'];
          
            $sql="UPDATE categories SET CategoryName='$categoryName' WHERE ID=$uniqueid";

            $result=mysqli_query($conn,$sql);
        }
?>