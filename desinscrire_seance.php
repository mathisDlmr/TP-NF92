<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Desinscription Séance</title>
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
            <h2>Désinscription séance</h2>
                <?php
                    //On vérifie que les vérifications HTML "required" n'ont pas été supprimées
                    if ((empty($_POST['eleve'])) || (empty($_POST['seance']))) {
                        echo "<p>Un problème a été rencontré avec vos données. <i>(Champ vide)</i></p>";
                        echo "<a href='desinscription_seance.php' class='retour'>Retour</a>";
                        exit();
                    };

                    //On vérifie que l'utilisateur n'a pas modifié l'id de l'élève en un id inexistant
                    include 'connexion.php';
                    $verif_eleve_existe = 'SELECT * FROM eleves WHERE ideleve = "'.$_POST['eleve'].'"';
                    $result = mysqli_query($connect, $verif_eleve_existe);

                    if(empty(mysqli_fetch_array($result))){
                        echo "<p>Un problème a été rencontré avec vos données. <i>(Eleve inexistant)</i></p>";
                        echo "<a href='desinscription_seance.php' class='retour'>Retour</a>";
                        mysqli_close($connect);
                        exit();
                    };

                    //Si l'ideleve existe bien, on vérifie que l'id de la séance est aussi un id existant
                    $verif_seance_existe = 'SELECT * FROM seances WHERE idseance = "'.$_POST['seance'].'"';
                    $result = mysqli_query($connect, $verif_seance_existe);
                
                    if(empty(mysqli_fetch_array($result))){
                        echo "<p>Un problème a été rencontré avec vos données. <i>(Séance inexistante)</i></p>";
                        echo "<a href='desinscription_seance.php' class='retour'>Retour</a>";
                        mysqli_close($connect);
                        exit();
                    };

                    //Si tout est bon, on supprime la séance correspondante aux entrées du formulaire
                    $supprimer_inscription_seance = 'DELETE FROM inscription WHERE idseance="'.$_POST['seance'].'" AND ideleve="'.$_POST['eleve'].'"';
                    $result = mysqli_query($connect, $supprimer_inscription_seance);
            
                    if (!$result) {
                        echo "<br>Erreur de connexion à la BDD  ".mysqli_error($connect);
                        echo "<a href='desinscription_seance.php' class='retour'>Retour</a>";
                        exit();
                    };

                    echo "<p>L'élève a été désinscrit !</p>";
                    echo "<a href='desinscription_seance.php' class='retour'>Retour</a>";
            
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