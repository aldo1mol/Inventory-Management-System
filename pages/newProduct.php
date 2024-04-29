<?php
// Include your database configuration here
include '../include/config.php';

if (isset($_POST['newProductAdded'])) {
    $productName = $_POST['newProductAdded'];
    insertNewProductNotification($conn, $productName);
}

function insertNewProductNotification($conn, $productName) {
    $notificationMessage = "A new product, $productName, have been added.";

    // set variable for current date and time
    $currentDateTime = date('Y-m-d H:i:s A');

    // Check if the message already exists in the table
    $checkQuery = "SELECT * FROM `notification` WHERE message = '$notificationMessage'";
    $resultCheck = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($resultCheck) === 0) {
        // The message doesn't exist, so insert it
        $insertQuery = "INSERT INTO notification (`message`,`date_time`) VALUES ('$notificationMessage','$currentDateTime')";
        mysqli_query($conn, $insertQuery);
    }
}

// Close the database connection
mysqli_close($conn);
?>
