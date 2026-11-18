<?php if (!empty($liste_professions)): ?>
<table border=1 > 
<?php foreach ($liste_professions as $idf => $nom): ?>
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
    Pas de professions
<?php endif ?>