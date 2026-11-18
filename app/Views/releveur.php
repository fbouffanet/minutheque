<?php if (!empty($liste_releveurs)): ?>
<table border=1 > 
<?php foreach ($liste_releveurs as $idf_releveur => $a_row): ?>
    <?php list($nom,$prenom,$login,$passwd,$email) =($a_row);  ?>
    <tr>
    <td>
    <?= esc($idf_releveur) ?>
    </td>
    <td>
    <?= esc($nom) ?>
    </td>
    <td>
    <?= esc($prenom) ?>
    </td> 
    <td>
    <?= esc($login) ?>
    </td>
    <td>
    <?= esc($email) ?>
    </td>   
</tr>
<?php endforeach ?>
</table>
<?php else: ?>
    Pas de releveur
<?php endif ?>