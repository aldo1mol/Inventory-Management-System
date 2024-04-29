<?php 
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
                <th scope="col">Unit Profit</th>
            </tr>
        </thead>';

    $sql = "SELECT ID, ProductName, Category, Quantity, SalesPrice, Profit FROM products LIMIT $start_from, $limit";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['ID'];
        $productName = $row['ProductName'];
        $category = $row['Category'];
        $quantity = $row['Quantity'];
        $salesPrice = $row['SalesPrice'];
        $profit = $row['Profit'];


        $table .= '<tr>';
        $table .= '<td scope="row">' . $id . '</td>';
        $table .= '<td>' . $productName . '</td>';
        $table .= '<td>' . $category . '</td>';
        $table .= '<td>' . $quantity . '</td>';
        $table .= '<td>₵ ' . $salesPrice . '</td>';
        $table .= '<td>₵ ' . $profit . '</td>';
        $table .= '<td>
                    <td>
                        <form method="post" Class="form-submit">
                            <input type="hidden" id="productName">
                            <input type="hidden" id="category">
                            <input type="hidden" id="price">
                            <input type="hidden" id="profit">
                            <input type="hidden" id="hiddendata">
                            <button type="button" class="btn btn-primary" onclick="AddToCart('.$id.')">Add to cart</button>
                        </form>
                    </td>';
        $table .= '</tr>';
    }

    $table .= '</table>';
    echo $table;
}
?>
