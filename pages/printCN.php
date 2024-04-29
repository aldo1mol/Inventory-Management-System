<?php
$today = date('Y-m-d');
include '../include/config.php';

if (isset($_POST['displayCustomer'])) {
    $input = '';
    
    $sql = "SELECT customerName FROM customers WHERE date = '$today' 
            AND id = (SELECT MAX(id) FROM customers WHERE date = '$today');";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        // If there's only one result, display a single input field of type "text"
        $row = mysqli_fetch_assoc($result);
        $customerName = $row['customerName'];
        $input .= '
            <div class="input-group">
                <input type="text" class="form-control" value="' . $customerName . '" readonly>
            </div>
        ';
    } 

    echo $input;
}
?>
