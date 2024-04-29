<?php
 include '../include/config.php';

 if(isset($_POST['input'])){

  $input = $_POST['input'];

 $query = "SELECT * FROM employees WHERE EmpName LIKE '%{$input}%' OR  Role LIKE '%{$input}%' OR Phone LIKE '%{$input}%' OR ID LIKE '%{$input}%'OR Email LIKE '%{$input}%' ";
 $result = mysqli_query($conn, $query);
//  $number=1;

 // Display search results
 if (mysqli_num_rows($result) > 0) {
  $table='
 <table>
  <thead>
  <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Phone No.</th>
        <th scope="col">Email</th>
        <th scope="col">Role</th> 
        <th scope="col">Operations</th>
  </tr>
  </thead>
    ';

    while($row=mysqli_fetch_assoc($result)){
        $id=$row['ID'];
        $EmpName=$row['EmpName'];
        $phone=$row['Phone'];
        $email=$row['Email'];
        $role=$row['Role'];
        $table.='<tr>
        <td scope="row">'.$id.'</td>
        <td>'.$EmpName.'</td>
        <td>'.$phone.'</td>
        <td>'.$email.'</td>
        <td>'.$role.'</td>
      <td>
        <i class="bx bx-dots-vertical-rounded" onclick="toggleIcons(this)"></i>

        <a href="#" class="me-3 profile hide-icons" data-bs-target="#employeeprofile" title="view profile" onclick="viewEmpProfile('.$id.')"><i class="fas fa-eye text-success"></i></a>
        <a href="#" class="me-3 edituser hide-icons" title="edit" data-bs-target="#editemployee" onclick="GetDetails('.$id.')"><i class="fas fa-edit text-info"></i></a>
        <a href="#" class="me-3 deleteuser hide-icons" title="Delete" onclick="DeleteUser('.$id.')"><i class="fas fa-trash-alt text-danger"></i></a>

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

