<?php 
   include '../include/config.php';
    
   
   extract($_POST);

   if (isset($_POST['ProdNameSend']) && isset($_POST['CategorySend']) 
    && isset($_POST['CPSend']) && isset($_POST['SPSend'])
    && isset($_POST['ProfitSend'])&& isset($_POST['QuantitySend'])
    && isset($_POST['SupplierSend']) && isset($_POST['DISSend'])
    && isset($_POST['EXPSend']) && isset($_POST['DSCSend'])
    ){
   
      $sql="INSERT INTO products(ProductName,Category,CostPrice,SalesPrice,
      Profit,Quantity,Supplier,DateInStock,`ExpireDate`,`Description`
      )
      VALUES ('$ProdNameSend','$CategorySend','$CPSend','$SPSend','$ProfitSend'
      ,'$QuantitySend','$SupplierSend','$DISSend','$EXPSend','$DSCSend'
      )";

      $result=mysqli_query($conn,$sql);
   };
?>