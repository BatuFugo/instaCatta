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
    <title>Registration</title>
    <link rel="stylesheet" href="public/css/registration.css">
    <link rel='stylesheet' href='https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css'>
</head>
<body>
    <?php
        if(isset($_POST["signup"])){
            $Name = $_POST["FName"];
            $Surname = $_POST["SName"];
            $Username = $_POST["UName"];
            $Email = $_POST["Email"];
            $Pass = $_POST["Password"];
            $ConPass = $_POST["ConfirmPassword"];

            $error = array();

            if(empty($Name) OR empty($Surname) OR empty($Email) OR empty($Pass) OR empty($ConPass)){
                array_push($error,"All fields are requireed");
            }

            if(!filter_var($Email, FILTER_VALIDATE_EMAIL)){
                array_push($error, "Email is not valid");
            }

            if(strlen($Pass)<8){
                array_push($error, "Password must be 8 caracters long");
            }

            if($Pass!==$ConPass){
                array_push($error, "Password does not match");
            }

            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $Pass)) {
                array_push($error, "Password must be have uppercase, lowercase and a number caracter");
            }

            require_once "private/include/database.php";

            $Check_E = "SELECT * FROM users WHERE email = '$Email'";
            $Check_U = "SELECT * FROM users WHERE email = '$Email'";

            $result = mysqli_query($conn, $Check_E);
            if(mysqli_num_rows($result)>0){
                array_push($error, "The Email is already used");
            }

            $result = mysqli_query($conn, $Check_U);
            if(mysqli_num_rows($result)>0){
                array_push($error, "The Username is already used");
            }

            if(count($error)>0){
                foreach($error as $err){
                    echo '<div class="alert alert-error">
                        <div class="icon__wrapper">
                        <span class="mdi mdi-alert-outline"></span>
                        </div>
                        <p>'.$err.'</p>
                        <span class="mdi mdi-open-in-new open"></span>
                        <span class="mdi mdi-close close" onclick="eliminaElemento(this)"></span>
                        </div>'
                    ;
                }
            } else {
                $passHash = password_hash($Pass, PASSWORD_DEFAULT);

                $num_rows = "SELECT * FROM users";
                $num = mysqli_query($conn, $num_rows);
                $N = mysqli_num_rows($num);
                    
                $sql = "INSERT INTO users (Name, Surname, Username, Email, password) VALUES (?, ?, ?, ?, ?)";
                $sql1 = "INSERT INTO accounts (id, descrizione, followers, seguiti) VALUES (" . ($N+1) . ", '', 0, 0)";
                $sql2 = "INSERT INTO 'foto profilo' (id) VALUES (" . ($N+1) . ")";


                $stmt = mysqli_stmt_init($conn);

                $prepare_stmt = mysqli_stmt_prepare($stmt,$sql);

                if($prepare_stmt){
                    mysqli_stmt_bind_param($stmt,"sssss",$Name,$Surname,$Username,$Email,$passHash);
                    mysqli_stmt_execute($stmt);
                    $conn->query($sql1);
                    print_r($sql2);
                    $conn->query($sql2);
                    session_start();
                    $_SESSION["UE"] = $Username;
                    header("Location: index.php");
                    die();
                } else {
                    echo '<div class="alert alert-error">
                        <div class="icon__wrapper">
                        <span class="mdi mdi-alert-outline"></span>
                        </div>
                        <p>Somethin oes wrong</p>
                        <span class="mdi mdi-open-in-new open"></span>
                        <span class="mdi mdi-close close" onclick="eliminaElemento(this)"></span>
                        </div>'
                    ;
                }
            }
        }
    ?>
    <div class="box">
        <form action="registration.php" method="post">
            <div class="title">Sign up</div>
            <input type="text" name="FName" placeholder="Name...">
            <input type="text" name="SName" placeholder="Surname...">
            <input type="text" name="UName" placeholder="Username...">
            <input type="text" name="Email" placeholder="Email...">
            <input type="password" name="Password" placeholder="Password" id="Password">
            <input type="password" name="ConfirmPassword" placeholder="Confirm password">
            <button type="sumbit" name="signup">SIGN UP</button>
            <a href="login.php">You already have an account? Log in</a>
        </form>
    </div>
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