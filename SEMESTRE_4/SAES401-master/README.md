# Jeu dont vous êtes le héros

![Page principal](images/main.png)

## Contexte
Comme dans les “livres dont vous êtes le héros”, ce projet vise à améliorer une application existante pour permettre l'intégration de scénarios échangeables. Les utilisateurs pourront ainsi naviguer entre différentes situations, collecter des objets uniques et affronter des adversaires, tout en influençant le déroulement de leur aventure par leurs choix.

## Sources
Les données nécessaires sont disponibles sur le [moodle R4A11](https://moodlelms.univ-paris13.fr/course/view.php?id=6724).

La programmation se fera obligatoirement avec Android Studio. Un serveur sera mis à disposition pour héberger les assets au fur et à mesure de l'avancée du projet.

Divers logiciels seront nécessaires pour la soumission des livrables. Ce document sera complété au fur et à mesure de l'avancement du projet.

## Livrables
- **Composition de l’équipe** : Groupe de 3 ou 4 personnes, planification des rôles (texte, 19 avril 2024, rendu collectif)
  - Compétence 5
- **Documentation JSON** : Explication du codage des “aventures” au format JSON (texte, 19 avril 2024, rendu collectif)
- **Mécanisme de bagarre** : Proposition et étude statistique des résultats (texte, 26 avril 2024, rendu collectif)
- **Aventure test** : Proposition d’une aventure test pour essayer le jeu (fichiers informatiques, 26 avril 2024, rendu collectif, rendu évolutif)

## Besoins de l'application
### Jeu
Le jeu permet aux joueurs de se déplacer d’une situation à une autre, de collecter des objets uniques, et d’affronter des adversaires. Chaque lieu propose des choix permettant de naviguer vers d’autres situations, avec des rencontres débloquant des situations supplémentaires.

### Possibilités offertes
#### Objets
Les objets sont uniques et définis par une description textuelle, un identifiant, et une icône PNG 32x32. Certains choix sont accessibles uniquement si le joueur possède certains objets. Les objets peuvent être acquis, affichés pour débloquer des choix, et détruits en fonction des situations.

![Icônes des objets](images/objets.png)

#### Rencontres
Les rencontres, associées à chaque situation, sont décrites sous forme de tableau et activent un mode combat interactif. Les combats utilisent des scores chiffrés (entre 1 et 6) et une composante aléatoire, dépendant des objets possédés par le joueur. Les résultats de rencontres débloquent des situations spécifiques et peuvent entraîner l’acquisition d’objets uniques.

![Exemple de rencontre](images/rencontre.png)

#### Statistiques
Chaque partie jouée est stockée pour des analyses statistiques. Cela permet de suivre les performances des joueurs, d'identifier les tendances et d'améliorer le jeu en conséquence.

![Statistiques des parties](images/statistiques.png)

#### Page de paramètres
L'application inclut une page de paramètres où les utilisateurs peuvent personnaliser leur expérience de jeu. Les paramètres disponibles incluent la configuration des sons, la gestion des notifications, et d'autres options de personnalisation.

![Page de paramètres](images/parametres.png)

![Page de paramètres](images/you_lost.png)

## Équipe de projet
Ce projet est réalisé par :
- Samy OKI
- Scander ALIOUI
- Zakaria CHAOUI

Étudiants en deuxième année de BUT informatique en Alternance à l'Université Paris 13.

## Remerciements
Merci à l'équipe pédagogique pour leur soutien continu et les ressources mises à notre disposition.
