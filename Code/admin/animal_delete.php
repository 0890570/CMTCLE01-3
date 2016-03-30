<?php require_once('../includes/template/admin/header.php');

$id = $_GET['id'];

$animal_select = mysqli_query($db, "SELECT * FROM `dier` WHERE `id` = '$id'");
$animal = mysqli_fetch_assoc($animal_select);

echo "<div class='title'><p>Diersoort verwijderen</p></div>";

if(isset($_POST['delete_animal'])) {

    // Verwijder beheerder na bevestiging, geef daarna een melding
    $delete_animal = mysqli_query($db, "DELETE FROM `dier` WHERE `id` = '$id'");
    if($delete_animal){
        echo "<div class='success'>Het betreffende dier is verwijderd.</div>";
        header("refresh:2; url='animal_overview.php");
    }else{
        echo "<div class='error'><b>Error:</b> Het is niet gelukt om het dier te verwijderen.</div>";
    }
}?>

    <form method="POST">
        <table class="user-table">
            <tr>
                <td>Naam:</td>
                <td><input type="text" name="naam" class="typeahead-alt" required readonly disabled value="<?= $animal['naam']?>"/></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="delete_animal" id="delete_animal" value="Diersoort verwijderen" class="login-button"/></td>
            </tr>
        </table>
    </form>

<?php require_once('../includes/template/admin/footer.php');?>