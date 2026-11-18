<?php if (!empty($liste_types_presence)): ?>
<table border=1 > 
<?php foreach ($liste_types_presence as $idf => $nom): ?>
    <tr>
    <td>
    <?= esc($idf) ?>
    </td>
    <td>
    <?= esc($nom) ?>
</td>    
</tr>
<?php endforeach ?>
</table>
<?php else: ?>
    Pas de type de comparution
<?php endif ?>