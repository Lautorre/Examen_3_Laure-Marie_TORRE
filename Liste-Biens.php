<?php

$request = 'SELECT * FROM produit';
$response = $bdd->query($request);

$logements = $response->fetchAll(PDO::FETCH_ASSOC);

?>
<?php include ('partials/Header.php'); ?>

    <table class="table">
        <thead>
            <tr>
                <th>Référence</th>
                <th>titre</th>
                <th>adresse</th>
                <th>ville</th>
                <th>Code postal</th>
                <th>surface</th>
                <th>Prix</th>
                <th>description</th>
                <th>Contrat</th>
                <th>photo</th>
            </tr>
        </thead>

        <tbody>
            <?php 
            $nomphoto=$logement['name'];
            foreach($logements as $logement) : ?>
                <tr>
                    
                    <td><?= $logement['id_logement'] ?></td>
                    <td><?= $logement['titre'] ?></td>
                    <td><?= $logement['adresse '] ?></td>
                    <td><?= $logement['ville'] ?></td>
                    <td><?= $logement['cp'] ?></td>
                    <td><?= $logement['surface '] ?></td>
                    <td><?= $logement['prix'] ?></td>
                    <td><?= $logement['description'] ?></td>
                    <td><?= $logement['type'] ?></td>
                    <td><img src= "uploads/<?=$logement['name']?>"></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    

<?php include ('partials/Footer.php'); ?>
