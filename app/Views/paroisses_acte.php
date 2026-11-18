<?php if (!empty($liste_paroisses_actes)): ?>
<table border=1 > 
    <tr>
        <th>Id Paroisse</th>
        <th>Id Acte </th>
    </tr>
<?php foreach ($liste_paroisses_actes as $a_ligne): ?>
    <?=  list($idf_paroisse,$idf_acte)=$a_ligne; ?>
    <tr>
    <td>
    <?= esc($idf_paroisse) ?>
    </td>
    <td>
    <?= esc($idf_acte) ?>
    </td>
    <td>
</tr>
<?php endforeach ?>
</table>
<?php else: ?>
    Pas de paroisses acte
<?php endif ?>