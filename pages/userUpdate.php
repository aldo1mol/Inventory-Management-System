<?php 
   include '../include/config.php';

   if(isset($_POST['updateid'])){
      $user_id=$_POST['updateid'];

      $sql="SELECT * FROM users WHERE id=$user_id";
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
        if(isset($_POST['hiddendata'])){
            $uniqueid=$_POST['hiddendata'];
            $FullName=$_POST['updateFName'];
            $Role=$_POST['updateRole'];
            $UserName=$_POST['updateUName'];
            $Password=$_POST['updatePassword'];
           



            

            $sql="UPDATE users SET EmpName='$FullName', `role`='$Role', `username`='$UserName', `password`='$Password' WHERE id=$uniqueid";

            $result=mysqli_query($conn,$sql);

        }
?>