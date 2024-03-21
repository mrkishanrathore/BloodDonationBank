<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/login_register.css">
</head>
<body>
    <div class="container">

    <?php

    if(isset($_POST["submit"])){
        $email = $_POST["email"];
        $inputpassword = $_POST["password"];

        require_once "../databaseConnection.php";
        $sql = "SELECT * FROM users_login WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if($user){
           
            if(password_verify($inputpassword, $user['password'])) {
                session_start();
                $_SESSION['username'] = $user["name"];
                $_SESSION['userType'] = $user["user_type"];
                $_SESSION['userId'] = $user["user_id"];

                header("Location: ../../index.php");
                die();
            }else{
                echo "<div class='alert alert-danger'>Password does not match.</div>";
            }
        }else{
            echo "<div class='alert alert-danger'>Email does not exist.</div>";
        }
        
    }
    ?>

    <div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
    <div class="login-container">
    <h2 class="text-center mb-4">Login</h2>
    <form action="login.php" method="post">
        <div class="form-group"> 
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block" name="submit">Login</button>
    </form>
    <div class="text-center mt-3">
        <p>Don't have an account? <a href="../registration/registration.php">Sign up here</a></p>
    </div>
</div>

    </div>
</div>

    </div>

</body>
</html>

