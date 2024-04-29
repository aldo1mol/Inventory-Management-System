<?php
include '../include/config.php';

if(isset($_POST['clearCart'])){
    $sql1 = "TRUNCATE TABLE cart";
    $sql2 = "TRUNCATE TABLE print";

    $result1 = mysqli_query($conn, $sql1);
    $result2 = mysqli_query($conn, $sql2);

}else {
    echo "Error clearing cart.";
}
?>


