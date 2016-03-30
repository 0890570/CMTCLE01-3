<?php
require_once('../includes/template/admin/header.php');

if(isset($_POST['questions_add'])){
    $diersoort = mysqli_real_escape_string($db, $_POST['diersoort']);
    $vraag = mysqli_real_escape_string($db, $_POST['vraag']);
    $goed = mysqli_real_escape_string($db, $_POST['goed_antwoord']);
    $fout1 = mysqli_real_escape_string($db, $_POST['fout_antwoord1']);
    $fout2 = mysqli_real_escape_string($db, $_POST['fout_antwoord2']);

    if(empty($vraag) || empty($goed) || empty($fout1) || empty($fout2)){
        echo "<div class='error'><b>Error:</b> U dient elk veld in te vullen!</div>";

    }else {
        $insert_question = mysqli_query($db, "INSERT INTO `vragen` (`diersoort`, `vraag`, `correct_antwoord`, `fout_antwoord_1`, `fout_antwoord_2`) VALUES ('$diersoort', '$vraag', '$goed', '$fout1', '$fout2')");
        if ($insert_question) {
            echo "<div class='success'>De vraag is toegevoegd aan de database!</div>";
            header("refresh:2; url='questions_overview.php");
        }else{
            echo "<div class='error'><b>Error:</b> Het is niet gelukt om de vraag toe te voegen!</div>";
        }
    }
}

$get_animals = mysqli_query($db, "SELECT * FROM `dier` ORDER BY `id` ASC");

?>

    <form method="post">
        <table>
            <tr>
                <td>Diersoort</td>
                <td><select name="diersoort">
                        <?php
                        while($animal = mysqli_fetch_assoc($get_animals)){?>
                            <option name="diersoort" value="<?= $animal['id'];?>"><?= $animal['naam'];?></option>
                        <?php }
                        ?>
                </select></td>
            </tr>
            <tr>
                <td>Vraag</td>
                <td><input type="text" class='typeahead' required name="vraag" /></td>
            </tr>
            <tr>
                <td>Goed antwoord</td>
                <td><input type="text" class='typeahead' required name="goed_antwoord" /></td>
            </tr>
            <tr>
                <td>Fout antwoord 1</td>
                <td><input type="text" class='typeahead' required name="fout_antwoord1" /></td>
            </tr>
            <tr>
                <td>Fout antwoord 2</td>
                <td><input type="text" class='typeahead' required name="fout_antwoord2" /></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Vraag toevoegen" id="questions_add" name="questions_add" class="comfirm-button"></td>
            </tr>
        </table>
    </form>

<?php require_once('../includes/template/admin/footer.php');?>