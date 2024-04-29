<?php
session_start();
include '../include/config.php';

if (isset($_POST['displaySB'])) {
    $input = '
    <div class="form-group text-warning">
        <label for="Served By">Served By</label>
        <div class="input-group mb-3">
            <span class="input-group-text bg-dark">
                <i class="bx bxs-shopping-bag-alt text-light"></i>
            </span>
            <select class="form-select" id="SB">
    ';

    // Get the username from the session
    $user = $_SESSION['username'];

    // Use prepared statement to avoid SQL injection
    $sql = "SELECT EmpName FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    // Bind the username parameter
    mysqli_stmt_bind_param($stmt, "s", $user);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $fullName = $row['EmpName'];
        $input .= '<option value="' . $fullName . '">' . $fullName . '</option>';
    }

    $input .= '
            </select>           
        </div>
    </div>
    ';

    echo $input;

    // Close the statement
    mysqli_stmt_close($stmt);
}
?>
