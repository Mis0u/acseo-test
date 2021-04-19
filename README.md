## Acseo Test



Afin d'utiliser ce projet vous devrez :
* Effectuer un git clone du projet
* Vous placer à la racine du projet et exécuter :
```
composer install
```
* Une fois l'installation terminée, vous devrez effectuer les modifications nécessaire dans le fichier .env afin de créer votre BDD.
* Dès que les informations ont été renseignés, veuillez exécuter :
```
php bin/console doctrine:create:database
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load -n
```

J'ai utilisé Webpack Encore, il faudra donc installer yarn (yarn install) ou npm (npm install) selon votre préférence. Une fois installé, exécuté :
```
yarn dev

```

Lancer votre serveur est aller à l'url "/contact" pour faire une demande et pour la connexion, rendez-vous sur l'url '/connexion'
id => admin@example.com
password => pass_1234

*Version utilisée de SYmfony => 5.2*
*Version utilisée de PHP =>7.4.5*
