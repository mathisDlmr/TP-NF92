<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Suppression Thème</title>
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
            <h2>Supprimer un thème</h2>
            <?php
                //On vérifie que la contrainte HTML "required" n'a pas été supprimée
                if(empty($_POST['theme'])){
                    echo "<p>Un problème a été rencontré avec vos données. <i>(Champ vide)</i></p>";
                    echo "<a href='suppression_theme.php' class='retour'>Retour</a>";
                    exit();
                };

                //On vérifie que l'idtheme n'a pas été changé en un id inexistant ou déjà supprimé
                include 'connexion.php';
                $verif_theme_existe = 'SELECT * FROM themes WHERE supprime = 0 AND idtheme = "'.$_POST['theme'].'"';
                $result = mysqli_query($connect, $verif_theme_existe);

                if (!$result) {
                    echo "<br>Erreur de connexion à la BDD  ".mysqli_error($connect);
                    echo "<a href='suppression_theme.php' class='retour'>Retour</a>";
                    exit();
                };

                if (empty(mysqli_fetch_array($result))){
                    echo "<p>Ce thème a déjà été supprimé</p>";
                    echo "<a href='suppression_theme.php' class='retour'>Retour</a>";
                    mysqli_close($connect);
                    exit();
                };

                //Si tout est bon, on change la valeur de theme.supprime pour le thème
                //On aurait également pu supprimer les séances futures avec ce thème, mais cela est un choix de conception
                $desactiver_theme = 'UPDATE themes SET supprime = 1 WHERE idtheme = "'.$_POST['theme'].'"';
                $result = mysqli_query($connect, $desactiver_theme);

                if (!$result) {
                    echo "<br>Erreur de connexion à la BDD  ".mysqli_error($connect);
                    echo "<a href='suppression_theme.php' class='retour'>Retour</a>";
                    exit();
                };

                echo "<p>Le thème a été supprimé !</p>";
                echo "<a href='suppression_theme.php' class='retour'>Retour</a>";

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