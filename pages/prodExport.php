<?php 
 include '../include/config.php';

header('Content-type: application/vnd-ms-excel');
$filename = "productsData.xls";
header("Content-Disposition:attachment;filename=\"$filename\"");

$table = '<table>
<thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Product Name</th>
        <th scope="col">Category</th>
        <th scope="col">Cost Price</th>
        <th scope="col">Sales Price</th>
        <th scope="col">Profit</th>
        <th scope="col">Quantity</th>
        <th scope="col">Supplier</th>
        <th scope="col">Date In Stock</th>
        <th scope="col">Expire Date</th>
        <th scope="col">Description</th>
    </tr>
</thead>';


$sql="SELECT * FROM products";
$result=mysqli_query($conn,$sql);
// $number=1;

while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['ID'];
    $productName = $row['ProductName'];
    $category = $row['Category'];
    $CP = $row['CostPrice'];
    $SP = $row['SalesPrice'];
    $profit = $row['Profit'];
    $quantity = $row['Quantity'];
    $supplier = $row['Supplier'];
    $DIS = $row['DateInStock'];
    $EXP = $row['ExpireDate'];
    $Description = $row['Description'];


    $table .= '<tr>';
    $table .= '<td scope="row">' . $id . '</td>';
    $table .= '<td>' . $productName . '</td>';
    $table .= '<td>' . $category . '</td>';
    $table .= '<td>' . $CP . '</td>';
    $table .= '<td>' . $SP . '</td>';
    $table .= '<td>' . $profit . '</td>';
    $table .= '<td>' . $quantity . '</td>';
    $table .= '<td>' . $supplier . '</td>';
    $table .= '<td>' . $DIS . '</td>';
    $table .= '<td>' . $EXP . '</td>';
    $table .= '<td>' . $Description . '</td>';

  
    $table .=  '</tr>';
  // $number++;
}


$table.='</table>';
echo $table;
?>