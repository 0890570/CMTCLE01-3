<?php
require_once('../includes/template/admin/header.php');

if(isset($_POST['animal_add'])){
    $diernaam = mysqli_real_escape_string($db, $_POST['naam']);

    if(empty($diernaam)){
        echo "<div class='error'><b>Error:</b> Het veld moet worden ingevuld!</div>";

    }else {
        $insert_animal = mysqli_query($db, "INSERT INTO `dier` (`naam`) VALUES ('$diernaam')");
        if ($insert_animal) {
            echo "<div class='success'>Het dier is toegevoegd aan de database!</div>";
            header("refresh:2; url='animal_overview.php");
        }else{
            echo "<div class='error'><b>Error:</b> Het is niet gelukt om het dier toe te voegen!</div>";
        }
    }
}
?>

    <form method="post">
        <table>
            <tr>
                <td>Naam</td>
                <td><input type="text" class='typeahead' required name="naam" /></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Diersoort toevoegen" id="animal_add" name="animal_add" class="comfirm-button"></td>
            </tr>
        </table>
    </form>

<?php require_once('../includes/template/admin/footer.php');?>