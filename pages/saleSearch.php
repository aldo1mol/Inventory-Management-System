<?php
 include '../include/config.php';

 if(isset($_POST['input'])){

  $input = $_POST['input'];

 $query = "SELECT * FROM sales WHERE CustomerName LIKE '%{$input}%' OR  ProductName LIKE '%{$input}%' OR Category LIKE '%{$input}%' OR 'Date' LIKE '%{$input}%' ";
 $result = mysqli_query($conn, $query);
//  $number=1;

 // Display search results
 if (mysqli_num_rows($result) > 0) {
  $table='
 <table>
  <thead>
  <tr>
        <th scope="col">ID</th>
        <th scope="col">Customer</th>
        <th scope="col">Product</th>
        <th scope="col">Price</th>
        <th scope="col">Quantity</th> 
        <th scope="col">Total Price</th> 
        <th scope="col">Profit</th> 
        <th scope="col">Date</th> 
  </tr>
  </thead>
    ';

    while($row=mysqli_fetch_assoc($result)){
        $id=$row['id'];
        $customer=$row['CustomerName'];
        $product=$row['ProductName'];
        $price=$row['SalesPrice'];
        $quantity=$row['Quantity'];
        $totalprice=$row['TotalPrice'];
        $profit=$row['Profit'];
        $date=$row['Date'];
        $table.='<tr>
        <td scope="row">'.$id.'</td>
        <td>'.$customer.'</td>
        <td>'.$product.'</td>
        <td>'.$price.'</td>
        <td>'.$quantity.'</td>
        <td>'.$totalprice.'</td>
        <td>'.$profit.'</td>
        <td>'.$date.'</td>
      </tr>';
      // $number++;
    }

    $table.='</table>';
    echo $table;
   }
   else {
    echo "<div class='text-danger text-center mt-3'><h2>No result found</h2></div>";
  }
 } 

?>

