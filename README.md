BlogIt
======

BlogIt is an open source blog engine alternative to Blogger and Wordpress and is built on Symfony2 and Bootstrap.

#Requirements

- PHP 5.3 or later
- Symfony2
- MySQL

#Installation

To install BlogIt to your server, go to desired folder of installation and clone the project from Github:

    $ git clone git@github.com:artur-gajewski/blogit.git

If you want to contribute to the project, please fork it into your Github account and then clone it into your development environment.

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
    
Finally, you will have to create the database schema for the BlogIt:

    $ app/console doctrine:schema:create

#Themes

BlogIt comes bundles with numerous Bootsrap 3 themes. In order to change the themes, modify the blog_theme variable in
parameters.yml configuration file taht reflect the folder name present in web/bundles/blogmain/themes folder.

Each theme has its own CSS folder that contains the bootstrap.css file that builds the complete layout and theme.css
which are meant to override certain components in the bootstrap.css definitions.

Themes are kindly provided by Thomas Park and his wonderful project at www.bootswatch.com

#Assets

BlogIt uses asset management and thus, you must install the assets.

    $ app/console assets:install

#Creating admin users

In order to be able to administrate your new blog, you must create a user:

	$ php app/console fos:user:create

Enter required information and after the console is done creating your user you are ready to login by adding /login to
the end of the main page's URL. So if your blog is installed at www.blogit-site.com then the access point to user login will
be www.blogit-site.com/login

#Usage

If you end up installing your own instance of BlogIt, I kindly ask you to send me a quick note about it. I would love
to see this blog engine in action some where in the world :)

#Contributing

We welcome any developers with various skills and background. Anyone is free to join the team and develop BlogIt.

If you want to join the team, please contact me and provide me with your github account ID so that I can add you to the team.

#Welcome

Enjoy and welcome to the project!

Artur Gajewski

info@arturgajewski.com

Skype: artur.t.gajewski
