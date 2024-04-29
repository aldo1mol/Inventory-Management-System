<?php 

include '../include/config.php';    

      // displaytable
  if(isset($_POST['displaySend'])){
    $table='
    <table>
      <thead>
        <tr>
          <th scope="col">Category Name</th>

        </tr>
      </thead>';

    $sql="SELECT * FROM categories";
    $result=mysqli_query($conn,$sql);
    // $number=1;
    
    while($row=mysqli_fetch_assoc($result)){
      $id=$row['ID'];
      $categoryName=$row['CategoryName'];
     

      $table.='<tr>';

      // $number can be replaced with the $id here
      $table.='
                 <td>'.$categoryName.'</td>
      
    

      <td>
        <i class="bx bx-dots-vertical-rounded" onclick="toggleIcons(this)"></i>

        <a href="#" class="me-3 edituser hide-icons" title="edit" data-bs-target="#editcategory" onclick="GetCatDetails('.$id.')"><i class="fas fa-edit text-dark"></i></a>
        <a href="#" class="me-3 deleteuser hide-icons" title="Delete" onclick="DeleteCategory('.$id.')"><i class="fas fa-trash-alt text-danger"></i></a>

      </td>
      </tr>';
      // $number++;
    }
    

    $table.='</table>';
    echo $table;  
}

?>
