<?php require_once('../includes/template/admin/header.php');

$id = $_GET['id'];
$animal = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `dier` WHERE `id` = '$id'"));

if(isset($_POST['animal_edit'])){

    // Haal alle gegevens op
    $diernaam = htmlspecialchars(mysqli_real_escape_string($db, $_POST['naam']));

    // Controleer of een veld leeg is
    if(empty($diernaam)){
        echo "<div class='error'><b>Error:</b> U dient elk veld in te voeren!</div>";
    }else{
        // Update gegevens van de betreffende persoon
        $update_animal = mysqli_query($db, "UPDATE `dier` SET `naam` = '$diernaam' WHERE `id` = '$id'");
        if ($update_animal) {
            echo "<div class='success'>De gegevens zijn aangepast.</div>";
            header("refresh:2; url='animal_overview.php");
        } else {
            echo "<div class='error'><b>Error:</b> Het is niet gelukt om de gegevens aan te passen.</div>";
        }
    }
}


?>
    <div class="title"><p>Diersoort wijzigen</p></div>
    <form method="POST">
        <table class="user-table">
            <tr>
                <td>Naam:</td>
                <td><input type="text" name="naam" class="typeahead-alt" required value="<?= $animal['naam'];?>"/></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="animal_edit" id="animal_edit" value="Diersoort aanpassen" class="login-button"/></td>
            </tr>
        </table>
    </form>

<?
require_once('../includes/template/admin/footer.php');
?>