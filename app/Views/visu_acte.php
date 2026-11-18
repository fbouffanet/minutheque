<?php if (!empty($infos_acte)): ?>
<?php print_r($infos_acte) ?>    
<?php
$date=$infos_acte['date'];
$date_rep=$infos_acte['date_rep'];
$idf_type_acte=$infos_acte['id_type_acte'];
$idf_notaire=$infos_acte['id_notaire'];
$cote=$infos_acte['cote'];
?>
<table border=1 > 
    <tr>
        <th>Date</th>
        <th>Date Rep </th>
        <th>Idf Type Acte</th>
        <th>Idf Notaire</th>
        <th>Cote</th>
        <th>Idf Paroisse Signature</th>
        <th>Date enregistrement</th>
        <th>Date Rep enregistrement</th>
        <th>Commentaires</th>
        <th>Date Modif</th>
        <th>Idf Releveur</th>
        <th>Transcription</th>
    </tr>
    <tr>
    <td>
    <?= esc($date) ?>
    </td>
    <td>
    <?= esc($date_rep) ?>
    </td>
    <td>
    <?= esc($idf_type_acte) ?>
    </td>
    <td>
    <?= esc($idf_notaire) ?>
    </td> 
    <td>
    <?= esc($cote) ?>
    </td>      
</tr>

</table>
<?php else: ?>
    Pas d'acte
<?php endif ?>