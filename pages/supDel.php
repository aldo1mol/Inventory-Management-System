<?php
    include '../include/config.php';

    if(isset($_POST['deletesend'])){
        $unique=$_POST['deletesend'];

        $sql="DELETE FROM suppliers WHERE supplierID=$unique";
        $result=mysqli_query($conn,$sql);
    }
?>