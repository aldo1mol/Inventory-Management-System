<?php
 include '../include/config.php';

 if(isset($_POST['input'])){

  $input = $_POST['input'];

 $query = "SELECT * FROM suppliers WHERE companyName LIKE '%{$input}%' OR contact LIKE '%{$input}%' ";
 $result = mysqli_query($conn, $query);
//  $number=1;

 // Display search results
 if (mysqli_num_rows($result) > 0) {
  $table='
 <table>
  <thead>
  <tr>
      <th scope="col">SUPPLIER ID</th>
      <th scope="col"> Company Name</th>
      <th scope="col">Contact</th>
  </tr>
</thead>';



    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['supplierID'];
        $companyName = $row['companyName'];
        $contact = $row['contact'];
        

        $table .= '<tr>';
        $table .= '<td scope="row">' . $id . '</td>';
        $table .= '<td>' . $companyName . '</td>';
        $table .= '<td>' . $contact . '</td>';
        
        $table .= '<td>
                    <i class="bx bx-dots-vertical-rounded" onclick="toggleIcons(this)"></i>
                    <a href="#" class="me-3 edituser hide-icons" title="edit" data-bs-target="#editproducts" onclick="GetDetails(' . $id . ')"><i class="fas fa-edit text-info"></i></a>
                    <a href="#" class="me-3 deleteuser hide-icons" title="Delete" onclick="DelSup(' . $id . ')"><i class="fas fa-trash-alt text-danger"></i></a>
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

