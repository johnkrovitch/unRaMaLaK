unRamalak and Gmf Installation
========================

1) Cloning repository
----------------------------------

Run :

    mkdir unRamalak && cd unRamalak

    git clone https://github.com/johnkrovitch/unRaMaLaK.git .

    cd Symfony


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


4) Running PHPUnit tests
--------------------------------

Run:

    app/console krovitch:test