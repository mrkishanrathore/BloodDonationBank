<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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

    <div class="container">
    
        <h2 class="mt-5 mb-3">User Requests</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Request ID</th>
                        <th>Sample ID</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
if(isset($_POST["update"])){
    $sample_id = $_POST["sample_id"];
    
    session_start();
    $userId = $_SESSION["userId"];
    $userName = $_SESSION["username"];
    
    require_once "../databaseConnection.php";

    $sql = "SELECT COUNT(*) AS count FROM requests WHERE user_id = ? AND sample_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $userId, $sample_id); // Assuming both user_id and sample_id are integers, use "i" for integer
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

// Check if the combination already exists
if ($row['count'] < 0) {

    $sql = "INSERT INTO requests (user_id,sample_id) VALUES (?, ?)";
    $stmt = mysqli_stmt_init($conn);
    $preparestmt = mysqli_stmt_prepare($stmt,$sql);
    if($preparestmt){
        mysqli_stmt_bind_param($stmt,"ss",$userId,$sample_id);
        mysqli_stmt_execute($stmt);

        // getting id
        $sql2 = "SELECT * FROM requests WHERE user_id='$userId'";
        $result2 = mysqli_query($conn, $sql2);
        $user2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);

        echo '
                    <tr>
                        <td>'.$userId.'</td>
                        <td>'.$userName.'</td>
                        <td>'.$user2['request_id'].'</td>
                        <td>'.$sample_id.'</td>
                    </tr>
                
        ';

        echo '<div class="alert alert-success mt-5" role="alert">Request added successfully!</div>';
    }else{
        die("soming went wrong");
    }
}else{
    echo '<div class="alert alert-warning mt-5" role="alert"> Request is already present!</div>';
}

}
?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container">
        <a href="../../index.php" class="btn btn-danger">Back to Home</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>