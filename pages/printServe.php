<?php
include '../include/config.php';

if (isset($_POST['displaySB'])) {
    // Fetch the Served By data for the user with the maximum id
    $sql = "SELECT servedBy FROM customers WHERE id = (SELECT MAX(id) FROM customers)";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        $servedBy = $row['servedBy'];

        // Create an input field with the Served By data
        $input = '
            <div class="form-group text-warning">
                <label for="Served By">Served By</label>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-dark">
                        <i class="bx bxs-shopping-bag-alt text-light"></i>
                    </span>
                    <input type="text" class="form-control" id="SB" value="' . $servedBy . '" readonly>
                </div>
            </div>
        ';

        echo $input;
    }
}
?>