<?php
// Include the configuration file
include '../include/config.php';

// Calculate the current date
$currentDate = date('Y-m-d');

// Query to select products with upcoming or extended expirations
$sql = "SELECT ProductName, ExpireDate FROM products WHERE ExpireDate >= '$currentDate'";
$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $productName = $row['ProductName'];
        $expireDate = $row['ExpireDate'];

        // Calculate the number of days until expiration
        $daysUntilExpiration = floor((strtotime($expireDate) - strtotime($currentDate)) / (60 * 60 * 24));

        // Check if a notification should be sent based on various criteria
        $notificationMessage = '';
        if ($daysUntilExpiration <= 7) {
            // Less than or equal to 7 days left
            $notificationMessage = "$productName will expire in less than a week.";
        } elseif ($daysUntilExpiration <= 30) {
            // Less than or equal to 30 days left
            $notificationMessage = "$productName will expire in less than a month.";
        } elseif ($daysUntilExpiration <= 90) {
            // Less than or equal to 90 days left
            $notificationMessage = "$productName will expire in less than 3 months.";
        } elseif ($daysUntilExpiration <= 150) {
            // Less than or equal to 150 days left (5 months)
            $notificationMessage = "$productName will expire in less than 5 months.";
        } elseif ($daysUntilExpiration <= 210) {
            // Less than or equal to 210 days left (7 months)
            $notificationMessage = "$productName will expire in less than 7 months.";
        } elseif ($currentDate >= $expireDate) {
            // Product expiration date extended or reached
            $notificationMessage = "$productName has reached or extended its expiration date.";
        }

        // Check if the message already exists in the table
        $checkQuery = "SELECT * FROM `notification` WHERE message = '$notificationMessage'";
        $resultCheck = mysqli_query($conn, $checkQuery);

        if ($resultCheck) {
            if (mysqli_num_rows($resultCheck) === 0 && $notificationMessage !== '') {
                // The message doesn't exist, and it's not an empty message, so insert it
                $currentDateTime = date('Y-m-d H:i:s A');
                $insertQuery = "INSERT INTO notification (`message`, `date_time`) VALUES ('$notificationMessage', '$currentDateTime')";
                $resultInsertNotification = mysqli_query($conn, $insertQuery);

                if ($resultInsertNotification) {
                    echo "Notification inserted for $productName: $notificationMessage";
                } else {
                    echo "Error inserting notification for $productName";
                }
            } else {
                echo "Notification for $productName already exists or message is empty.";
            }
        } else {
            echo "Error checking existing notifications.";
        }
    }
} else {
    echo "Error fetching products with upcoming or extended expirations";
}

// Close the database connection
mysqli_close($conn);









// // Include the configuration file
// include '../include/config.php';

// // Calculate the date that is 5 months from now
// $currentDate = date('Y-m-d');
// $expireDateThreshold = date('Y-m-d', strtotime('+5 months'));

// // Query to select products that will expire within 5 months
// $sql = "SELECT ProductName, ExpireDate FROM products WHERE ExpireDate >= '$currentDate' AND ExpireDate <= '$expireDateThreshold'";
// $result = mysqli_query($conn, $sql);

// if ($result) {
//     while ($row = mysqli_fetch_assoc($result)) {
//         $productName = $row['ProductName'];
//         $expireDate = $row['ExpireDate'];
        
//         // Calculate the days until expiration
//         $daysUntilExpiration = floor((strtotime($expireDate) - strtotime($currentDate)) / (60 * 60 * 24));
        
//         // Create the notification message
//         $notificationMessage = "$productName will expire in $daysUntilExpiration days.";

//         // Check if the message already exists in the table
//         $checkQuery = "SELECT * FROM `notification` WHERE message = '$notificationMessage'";
//         $resultCheck = mysqli_query($conn, $checkQuery);

//         if ($resultCheck) {
//             if (mysqli_num_rows($resultCheck) === 0) {
//                 // The message doesn't exist, so insert it
//                 $currentDateTime = date('Y-m-d H:i:s A');
//                 $insertQuery = "INSERT INTO notification (`message`, `date_time`) VALUES ('$notificationMessage', '$currentDateTime')";
//                 $resultInsertNotification = mysqli_query($conn, $insertQuery);

//                 if ($resultInsertNotification) {
//                     echo "Notification inserted for $productName";
//                 } else {
//                     echo "Error inserting notification for $productName";
//                 }
//             } else {
//                 echo "Notification for $productName already exists.";
//             }
//         } else {
//             echo "Error checking existing notifications.";
//         }
//     }
// } else {
//     echo "Error fetching products within 5 months of expiration";
// }

// // Close the database connection
// mysqli_close($conn);
?> 
