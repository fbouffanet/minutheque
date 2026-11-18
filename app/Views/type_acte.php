<?php if (!empty($liste_types_actes)): ?>
<table border=1 > 
<?php foreach ($liste_types_actes as $idf => $nom): ?>
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
    Pas de type d'acte
<?php endif ?>