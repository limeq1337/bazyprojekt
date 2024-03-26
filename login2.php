<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['login']) && !empty($_POST['pass'])) {
        $login = $_POST['login'];
        $pass = $_POST['pass'];
        
        // Zabezpieczamy dane przed atakami SQL injection
        $login = mysqli_real_escape_string($conn, $login);
        $pass = mysqli_real_escape_string($conn, $pass);
        
        // Zapytanie do bazy danych w celu sprawdzenia danych logowania
        $sql = "SELECT * FROM workers WHERE worker_login = '$login' AND worker_password = '$pass'";
        $result = $conn->query($sql);
        
        // Sprawdzenie, czy wynik zapytania zawiera co najmniej jeden rekord
        if ($result->num_rows > 0) {
            // Dane logowania są poprawne, przekierowanie na stronę powitalną
            header("Location: welcome.php");
            exit();
        } else {
            // Dane logowania są niepoprawne, przekierowanie z powrotem do formularza logowania z odpowiednim komunikatem błędu
            header("Location: index.php?error=1");
            exit();
        }
    } else {
        // Przekierowanie z powrotem do formularza logowania z odpowiednim komunikatem błędu
        header("Location: index.php?error=2");
        exit();
    }
} else {
    // Przekierowanie na stronę logowania
    header("Location: index.php");
    exit();
}

$conn->close();
?>
