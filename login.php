<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        

        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);
        

        $sql = "SELECT * FROM workers WHERE worker_login = '$username' AND worker_password = '$password'";
        $result = $conn->query($sql);
        
 
        if ($result->num_rows > 0) {
  
            header("Location: welcome.php");
            exit();
        } else {
        
            header("Location: index.html?error=1");
            exit();
        }
    } else {
   
        header("Location: index.html?error=2");
        exit();
    }
} else {
  
    header("Location: index.html");
    exit();
}

$conn->close();
?>
