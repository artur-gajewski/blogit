BlogIt
======

BlogIt is an open source blog engine alternative to Blogger and Wordpress and is built on Symfony2 and Bootstrap.

#Requirements

- PHP 5.3 or later
- Symfony2
- MySQL

#Features

- Multilingual UI, currently English and Finnish
- Support for multiple users
- Administration of categories and posts
- WYSIWYG editor
- Many nice Bootstrap3 themes out-of-the-box
- Facebook comments plugin
- Facebook like button

I have published my own blog about reading at [www.kirjablogi.com](http://www.kirjablogi.com) and you are more than welcome to have a look around.
Unfortunately this blog is only in finnish as the main target are finnish book readers.

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
    
Next, you will have to create the database schema for the BlogIt:

    $ app/console doctrine:schema:create

If you are developing BlogIt, you can update your schema with:

    $ app/console doctrine:migrations:migrate

When you make changes to any of the entities, make sure to create migration file:

    $ app/console doctrine:migrations:diff

Make sure you remember to commit the new migration file as well!

#Vagrant

If you want to get development environment setup fast, you can use Vagrant to setup development environment for BlogIt
virtually. All you have to do is run Vagrant as follows:

    $ vagrant up

#Themes

BlogIt comes bundles with numerous Bootsrap 3 themes. In order to change the themes, modify the blog_theme variable in
parameters.yml configuration file taht reflect the folder name present in web/bundles/blogmain/themes folder.

Each theme has its own CSS folder that contains the bootstrap.css file that builds the complete layout and theme.css
which are meant to override certain components in the bootstrap.css definitions.

Themes are kindly provided by Thomas Park and his wonderful project at www.bootswatch.com

#AddSearch implementation

This blog features, along it's own native search function, a possibility to use AddSearch's technology to index the whole
blog and to use their plugin to generate very nice content search based on a search word.

In order to replace the blog's own search function with AddSearch plugin, you must obtain a site specific key from
[www.addsearch.com](http://www.addsearch.com) and insert it into the addsearch_key variable in parameters.yml file.

#Assets

BlogIt uses asset management and thus, you must install the assets.

    $ app/console assets:install

#Creating admin users

In order to be able to administrate your new blog, you must create a user:

	$ php app/console blog:user:create

Enter required information and after the console is done creating your user you are ready to login.

#Parameters

There are many things you can customize in BlogIt in the parameters.yml file:

	blog_theme: Theme of the blog.
	blog_title: Title of the blog which will be visible in the navigation bar and browser's bar.
	blog_hero: Hero unit's big text.
	blog_subhero: Smaller head text under the hero unit.
	blog_copyright: Your copyright name.
	blog_email: email address you want to display to your readers.
	facebook_like_button: Whether you want to enable Facebook button after each post.
	facebook_commenting: Whether you want to enable Facebook comment plugin so that people can comment on your posts.

#RESTful API

If you want to implement blog writings to any third party website, it is very simple to do so by using BlogIt's RESTful API.

Fetch list of posts from newest to oldest: /api/v1/posts

Fetch list of posts from newest to oldest that are currently available: /api/v1/posts?current=true
<br/>
This feature is good for news content on website's front page and you want to only display current news.

Fetch list of posts in chronological order: /api/v1/posts/ordered

Fetch individual post: /api/v1/posts/{postId}

Fetch list of categories: /api/v1/categories

Fetch posts in individual category: /api/v1/categories/{categoryId}

You can test out the API on my personal blog and fetch posts with [www.kirjablogi.com/api/v1/posts](http://www.kirjablogi.com/api/v1/posts)

#If you use BlogIt

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
