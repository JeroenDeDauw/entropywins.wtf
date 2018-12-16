# entropywins.wtf website

[![Build Status](https://travis-ci.org/JeroenDeDauw/entropywins.wtf.svg)](https://travis-ci.org/JeroenDeDauw/entropywins.wtf)

This repo contains the resources of the [entropywins.wtf website](https://entropywins.wtf).

## Development

The application is build on top of the Symfony 4 PHP web framework.

Development is done via Docker. No local PHP installation is needed.

### Installing the application

    make install

### Running the application

In the root of the project, execute this to start the Docker containers:

    docker-compose up

After the command finished, you can view the application at http://localhost:8042

### Stopping the application

In the root of the project, execute this to stop the Docker containers:

    docker-compose down

### Executing PHP (including tests)
    
Running the tests (includes PHPUnit)

	make test
   
Running the style checks

	make cs
   
Full CI run

	make ci

You can get a shell from which you can interact with Symfony via PHP. Though beware that this is executed as root,
and that newly created files will be owned by root.

    docker-compose exec php-fpm bash
    
## Deployment

Standard deployment practices for Symfony 4 applications can be followed. See
[How to Deploy a Symfony Application](https://symfony.com/doc/current/deployment.html)

However since the website does not currently have a database or uses compiled assets, many steps can be skipped.

Get a clone of the git repository

	git clone git@github.com:JeroenDeDauw/entropywins.wtf.git
	
Then follow steps A through D from the section
"[Common Post-Deployment Tasks](https://symfony.com/doc/current/deployment.html#common-post-deployment-tasks)".

### Updating to a new version

1. `git pull` - get the latest version of the site
2. `composer install` - install the dependencies (`make install` if you have Docker instead of PHP)
