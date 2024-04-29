<?php
 include '../include/config.php';

 if(isset($_POST['input'])){

  $input = $_POST['input'];

 $query = "SELECT * FROM users WHERE EmpName LIKE '%{$input}%' OR `role` LIKE '%{$input}%' OR username LIKE '%{$input}%' OR `password` LIKE '%{$input}%'";
 $result = mysqli_query($conn, $query);
//  $number=1;

 // Display search results
 if (mysqli_num_rows($result) > 0) {
  $table='
 <table>
    <thead>
        <tr>
            <th scope="col">USER ID</th>
            <th scope="col">FULL NAME</th>
            <th scope="col">ROLE</th>
            <th scope="col">USERNAME</th>
            <th scope="col">PASSWORD</th>
            <th scope="col">Operations</th>
        </tr>
    </thead>';



    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $fullname = $row['fullname'];
        $role = $row['role'];
        $username = $row['username'];
        $password = $row['password'];

        $table .= '<tr>';
        $table .= '<td scope="row">' . $id . '</td>';
        $table .= '<td>' . $fullname . '</td>';
        $table .= '<td>' . $role . '</td>';
        $table .= '<td>' . $username . '</td>';
        $table .= '<td>' . $password . '</td>';
        $table .= '<td>
                     <i class="bx bx-dots-vertical-rounded" onclick="toggleIcons(this)"></i>
                     <a href="#" class="me-3 edituser hide-icons" title="edit" data-bs-target="#editusers" onclick="GetDetails(' . $id . ')"><i class="fas fa-edit text-info"></i></a>
                     <a href="#" class="me-3 deleteuser hide-icons" title="Delete" onclick="DeleteUser(' . $id . ')"><i class="fas fa-trash-alt text-danger"></i></a>
                  </td>';
        $table .= '</tr>';
    }

    $table .= '</table>';
    echo $table;
   }
   else {
    echo "<div class='text-danger text-center mt-3'><h2>No result found</h2></div>";
  }
 } 

?>

