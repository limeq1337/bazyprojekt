<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // Zabezpieczamy dane przed atakami SQL injection
        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);
        
        // Zapytanie do bazy danych w celu sprawdzenia danych logowania
        $sql = "SELECT * FROM workers WHERE worker_login = '$username' AND worker_password = '$password'";
        $result = $conn->query($sql);
        
        // Sprawdzenie, czy wynik zapytania zawiera co najmniej jeden rekord
        if ($result->num_rows > 0) {
            // Dane logowania są poprawne, przekierowanie na stronę powitalną
            header("Location: welcome.php");
            exit();
        } else {
            // Dane logowania są niepoprawne, przekierowanie z powrotem do formularza logowania z odpowiednim komunikatem błędu
            header("Location: index.html?error=1");
            exit();
        }
    } else {
        // Przekierowanie z powrotem do formularza logowania z odpowiednim komunikatem błędu
        header("Location: index.html?error=2");
        exit();
    }
} else {
    // Przekierowanie na stronę logowania
    header("Location: index.html");
    exit();
}

$conn->close();
?>
