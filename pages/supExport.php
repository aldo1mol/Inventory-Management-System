<?php 
 include '../include/config.php';

header('Content-type: application/vnd-ms-excel');
$filename = "SuppliersData.xls";
header("Content-Disposition:attachment;filename=\"$filename\"");

$table = '<table>
<thead>
    <tr>
        <th scope="col">SUPPLIER ID</th>
        <th scope="col"> Company Name</th>
        <th scope="col">Contact</th>
    </tr>
</thead>';

$sql="SELECT * FROM suppliers";
$result=mysqli_query($conn,$sql);
// $number=1;

while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['supplierID'];
    $companyName = $row['companyName'];
    $contact = $row['contact'];
    

    $table .= '<tr>';
    $table .= '<td scope="row">' . $id . '</td>';
    $table .= '<td>' . $companyName . '</td>';
    $table .= '<td>' . $contact . '</td>';
    $table .= '</tr>';
}


$table.='</table>';
echo $table;
?>