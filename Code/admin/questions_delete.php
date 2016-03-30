<?php require_once('../includes/template/admin/header.php');

$id = $_GET['id'];

$question_select = mysqli_query($db, "SELECT * FROM `vragen` WHERE `id` = '$id'");
$question = mysqli_fetch_assoc($question_select);

echo "<div class='title'><p>Vraag verwijderen</p></div>";

if(isset($_POST['delete_question'])) {

    // Verwijder beheerder na bevestiging, geef daarna een melding
    $delete_question = mysqli_query($db, "DELETE FROM `vragen` WHERE `id` = '$id'");
    if($delete_question){
        echo "<div class='success'>Het betreffende vraag is verwijderd.</div>";
        header("refresh:2; url='questions_overview.php");
    }else{
        echo "<div class='error'><b>Error:</b> Het is niet gelukt om de vraag te verwijderen.</div>";
    }
}?>

    <form method="POST">
        <table class="user-table">
            <tr>
                <td>Vraag:</td>
                <td><input type="text" name="vraag" class="typeahead-alt" required readonly disabled value="<?= $question['vraag']?>"/></td>
            </tr>
            <tr>
                <td>Correct antwoord:</td>
                <td><input type="text" name="goed" class="typeahead-alt" required readonly disabled value="<?= $question['correct_antwoord']?>"/></td>
            </tr>
            <tr>
                <td>Fout antwoord 1:</td>
                <td><input type="text" name="fout1" class="typeahead-alt" required readonly disabled value="<?= $question['fout_antwoord_1']?>"/></td>
            </tr>
            <tr>
                <td>Fout antwoord 2:</td>
                <td><input type="text" name="fout2" class="typeahead-alt" required readonly disabled value="<?= $question['fout_antwoord_2']?>"/></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="delete_question" id="delete_question" value="Vraag verwijderen" class="login-button"/></td>
            </tr>
        </table>
    </form>

<?php require_once('../includes/template/admin/footer.php');?>