<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/login_register.css">
</head>

<body>
    <div class="container">

        <?php

    if(isset($_POST["submit"])){

        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirmpassword = $_POST["confirmpassword"];
        $usertype = $_POST["userType"];
        $bloodgroup = $_POST["bloodGroup"];

        $passwordhash = password_hash($password, PASSWORD_DEFAULT);

        $errors = array();
        if(empty($name) OR empty($email) OR empty($password) OR empty($confirmpassword)){
            array_push($errors,"All fields are required");
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            array_push($errors, "Email is not valid");
        }
        if(strlen($password)<8){
            array_push($errors, "Password must be at least 8 characters or more");
        }
        if($password != $confirmpassword){
            array_push($errors, "Password does not match.");
        }
        if($usertype === "receiver" && empty($bloodgroup)){
            array_push($errors, "Please select a blood type.");
        }

        require_once "../databaseConnection.php";
        $sql = "SELECT * FROM users_login WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        $rowCount = mysqli_num_rows($result);
        if($rowCount > 0){
            array_push($errors,"Email already Exists.");
        }

        if(count($errors) > 0){
            foreach($errors as $error){
                echo "<div class='alert alert-danger'>$error</div>";
            }
        }
        else{
            $sql = "INSERT INTO users_login (name, email, password, user_type, blood_group) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            $preparestmt = mysqli_stmt_prepare($stmt,$sql);
            if($preparestmt){
                mysqli_stmt_bind_param($stmt,"sssss",$name,$email,$passwordhash, $usertype, $bloodgroup);
                mysqli_stmt_execute($stmt);

                // getting id
                $sql2 = "SELECT * FROM users_login WHERE email='$email'";
                $result2 = mysqli_query($conn, $sql2);
                $user2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);

                session_start();
                $_SESSION['username'] = $name;
                $_SESSION['userType'] = $usertype;
                $_SESSION['userId'] = $user2['user_id'];

                header("Location: ../../index.php");
                die();
                
            }else{
                die("soming went wrong");
            }
        }

    }

    ?>

    <div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="registration-container">
            <h2 class="text-center mb-4">Registration</h2>
            <form action="registration.php" method="post">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label for="confirmpassword">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" required>
                </div>
                <div class="form-group">
                    <label for="userType">User Type</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="userType" id="hospitalRadio" value="hospital" required>
                        <label class="form-check-label" for="hospitalRadio">Hospital</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="userType" id="receiverRadio" value="receiver" checked required>
                        <label class="form-check-label" for="receiverRadio">Blood Receiver</label>
                    </div>
                </div>
                <div class="form-group" id="bloodTypeField">
                    <label for="bloodGroup">Blood Group</label>
                    <select class="form-control" name="bloodGroup" id="bloodGroup">
                        <option value="">Select Blood Group</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block" name="submit">Register</button>
            </form>
        </div>
    </div>
</div>

    </div>

    <script src="../js/registration.js"></script>
</body>

</html>