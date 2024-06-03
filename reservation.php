<?php
$servername = "localhost";
$username = "srv64140_bazy";
$password = "Jv54ZBp2VCjad9HJET7v";
$dbname = "srv64140_bazy";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start(); 


if (!isset($_SESSION['guestLogin'])) {

    header("Location: index.php");
    exit();
}


$guestLogin = $_SESSION['guestLogin'];


$sqlFetchUser = "SELECT guestId, name, lastName FROM guest WHERE guestLogin = '$guestLogin'";
$result = $conn->query($sqlFetchUser);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $guestId = $user['guestId'];
    $guestName = $user['name'];
    $guestLastName = $user['lastName'];
} else {
    echo "Błąd: Nie można znaleźć danych użytkownika.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stayId = $_POST['stayId'];
    $stayPeriod = $_POST['stayPeriod'];
    $location = $_POST['location'];
    $feedingOption = $_POST['feedingOption'];
    $roomType = $_POST['roomType'];
    $standard = $_POST['standard'];
    $hotelName = $_POST['hotelName'];

    $roomNumber = 101; 
    $date = date('Y-m-d'); 
    $price = 100; 

  
    $result = $conn->query("SELECT roomNumber FROM rooms WHERE roomNumber = '$roomNumber'");
    if ($result->num_rows == 0) {

        $sqlRoom = "INSERT INTO rooms (roomNumber, guestLimit, standard, isAvailable)
                    VALUES ('$roomNumber', '2', '$standard', '1')";
        $conn->query($sqlRoom);
    }

 
    $result = $conn->query("SELECT MAX(reservationId) AS maxReservationId FROM reservation");
    $row = $result->fetch_assoc();
    $newReservationId = $row['maxReservationId'] + 1;

 
    $sqlReservation = "INSERT INTO reservation (reservationId, guestId, guestLogin, name, lastName, roomNumber, date, price, feedingOption, stayId, stayPeriod, location, roomType, standard, hotelName)
                       VALUES ('$newReservationId', '$guestId', '$guestLogin', '$guestName', '$guestLastName', '$roomNumber', '$date', '$price', '$feedingOption', '$stayId', '$stayPeriod', '$location', '$roomType', '$standard', '$hotelName')";

    if ($conn->query($sqlReservation) === TRUE) {
        echo '<h1 id="maintext2">Rezerwacja zakończona sukcesem!</h1>';
        
     
        $sqlFetchReservation = "SELECT * FROM reservation WHERE reservationId = '$newReservationId'";
        $result = $conn->query($sqlFetchReservation);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<h2>Informacje o rezerwacji:</h2>";
                echo "<p>Reservation ID: " . $row["reservationId"]. "</p>";
                echo "<p>Guest ID: " . $row["guestId"]. "</p>";
                echo "<p>Guest Login: " . $row["guestLogin"]. "</p>";
                echo "<p>Guest Name: " . $row["name"]. "</p>";
                echo "<p>Guest Lastname: " . $row["lastName"]. "</p>";
                echo "<p>Room Number: " . $row["roomNumber"]. "</p>";
                echo "<p>Date: " . $row["date"]. "</p>";
                echo "<p>Price: " . $row["price"]. "</p>";
                echo "<p>Feeding Option: " . $row["feedingOption"]. "</p>";
                echo "<p>Stay ID: " . $row["stayId"]. "</p>";
                echo "<p>Stay Period: " . $row["stayPeriod"]. "</p>";
                echo "<p>Location: " . $row["location"]. "</p>";
                echo "<p>Room Type: " . $row["roomType"]. "</p>";
                echo "<p>Standard: " . $row["standard"]. "</p>";
                echo "<p>Hotel Name: " . $row["hotelName"]. "</p>";
            }
        } else {
            echo "Brak informacji o rezerwacji.";
        }
    } else {
        echo "Błąd: " . $sqlReservation . "<br>" . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Nazwa</title>
</head>
<body>
<div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col" id="trivago">
              

      

      
    

                <br><a href="index.php"><button class="workerbut text-center btn search">Wróć do początku</button></a>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
