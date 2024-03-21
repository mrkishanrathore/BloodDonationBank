<?php
session_start();

// Check if the session variable exists
if(isset($_SESSION['username']) && isset($_SESSION['userType']) && $_SESSION['userId']) {
    $username = $_SESSION['username'];
    $userType = $_SESSION['userType'];
    $userId = $_SESSION['userId'];

    $data = array(
        'username' => $username,
        'userType' => $userType,
        'userId' => $userId
    );

    // Return data as JSON response
    header('Content-Type: application/json');
    echo json_encode($data);

} else {
    echo 'Session variable not set';
}
?>
