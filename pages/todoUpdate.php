<?php 
   include '../include/config.php';

   if(isset($_POST['updateid'])){
      $user_id=$_POST['updateid'];

      $sql="SELECT * FROM todo_list WHERE id=$user_id";
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
            $todo=$_POST['updatetodo'];
            $status=$_POST['updatestatus'];
          
            $sql="UPDATE todo_list SET todo='$todo', `status`= '$status' WHERE id=$uniqueid";

            $result=mysqli_query($conn,$sql);
        }
?>