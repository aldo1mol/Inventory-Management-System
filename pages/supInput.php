<?php
include '../include/config.php';

if (isset($_POST['displaySuppliers'])) {
    $input = '
    <div class="form-group text-light">
        <label for="category">Suppliers</label>
        <div class="input-group mb-3">
            <span class="input-group-text bg-dark">
                <i class="fas fa-user text-light"></i>
            </span>
            <select class="form-select" id="suppliers">
    ';

    $sql = "SELECT companyName FROM suppliers";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)){
        $companyName = $row['companyName'];
        $input .= '<option value="' . $companyName . '">' . $companyName . '</option>';
    }

    $input .= '
            </select>           
        </div>
    </div>
    ';

    echo $input;
}
?>
