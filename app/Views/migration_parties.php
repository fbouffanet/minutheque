<?php if (!empty($liste_personnes)): ?>
<table border=1 > 
<?php foreach ($liste_personnes as $idf_personne => $a_row): ?>
    <?php list($idf_acte,$idf_type_comparution,$st_nom,$st_prenom,$st_surnom,$idf_profession,$idf_paroisse_residence,$idf_paroisse_origine,$st_sexe,$st_commentaires) =$a_row;  ?>
    <tr>
    <td>
    <?= esc($idf_acte) ?>
    </td>
    <td>
    <?= esc($idf_type_comparution) ?>
    </td>
    <td>
    <?= esc($st_nom) ?>
    </td> 
    <td>    
    <?= esc($st_prenom) ?>
    </td>
    <td>    
    <?= esc($st_surnom) ?>
    </td>  
    <td>
    <?= esc($st_sexe) ?>
    </td>
    <td>
    <?= esc($st_commentaires) ?>
    </td>   
</tr>
<?php endforeach ?>
</table>
<?php else: ?>
    Pas de personnes
<?php endif ?>