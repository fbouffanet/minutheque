<?php if (!empty($liste_notaires)): ?>
<table border=1 > 
<?php foreach ($liste_notaires as $idf => $a_row):  ?>
<?php list($nom,$id_paroisse) =($a_row);  ?>
    <tr>
    <td>
    <?= esc($idf) ?>
    </td>
    <td>
    <?= esc($nom) ?>
</td>
</td>
    <td>
    <?= esc($id_paroisse) ?>
</td>        
</tr>
<?php endforeach ?>
</table>
<?php else: ?>
    Pas de notaire
<?php endif ?>