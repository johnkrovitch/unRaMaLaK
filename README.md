unRamalak and Gmf Installation
========================

What's n3w ?

> Working on gmf

> Tentative d'implémentation d'évènements dans le gmf pour gérer les chargements d'entités du modèle par exemple, je pense...


1) Cloning repository
----------------------------------

Run :

    mkdir unRamalak && cd unRamalak

    git clone https://github.com/johnkrovitch/unRaMaLaK.git .


2) Installing with composer
----------------------------------

http://getcomposer.org/ or just run the following command:

    curl -s http://getcomposer.org/installer | php

    php composer.phar update


2) Checking your System Configuration
-------------------------------------

Before starting coding, make sure that your local system is properly
configured for Symfony.

Execute the `check.php` script from the command line:

    php app/check.php

Access the `config.php` script from a browser:

    http://localhost/path/to/symfony/app/web/config.php

If you get any warnings or recommendations, fix them before moving on.


3) Setting
--------------------------------

Copy & rename app/config/parameters-dist.yml to app/config/parameters.yml
and set your own parameters, for database for example.

4) Running PHPUnit tests
--------------------------------

Run:

    app/console krovitch:test