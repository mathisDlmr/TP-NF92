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
            <form method='POST' action='desinscrire.php'>
                <?php
                //On récupère tous les élèves inscrits à des séances futures
                include 'connexion.php';
                $recuperer_eleves_inscrits = "SELECT * FROM eleves WHERE ideleve IN (SELECT ideleve FROM inscription WHERE idseance IN (SELECT idseance FROM seances WHERE DateSeance > CURDATE())) ORDER by nom";
                $result = mysqli_query($connect, $recuperer_eleves_inscrits);

                if (!$result) {
                    echo "<br>Erreur de connexion à la BDD  ".mysqli_error($connect);
                    echo "<a href='accueil.html' class='retour'>Accueil</a>";
                    exit();
                };

                //On vérifie qu'il existe des élèves inscrits à des séances futures dans la BDD'
                if (mysqli_num_rows($result) == 0) {
                    echo "<p>Aucun élève ne s'est encore inscrit</p>";
                    echo "<a href='inscription_eleve.php' class='retour'>Inscrire un élève</a>";
                    mysqli_close($connect);
                    exit();
                };

                //On génère un formulaire à partir de tous les élèves inscrits à des séances futures dans la BDD
                echo "<label for='eleve'>Élève</label>";
                echo "<select id='eleve' name='eleve' size='6' required>";
                $mois = array("janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
                while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
                    list($year, $moi, $day) = explode("-", $row[3]);
                    $dateNaiss = "$day ".$mois[$moi-1]." $year";
                    echo "<option value='$row[0]'>$row[1] $row[2] ($dateNaiss)</option>";
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