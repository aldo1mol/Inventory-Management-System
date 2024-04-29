<?php
include '../include/config.php';

if(isset($_POST['del_Cart_item'])){
    $unique = $_POST['del_Cart_item'];
    
    $sql = "DELETE FROM cart WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $unique);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
?>