<?php

require_once('../connect.php');
require_once('../src/functions.php');

$pdo = new PDO(DSN, LOGIN, PWD);


if (!empty($_POST)) {

    $sqlInsert = 'INSERT INTO contact (`lastname`, `firstname`, `civility_id`) 
              VALUES (:lastname, :firstname, :civility)';

    $prepared = $pdo->prepare($sqlInsert);

    $prepared->bindValue(':lastname', $_POST['lastname'], PDO::PARAM_STR);
    $prepared->bindValue(':firstname', $_POST['firstname'], PDO::PARAM_STR);
    $prepared->bindValue(':civility', $_POST['civility'], PDO::PARAM_INT);

    $prepared->execute();

    echo "INSERTION !!!";

}


$sqlContact = 'SELECT * FROM contact ORDER BY lastname, firstname ASC;';

$resultat = $pdo->query($sqlContact);

$contacts = $resultat->fetchAll(PDO::FETCH_ASSOC);


$sqlCivility = 'SELECT * FROM civility;';
$civilityResult = $pdo->query($sqlCivility);
$dbCivilities = $civilityResult->fetchAll(PDO::FETCH_ASSOC);
$civilities = [];

foreach ($dbCivilities as $civility) {

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
        <td>' . fullname($contact['firstname'], $contact['lastname']) . '</td>
    </tr>';
}
echo '</tbody>
</table>';


?>

<form method="post">
    <div>
        <?php
        foreach ($dbCivilities as $civility) {
            echo '<input type="radio" name="civility" value="' . $civility['id'] . '"><label>' . $civility['civility'] . '</label>';
        }
        ?>
    </div>
    <?php
    $forbidden = ['id', 'civility_id'];
    foreach ($contacts[0] as $field => $value) {
        if (!in_array($field, $forbidden)){ ?>
            <label for="<?= $field; ?>"><?= ucfirst($field); ?></label>
        <input type="text" name="<?= $field; ?>" id="<?= $field; ?>" placeholder="<?= $value; ?>">
        <?php
    }
    } ?>

    <input type="submit">
</form>
