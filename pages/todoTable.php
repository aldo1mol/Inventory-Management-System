<?php
include '../include/config.php';

$sql = "SELECT id, todo, `status` FROM todo_list";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id'];
    $todo = $row['todo'];
    $status = $row['status'];

    if (isset($_POST['displayTodo'])) {
        $input = '
        <li class="'.$status.'">
            <p>'.$todo.'</p>
            <i class="bx bx-dots-vertical-rounded" onclick="toggleIcons(this)"></i>
            <a href="#" class="edituser hide-icons" title="edit" data-bs-target="#edittodo" onclick="GetTodo('.$id.')"><i class="fas fa-edit text-dark"></i></a>
            <a href="#" class="deleteuser hide-icons" title="Delete" onclick="DeleteTodo('.$id.')"><i class="fas fa-trash-alt text-danger"></i></a>
        </li>
        ';

        echo $input;
    }
}

?>
