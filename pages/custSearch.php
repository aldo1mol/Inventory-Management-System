<?php
 include '../include/config.php';

 if(isset($_POST['input'])){

  $input = $_POST['input'];

 $query = "SELECT * FROM customers WHERE customername LIKE '%{$input}%' OR  phone LIKE '%{$input}%' OR AmtSpent LIKE '%{$input}%' OR `date` LIKE '%{$input}%'OR id LIKE '%{$input}%' ";
 $result = mysqli_query($conn, $query);

 // Display search results
 if (mysqli_num_rows($result) > 0) {
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
        <th scope="col">Operations</th>

      </tr>
    </thead>';
      
  
    while($row=mysqli_fetch_assoc($result)){
        $id=$row['id'];
        $customerName=$row['customerName'];
        $phone=$row['phone'];
        $AmtSpent=$row['AmtSpent'];
        $ServedBy=$row['servedBy'];
        $date=$row['date'];
  
          $table.='<tr>
          <td scope="row">'.$id.'</td>
          <td>'.$customerName.'</td>
          <td>'.$phone.'</td>
          <td>'.$AmtSpent.'</td>
          <td>'.$ServedBy.'</td>
          <td>'.$date.'</td>
        
        <td>
          <i class="bx bx-dots-vertical-rounded" onclick="toggleIcons(this)"></i>
  
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
  
