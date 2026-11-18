<?php if (!empty($liste_paroisses)): ?>
<table border=1 > 
<?php foreach ($liste_paroisses as $idf_paroisse => $nom): ?>
    <tr>
    <td>
    <?= esc($idf_paroisse) ?>
    </td>
    <td>
    <?= esc($nom) ?>
</td>    
</tr>
<?php endforeach ?>
</table>
<?php else: ?>
    Pas de paroisse
<?php endif ?>