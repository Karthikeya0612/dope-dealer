<?php 
  include('../includes/base.php');
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include './dbconnect.php';
    
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
      $row = $result->fetch_assoc();
      if (password_verify($password, $row["password"])) {
        header("Location: ../index.php");
        exit(); // Make sure to exit to prevent further script execution
      } else {
        echo '<div class="alert alert-danger" role="alert">
        Incorrect password!
        </div>';
      }
    } else {
      echo '<div class="alert alert-danger" role="alert">
      User not found!
      </div>';
    }
    
    $stmt->close();
    $conn->close();
}
?>
<form method="POST" action="">
    <h1>Login</h1>
    <div class="mb-3">
        <input type="text" class="form-control" id="username" name="username" placeholder="Username">
    </div>
    <div class="mb-3">
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
    </div>
    <button type="submit" class="btn btn-outline-primary">Login</button>
</form>
</body>
</html>
