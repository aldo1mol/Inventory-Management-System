<?php

include '../include/config.php';

if(isset($_POST['displaySend'])){
    $table = '
        <table class="table table-dark table-striped" id="cartTable" >
            <thead class="table-dark">
                <tr>
                    <th>Item ID</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Sales Price</th>
                    <th>Quantity</th>
                    <th>Profit</th>
                    <th>Total Price</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>';

    $sql = "SELECT id, ProductName, Category, SalesPrice, Profit FROM cart";
    $result = mysqli_query($conn, $sql);

    $grand_total = 0; // initialize grand total variable

    while($row = mysqli_fetch_assoc($result)){
        $id = $row['id'];
        $productName = $row['ProductName'];
        $category = $row['Category'];
        $sales_price = $row['SalesPrice'];
        $profit = $row['Profit'];


        $table .= '<tr>';
        $table .= '
            <td scope="row">'.$id.'</td>
            <td>'.$productName.'</td>
            <td>'.$category.'</td>
            <td>'.$sales_price.'</td>

            <td>
                <input type="number" style="width:50px;" class="quantity">
            </td>
            <td>
               <input type="text" style="width: 130px;" class="profit" data-profit="'.$profit.'" readonly>
            </td>
            <td>
                <input style="width: 130px;" type="text" class="total_price" readonly>
            </td>
            <td>'.date("Y-m-d").'</td>
            <td>
                <button class="btn btn-danger" onclick="DeleteCartItem('.$id.')">Remove</button>
            </td>
        ';
        $table .= '</tr>';

      // add price to grand total
    }

    $table .= '</table>';

    
    echo $table;
}





?>
