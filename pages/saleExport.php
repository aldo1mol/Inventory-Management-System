<?php 
 include '../include/config.php';

header('Content-type: application/vnd-ms-excel');
$filename = "salesData.xls";
header("Content-Disposition:attachment;filename=\"$filename\"");

$table = '<table>
<thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Customer Name</th>
        <th scope="col">Product Name</th>
        <th scope="col">Category</th>
        <th scope="col">Sale Price</th>
        <th scope="col">Quantity</th>
        <th scope="col">Profit</th>
        <th scope="col">Total Price</th>
        <th scope="col">Date</th>
    </tr>
</thead>';


$sql="SELECT * FROM sales";
$result=mysqli_query($conn,$sql);
// $number=1;

while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['ID'];
    $customerName = $row['CustomerName'];
    $productName = $row['ProductName'];
    $category = $row['Category'];
    $SP = $row['SalesPrice'];
    $quantity = $row['Quantity'];
    $profit = $row['Profit'];
    $TP = $row['TotalPrice'];
    $D = $row['Date'];

    $table .= '<tr>';
    $table .= '<td scope="row">' . $id . '</td>';
    $table .= '<td>' . $customerName . '</td>';
    $table .= '<td>' . $productName . '</td>';
    $table .= '<td>' . $category . '</td>';
    $table .= '<td>' . $SP . '</td>';
    $table .= '<td>' . $quantity . '</td>';
    $table .= '<td>' . $profit . '</td>';
    $table .= '<td>' . $TP . '</td>';
    $table .= '<td>' . $D . '</td>';
  
    $table .=  '</tr>';
  // $number++;
}


$table.='</table>';
echo $table;
?>