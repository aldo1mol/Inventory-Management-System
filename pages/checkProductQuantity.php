<?php
// Include the configuration file
include '../include/config.php';

// Query to check products with zero or less quantity
$sql = "SELECT ProductName FROM products WHERE Quantity <= 0";
$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $productName = $row['ProductName'];
        $notificationMessage = "$productName is out of stock";

        // Check if the message already exists in the table
        $checkQuery = "SELECT * FROM `notification` WHERE message = '$notificationMessage'";
        $resultCheck = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($resultCheck) === 0) {
            // The message doesn't exist, so insert it
            $currentDateTime = date('Y-m-d H:i:s A');
            $insertQuery = "INSERT INTO notification (`message`, `date_time`) VALUES ('$notificationMessage', '$currentDateTime')";
            $resultInsertNotification = mysqli_query($conn, $insertQuery);

            if ($resultInsertNotification) {
                echo "Notification inserted for $productName";
            } else {
                echo "Error inserting notification for $productName";
            }
        }
    }
} else {
    echo "Error fetching products with zero or less quantity";
}

// Close the database connection
mysqli_close($conn);
?>
