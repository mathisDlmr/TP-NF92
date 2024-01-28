<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Valider élève</title>
    <link href="styles/style.css" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="https://c0.klipartz.com/pngpicture/308/494/gratis-png-lightning-mcqueen-mater-doc-hudson-cars-la-compania-de-walt-disney-cars.png">
</head>

<body>
    <div class="wrapper">
        <header>
            <h1>Auto-école de l'UTC</h1>
            <nav>
                <ul>
                    <li><a href="accueil.html">Accueil</a></li>
                    <li class="deroulant"><a href="#">Gestion élèves &ensp;</a>
                        <ul class="sous">
                            <li><a href="ajout_eleve.html">Ajouter un élève</a></li>
                            <li><a href="consultation_eleve.php">Consultation élèves</a></li>
                            <li><a href="visualisation_calendrier_eleve.php">Calendrier élève</a></li>
                        </ul>
                    </li>
                    <li class="deroulant"><a href="#">Gestion thèmes &ensp;</a>
                        <ul class="sous">
                            <li><a href="ajout_theme.html">Ajouter un thème</a></li>
                            <li><a href="suppression_theme.php">Supprimer un thème</a></li>
                        </ul>
                    </li>
                    <li class="deroulant"><a href="#">Gestion séances &ensp;</a>
                        <ul class="sous">
                            <li><a href="ajout_seance.php">Ajouter une séance</a></li>
                            <li><a href="inscription_eleve.php">Inscrire un élève à une séance</a></li>
                            <li><a href="desinscription_seance.php">Désinscrire un élève à une séance</a></li>
                            <li><a href="validation_seance.php">Valider une séance</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header>
        <main>
            <h2>Ajouter un élève</h2>
            <?php
            //On vérifie que les contraintes HTML "required" n'ont pas été supprimées
            if (empty($_POST['nom']) || empty($_POST['prenom']) || empty($_POST['naissance'])) {
                echo "<p>Un problème a été rencontré avec vos données. <i>(Champ vide)</i></p>";
                echo "<a href='ajout_eleve.html' class='retour'>Retour</a>";
                exit();
            }
            
            //On vérifie que l'élève est majeur (pas précisé dans le cahier des charges mais pertinant)
            if (strtotime($_POST['naissance']) > strtotime("- 15 years")) {
                echo "<p>L'élève n'a pas l'âge légal ! </p>";
                echo "<a href='ajout_eleve.html' class='retour'>Retour</a>";
                exit();
            }

            include 'connexion.php';

            //On échappe les caractères spéciaux pour éviter les problèmes
            $nom_echappe = mysqli_real_escape_string($connect, $_POST['nom']);
            $prenom_echappe = mysqli_real_escape_string($connect, $_POST['prenom']);

            //Si tout est bon, on essaye d'ajouter l'élève à la BDD en vérifiant que personne n'a le même nom et prénom
            $verif_eleve_inexistant = 'SELECT * FROM eleves WHERE nom = "'.$nom_echappe.'" and prenom = "'.$prenom_echappe.'" ';
            $result = mysqli_query($connect, $verif_eleve_inexistant);

            if (!$result) {
                echo "<br>Erreur de connexion à la BDD  ".mysqli_error($connect);
                echo "<a href='ajout_eleve.html' class='retour'>Retour</a>";
                exit();
            };

            //Si un élève avec le même nom et prénom est déjà dans la BDD, on demande à l'utilisateur de confirmer l'ajout
            if (!empty(mysqli_fetch_array($result))) {
                echo "<p>Un élève avec le même nom et prénom est déjà inscrit</p>";
                echo "<p>Voulez-vous continuer ?</p>";

                echo "<form method='POST' action='ajouter_eleve.php'>";
                echo "<input type='hidden' id='nom' name='nom' value='{$_POST['nom']}'>";
                echo "<input type='hidden' id='prenom' name='prenom' value='{$_POST['prenom']}'>";
                echo "<input type='hidden' id='naissance' name='naissance' value='{$_POST['naissance']}'>";
                echo "<input type='submit' value='Oui'>";
                echo "<a href='ajout_eleve.html' class='retour'>Non</a>";
                echo "</form>";

            //Si on est sûr que l'élève est nouveau, on l'ajoute directement
            } else {
                date_default_timezone_set('Europe/Paris');
                $date = date("Y\-m\-d");
                $ajouter_eleve = 'INSERT INTO eleves VALUES (NULL,"'.$nom_echappe.'", "'.$prenom_echappe.'", "'.$_POST['naissance'].'", "'.$date.'")';
                $result = mysqli_query($connect, $ajouter_eleve);

                if (!$result) {
                    echo "<br>Erreur de connexion à la BDD  ".mysqli_error($connect);
                    echo "<a href='ajout_eleve.html' class='retour'>Retour</a>";
                    exit();
                };

                echo "<p>L'élève a été ajouté ! </p>";
                echo "<a href='ajout_eleve.html' class='retour'>Retour</a>";
            };

            mysqli_close($connect);
            ?>
        </main>
    </div>
    <footer>
        <a target="_blank" href="https://www.utc.fr/" class="lien-icone"><img src="https://upload.wikimedia.org/wikipedia/fr/thumb/4/45/Logo_UTC_2018.svg/2560px-Logo_UTC_2018.svg.png" alt="UTC" height="42px"></a>
        <div>
            <a target="_blank" href="https://facebook.com/" class="lien-icone"><img src="https://logodownload.org/wp-content/uploads/2014/09/facebook-logo-1-2.png" alt="Twitter" height="42px" width="42px"></a>
            <a target="_blank" href="https://instagram.com" class="lien-icone"><img src="https://clipartcraft.com/images/instagram-logo-transparent-background-2.png" alt="Instagram" height="42px" width="42px"></a>
        </div>
    </footer>
</body>
</html>
