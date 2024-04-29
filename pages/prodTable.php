<?php 
// Include the configuration file
include '../include/config.php';

// Retrieve the limit value from the database
$sql = "SELECT limitValue FROM `limit`";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
    $limit = $row['limitValue'];
} else {
    $limit = 10; // Set a default value if the limit is not found in the database
}

// Function to update the limit value in the database
function updateLimitValue($newLimit, $conn) {
    $updateQuery = "UPDATE `limit` SET limitValue = $newLimit";
    mysqli_query($conn, $updateQuery);
}

// Check if the form is submitted
if (isset($_POST['updateLimit'])) {
    $newLimit = $_POST['updateLimit'];
    updateLimitValue($newLimit, $conn);
    $limit = $newLimit;
}

$page = isset($_POST['page']) ? $_POST['page'] : 1;
$start_from = ($page - 1) * $limit;

// Pagination code
$query = mysqli_query($conn, "SELECT COUNT(*) as total_products FROM products");
$total_items = mysqli_fetch_assoc($query)['total_products'];
$total_pages = ceil($total_items / $limit);
$previous_page = $page > 1 ? $page - 1 : 1;
$next_page = $page < $total_pages ? $page + 1 : $total_pages;

$output = '<ul class="pagination justify-content-center">';
$output .= '<li class="page-item"><span class="page-link text-dark bg-light" id="1"><i class="fa fa-angles-left"></i></span></li>';
$output .= '<li class="page-item"><span class="page-link text-dark bg-light" id="'.$previous_page.'"><i class="fa fa-angle-left"></i></span></li>';
$output .= '<li class="page-item"><span class="page-link text-dark bg-light">'.$page.' of '.$total_pages.'</span></li>';
$output .= '<li class="page-item"><span class="page-link text-dark bg-light" id="'.$next_page.'"><i class="fa fa-angle-right"></i></span></li>';
$output .= '<li class="page-item"><span class="page-link text-dark bg-light" id="'.$total_pages.'"><i class="fa fa-angles-right"></i></span></li>';

$output .= '<li class="page-item">';
$output .= '<span style="margin-left:70px;">Limit:</span><input type="number" id="updateLimit" class="form-control" value="'.$limit.'" min="1" max="100" style="display: inline-block; width: 65px; margin-left: 5px;">'; // Adjust the min and max values as needed

$output .= '</li>';

$output .= '</ul>';

echo $output;

// Display the table
if (isset($_POST['displaySend'])) {
    $table = '<table>
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Product Name</th>
                <th scope="col">Category</th>
                <th scope="col">Quantity In Stock</th>
                <th scope="col">Sales Price</th>
                <th scope="col">Operations</th>
            </tr>
        </thead>';

    $sql = "SELECT ID, ProductName, Category, Quantity, SalesPrice FROM products ORDER BY ID DESC LIMIT $start_from, $limit";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['ID'];
        $productName = $row['ProductName'];
        $category = $row['Category'];
        $quantity = $row['Quantity'];
        $salesPrice = $row['SalesPrice'];

        $currentDateTime = date('Y-m-d H:i:s A');

        $notificationMessage = '';

        if ($quantity <= 10 && $quantity > 0) {
            $notificationMessage = "$productName is running low on stock. Only $quantity left.";
        }
        // elseif ($quantity == 0) {
        //     $notificationMessage = "$productName is out of stock.";
        // }
    
        // Check if the same message does not exist in the 'notification' table
        if (!empty($notificationMessage)) {
            $checkQuery = "SELECT * FROM notification WHERE message = '$notificationMessage'";
            $resultCheck = mysqli_query($conn, $checkQuery);
    
            if (mysqli_num_rows($resultCheck) == 0) {
                // Insert the notification message into the 'notification' table
                $insertNotificationQuery = "INSERT INTO notification (`message`,date_time) VALUES ('$notificationMessage','$currentDateTime')";
                $resultInsertNotification = mysqli_query($conn, $insertNotificationQuery);
    
                if (!$resultInsertNotification) {
                    // Handle the case where the notification message insertion fails
                    // You can log an error or take other appropriate actions
                }
            }
        }
    
        $table .= '<tr>';
        $table .= '<td scope="row">' . $id . '</td>';
        $table .= '<td>' . $productName . '</td>';
        $table .= '<td>' . $category . '</td>';
        $table .= '<td>' . $quantity . '</td>';
        $table .= '<td>₵ ' . $salesPrice . '</td>';
        $table .= '<td>
                    <i class="bx bx-dots-vertical-rounded" onclick="toggleIcons(this)"></i>
                    <a href="#" class="me-3 profile hide-icons" data-bs-target="#productsprofile" title="view profile" onclick="viewProfile(' . $id . ')"><i class="fas fa-eye text-success"></i></a>
                    <a href="#" class="me-3 edituser hide-icons" title="edit" data-bs-target="#editproducts" onclick="GetDetails(' . $id . ')"><i class="fas fa-edit text-info"></i></a>
                    <a href="#" class="me-3 deleteuser hide-icons" title="Delete" onclick="DeleteUser(' . $id . ')"><i class="fas fa-trash-alt text-danger"></i></a>
                </td>';
        $table .= '</tr>';
    }

    $table .= '</table>';
    echo $table;
}


 ?>
