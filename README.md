# car_comparison
A simple app to make a list of cars to buy and rank them by feature.

#Getting Started

This is a PHP 5 application.
After download, put your MySQL db info into the db_connect.php file (template provided). <br/>
Also, you will have to create one blank text file for AJAX query to check username uniqueness<br/>
in addition to adding a directory to store user photos  

Instructions below. 

#Prerequisites

PHP installation, MySQL Database, Font Awesome library (optional)

#Installing

After download, use the template to create a 'db_connect.php' in the root directory and define the following constants:

DEFINE('DBHOST' , 'localhost' ); // <-- usually localhost <br/>
DEFINE('DBUSER' , 'sample_user' ); // <-- MySQL db user name <br/>
DEFINE('DBPASS' , 'sample_pass' ); // <-- MySQL password  <br/>
DEFINE('DBNAME' , 'sample_carcomparisonDBname' ); // <-- what you want to call the database to hold tables

The validation is run using javascript - not running javascript will result in unvalidated data.

Please create a blank text file to store usernames and give write access (I call this file usernamelist.txt).
Then, include its address in your db_connect.php in the variable $filePath (stored as string).

Please create a directory to store user photos and put it in the db_connect.php file .
Then, include its address in your db_connect.php in the variable $picStoragePath (stored as string).

Check 'template_head.php' to check the link to the font awesome css file.  The default is a local version, but you <br/>
can change this to the CDN.  This is optional. 

That's it!
