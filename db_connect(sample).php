<?php

//Info for local host
DEFINE('DBHOST' , 'localhost' );                  // <-- usually localhost
DEFINE('DBUSER' , 'sample_user' );                // <-- MySQL db user name
DEFINE('DBPASS' , 'sample_pass' );                // <-- MySQL password
DEFINE('DBNAME' , 'sample_carcomparisonDBname' ); // <-- what you want to call the database to hold tables

// Filepath below is where usernamelist.txt is stored for AJAX query (make this file in your file system
// because this program will not make it automatically)
$filePath = "carcomparisondata/usernamelist.txt";

//Directory where the user's car photos are stored (include ending slash) (must make directory in your file system first)
$picStoragePath = "carcomparisondata/user_photos/";

