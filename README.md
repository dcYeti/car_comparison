# car_comparison
A simple app to make a list of cars to buy and rank them by feature.

#Getting Started

This is a PHP 5 application.  
After download, all you have to do is put your db info into the db_connect.php file (template provided).  Instructions below.
May also want to check "template_head.php" to make sure the JQuery CDNs are updated.

#Prerequisites

PHP installation, MySQL Database 

#Installing

After download, use the template to create a 'db_connect.php' in the root directory and define the following constants:

DEFINE('DBHOST' , 'localhost' );                  // <-- usually localhost
DEFINE('DBUSER' , 'sample_user' );                // <-- MySQL db user name
DEFINE('DBPASS' , 'sample_pass' );                // <-- MySQL password
DEFINE('DBNAME' , 'sample_carcomparisonDBname' ); // <-- what you want to call the database to hold tables

The validation is run using javascript, part of which uses AJAX to query a text file for presence of existing username:

Please create a blank text file to store usernames and give write access (I call this file usernamelist.txt).  
Then, include its address in your db_connect.php in the variable $filePath (stored as string).

The example below uses relative path:
$filePath = '../../sample_path/usernamelist.txt';  

That's it!
