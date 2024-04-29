<?php
include '../include/config.php';

// Get the product details from the AJAX request
$productName = $_POST['productNameSend'];
$category = $_POST['categorySend'];
$price = $_POST['priceSend'];
$profit = $_POST['profitSend'];

// Check if the product is available (quantity greater than zero)
$sqlAvailability = "SELECT Quantity FROM products WHERE ProductName='$productName'";
$resultAvailability = mysqli_query($conn, $sqlAvailability);

if ($resultAvailability && mysqli_num_rows($resultAvailability) > 0) {
    $row = mysqli_fetch_assoc($resultAvailability);
    $quantity = $row['Quantity'];

    if ($quantity <= 0) {
        // Product is out of stock
        echo "out_of_stock";
    } else {
        // Check if the product already exists in the cart
        $sql = "SELECT * FROM cart WHERE ProductName='$productName'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // If the product already exists in the cart, return a message
            echo "already_added";
        } else {
            // If the product does not exist in the cart and is available, insert it into the database
            $sqlInsert = "INSERT INTO cart (ProductName, Category, SalesPrice, Profit) VALUES ('$productName','$category','$price','$profit')";
            $resultInsert = mysqli_query($conn, $sqlInsert);

            if ($resultInsert) {
                // If the product was successfully added to the cart, return a success message
                echo "success";
            } else {
                // If there was an error adding the product to the cart, return an error message
                echo "error";
            }
        }
    }
} else {
    // Product not found or database error
    echo "product_not_found";
}

// Close the database connection
mysqli_close($conn);

?>

   
