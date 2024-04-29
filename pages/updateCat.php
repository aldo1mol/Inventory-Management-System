<?php
include '../include/config.php';

if (isset($_POST['updateCategory'])) {
    $input = '
    <div class="form-group text-light">
        <label for="category">Category</label>
        <div class="input-group mb-3">
            <span class="input-group-text bg-dark">
                <i class="bx bxs-shopping-bag-alt text-light"></i>
            </span>
            <select class="form-select" id="updatecategory">
    ';

    $sql = "SELECT categoryName FROM categories";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $categoryName = $row['categoryName'];
        $input .= '<option value="' . $categoryName . '">' . $categoryName . '</option>';
    }

    $input .= '
            </select>           
        </div>
    </div>
    ';

    echo $input;
}
?>
