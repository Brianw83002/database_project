# Install these 
   [Install php 8.2](https://windows.php.net/downloads/releases/php-8.2.28-Win32-vs16-x64.zip)
   [Install MySql](https://dev.mysql.com/get/Downloads/MySQLInstaller/mysql-installer-community-8.0.41.0.msi)
   [video for how to install php(the path should be for the User, NOT system!)](https://www.youtube.com/watch?v=n04w2SzGr_U&ab_channel=Novuspad)

   make sure the php folder is name php_8.2.28 
    adjust the path accordingly  

# After installing all of them
    copy the file named "php.ini" from this repo
    past it into your php folder

# Setup
    in the setup for mysqlWorkbench, select:

    Custom -> most recent versions of Server and most recent version of Workbench

    set a password

    in connect.php set the password to be the same password you use

# in Workbench:
    create a query by copying all the text in createTables.txt and pasting it to workbench  
    run the query to set up the tables

# to run
    access the folder this file is in inside the terminal
    
    use the command: php -S localhost:5500

    go to http://localhost:5500/connect.php
   
