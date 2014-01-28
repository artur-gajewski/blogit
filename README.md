BlogIt
======

BlogIt is an open source blog engine alternative to Blogger and Wordpress and is built on Symfony2 and Bootstrap.

#Requirements

- PHP 5.3 or later
- Symfony2
- MySQL

#Installation

Fork the project into your Github account and then clone it into your development environment.

    $ git clone git@github.com:YOUR_GIT_ACCOUNT_NAME/blogit.git

Now go to your newly created directory.

Copy the distribution file for the parameters to your local file:

    $ cp app/config/parameters.yml-dist app/config/parameters.yml

Modify the parameters.yml to reflect your database connections and blog settings of your preference.

Create the following directories inside app folder:

- cache
- logs

Prepare cache, logs folder permissions by running (double check your apache user on the first one):

    $ sudo chmod -Rf +a "daemon allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs
    $ sudo chmod -Rf +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs

If you don't have Composer yet, download it following the instructions on
http://getcomposer.org/ or just run the following command:

    $ curl -s https://getcomposer.org/installer | php

Then, use the `install` command to install all dependencies:

    $ php composer.phar install

After all dependencies are installed, make sure your app/cache and app/logs
folder have write access. If there is no write access, the web server might
output an internal error.

Connect to your database and run these commands:

    CREATE USER 'blogit'@'localhost' IDENTIFIED BY 'secret';
    GRANT ALL PRIVILEGES ON *.* TO 'blogit'@'localhost';

then run the following commands:

    $ app/console doctrine:database:create

#Database migrations

This app comes bundled with Doctrine Migrations bundle, which simplifies the
process of keeping database structure in sync with multiple developers and
production environment.

Migrations bundle checks the structure of your entities and does it's magic
based on that information.

First let's create database based on the values in app/config/parameters.yml file.

    $ app/console doctrine:database:create

After you have created the database, you need to create schema into it. Since we are
using Doctrine migrations, we use the console tool to create the schema from the
migrations files.

    $ app/console doctrine:migrations:migrate

New migration scripts appear when you pull new code from Github. To see if there
are any new migrations required for you to run in your current code version, you need to check the status.

    $ app/console doctrine:migrations:status

If you see new migrations available, all you have to do is run the migrations again.

    $ app/console doctrine:migrations:migrate

You should now have your database in an updated state with up-to-date structure
that corresponds with application's entity classes.

#Assets

BlogIt uses asset management and thus, you must install the assets.

    $ app/console assets:install

#Creating admin users

In order to be able to administrate your new blog, you must create a user:

	$ php app/console fos:user:create

Enter required information and after the console is done creating your user you are ready to login.

#Contributing

We welcome any developers with various skills and background. Anyone is free to join the team and develop BlogIt.

If you want to join the team, please contact me and provide me with your github account ID so that I can add you to the team.

#Welcome

Enjoy and welcome to the project!

Artur Gajewski

info@arturgajewski.com

Skype: artur.t.gajewski
