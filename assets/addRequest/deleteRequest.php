<?php
// Check if the form has been submitted
if(isset($_POST['delete'])) {
    // Get the request_id from the form
    $request_id = $_POST['request_id'];
    
    require_once "../databaseConnection.php";
    
    // Prepare the SQL statement
    $sql = "DELETE FROM requests WHERE request_id = ?";

    // Prepare statement
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "i", $request_id);

    // Execute statement
    mysqli_stmt_execute($stmt);

    // Check if deletion was successful
    if(mysqli_stmt_affected_rows($stmt) > 0) {
        header("Location: ../requests/requests.php");
    } else {
        echo "Error deleting request: " . mysqli_error($conn);
    }

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
