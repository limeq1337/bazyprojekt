<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Nazwa</title>
</head>
<body>
   
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Login
                    </div>
                    <div class="card-body">
                        <?php
                  
                        if(isset($_GET['error'])) {
                            $error = $_GET['error'];
                            if($error == 1) {
                                echo '<div class="alert alert-danger" role="alert">Nieprawidłowa nazwa użytkownika lub hasło.</div>';
                            } elseif($error == 2) {
                                echo '<div class="alert alert-danger" role="alert">Wprowadź nazwę użytkownika i hasło.</div>';
                            }
                        }
                        ?>
                        <form method="POST" action="login2.php">
                            <div class="form-group">
                                <label for="username">Nazwa użytkownika:</label>
                                <input type="text" class="form-control" id="login" name="login" placeholder="Wprowadź nazwę użytkownika">
                            </div>
                            <div class="form-group">
                                <label for="password">Hasło:</label>
                                <input type="password" class="form-control" id="pass" name="pass" placeholder="Wprowadź hasło">
                            </div>
                            <button type="submit" class="btn btn-primary">Zaloguj</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
