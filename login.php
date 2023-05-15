<?php
    session_start();
    if(isset($_SESSION["UE"])){
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/registration.css">
    <link rel='stylesheet' href='https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css'>
    <title>Log-in</title>
</head>
<body>
    <?php
        if(isset($_POST["login"])){
            $EU = $_POST["E/U"];
            $Pass1 = $_POST["Password"];
            require_once "private/include/database.php";

            $sql = "SELECT * FROM users WHERE email = ? OR Username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $EU, $EU);
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if (password_verify($Pass1, $user["password"])) {
                    session_start();
                    $_SESSION["UE"] = $EU;
                    header("Location: index.php");
                    die();
                } else {
                    echo '<div class="alert alert-error">
                        <div class="icon__wrapper">
                        <span class="mdi mdi-alert-outline"></span>
                        </div>
                        <p>Incorrect password</p>
                        <span class="mdi mdi-open-in-new open"></span>
                        <span class="mdi mdi-close close" onclick="eliminaElemento(this)"></span>
                        </div>';
                }
            } else {
                echo '<div class="alert alert-error">
                        <div class="icon__wrapper">
                        <span class="mdi mdi-alert-outline"></span>
                        </div>
                        <p>Username or Email doesn\'t exist</p>
                        <span class="mdi mdi-open-in-new open"></span>
                        <span class="mdi mdi-close close" onclick="eliminaElemento(this)"></span>
                        </div>';
            }
        }
    ?>
    <form  action="login.php" method="post">
        <input type="text" name="E/U" placeholder="Email/Username">
        <input type="password" name="Password" placeholder="Password" id="Password">
        <button type="submit" name="login">LOG IN</button>
        <a href="registration.php">You don't have an account? Sign up</a>
    </form>
    <script>
        function eliminaElemento(elemento) {
            // Ottenere il genitore dell'elemento (div.element)
            var genitore = elemento.parentNode;

            // Rimuovere l'elemento cliccato dal genitore
            genitore.parentNode.removeChild(genitore);
        }
    </script>
</body>
</html>