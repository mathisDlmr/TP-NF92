<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Valider séance</title>
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
            <?php
            //On vérifie que la contrainte HTML "required" n'a pas été supprimée
            if(empty($_POST['seance'])){
                echo "<p>Un problème a été rencontré avec vos données. <i>(Champ vide)</i></p>";
                echo "<a href='validation_seance.php' class='retour'>Retour</a>";
                exit();
            };

            //On récupère toutes les séances de la table inscription 
            include 'connexion.php';
            $recuperer_seances = 'SELECT * FROM inscription INNER JOIN eleves ON inscription.ideleve = eleves.ideleve WHERE inscription.idseance = "'.$_POST['seance'].'"';
            $result = mysqli_query($connect, $recuperer_seances);

            if (!$result) {
                echo "<br>Erreur de connexion à la BDD  ".mysqli_error($connect);
                echo "<a href='validation_seance.php' class='retour'>Retour</a>";
                exit();
            };

            //On vérifie que l'idseance n'a pas été modifié en une séance sans élève ou inexistante
            if (mysqli_num_rows($result) == 0){
                echo "<p> Aucun élève n'est inscrit à cette séance</p>";
                echo "<a href='validation_seance.php' class='retour'>Retour</a>";
                mysqli_close($connect);
                exit();
            };

            //Si tout est bon, on génère le formulaire
            echo "<FORM ACTION='noter_eleves.php' METHOD='POST'>";
            echo "<table>";
            echo "<tr> <th>Nom:</th> <th>Prénom:</th> <th>Nombre de fautes:</th> </tr>";
            while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                echo "<input type='hidden' value='$row[1]' name='ideleve_$row[1]'>";
                echo "<tr>";
                echo "<td> $row[4]</td>";
                echo "<td> $row[5]</td>";
                if($row[2] == -1){ // si l'élève n'est pas encore noté, le champ est vide
                    echo "<td class='fautes'><input type='number' name='nbfautes_$row[1]' min='0' max='40' id='nombre' style='margin-bottom: 0px;'></td>";
                } else { //si l'élève est noté, on affiche sa note
                    $fautes = 40 - $row[2];
                    echo "<td class='fautes'><input type='number' name='nbfautes_$row[1]' min='0' max='40' id='nombre' value='$fautes' style='margin-bottom: 0px;'></td>";
                };
                echo "</tr>";
            };
            echo "</table>";
            echo '<input type="hidden" name="seance" value="'.$_POST['seance'].'">';
            echo "<br>";
            echo "<input type='submit' value='Valider'>";
            echo "<INPUT type='reset' value='Effacer'>";
            echo "<a href='validation_seance.php' class='retour'>Retour</a>";
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