<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Noter élève</title>
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
                }

                //On vérifie que l'idseance existe bien
                include 'connexion.php';
                $idseance = $_POST['seance'];
                $verif_seance_existe = "SELECT * FROM inscription WHERE idseance = '$idseance'";
                $result = mysqli_query($connect,$verif_seance_existe);

                if (!$result) {
                    echo "<br>Erreur de connexion à la BDD  ".mysqli_error($connect);
                    echo "<a href='validation_seance.php' class='retour'>Retour</a>";
                    exit();
                };

                //On vérifie que la séance contient bien des inscrits (que l'idseance n'a pas été modifié)
                if (mysqli_num_rows($result) == 0) {
                    echo "<p>Aucun élève n'est inscrit à cette séance</p>";
                    echo "<a href='inscription_eleve.php' class='retour'>Retour</a>";
                    mysqli_close($connect);
                    exit();
                };

                //Si toutes les vérifications sont passées, on affiche le tableau avec chaque élève
                //La variable i compte le nombre d'élève qu'il reste à noter
                $non_note=0;
                while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                    $nb_fautes = $_POST["nbfautes_$row[1]"];

                    //Si le champ est vide ou a été vidé, on efface la note et on retient qu'il manque 1 note
                    if(empty($nb_fautes)) {
                        $non_note+=1;

                        $ideleve = $_POST["ideleve_$row[1]"];
                        $noter_eleve = "UPDATE inscription SET note = -1 WHERE ideleve = '$ideleve' AND idseance = '$idseance'";
                        $result2 = mysqli_query($connect, $noter_eleve);

                        if (!$result2) {
                            echo "<br>Erreur de connexion à la BDD  ".mysqli_error($connect);
                            echo "<a href='validation_seance.php' class='retour'>Retour</a>";
                            exit();
                        };

                    //Si la note n'a pas été entrée, on retient qu'il manque une note
                    } elseif ($nb_fautes==-1){
                        $non_note+=1;

                    //Sinon, on modifie la note de l'élève
                    } else {
                        $ideleve = $_POST["ideleve_$row[1]"];
                        $note = 40 - $nb_fautes;
                        $noter_eleve = "UPDATE inscription SET note = $note WHERE ideleve = '$ideleve' AND idseance = '$idseance'";
                        $result2 = mysqli_query($connect, $noter_eleve);

                        if (!$result2) {
                            echo "<br>Erreur de connexion à la BDD  ".mysqli_error($connect);
                            echo "<a href='validation_seance.php' class='retour'>Retour</a>";
                            exit();
                        };
                    };
                };

                //Enfin, on annonce à l'utilisateur le nombre de notes restantes
                if($non_note==0) {
                    echo "<p>Toutes les notes ont été rentrées</p>";
                } elseif ($non_note==1) {
                    echo "<p>Les notes saisies ont été rentrées</p>";
                    echo "<p>1 note sera encore à rentrer</p>";
                } else {
                    echo "<p>Les notes saisies ont été rentrées</p>";
                    echo "<p>$non_note notes seront encore à rentrer</p><br>";
                };
                echo "<a href='validation_seance.php' class='retour'>Retour</a>";
                
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