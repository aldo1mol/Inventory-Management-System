<?php

include '../include/config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tableData = json_decode($_POST["tableData"], true);
    $grandTotal = floatval($_POST["grandTotal"]);
    $customerName = $_POST["customerName"];
    $phone = $_POST["phone"];
    $servedBy = $_POST['servedby'];
    $date = date("Y-m-d"); // Set the date

    // Initialize variables for print table
    $printProductName = [];
    $printQuantity = [];
    $printTotalPrice = [];

    foreach ($tableData as $row) {
        $productName = $row[0];
        $category = $row[1];
        $salesPrice = $row[2];
        $quantity = $row[3];
        $profit = $row[4];
        $totalPrice = $row[5];

        // Ensure that numeric values are handled correctly
        $salesPrice = is_numeric($salesPrice) ? $salesPrice : 0;
        $quantity = is_numeric($quantity) ? $quantity : 0;
        $profit = is_numeric($profit) ? $profit : 0;
        $totalPrice = is_numeric($totalPrice) ? $totalPrice : 0;


        // Insert into 'sales' table
        $stmt = $conn->prepare("INSERT INTO sales (CustomerName, ProductName, Category, SalesPrice, Quantity, TotalPrice, Profit, `Date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdsdds", $customerName, $productName, $category, $salesPrice, $quantity, $totalPrice, $profit, $date);
        $stmt->execute();
        
        // Handle errors if necessary
        if ($stmt->error) {
            echo "Error: " . $stmt->error;
            exit; // Exit to prevent further execution
        }
        
        // Close the statement
        $stmt->close();

        // Store data for 'print' table
        $printProductName[] = $productName;
        $printQuantity[] = $quantity;
        $printTotalPrice[] = $totalPrice;

        // Subtract the quantity from the products table
        $sql4 = "UPDATE products SET Quantity = Quantity - $quantity WHERE ProductName = '$productName'";
        $resultUpdateProducts = mysqli_query($conn, $sql4);

        if (!$resultUpdateProducts) {
            // If there was an error updating the products table, handle it as needed
            echo "error_update_products";
            exit; // Exit to prevent further execution
        }
    }

    // Insert into 'customers' table
    $stmt = $conn->prepare("INSERT INTO customers (customerName, phone, AmtSpent, servedBy, `date`) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $customerName, $phone, $grandTotal, $servedBy, $date);
    $stmt->execute();
    
    // Handle errors if necessary
    if ($stmt->error) {
        echo "Error: " . $stmt->error;
        exit; // Exit to prevent further execution
    }
    
    // Close the statement
    $stmt->close();

    // Insert into 'print' table
    for ($i = 0; $i < count($printProductName); $i++) {
        $stmt = $conn->prepare("INSERT INTO `print` (product_name, quantity, total_price) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $printProductName[$i], $printQuantity[$i], $printTotalPrice[$i]);
        $stmt->execute();
        
        // Handle errors if necessary
        if ($stmt->error) {
            echo "Error: " . $stmt->error;
            exit; // Exit to prevent further execution
        }
        
        // Close the statement
        $stmt->close();
    }

    echo "Data saved to the 'sales', 'customers', and 'print' tables successfully!";
} else {
    echo "Invalid request!";
}

// Close the database connection (if not already closed)
$conn->close();



// // Include the configuration file
// include '../include/config.php';

// // Get the product details from the AJAX request
// $customerName = $_POST['custNameSend'];
// $productName = $_POST['prodNameSend'];
// $category = $_POST['categorySend'];
// $price = $_POST['priceSend'];
// $quantity = $_POST['quantitySend'];
// $totalPrice = $_POST['totalPriceSend'];
// $phone = $_POST['phoneSend'];
// $grandTotal = $_POST['gTotalSend'];
// $servedBy = $_POST['servedbySend'];
// $profit = $_POST['profitSend'];
// $date = date("Y-m-d");

// // Check if the product already exists in the sales database
// $sql = "SELECT * FROM sales WHERE ProductName = '$productName' AND Category = '$category' AND SalesPrice = '$price' 
//         AND Quantity = '$quantity' AND TotalPrice = '$totalPrice' AND Date = '$date'";
// $resultSales = mysqli_query($conn, $sql);

// if (mysqli_num_rows($resultSales) > 0) {
//     // If the product already exists in the sales, return a message
//     echo "already_saved";
// } else {
//     // If the product does not exist in the sales, insert it into the database
//     $sql1 = "INSERT INTO sales (CustomerName, ProductName, Category, SalesPrice, Quantity, TotalPrice, Profit, `Date`) VALUES ('$customerName', 
//     '$productName', '$category', '$price', '$quantity', '$totalPrice', '$profit', '$date')";
//     $resultSalesInsert = mysqli_query($conn, $sql1);

//     $sql2 = "INSERT INTO customers (customerName, phone, AmtSpent, servedBy, `date`) VALUES ('$customerName', '$phone', 
//     '$grandTotal', '$servedBy', '$date')";
//     $resultCustomersInsert = mysqli_query($conn, $sql2);

//     $sql3 = "INSERT INTO `print` (product_name, quantity, total_price) VALUES ('$productName', '$quantity', 
//     '$totalPrice')";
//     $resultPrintInsert = mysqli_query($conn, $sql3);

//     if ($resultSalesInsert && $resultCustomersInsert) {
//         // If the product was successfully saved, subtract the quantity from the products table
//         $sql4 = "UPDATE products SET Quantity = Quantity - $quantity WHERE ProductName = '$productName'";
//         $resultUpdateProducts = mysqli_query($conn, $sql4);

//         if ($resultUpdateProducts) {
//             // If the quantity was successfully subtracted from the products table, return a success message
//             echo "success";
//         } else {
//             // If there was an error subtracting the quantity from the products table, return an error message
//             echo "error";
//         }
//     } else {
//         // If there was an error adding the product to the sales or customers table, return an error message
//         echo "error";
//     }
// }

// // Close the database connection
// mysqli_close($conn);
?>

   
