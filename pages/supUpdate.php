<?php 
   include '../include/config.php';

   if(isset($_POST['updateid'])){
      $user_id=$_POST['updateid'];

      $sql="SELECT * FROM suppliers WHERE supplierID=$user_id";
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
            $companyName=$_POST['updateCompName'];
            $contact=$_POST['updateContact'];
            



            

            $sql="UPDATE suppliers SET companyName='$companyName', contact='$contact' WHERE supplierID=$uniqueid";

            $result=mysqli_query($conn,$sql);

        }
?>