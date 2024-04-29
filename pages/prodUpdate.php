<?php 
   include '../include/config.php';

   if(isset($_POST['updateid'])){
      $user_id=$_POST['updateid'];

      $sql="SELECT * FROM products WHERE ID=$user_id";
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
            $productName=$_POST['updateprodName'];
            $category=$_POST['updatecategory'];
            $CP=$_POST['updateCP'];
            $SP=$_POST['updateSP'];
            $profit=$_POST['updateprofit'];
            $quantity=$_POST['updatequantity'];
            $supplier=$_POST['updatesupplier'];
            $DIS=$_POST['updateDIS'];
            $EXP=$_POST['updateEXP'];
            $DSC=$_POST['updateDSC'];



            

            $sql="UPDATE products SET ProductName='$productName',Category='$category',CostPrice='$CP', SalesPrice='$SP',Profit='$profit',
            Quantity='$quantity',Supplier='$supplier', DateInStock='$DIS', `ExpireDate`='$EXP', `Description`='$DSC' WHERE ID=$uniqueid";

            $result=mysqli_query($conn,$sql);

        }
?>