<?php if (!empty($liste_actes)): ?>
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
<?php foreach ($liste_actes as $idf_acte => $a_row): ?>
<?php list($date,$date_rep,$st_date_enregistrement,$st_date_rep_enregistrement,$idf_type_acte,$idf_notaire,$cote,$idf_paroisse_signature,$commentaires,$date_modification,$idf_redacteur,$st_transcription) =($a_row);  ?>
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
    <td>
    <?= esc($idf_paroisse_signature) ?>
    </td> 
    <td>
    <?= esc($st_date_enregistrement) ?>
    </td>
    <td>
    <?= esc($st_date_rep_enregistrement) ?>
    </td>
    <td>
    <?= esc($commentaires) ?>
    </td>
    <td>
    <?= esc($date_modification) ?>
    </td>
    <td>
    <?= esc($idf_redacteur) ?>
    </td> 
    <td>
        <pre>
    <?= esc($st_transcription) ?>
    </pre>    
    </td>        
</tr>
<?php endforeach ?>
</table>
<?php else: ?>
    Pas d'acte
<?php endif ?>