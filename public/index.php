<?php

require_once('../connect.php');
require_once('../src/functions.php');

$pdo = new PDO(DSN, LOGIN, PWD);


$sqlContact = 'SELECT * FROM contact ORDER BY lastname, firstname ASC;';

$resultat = $pdo->query($sqlContact);

$contacts = $resultat->fetchAll(PDO::FETCH_ASSOC);


$sqlCivility = 'SELECT * FROM civility;';
$civilityResult = $pdo->query($sqlCivility);
$dbCivilities = $civilityResult->fetchAll(PDO::FETCH_ASSOC);
$civilities = [];

foreach ($dbCivilities as $civility){

    $civilities[$civility['id']] = $civility['civility'];
}




echo '<table>';
echo '<thead>
<tr>
    <th>Civilité</th><th>NOM Prénom</th>
</tr>
</thead>';

echo '<tbody>';

foreach ($contacts as $contact) {


    echo '<tr>
        <td>' . $civilities[$contact['civility_id']] . '</td>
        <td>' . fullname($contact['firstname'], $contact['lastname'])  . '</td>
    </tr>';
}
echo '</tbody>
</table>';

?>

<form method="post">
    <label for="firstname"></label>
    <input type="text" name="firstname" id="firstname">
    <label for="lastname"></label>
    <input type="text" name="lastname" id="lastname">

</form>
