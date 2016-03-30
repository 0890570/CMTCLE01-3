<?php
require_once('../includes/template/admin/header.php'); ?>

<a href="animal_add.php">Voeg een nieuwe diersoort toe</a>
<?php

// Haal beheerders op, hoofdbeheerder kan niet worden verwijderd. Hoofdbeheerder kan andere accounts verwijderen
$get_animals = mysqli_query($db, "SELECT * FROM `dier` ORDER BY `naam` ASC");
?>
    <div class="table-users">
        <div class="title"><p>Overzicht diersoorten</p></div>

        <table class="user-table">
            <thead>
            <th>Diernaam</th>
            <th>Wijzigen</th>
            <th>Verwijderen</th>
            </thead>
            <?php
            while($animal = mysqli_fetch_assoc($get_animals))
            {
                ?>
                <tr>
                    <td><?= $animal['naam'];?></td>
                    <td><a href="animal_edit.php?id=<?=$animal['id'];?>">Wijzig</a></td>
                    <td><a href="animal_delete.php?id=<?=$animal['id'];?>">Verwijderen</a></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>

<?php
require_once('../includes/template/admin/footer.php');
?>