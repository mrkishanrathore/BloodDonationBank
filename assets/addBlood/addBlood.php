<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Blood Sample</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/login_register.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    
    <div class="container">

        <?php
    if(isset($_POST["submit"])){
        $bloodtype = $_POST['bloodType'];
        $quantity = $_POST['quantity'];
        $expirydate = $_POST['expiryDate'];

        // update later
        session_start();
        $hospitalid = $_SESSION["userId"];;

        $errors = array();
        if(empty($bloodtype) OR empty($quantity) OR empty($expirydate)){
            array_push($errors,"All fields are required");
        }
        
        require_once "../databaseConnection.php";

        if(count($errors) > 0){
            foreach($errors as $error){
                echo "<div class='alert alert-danger'>$error</div>";
            }
        }else{

            $sql = "INSERT INTO available_blood (hospital_id, blood_type, quantity, expire_date) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            $preparestmt = mysqli_stmt_prepare($stmt,$sql);
            if($preparestmt){
                mysqli_stmt_bind_param($stmt,"isis",$hospitalid,$bloodtype,$quantity,$expirydate);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>You have added blood sample successfully</div>";
            }else{
                die("soming went wrong");
            }
        }

    }

    ?>

        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="add-blood-container">
                    <h2 class="text-center mb-4">Add Blood Sample</h2>
                    <form action="addBlood.php" method="post">
                        <!-- Specify the PHP file to process form data -->
                        <div class="form-group">
                            <label for="bloodType">Blood Type</label>
                            <select class="form-control" id="bloodType" name="bloodType" required>
                                <!-- Add name attribute -->
                                <option value="">Select Blood Type</option>
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
                        <div class="form-group">
                            <label for="quantity">Quantity (in milliliters)</label>
                            <input type="number" class="form-control" id="quantity" name="quantity"
                                placeholder="Enter quantity" required step="100" min="0"> <!-- Add name attribute -->
                        </div>
                        <div class="form-group">
                            <label for="expiryDate">Expiry Date</label>
                            <input type="date" class="form-control" id="expiryDate" name="expiryDate" required>
                            <!-- Add name attribute -->
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" name="submit">Add sample</button>
                    </form>
                </div>
            </div>
        </div>

    </div>


</body>

</html>