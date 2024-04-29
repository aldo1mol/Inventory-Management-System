<?php
include '../include/config.php';

if (isset($_POST['displayEName'])) {
    $input = '
    <div class="form-group text-warning">
        <div class="input-group mb-3">
            <span class="input-group-text bg-dark">
                <i class="bx bxs-shopping-bag-alt text-light"></i>
            </span>
            <select class="form-select" id="Names">
    ';

    $sql = "SELECT EmpName FROM employees";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $Name = $row['EmpName'];
        $input .= '<option value="' . $Name . '">' . $Name . '</option>';
    }

    $input .= '
            </select>           
        </div>
    </div>
    ';

    echo $input;
}
?>