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
$query = mysqli_query($conn, "SELECT COUNT(*) as total_sales_row FROM sales");
$total_sales_row = mysqli_fetch_assoc($query)['total_sales_row'];
$total_pages = ceil($total_sales_row / $limit);
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

      

      // displaytable
  if(isset($_POST['displaySend'])){
    $table='
    <table>
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Customer</th>
          <th scope="col">Product</th>
          <th scope="col">Category</th>
          <th scope="col">Sale Price</th> 
          <th scope="col">Quantity</th> 
          <th scope="col">Total Price</th> 
          <th scope="col">Profit</th> 
          <th scope="col">Date</th> 
         

        </tr>
      </thead>';

    $sql="SELECT ID,CustomerName,ProductName,Category,`SalesPrice` , Quantity, TotalPrice, Profit, Date FROM sales  ORDER BY Date DESC LIMIT $start_from, $limit";
    $result=mysqli_query($conn,$sql);
    // $number=1;
    
    while($row=mysqli_fetch_assoc($result)){
      $id=$row['ID'];
      $custName=$row['CustomerName'];
      $prod=$row['ProductName'];
      $cat=$row['Category'];
      $sp=$row['SalesPrice'];
      $q=$row['Quantity'];
      $tp=$row['TotalPrice'];
      $p=$row['Profit'];
      $d=$row['Date'];

      $table.='<tr>';

      // $number can be replaced with the $id here
      $table.='<td scope="row">'.$id.'</td> 
      <td>'.$custName.'</td>
      <td>'.$prod.'</td>
      <td>'.$cat.'</td>
      <td>'.$sp.'</td>
      <td>'.$q.'</td>
      <td>'.$tp.'</td>
      <td>'.$p.'</td>
      <td>'.$d.'</td>
    
      </tr>';
      // $number++;
    }
    

    $table.='</table>';
    echo $table;  
}

?>
