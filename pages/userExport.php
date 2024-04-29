<?php 
 include '../include/config.php';

header('Content-type: application/vnd-ms-excel');
$filename = "UsersData.xls";
header("Content-Disposition:attachment;filename=\"$filename\"");

$table = '<table>
<thead>
<tr>
    <th scope="col">USER ID</th>
    <th scope="col">FULL NAME</th>
    <th scope="col">ROLE</th>
    <th scope="col">USERNAME</th>
    <th scope="col">PASSWORD</th>
</tr>
</thead>';

$sql="SELECT * FROM users";
$result=mysqli_query($conn,$sql);
// $number=1;

$sql = "SELECT id, fullname, `role`, username, `password` FROM users";
    $result = mysqli_query($conn, $sql);

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
        $table .= '</tr>';
}


$table.='</table>';
echo $table;
?>