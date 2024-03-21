<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

<header class="continer-fluid ">
        <div id="menu-jk" class="header-bottom">
            <div class="container">
                <div class="row nav-row">
                    <div class="col-md-3 logo">
                        <img src="../images/logo.jpg" alt="">
                    </div>
                    <div class="col-md-9 nav-col">
                        <nav class="navbar navbar-expand-lg navbar-light">

                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav">
                                    <li class="nav-item active">
                                        <a class="nav-link" href="../../index.php"> Back >
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container mb-4 mt-4">
        <h1 class="mb-4">Requests</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php

session_start();
$hospitalId = $_SESSION["userId"];

require_once "../databaseConnection.php";

$sql = "SELECT sample_id FROM available_blood WHERE hospital_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $hospitalId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$sampleIds = array();
while ($row = mysqli_fetch_assoc($result)) {
    $sampleIds[] = $row['sample_id'];
}

// Prepare SQL query to select all rows from requests table where sample_id matches any of the sample_ids
$sql = "SELECT * FROM requests WHERE sample_id IN (" . implode(',', array_fill(0, count($sampleIds), '?')) . ")";
$stmt = mysqli_prepare($conn, $sql);

// Create a string with a repeating character 'i' for each sample_id
$types = str_repeat('i', count($sampleIds));

// Bind parameters dynamically
mysqli_stmt_bind_param($stmt, $types, ...$sampleIds);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Blood Request</h5>
                <p class="card-text">Request ID: ' . $row["request_id"] . '</p>
                <p class="card-text">User ID: ' . $row["user_id"] . '</p>
                <p class="card-text">Sample ID: ' . $row["sample_id"] . '</p>
                <p class="card-text">Date of Expiry: ' . $row["date_of_request"] . '</p>
                <form method="post" action="../addRequest/deleteRequest.php">
                    <input type="hidden" name="request_id" value="' . $row["request_id"] . '"/>
                    <button type="submit" name="delete" class="btn btn-danger">Complete Request</button>
                </form>
            </div>
        </div>
    </div>';
    
    }
} else {
    echo '<div class="col">
    <div class="alert alert-info" role="alert">
        No available requests.
    </div>
  </div>';
}
    
        ?>
        </div>
    </div>

</body>

</html>