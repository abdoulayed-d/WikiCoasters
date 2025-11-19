# Wiki Coaster

## Installation

Cloner le depot: git clone LIEN_DU_DEPOT

Choisir une branche: `git checkout -b tp1 origin/tp1`

Installer les dependances PHP: `composer install`

Installer les dépendances Js/CSS (assets) : `npm install`

Si vous utiliser Docker, lancez Docker Desktop puis démarrez le container: `docker-compose up -d`

Assemblez les assets: `npm run build`

lancez le serveur symfony: `symfony serve`

`git status`
`git add .`
`git commit -m "commentaire de changement du code"`
`git push`

## Base de données

Générer la DB `symfony console doctrine:databas:create`

Créer une migration `symfony console make:migration`

Mettre à jour la DB `sumfony console doctrine:migrations:migrate`
