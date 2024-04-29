<?php
    include '../include/config.php';

    if(isset($_POST['clearNote'])){
        $sql = "TRUNCATE TABLE notification";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "Notifications cleared successfully.";
        } else {
            echo "Error clearing cart.";
        }
    }
?>