<?php 
include '../include/config.php';

// Calculate the grand total
$grandTotalSQL = mysqli_query($conn, "SELECT SUM(total_price) AS grand_total FROM `print`");
$grand_total_row = mysqli_fetch_assoc($grandTotalSQL);
$grand_total = $grand_total_row['grand_total'];

// Display the table
if (isset($_POST['displaySend'])) {
    $table = '<table id="customers">
        <thead>
            <tr>
                <th scope="col">Product Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total Price</th>
            </tr>
        </thead>';

    $sql = "SELECT id, product_name, quantity, total_price FROM `print`";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $productName = $row['product_name'];
        $quantity = $row['quantity'];
        $totalPrice = $row['total_price'];

        $table .= '<tr>';
        // $table .= '<td scope="row">' . $id . '</td>';
        $table .= '<td>' . $productName . '</td>';
        $table .= '<td>' . $quantity . '</td>';
        $table .= '<td>' . $totalPrice. '</td>';
        $table .= '</tr>';
    } 

    $table .= '<tr rowspan="2">';
    $table .= '
        <td>
            <h6>CUSTOMER NAME:</h6> 
        </td>
        <td colspan="3">
           <div id="CN"></div>     
        </td>
    ';
    $table .= '</tr>';
    
    $table .= '<tr>';
    $table .= '
        <td colspan="1"></td>
        <td>
            <h6>GRAND TOTAL:</h6> <p>' . $grand_total . '</p>
        </td>
        <td id="SB_input">
            
        </td>
    ';
    $table .= '</tr>';

    $table .= '</table>';
    echo $table;
} 
?>
