<?php
include('../includes/base.php');

$show_alert = false;
$show_error=false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include './dbconnect.php';
    
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $exists = false;
    
    if (($password == $cpassword) && !$exists) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        
        try {
            if ($stmt->execute()) {
                $show_alert = true;
                header("Location: ./login.php");
                exit();
            }
        } catch (mysqli_sql_exception $e) {
            // Check if the error is due to duplicate entry
            if ($e->getCode() == 1062) { // MySQL error code for duplicate entry
                // Handle the error, e.g., inform the user that the username is taken
                echo '<div class="alert alert-danger" role="alert">
                Username is already taken.
                </div>';
            } else {
                // Handle other database-related errors
                echo '<div class="alert alert-danger" role="alert">
                '.$e->getMessage().'
                </div>' ;
            }
        }
        
        $stmt->close();
        $conn->close();
    }else{
        $show_error="Passwords do not match!";
}
}
?>


<?php
if ($show_alert) {
    echo '<div class="alert alert-success" role="alert">
    Your account has been created!
    </div>';
}
?>
<?php
if ($show_error) {
    echo '<div class="alert alert-danger" role="alert">
    '.$show_error.'
    </div>';
}
?>

<form method="POST" action="">
    <h1>Sign Up</h1>
    <div class="mb-3">
        <input type="text" class="form-control" name="username" id="username" placeholder="Username">
    </div>
    <div class="mb-3">
        <input type="email" class="form-control" name="email" id="email" placeholder="Email">
    </div>
    <div class="mb-3">
        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
    </div>
    <div class="mb-3">
        <input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="Confirm Password">
    </div>
    <button type="submit" class="btn btn-outline-primary">Sign Up</button>
</form>

