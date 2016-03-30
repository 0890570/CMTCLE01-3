<?php
require_once('../includes/template/admin/header.php'); ?>

    <a href="questions_add.php">Voeg een nieuwe vraag toe</a>
<?php

// Haal beheerders op, hoofdbeheerder kan niet worden verwijderd. Hoofdbeheerder kan andere accounts verwijderen
$get_questions = mysqli_query($db, "SELECT * FROM `vragen` INNER JOIN `dier` ON `dier`.`id` = `vragen`.`diersoort` ORDER BY `diersoort` ASC");
$get_animals = mysqli_query($db, "SELECT * FROM `dier` ORDER BY `id` ASC");

if(isset($_POST['select_animal'])){
    $diersoort = mysqli_real_escape_string($db, $_POST['diersoort']);
    $get_questions = mysqli_query($db, "SELECT * FROM `vragen` INNER JOIN `dier` ON `dier`.`id` = `vragen`.`diersoort` WHERE `vragen`.`diersoort` = '$diersoort' ORDER BY `diersoort` ASC");
}
?>

    <div class="table-users">
        <div class="title"><p>Overzicht vragen</p></div>

        <form method="post">
            <table>
                <tr>
                    <td>Kies diersoort</td>
                    <td><select name="diersoort">
                            <?php
                            while($animal = mysqli_fetch_assoc($get_animals)){?>
                                <option name="diersoort" value="<?= $animal['id'];?>"><?= $animal['naam'];?></option>
                            <?php }
                            ?>
                     </select></td>
                    <td><input type="submit" value="Selecteer dier" id="select_animal" name="select_animal" class="comfirm-button"></td>
                </tr>
            </table>

        </form>

        <table class="user-table">
            <thead>
            <th>Diersoort</th>
            <th>Vraag</th>
            <th>Correct</th>
            <th>Fout 1</th>
            <th>Fout 2</th>
            <th>Wijzig</th>
            <th>Verwijderen</th>
            </thead>
            <?php
            while($question = mysqli_fetch_assoc($get_questions))
            {
                ?>
                <tr>
                    <td><?= $question['naam'];?></td>
                    <td><?= $question['vraag'];?></td>
                    <td><?= $question['correct_antwoord'];?></td>
                    <td><?= $question['fout_antwoord_1'];?></td>
                    <td><?= $question['fout_antwoord_2'];?></td>
                    <td><a href="questions_edit.php?id=<?=$question['id'];?>">Wijzig</a></td>
                    <td><a href="questions_delete.php?id=<?=$question['id'];?>">Verwijderen</a></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>

<?php
require_once('../includes/template/admin/footer.php');
?>