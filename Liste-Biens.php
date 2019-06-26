<?php
require 'PDO.php';
$request = 'SELECT * FROM logement';
$response = $bdd->query($request);

$logements = $response->fetchAll(PDO::FETCH_ASSOC);

?>
<?php include ('partials/Header.php'); ?>

    <a href="index.php" class="btn btn-danger btn-sm mb-2">< Retour</a>
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
            
            foreach($logements as $logement) : 
            $nomphoto=$logement['photo'];?>
                <tr>
                    
                    <td><?= $logement['id_logement'] ?></td>
                    <td><?= $logement['titre'] ?></td>
                    <td><?= $logement['adresse '] ?></td>
                    <td><?= $logement['ville'] ?></td>
                    <td><?= $logement['cp'] ?></td>
                    <td><?= $logement['surface '] ?></td>
                    <td><?= $logement['prix'] ?></td>
                    <td><?= $text = $logement['description'];
                            $newtext = wordwrap( $text, 20 ); ?></td>
                    <td><?= $logement['type'] ?></td>
                    <td><img src= "uploads/<?=$nomphoto?>" height="100"></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    

<?php include ('partials/Footer.php'); ?>
