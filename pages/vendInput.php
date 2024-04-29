<?php
include '../include/config.php';

if (isset($_POST['displayVendor'])) {
    $input = '
    <div class="form-group text-light">
        <label for="served-by">Served By</label>
        <div class="input-group mb-3">
            <span class="input-group-text bg-dark">
                <i class="bx bxs-shopping-bag-alt text-light"></i>
            </span>
            <select class="form-select" id="vendor">
    ';

    $sql = "SELECT EmpName FROM employees";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $EmpName = $row['EmpName'];
        $input .= '<option value="' . $EmpName . '">' . $EmpName . '</option>';
    }

    $input .= '
            </select>           
        </div>
    </div>
    ';

    echo $input;
}
?>
