<!--Code de connexion à la BDD-->

<?php
  $dbhost = '';
  $dbuser = '';
  $dbpass = '';
  $dbname = '';
  $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
  mysqli_set_charset($connect, 'utf8');
?>
