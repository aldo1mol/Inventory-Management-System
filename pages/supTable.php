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
$query = mysqli_query($conn, "SELECT COUNT(*) as total_suppliers FROM suppliers");
$total_suppliers = mysqli_fetch_assoc($query)['total_suppliers'];
$total_pages = ceil($total_suppliers / $limit);
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
                <th scope="col">SUPPLIER ID</th>
                <th scope="col"> Company Name</th>
                <th scope="col">Contact</th>
            </tr>
        </thead>';

    $sql = "SELECT supplierID, companyName, contact FROM suppliers LIMIT $start_from, $limit";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['supplierID'];
        $companyName = $row['companyName'];
        $contact = $row['contact'];
        

        $table .= '<tr>';
        $table .= '<td scope="row">' . $id . '</td>';
        $table .= '<td>' . $companyName . '</td>';
        $table .= '<td>' . $contact . '</td>';
        
        $table .= '<td>
                    <i class="bx bx-dots-vertical-rounded" onclick="toggleIcons(this)"></i>
                    <a href="#" class="me-3 edituser hide-icons" title="edit" data-bs-target="#editproducts" onclick="GetDetails(' . $id . ')"><i class="fas fa-edit text-info"></i></a>
                    <a href="#" class="me-3 deleteuser hide-icons" title="Delete" onclick="DelSup(' . $id . ')"><i class="fas fa-trash-alt text-danger"></i></a>
                </td>';
        $table .= '</tr>';
    }

    $table .= '</table>';
    echo $table;
}
?>
