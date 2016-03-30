<?
session_start();
require_once('includes/template/header.php');

//Als er op de knop inloggen wordt gedrukt
if (isset($_POST['inloggen']))
{
    // Haal alle gegevens op
    $email = htmlspecialchars(mysqli_real_escape_string($db, $_POST['email']));
    $ww	 = htmlspecialchars(mysqli_real_escape_string($db, $_POST['ww']));
    $wachtwoord = sha1(md5($ww));

    // Haal de gebruiker op
    $inlogQuery = mysqli_query($db, "SELECT * FROM `users` WHERE `email` = '$email' AND `wachtwoord` = '$wachtwoord' LIMIT 1");

    //Als de opgegeven gegevens herkend worden worden de sessies aangemaakt
    if ($inloggen = mysqli_fetch_assoc($inlogQuery))
    {

        // Is het account geactiveerd (wordt NIET gebruikt)? Zo ja, maak een sessie aan
        if ($inloggen['activated'] == "0")
        {
            echo "<div class='error'>Uw account is nog niet geactiveerd!</div>";
        }
        else
        {
            $_SESSION['username'] = $email;
            setcookie("Interactieve kinderboerderij", $email, time() + (86400 * 30), "/"); // 86400 = 1 day
            header("Location: admin/index.php");
        }
    }
    else
    {
        echo "<div class='error''><b>Oops:</b> Het ingevulde e-mailadres of wachtwoord is onjuist!</div>";
    }
}

?>
    <div class="login-box">
        <form id="loginform" name="loginform" method="post">
            <table cellpadding="5">
                <tr><td><input type="text" name="email" id="email" class="typeahead-alt" placeholder="E-mailadres" required /></td></tr>
                <tr><td><input type="password" name="ww" id="ww" class="typeahead-alt" placeholder="Wachtwoord" required /></td></tr>
                <tr><td><input type="submit" name="inloggen" id="inloggen" value="Inloggen" class="login-buttons"/></td></tr>
            </table>
        </form>
        <!--<div class='password_reset'><a href='password_reset.php'>Wachtwoord vergeten</a></div>-->
    </div>

<?php
require_once('includes/template/footer.php');
?>