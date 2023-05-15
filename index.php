<?php
    session_start();
    if(!isset($_SESSION["UE"])){
        header("Location: login.php");
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/profile.css">
    <title>My proile</title>
</head>
<body>
    <header>
        <h2>InstaCatta</h2>
        <nav>
            <ul class="nav_icons">
                <li><a href="index.php"><span class="gg-home-alt"></span></a></li>
                <li><a href=""><span class="gg-search"></span></a></li>
                <li><a href=""><span class="gg-profile"></span></a></li>
                <li><a href=""><span class="gg-mail" style="--ggs: 1.4; margin-bottom: 5px;"></span></a></li>
                <li><a href="settings.php"><span class="gg-options" style="--ggs: 1.4; margin-bottom: 5px;"></span></a></li>
            </ul>
        </nav>
        <form>
            <input type="text" name="" class="search" id="" placeholder="search...">
        </form>
    </header>
    <div class="profile_box">
        <img src="public/img/profile.png" alt="">
        <?php
            require_once "private/include/database.php";
            $EU = $_SESSION["UE"];

            $sql = "SELECT * FROM users WHERE email = ? OR Username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $EU, $EU);
            $stmt->execute();

            $result = $stmt->get_result();

            $user = $result->fetch_assoc();

            echo '<div class="accEle"><p class="User">'.$user["Username"].'</p>';

            $sql = "SELECT * FROM accounts WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $user["id"]);
            $stmt->execute();

            $result = $stmt->get_result();

            $user = $result->fetch_assoc();
            
            echo '<div class="row"><p class="Numbers">Followers: '.$user["followers"].'</p>';
            echo '<p class="Numbers">Seguiti: '.$user["seguiti"].'</p></div>';
            echo '<label>descrizione:</label>';
            if($user["descrizione"]!=""){
                echo '<p class="Description">'.$user["descrizione"].'</p></div>';
            } else {
                echo '<p class="Description">Nulla di nuovo...</p></div>';
            }
        ?>
    </div>
</body>
</html>