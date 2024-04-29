<?php 
 include '../include/config.php';

header('Content-type: application/vnd-ms-excel');
$filename = "EmployeesData.xls";
header("Content-Disposition:attachment;filename=\"$filename\"");

$table='
<table class="table mt-3" id="usertable" >
  <thead class="table-dark">
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">Gender</th>
      <th scope="col">Email</th>
      <th scope="col">Address</th>
      <th scope="col">Phone</th>
      <th scope="col">Hire_date</th>
      <th scope="col">Role</th>
      <th scope="col">SalaryPerMonth</th>
    </tr>
  </thead>';

$sql="SELECT * FROM employees";
$result=mysqli_query($conn,$sql);
// $number=1;

while($row=mysqli_fetch_assoc($result)){
  $id=$row['ID'];
  $name=$row['EmpName'];
  $gender=$row['Gender'];
  $email=$row['Email'];
  $address=$row['Address'];
  $phone=$row['Phone'];
  $hired=$row['Hire_date'];
  $role=$row['Role'];
  $salary=$row['SalaryPerMonth'];
  $table.='<tr>';

  // $number can be replaced with the $id here
  $table.='<td scope="row">'.$id.'</td> 
  <td>'.$name.'</td>
  <td>'.$gender.'</td>
  <td>'.$email.'</td>
  <td>'.$address.'</td>
  <td>'.$phone.'</td>
  <td>'.$hired.'</td>
  <td>'.$role.'</td>
  <td>'.$salary.'</td>
  
  
  </tr>';
  // $number++;
}


$table.='</table>';
echo $table;
?>