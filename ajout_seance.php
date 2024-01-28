<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Ajouter séance</title>
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
            <?php
            //On récupère les thèmes existants dans la BDD pour générer le formulaire
            include("connexion.php");
            $chercher_themes_existants = "SELECT * FROM themes where supprime ='0'";
            $result = mysqli_query($connect, $chercher_themes_existants);

            if (!$result) {
                echo "<br>Erreur de connexion à la BDD  ".mysqli_error($connect);
                echo "<a href='accueil.html' class='retour'>Accueil</a>";
                mysqli_close($connect);
                exit();
            };

            //Si aucun thème n'a encore été créé, on en informe l'utilisateur
            if(mysqli_num_rows($result) == 0) {
                echo"<p>Aucun thème n'a encore été créé";
                echo "<a href='ajout_theme.html' class='retour'>Créér un thème</a>";
                mysqli_close($connect);
                exit();
            };
            
            //Si tout est bon, on génère le formulaire
            echo "<h2>Ajouter une séance</h2>";
            echo "<FORM METHOD='POST' ACTION='ajouter_seance.php' >";
            echo "<label for='theme'>Choix du Thème</label>";
            echo "<select id='theme' name='theme' size='4' required>";
            while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
                echo "<option value='$row[0]'>$row[0] - $row[1]</option>";
            };
            echo "</select>";
            echo "<br>";

            date_default_timezone_set("Europe/Paris");
            $date = date("Y\-m\-d");
            $futureDate=date('Y-m-d', strtotime('+10 years'));

            echo "<label for='date'>Date de la séance</label>";
            echo "<input type='date' id='date' name='date' min=$date max=$futureDate required>";
            echo "<label for='effMax'>Effectif Maximum</label>";
            echo "<input type='number' id='effMax' name='effMax' min='1' max='50' required>"; //onkeydown='return false' pour empêcher 'e'
            echo "<INPUT type='submit' value='Valider'>";
            echo "<INPUT type='reset' value='Effacer'>";
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