<?php
    include '../include/config.php';

    if(isset($_POST['deletesend'])){
        $unique=$_POST['deletesend'];

        $sql="DELETE FROM todo_list WHERE id=$unique";
        $result=mysqli_query($conn,$sql);
    }
?>