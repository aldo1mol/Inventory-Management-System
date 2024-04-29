<?php
include '../include/config.php';

if (isset($_POST['displayMessages'])) {
    // Initialize an empty string to store the HTML content.
    $output = '';

    // Fetch messages from the "notification" table.
    $sql = "SELECT id, `message`, `date_time` FROM `notification` ORDER BY `date_time` DESC";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $message = $row['message'];
            $dateTime = $row['date_time'];

            // Create a Bootstrap container for each message.
            $output .= '<div class="container mt-4">
                            <div class="alert alert-light  bg-dark">
                                <p class="lead text-light fw-bold">' . $message . '</p>
                                <p class="text-muted">' . $dateTime . '</p>
                            </div>
                        </div>';
        }
    } else {
        // Handle database query error.
        $output = '<div class="alert alert-danger">Error: ' . mysqli_error($conn) . '</div>';
    }

    echo $output;
}
?>
