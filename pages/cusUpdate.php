<?php 
   include '../include/config.php';

   if(isset($_POST['updateid'])){
      $user_id=$_POST['updateid'];

      $sql="SELECT * FROM customers WHERE ID=$user_id";
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
            $EmpName=$_POST['updatePhone'];
            $gender=$_POST['updateAmtSpent'];
            $address=$_POST['updateaddress'];
            $mobile=$_POST['updatephone'];
            $hired=$_POST['updatehiredate'];
            $role=$_POST['updaterole'];
            $salary=$_POST['updatesalary'];
            $email=$_POST['updateEmail'];

            

            $sql="UPDATE employees SET EmpName='$EmpName',Gender='$gender',Email='$email',`Address`='$address',Phone='$mobile',Hire_date='$hired',
            `Role`='$role',SalaryPerMonth='$salary' WHERE ID=$uniqueid";

            $result=mysqli_query($conn,$sql);

        }
?>