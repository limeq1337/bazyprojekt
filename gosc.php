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
                <h1 id="maintext2">Hotel Trivago</h1>
                <h3 id="secondtext">Wyszukiwarka pobytów</h3>

                <div id="formsearch">
                    <form method="GET" id="searchForm">
                        <div class="form-group">
                            <label for="stayPeriod">Okres:</label>
                            <input type="date" name="stayPeriod" id="stayPeriod" class="form-control m-auto" style="width: 200px;">
                        </div>
                        <div class="form-group text-center">
                            <label for="location">Lokalizacja:</label>
                            <select name="location" id="location" class="form-control m-auto" style="width: 200px;">
                                <option value="">Wybierz lokalizację</option>
                                <?php
                                // Połączenie z bazą danych
                                $servername = "localhost"; 
                                $username = "srv64140_bazy"; 
                                $password = "Jv54ZBp2VCjad9HJET7v"; 
                                $dbname = "srv64140_bazy"; 

                                // Tworzenie połączenia
                                $conn = new mysqli($servername, $username, $password, $dbname);

                                // Sprawdzanie połączenia
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // Zapytanie SQL
                                $sql = "SELECT DISTINCT location FROM available_stays";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row["location"] . '">' . $row["location"] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group text-center">
                            <label for="feedingOption">Opcja Wyżywienia:</label>
                            <select name="feedingOption" id="feedingOption" class="form-control m-auto" style="width: 200px;">
                                <option value="">Wybierz opcję</option>
                                <option value="1">Tak</option>
                                <option value="0">Nie</option>
                            </select>
                        </div>
                        <div class="form-group inputy">
                            <label for="roomType">Rodzaj Pokoju:</label>
                            <select name="roomType" id="roomType" class="form-control m-auto" style="width: 200px;">
                                <option value="">Wybierz rodzaj</option>
                                <?php
                                $sql = "SELECT DISTINCT roomType FROM available_stays";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row["roomType"] . '">' . $row["roomType"] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group inputy">
                            <label for="standard">Standard:</label>
                            <select name="standard" id="standard" class="form-control m-auto" style="width: 200px;">
                                <option value="">Wybierz standard</option>
                                <?php
                                $sql = "SELECT DISTINCT standard FROM available_stays";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row["standard"] . '">' . $row["standard"] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="workerbut text-center btn search">Szukaj</button>
                    </form>
                </div>

                <div id="available_stays" class="row mt-4">
                <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET)) {
        $stayPeriod = isset($_GET['stayPeriod']) ? $_GET['stayPeriod'] : '';
        $location = isset($_GET['location']) ? $_GET['location'] : '';
        $feedingOption = isset($_GET['feedingOption']) ? $_GET['feedingOption'] : '';
        $roomType = isset($_GET['roomType']) ? $_GET['roomType'] : '';
        $standard = isset($_GET['standard']) ? $_GET['standard'] : '';

        $sql = "SELECT stayId, stayPeriod, location, feedingOption, roomType, standard, img, hotelName FROM available_stays WHERE 1=1";

        if (!empty($stayPeriod)) {
            $sql .= " AND stayPeriod = '$stayPeriod'";
        }
        if (!empty($location)) {
            $sql .= " AND location = '$location'";
        }
        if ($feedingOption !== '') {
            $sql .= " AND feedingOption = '$feedingOption'";
        }
        if (!empty($roomType)) {
            $sql .= " AND roomType = '$roomType'";
        }
        if (!empty($standard)) {
            $sql .= " AND standard = '$standard'";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="col mb-3 pob">';
                echo '<div class="card" style="width: 18rem;">';
                if (!empty($row["img"])) {
                    echo '<img src="' . $row["img"] . '" class="card-img-top" alt="Hotel Image">';
                }
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $row["hotelName"] . '</h5>';
                echo '<p class="card-text">ID Pobytu: ' . $row["stayId"] . '</p>';
                echo '<p class="card-text">Okres: ' . $row["stayPeriod"] . '</p>';
                echo '<p class="card-text">Lokalizacja: ' . $row["location"] . '</p>';
                echo '<p class="card-text">Opcja Wyżywienia: ' . ($row["feedingOption"] ? 'Tak' : 'Nie') . '</p>';
                echo '<p class="card-text">Rodzaj Pokoju: ' . $row["roomType"] . '</p>';
                echo '<p class="card-text">Standard: ' . $row["standard"] . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '<script>document.getElementById("available_stays").style.display = "flex";</script>';
        } else {
            echo "Brak dostępnych pobytów.";
        }
    }

    $conn->close();
    ?>
                </div>
      
    

                <br><a href="index.php"><button class="workerbut text-center btn search">Wróć do początku</button></a>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
