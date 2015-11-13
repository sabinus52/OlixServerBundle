OlixServerBundle
================

Security bundle for Symfony2 with server management


Installation
------------


### Etape 1 : Télécharger OlixServerBundle avec composer

Ajouter OlixServerBundle en executant la commande :

``` bash
$ php composer.phar require olix/server-bundle "dev-master"
```


### Etape 2 : Activer le bundle

Activer le bundle dans le kernel :

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Olix\ServerBundle\OlixServerBundle(),
    );
}
```


### Etape 3 : Importer le fichier de routage

Importer le routage suivant pour inclure toutes les routes

``` yaml
# app/config/routing.yml
olix_admin_server:
    resource: "@OlixServerBundle/Resources/config/routing.yml"
```



Utilisation du module MONIT
---------------------------

Activer le serveur http de monit dans le fichier de configuration `/etc/monit/monitrc`.
**Le port doit être obligatoirement `2812`**

```
set httpd port 2812 and
#    use address localhost  # only accept connection from localhost
#    allow 192.168.1.0/24       # allow localhost to connect to the server and
#    allow admin:monit      # require user 'admin' with password 'monit'
#    allow @adm           # allow users of group 'monit' to connect (rw)
#    allow @sudo readonly  # allow users of group 'users' to connect readonly
```

et configurer le à votre convenance https://mmonit.com/monit/documentation/monit.html#MONIT-HTTPD



Utilisation du module COLLECTD
------------------------------

Configurer Apache de cette manière pour accéder au script en local.

```
ScriptAlias /rtm /usr/share/doc/collectd/examples/php-collection
<Directory /usr/share/doc/collectd/examples/php-collection>
    Require local
</Directory>
```

**L'alias doit être obligatoirement `rtm`**


