<?php 
   include '../include/config.php';

   if(isset($_POST['updateCatid'])){
      $user_id=$_POST['updateCatid'];

      $sql="SELECT * FROM settings";
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
        if(isset($_POST['hiddenCompdata'])){ 
            $uniqueid=$_POST['hiddenCompdata'];
            $compName=$_POST['updatecompName'];
          
            $sql="UPDATE settings SET CompanyName='$compName' LIMIT 1";

            $result=mysqli_query($conn,$sql);
        }
?>