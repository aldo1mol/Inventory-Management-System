<?php
include "../include/config.php";

if (isset($_POST['updateid'])) {
    $id = $_POST['updateid'];

    $sql = "SELECT ProductName, Category, SalesPrice FROM cart WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $response = array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $response = $row;
        }
        echo json_encode($response);
    } else {
        $response['status'] = 200;
        $response['message'] = "Invalid or data not found";
        echo json_encode($response);
    }
} else {
    $response['status'] = 200;
    $response['message'] = "Invalid or missing 'updateid' parameter";
    echo json_encode($response);
}
?>
