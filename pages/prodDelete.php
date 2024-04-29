<?php
    include '../include/config.php';

    if(isset($_POST['deletesend'])){
        $unique=$_POST['deletesend'];

        $sql="DELETE FROM products WHERE ID=$unique";
        $result=mysqli_query($conn,$sql);
    }
?>