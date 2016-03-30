<?
session_start();
require('includes/template/header.php');

$ver = $_GET['ver'];

if(isset($_POST['wachtwoord'])) {

    // Haal alle gegevens op
    $ww = htmlspecialchars(mysqli_real_escape_string($db, $_POST['ww']));
    $wwh = htmlspecialchars(mysqli_real_escape_string($db, $_POST['wwh']));
    $wachtwoord1 = sha1(md5($ww));
    $wachtwoord2 = sha1(md5($wwh));

    // Is het wachtwoord gelijk aan het wachtwoord herhalen
    if ($wachtwoord1 == $wachtwoord2)
    {
        // Update het wachtwoord voor de betreffende gebruiker
        $update = mysqli_query($db, "UPDATE users SET `wachtwoord` = '$wachtwoord1', `herstelcode` = 'NULL' WHERE `herstelcode` = '$ver'");
        if($update){

            echo "<div class='success'>Het wachtwoord is succesvol aangepast.</div>";
        }
        else
        {
            echo "<div class='error'><b>Error:</b> Het is niet gelukt om het wachtwoord aan te passen!</div>";
        }
    }
    else
    {
        echo "<div class='error'><b>Error:</b> De opgegeven wachtwoord zijn niet gelijk!</div>";
    }
}

if(!empty($ver)){

    // Als in de link een verificatie code is meegestuurd, kijk of deze overeen komt
    $check = mysqli_query($db, "SELECT * FROM `users` WHERE `herstelcode` = '$ver' LIMIT 1");

    // Als er een rij is gevonden, laat formulier zien
    if ($updating = mysqli_fetch_assoc($check)){ ?>
        <div class="login-box">
            <div class="login-title">Wachtwoord veranderen</div><br>
            <form id="loginform" name="loginform" method="post" action="">
                <table cellpadding="5">
                    <tr><td>Nieuw wachtwoord:</td><td><input type="password" name="ww" id="ww" class="typeahead-alt" required /></td></tr>
                    <tr><td>Herhaal wachtwoord:</td><td><input type="password" name="wwh" id="wwh" class="typeahead-alt" required /></td></tr>
                    <tr><td colspan="2"><input type="submit" name="wachtwoord" id="wachtwoord" value="Verstuur" class="login-button"/></td></tr>
                </table>
            </form>
        </div>
        <?php

    }
}

// Als de gebruiker zijn e-mailadres heeft ingevoerd
elseif(isset($_POST['stap1'])){

    // Haal de gegevens op
    $email = mysqli_real_escape_string($db, $_POST['email']);

    // Als email leeg is, anders
    if(empty($email)){
        echo "<div class='error'><b>Error:</b> Het opgegeven e-mailadres is niet juist!</div>";
    }else{

        // Email check
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<div class='error'><b>Error:</b> Het opgegeven e-mailadres is niet juist!</div>";
        }else{
            $timestamp = time();
            $hash = sha1($timestamp);

            // Zet de herstelcode in de tabel voor de betreffende user
            $update = mysqli_query($db, "UPDATE `users` SET `herstelcode` = '$hash' WHERE `email` = '$email'");

            // Gelukt? Stuur een mail met verdere instructies
            if($update){
                $to = $email;
                $subject = "Interactieve kinderboerderij - Wachtwoord reset";
                $message = "Beste " . $naam . ",

Om uw nieuwe wachtwoord in te stellen, klik op de onderstaande link:
" . "\n http://project.cmi.hr.nl/2015_2016/password_reset.php?ver=".$hash."

Wilt u uw wachtwoord niet wijzigen, dan kunt u deze e-mail als niet verzonden beschouwen";

                $headers = "From: info@interactievekinderboerderij.nl";
                mail($to, $subject, $message, $headers);

                echo "<div class='success' style='margin-left:0px;'>Er is een e-mail verzonden voor de volgende instructies.</div>";
            } else {
                echo "<div class='success' style='margin-left:0px;'>Er is een fout opgetreden. Probeer het opnieuw.</div>";
            }


        }
    }
}else {
    ?>
    <div class="login-box">
        <div class="login-title">Wachtwoord vergeten</div>
        <br>

        <form id="loginform" name="loginform" method="post">
            <table cellpadding="5">
                <tr>
                    <td>E-mailadres:</td>
                    <td><input type="email" name="email" id="email" class="typeahead-alt" required/></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="stap1" id="stap1" value="Stuur mij een e-mail"class="login-button"/></td>
                </tr>
            </table>
        </form>
    </div>
    <?php
}
require('includes/template/footer.php');