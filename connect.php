<?php
$servername = "localhost"; // Nazwa hosta
$username = "00956788_projekt"; // Nazwa użytkownika bazy danych
$password = "Projekt123@"; // Hasło użytkownika bazy danych
$dbname = "00956788_projekt"; // Nazwa bazy danych

// Tworzenie połączenia z bazą danych
$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdzanie połączenia
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
} else {
    echo "Połączono pomyślnie!";
}
?>