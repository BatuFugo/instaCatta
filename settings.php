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
    <title>Settings</title>
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
    <?php
        if(isset($_POST["logout"])){
            echo '<form action="settings.php" method="post" class="btn_cont">
            <p>Are you sure?</p>
            <button type="submit" name="logoutYes">YES</button>
            <button type="submit" name="logoutNo">NO</button>
            </form></div>';
        } elseif(isset($_POST["logoutYes"])){
            header("Location: logout.php");
        } else if(isset($_POST["modPro"])){
            echo '<div><form action="settings.php" method="post" class="modBox">
            <p>foto profilo:</p>
            <label for="images" class="drop-container">
            <input type="file" id="images" accept="image/*">
            </label>
            <p>descrizione:</p>
            <input type="text" class="desc" maxlength="255">
            <button type="submit" name="finMode">Modifica</button>
            <form action="settings.php" method="post">
            <button type="submit" name="">Annulla</button>
            </form>
            </form>
            </div>';
        } else if(isset($_POST["finMode"])){
            echo '<form action="settings.php" method="post" class="btn_cont">
            <p>Are you sure?</p>
            <button type="submit" name="logoutYes">YES</button>
            <button type="submit" name="modPro">NO</button>
            </form></div>';
        } else {
            echo '<form action="settings.php" class="btn_cont" method="post">
            <button type="submit" name="modPro">Modifica profilo</button>
            <button type="submit" name=""></button>
            <button type="submit" name=""></button>
            <button type="submit" name=""></button>
            <button type="submit" name=""></button>
            <button type="submit" name="logout">Log out</button>
            </form>';
        }
    ?>
</body>
</html>