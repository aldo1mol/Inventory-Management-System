<?php 
 include '../include/config.php';

header('Content-type: application/vnd-ms-excel');
$filename = "CustomersData.xls";
header("Content-Disposition:attachment;filename=\"$filename\"");

$table='
<table>
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Customer Name</th>
          <th scope="col">Phone No.</th>
          <th scope="col">Amt Spent</th>
          <th scope="col">Served By</th> 
          <th scope="col">Date</th> 

        </tr>
      </thead>';

$sql="SELECT * FROM customers";
$result=mysqli_query($conn,$sql);
// $number=1;


while($row=mysqli_fetch_assoc($result)){
    $id=$row['id'];
    $customerName=$row['customerName'];
    $phone=$row['phone'];
    $AmtSpent=$row['AmtSpent'];
    $ServedBy=$row['servedBy'];
    $date=$row['date'];

  $table.='<tr>';

  // $number can be replaced with the $id here
  $table.='<td scope="row">'.$id.'</td> 
  <td>'.$customerName.'</td>
  <td>'.$phone.'</td>
  <td>'.$AmtSpent.'</td>
  <td>'.$ServedBy.'</td>
  <td>'.$date.'</td>

  
  
  </tr>';
  // $number++;
}


$table.='</table>';
echo $table;
?>