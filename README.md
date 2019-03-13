# api

bdd : apiphp

//initialisation projet

composer install

php bin/console d:m :m

php bin/console d:f:l


//install web pack

composer require encore

yarn install

  //Code js
  
  Créer fichier js dans : "assets/js"
  Indiquer ce fichier dans "webpack.config.js" à la racine du projet : ".addEntry('xxx', './assets/js/xxx.js')"
  Puis lancer commande : "yarn encore dev"  --->  Ca va créer les fichiers js dans public/build/js
  
  et yarn encode dev --watch : Pour que chaque modif dans un fichier js ( dans assets/js) soit déversée dans public/build/js

