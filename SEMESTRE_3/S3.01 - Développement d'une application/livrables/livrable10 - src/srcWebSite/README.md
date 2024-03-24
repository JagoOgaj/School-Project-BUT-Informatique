# FinderCine

Bienvenue sur le dépôt GitHub de FinderCine, un site de gestion de films développé en PHP.

## Prérequis

Avant de pouvoir utiliser le site, assurez-vous d'avoir les éléments suivants installés sur votre machine :

- **Serveur Apache :** Le site nécessite un serveur Apache pour fonctionner correctement. Si vous ne l'avez pas déjà installé, vous pouvez le faire en suivant les instructions disponibles sur le site officiel [Apache HTTP Server](https://httpd.apache.org/).

- **PHP :** Assurez-vous d'avoir PHP installé sur votre serveur. Vous pouvez obtenir la dernière version de PHP sur le site officiel de [PHP](https://www.php.net/).

## Configuration de la base de données

1. Creer le fichier `credential.php`.

2. Ouvrez le fichier `credential.php` dans votre éditeur de texte préféré.

3. Modifiez les paramètres de connexion à la base de données (`$dsn`, `$login`, `$mdp`) avec vos propres informations.
```php
#exemple de credential.php
    <?php 
    $dsn = "driver:host=host;dbname=dbName";
    $login = "user";
    $mdp = "pwd";

```

## Comment lancer le site

1. Assurez-vous d'avoir un serveur Apache fonctionnel et PHP installé sur votre machine.

2. Clonez ce dépôt sur votre machine en utilisant la commande suivante :
    ```
    git clone <url>
    ```

3. Placez le dossier cloné dans le répertoire de votre serveur web (par exemple, dans le répertoire `htdocs` pour Apache).

4. Ouvrez votre navigateur web et accédez au site en utilisant l'URL appropriée.

5. Vous devriez maintenant voir le site de gestion de films. Assurez-vous d'avoir correctement configuré la base de données en suivant les étapes ci-dessus.

## Fonctionnalités

- **Recherche Simple :** Permet de rechercher des films ou des acteurs en utilisant des mots-clés.
- **Recherche Approfondie :** Offre une recherche avancée avec des critères supplémentaires tels que le genre, l'année de sortie, etc.
- **Similitudes entre 2 acteurs ou 2 films :** Identifie les similitudes entre deux acteurs ou deux films en fonction de différents critères.
- **Chemin le plus court entre 2 acteurs ou 2 films :** Trouve le chemin le plus court entre deux acteurs ou deux films en utilisant des algorithmes de graphes.
- **Création de compte :** Permet aux utilisateurs de créer un compte sur le site.
- **Historisation des recherches :** Pour les trois fonctionnalités de recherche, les recherches effectuées par les utilisateurs sont historisées s'ils ont un compte.
- **Mise en favori :** Les utilisateurs peuvent marquer leurs contenus préférés (films, acteurs, etc.).
- **Réinitialisation du mot de passe oublié :** Offre la possibilité aux utilisateurs de réinitialiser leur mot de passe s'ils l'ont oublié.
- **Contacter l'assistance :** Les utilisateurs peuvent contacter l'assistance en cas de problème ou de question.


## Contribuer

Si vous souhaitez contribuer à ce projet, n'hésitez pas à créer une nouvelle branche, à effectuer vos modifications, puis à soumettre une demande de fusion.


Merci de contribuer au développement de FinderCine!


---

## Auteurs

- [OKI Samy](https://github.com/Samy93000)
- [Alioui Scander](https://github.com/a-scander)

