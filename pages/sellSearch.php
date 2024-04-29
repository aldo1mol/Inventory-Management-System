<?php
 include '../include/config.php';

 if(isset($_POST['input'])){

  $input = $_POST['input'];

 $query = "SELECT * FROM products WHERE ProductName LIKE '%{$input}%' OR  Category LIKE '%{$input}%' OR  `Description` LIKE '%{$input}%' OR DateInStock LIKE '%{$input}%' OR ID LIKE '%{$input}%'OR Supplier LIKE '%{$input}%' ";
 $result = mysqli_query($conn, $query);
//  $number=1;

 // Display search results
 if (mysqli_num_rows($result) > 0) {
  $table='
  <table>
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


    while($row=mysqli_fetch_assoc($result)){
        $id=$row['ID'];
        $ProductName=$row['ProductName'];
        $Category=$row['Category'];
        $Quantity=$row['Quantity'];
        $SalesPrice=$row['SalesPrice'];
  
        $table.='<tr>';
  
        // $number can be replaced with the $id here
        $table.='<td scope="row">'.$id.'</td> 
        <td>'.$ProductName.'</td>
        <td>'.$Category.'</td>
        <td>'.$Quantity.'</td>
        <td> 
          ₵ '.$SalesPrice.'</td>
        <td>
            <form method="post" Class="form-submit">
                <input type="hidden" id="productName">
                <input type="hidden" id="price">
                <input type="hidden" id="hiddendata">
                <button type="button" class="btn btn-primary" onclick="addToCartAndUpdateProfile('.$id.')">Add to cart</button>
            </form>
        </td>
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

