<?php

require 'PDO.php';

if (!empty($_POST)) {

// VERIFICATION DE l'"EXISTENCE" DES $_POST
    
    if(!isset ($_POST['titre'])) {
        new Exception('Le titre est invalide.');
    }

    if(!isset ($_POST['adresse '])) {
        new Exception('L\'adresse est invalide.');
    }

    if(!isset ($_POST['ville'])) {
        new Exception('La ville est invalide.');
    }

    if(!isset ($_POST['cp'])) {
        new Exception('Le cp est invalide.');
    }

    // Il faut vérifier que le code postal est un chiffre entre 1000 et 100000
    if (($_POST['cp']) < 1000 || ($_POST['cp']) > 100000  ) {
        new Exception('Le code postal doit être compris entre 1000 et 100000.');
    }

    if(!isset ($_POST['surface'])) {
        new Exception('Le surface est invalide.');
    }
    // Il faut vérifier que la surface est un nombre entier (\pas de lettres ni de point ni de virgules\)
    if (!is_numeric($_POST['surface'])) {
        new Exception('La surface doit être un nombre.');
    }

    if (strpos($_POST['surface'], '.' )) {
        new Exception('La surface doit être un nombre entier');
    }

    if (strpos($_POST['surface'], ',' )) {
        new Exception('La surface doit être un nombre entier');
    }

    if(!isset ($_POST['prix'])) {
        new Exception('Le prix est invalide.');
    }

    // Il faut vérifier que le prix est un nombre entier (\pas de lettres ni de point ni de virgules\)
    if (!is_numeric($_POST['prix'])) {
        new Exception('Le prix doit être un nombre.');
    }

    if (strpos($_POST['prix'], '.' )) {
        new Exception('Le prix doit être un nombre entier');
    }

    if (strpos($_POST['prix'], ',' )) {
        new Exception('Le prix doit être un nombre entier');
    }

    if(!isset ($_POST['type'])) {
        new Exception('Le type est invalide.');
    }

    // Vérifier que l'on a pas mis un autre type que les deux proposés
    $typesobligatoires = array('location', 'vente');

    if(($_POST['type'])== $typesobligatoires) {
        new Exception('Choisir le type entre les deux propositions');
    }

    if(!isset ($_POST['photo'])) {
        new Exception('La photo est invalide.');
    }


    // REMPLIR LA TABLE LOGEMENT AVEC LE FORMULAIRE
    $request = 'INSERT INTO logement (titre, adresse, ville, cp, surface, prix, photo, type, description)
                VALUES (:titre, :adresse, :ville, :cp, :surface, :prix, :photo, :type, :description)';

    $ajoutlogement = $bdd->prepare($request);

    $response = $ajoutlogement->execute([
        'titre'         => $_POST['titre'],
        'adresse'       => $_POST['adresse'],
        'ville'         => $_POST['ville'],
        'cp'            => $_POST['cp'],
        'surface'       => $_POST['surface'],
        'prix'          => $_POST['prix'],
        'photo'         => $_FILES['photo']['name'],
        'type'          => $_POST['type'],
        'description'   => $_POST['description'],

    ]);

    // Changer le nom de la photo !
    $id_logement = $bdd->lastInsertId();
    $newName = 'logement_' . $id_logement;
    if ($_FILES['photo']['error'] == 0) {

        // Est-ce que le fichier a une taille correcte

        if ($_FILES['photo']['size'] <= 32000000) {
            // L'extension est-elle ok ?
            $infosfichier = pathinfo($_FILES['photo']['name']);
            $extension_upload = $infosfichier['extension'];
            $extensions_autorisees = ['jpg', 'jpeg', 'gif', 'png'];

            if (in_array($extension_upload, $extensions_autorisees)) {

                // Changer le nom et stocker l'image dans uploads:

                move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/' .  $newName . '.' . $extension_upload);
                echo "L'envoi a bien été effectué !";

                $request = 'UPDATE logement
                            SET photo = "' . $newName . '.' . $extension_upload . '" 
                            WHERE id_logement = ' . $id_logement;

                var_dump ($request);


                            
                $bdd->query($request);

                // CHANGER LA TAILLE DE L'IMAGE
               
            }
        }
    }


    }
?>

<?php include ('Partials/Header.php'); ?>

    <a href="index.php" class="btn btn-danger btn-sm mb-2">< Retour</a>

    <form action="Ajout-Bien.php" method="post" class="mt-3" enctype="multipart/form-data">

        <!-- Titre du bien -->
        <div class="form-group">
            <input name="titre" type="text" class="form-control" placeholder="ajouter un titre">
        </div>

        <!-- adresse  du bien -->
        <div class="form-group">
            <input name="adresse" type="text" class="form-control" placeholder="ajouter une adresse">
        </div>

        <!--ville du bien -->
        <div class="form-group">
            <input name="ville" type="text" class="form-control" placeholder="ajouter une ville ">
        </div>

        <!-- cp du bien -->
        <div class="form-group">
            <input name="cp" type="text" class="form-control" placeholder="ajouter un code postal ">
        </div>

        <!-- Surface du bien -->
        <div class="form-group">
            <input name="surface" type="text" class="form-control" placeholder="ajouter la surface">
        </div>

        <!-- Prix du bien -->
        <div class="form-group">
            <input name="prix" type="text" class="form-control" placeholder="ajouter un prix">
        </div>

        <!-- Type contrat -->
        <div class="form-group">
            <select name="type" class="form-control">
                <option selected disabled >Choisir un type de contrat... </option>
                <option value="location">location</option>
                <option value="vente">vente</option>
            </select>
        </div>

            <!-- Description du bien -->
        <div class="form-group">
            <textarea name="description" cols="30" rows="10" class="form-group" placeholder="ajouter une description"></textarea>
        </div>

            <!-- Photo du bien -->
        <div>
            <input type="file" name="photo" class="btn btn-info float-left" />
        </div>
        
        <button class="btn btn-danger float-right">Ajouter un produit</button>
    </form>



<?php include ('Partials/Header.php'); ?>