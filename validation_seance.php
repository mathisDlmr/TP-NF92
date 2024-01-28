<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Validation séance</title>
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
            <h2>Valider une séance</h2>
            <form method='POST' action='valider_seance.php'>
                <?php
                //On récupère toutes les séances passées de la table inscription
                //On aurait pu se limiter aux séances où des élèves sont encore à noter, mais c'est un choix de conception
                include 'connexion.php';
                $recuperer_seances_passees = "SELECT * FROM seances JOIN themes ON seances.idtheme = themes.idtheme WHERE DateSeance <= CURRENT_DATE() AND seances.idseance IN (SELECT idseance FROM inscription)";
                $result = mysqli_query($connect, $recuperer_seances_passees);

                if (!$result) {
                    echo "<br>Erreur de connexion à la BDD  ".mysqli_error($connect);
                    echo "<a href='accueil.html' class='retour'>Accueil</a>";
                    exit();
                };

                //On vérifie qu'il existe des séances passées dans la table inscription
                if(mysqli_num_rows($result) == 0) {
                    echo "Aucune séance passée n'a encore eu lieu";
                    echo "<a href='ajout_seance.php' class='retour'>Ajouter une séance</a>";
                    mysqli_close($connect);
                    exit();
                };

                //Si tout est bon, on génère le formulaire pour sélectionner la séance
                echo "<label for='seance'>Séance</label>";
                echo "<select id='seance' name='seance' size='6' required>";
                $mois = array("janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
                while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
                    list($year, $moi, $day) = explode("-", $row[1]);
                    $date = "$day ".$mois[$moi-1]." $year";
                    echo "<option value='$row[0]'>$date ($row[5])</option>";
                };
                echo "</select>";
                echo "<INPUT type='submit' value='Valider'>";
                echo "<INPUT type='reset' value='Effacer'>";
                
                mysqli_close($connect);
                ?>
            </form>
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