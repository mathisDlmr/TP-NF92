<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Sélection séance</title>
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
            <h2>Sélectionner la séance</h2>
            <?php
            //On vérifie que les vérifications HTML "required" n'ont pas été supprimées
            if (empty($_POST['eleve'])) {
                echo "<p>Un problème a été rencontré avec vos données. <i>(Champ vide)</i></p>";
                echo "<a href='inscription_eleve.php' class='retour'>Retour</a>";
                exit();
            };

            //On vérifie que l'utilisateur n'a pas modifié l'id de l'élève en un id inexistant
            include("connexion.php");
            $verif_eleve_existe = 'SELECT * FROM eleves WHERE ideleve = "'.$_POST['eleve'].'"';
            $result = mysqli_query($connect, $verif_eleve_existe);

            //Si l'ideleve n'existe pas (il a été modifié), on prévient l'utilisateur
            if(empty(mysqli_fetch_array($result))){
                echo "<p>Un problème a été rencontré avec vos données. <i>(Eleve inexistant)</i></p>";
                echo "<a href='inscription_eleve.php' class='retour'>Retour</a>";
                mysqli_close($connect);
                exit();
            };

            //On propose dans le formulaire toutes les séances futures auxquelles l'élève n'est pas inscrit, et où l'effectif max n'est pas atteint
            $eleve=$_POST['eleve'];
            $recuperer_seances_dispo = "SELECT * FROM seances WHERE seances.EffMax > (SELECT COUNT(*) FROM inscription WHERE inscription.idseance = seances.idseance) AND idseance NOT IN (SELECT idseance FROM inscription WHERE ideleve=$eleve) AND seances.DateSeance > CURDATE()";
            $result = mysqli_query($connect, $recuperer_seances_dispo);

            if (!$result) {
                echo "<br>Erreur de connexion à la BDD  ".mysqli_error($connect);
                echo "<a href='inscription_eleve.php' class='retour'>Retour</a>";
                exit();
            };

            //Si l'élève est inscrit à toutes les séances, on prévient l'utilisateur
            if (mysqli_num_rows($result) == 0) {
                echo "<p>L'élève est inscrit à toutes les séances futures proposées</p>";
                echo "<a href='inscription_eleve.php' class='retour'>Retour</a>";
                mysqli_close($connect);
                exit();
            };

            //Si tout est bon, on génère le formulaires avec les séances à proposer
            echo "<FORM METHOD='POST' ACTION='inscrire_eleve.php' >";
            echo "<input type='hidden' name='ideleve' value=$eleve>";
            echo "<label for='seance'>Séance</label>";
            echo "<select id='seance' name='idseance' size='4' required>";
            $mois = array("janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
            list($year, $moi, $day) = explode("-", $firstRow[1]);
            $date = "$day ".$mois[$moi-1]." $year";
            while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
                list($year, $moi, $day) = explode("-", $row[1]);
                $date = "$day ".$mois[$moi-1]." $year";
                echo "<option value='$row[0]'>$date (thème $row[3])</option>";
            };
            echo "</select>";
            echo "<br>";
            echo "<INPUT type='submit' value='Valider'>";
            echo "<INPUT type='reset' value='Effacer'>";
            echo "<a href='inscription_eleve.php' class='retour'>Retour</a>";
            echo "</FORM>";

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