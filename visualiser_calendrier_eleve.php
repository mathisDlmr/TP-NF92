<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Calendrier élève</title>
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
            <h2>Calendrier élève</h2>
            <?php
                //On vérifie que les contraintes HTML "required" n'ont pas été supprimées
                if (empty($_POST['eleve'])) {
                    echo "<p>Un problème a été rencontré avec vos données. <i>(Champ vide)</i></p>";
                    echo "<a href='visualisation_calendrier_eleve.php' class='retour'>Retour</a>";
                    exit();
                };

                //On récupère les séances futures auxquelles l'élève est inscrit
                include 'connexion.php';
                $recuperer_seances_eleve_inscrit = 'SELECT seances.DateSeance, themes.nom FROM inscription INNER JOIN seances ON inscription.idseance = seances.idseance INNER JOIN themes ON themes.idtheme = seances.idtheme WHERE inscription.ideleve = "'.$_POST['eleve'].'" AND seances.DateSeance > CURDATE()';            
                $result = mysqli_query($connect, $recuperer_seances_eleve_inscrit);

                if (!$result) {
                    echo "<br>Erreur de connexion à la BDD  ".mysqli_error($connect);
                    echo "<br><br><a href='visualisation_calendrier_eleve.php' class='retour'>Retour</a>";
                    exit();
                };
                
                //Si l'élève n'est inscrit à aucune séance ou n'existe pas, on prévient l'utilisateur
                if (mysqli_num_rows($result) == 0) {
                    echo "<p>L'élève n'est inscrit à aucune séance</p>";
                    echo "<a href='visualisation_calendrier_eleve.php' class='retour'>Retour</a>";
                    mysqli_close($connect);
                    exit();
                };

                //Sinon, on génère le tableau avec les séances de l'élève
                echo"<table>";
                echo"<tr><th>Date de la séance</th><th>Thème</th></tr>";
                $mois = array("janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
                while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
                    list($year, $moi, $day) = explode("-", $row[0]);
                    $dateSeance = "$day ".$mois[$moi-1]." $year";
                    echo"<tr>";
                    echo"<td>$dateSeance</td><td>$row[1]</td>";
                    echo "</tr>";
                };
                echo"</table>";
                echo "<br><br><a href='visualisation_calendrier_eleve.php' class='retour'>Retour</a>";

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