<?php require_once('../includes/template/admin/header.php');

$id = $_GET['id'];
$question = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `vragen` WHERE `id` = '$id'"));

if(isset($_POST['question_edit'])){

    // Haal alle gegevens op
    $vraag = htmlspecialchars(mysqli_real_escape_string($db, $_POST['vraag']));
    $goed = htmlspecialchars(mysqli_real_escape_string($db, $_POST['goed']));
    $fout1 = htmlspecialchars(mysqli_real_escape_string($db, $_POST['fout1']));
    $fout2 = htmlspecialchars(mysqli_real_escape_string($db, $_POST['fout2']));

    // Controleer of een veld leeg is
    if(empty($vraag) || empty($goed) || empty($fout1) || empty($fout2)){
        echo "<div class='error'><b>Error:</b> U dient elk veld in te voeren!</div>";
    }else{
        // Update gegevens van de betreffende persoon
        $update_question = mysqli_query($db, "UPDATE `vragen` SET `diersoort` = $id, `vraag` = '$vraag', `correct_antwoord` = '$goed', `fout_antwoord_1` = '$fout1', `fout_antwoord_2` = '$fout2' WHERE `id` = $id");
        if ($update_question) {
            echo "<div class='success'>De vraag met antwoorden aangepast.</div>";
            header("refresh:2; url='questions_overview.php");
        } else {
            echo "<div class='error'><b>Error:</b> Het is niet gelukt om de vraag en antwoorden aan te passen.</div>";
        }
    }
}

?>
    <div class="title"><p>Vraag wijzigen</p></div>
    <form method="POST">
        <table class="user-table">
            <tr>
                <td>Vraag:</td>
                <td><input type="text" name="vraag" class="typeahead-alt" required value="<?= $question['vraag'];?>"/></td>
            </tr>
            <tr>
                <td>Correct antwoord:</td>
                <td><input type="text" name="goed" class="typeahead-alt" required value="<?= $question['correct_antwoord'];?>"/></td>
            </tr>
            <tr>
                <td>Fout antwoord 1:</td>
                <td><input type="text" name="fout1" class="typeahead-alt" required value="<?= $question['fout_antwoord_1'];?>"/></td>
            </tr>
            <tr>
                <td>Fout antwoord 2:</td>
                <td><input type="text" name="fout2" class="typeahead-alt" required value="<?= $question['fout_antwoord_2'];?>"/></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="question_edit" id="question_edit" value="Vraag aanpassen" class="login-button"/></td>
            </tr>
        </table>
    </form>

<?
require_once('../includes/template/admin/footer.php');
?>