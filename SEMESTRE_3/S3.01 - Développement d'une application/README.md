# Table des matières

1. [Contexte](#contexte)
2. [Sources](#sources)
3. [Livrables](#livrables)
   1. [Composition de l’équipe, planification de la répartition du rôle de manager, mise en place d’un dépôt de code accessible aux membres de l’équipe et à l’équipe pédagogique](#livrable-1)
   2. [Analyse des conditions juridiques d’utilisation des données initiales](#livrable-2)
   3. [Mise en place d’une plateforme de développement avec les logiciels recommandés](#livrable-3)
   4. [Analyse de la base de données fournie et création de schémas SQL correspondant ; scripts shells de récupération des données les plus récentes et chargement/remplacement dans la base](#livrable-4)
   6. [Création d’un rapport de management pour la période dont vous allez être responsable détaillant la répartition et la planification des tâches, ainsi que l’évaluation individuelles de ces tâches par le manager](#livrable-6)
   8. [Rapport sur trois algorithmes au sein de l’application](#livrable-8)
   10. [Première démonstration de l’application fonctionnelle](#livrable-10)
4. [Besoins de l’application](#besoins-de-lapplication)
   1. [Présentation d'information](#presentation-dinformation)
   2. [Recherche](#recherche)
   3. [Trouver des films ou personnes en commun](#trouver-des-films-ou-personnes-en-commun)
   4. [Rapprochement de films](#rapprochement-de-films)

# Contexte

Une base de données contenant un grand nombre d’informations sur la production cinématographique et audiovisuelle est en accès libre. Le but de cette SAÉ sera de construire une application complète permettant de mettre en place ces informations dans un système d’information et de présenter des informations à la communauté d’utilisation, à la fois des informations brutes issues de la base ou des informations calculées à partir de ces données.

## Sources

Les données sont disponibles à l’adresse suivante : [https://www.imdb.com/interfaces/](https://www.imdb.com/interfaces/). Il est également recommandé (mais ce n’est pas obligatoire) d’utiliser les sources suivantes pour l’application :

- PHP
- Bootstrap + Bootstrap icons
- JQuery pour la partie présentation si nécessaire
- Un serveur web (par exemple apache2)

Divers logiciels vous seront aussi nécessaires pour rendre vos livrables.

## Livrables

1. **Composition de l’équipe, planification de la répartition du rôle de manager, mise en place d’un dépôt de code accessible aux membres de l’équipe et à l’équipe pédagogique** (texte, 16 octobre 2023, rendu collectif) (Compétence 5)

2. **Analyse des conditions juridiques d’utilisation des données initiales** (format : texte, 17 novembre 2023, rendu individuel) (Compétence 4 / Compétence 6)

3. **Mise en place d’une plateforme de développement avec les logiciels recommandés** (format: texte explicatif ; 20 octobre 2023, rendu collectif) (Compétence 1 / Compétence 3)

4. **Analyse de la base de données fournie et création de schémas SQL correspondant ; scripts shells de récupération des données les plus récentes et chargement/remplacement dans la base** (format : scripts shells ; schémas SQL ; graphiques UML ; indicateurs de performance (temps de chargement, récupération, etc.) ; rendu collectif, 22 décembre 2023) (Compétence 3 / Compétence 4)

5. **Création de rapports individuels évolutifs sur le travail réalisé** (format : texte mis en page ; à la fin de chaque période de deux semaines, rendu individuel) (Compétence 1 / Compétence 6)

6. **Création d’un rapport de management pour la période dont vous allez être responsable détaillant la répartition et la planification des tâches, ainsi que l’évaluation individuelles de ces tâches par le manager** (rendu individuel au début de la période suivant la période où un élève remplit le rôle de manager). (Compétence 5 / Compétence 6). Précisions: à faire avec le logiciel de votre choix (Excel par exemple), inclure des diagrammes de Gantt, des tableaux de suivi, etc.

7. **Création de personas de clients susceptibles d’utiliser le site** (17 novembre 2023, ; rendu individuel) (Compétence 1 / Compétence 5)

8. **Rapport sur trois algorithmes au sein de l’application** (approximation d’un nom ; trouver des éléments en commun dans deux listes de façon optimale ; trouver la plus courte chaîne entre deux éléments dans le graphe “a joué dans”) (rendu collectif ; 19 janvier 2024) (Compétence 2)

9. **Prototypage de l’application** (tâches à effectuer, user stories, scénarios, design, présentation de prototype avec des logiciels de type Figma, Balsamiq ou autres ; rendu 22 décembre 2023). (Compétence 1)

10. **Première démonstration de l’application fonctionnelle** (16 février 2024) (Compétence 1 / Compétence 2 / Compétence 4)



# Besoins de l’application

## Présentation d'information

L’application doit permettre la présentation d’information sur les personnes et les films présents dans les données (attention, certains films sont en fait des séries et ont des épisodes). Lorsque c’est pertinent, il faut pouvoir passer d’une fiche à une autre.

## Recherche

Il faut pouvoir chercher une personne par son nom, son prénom ou un film par son titre, en recherche simple, et proposer une recherche avancée qui permet de sélectionner par d’autres critères (plage de temps pour la naissance d’une personne ou pour la création d’un film, par exemple). La recherche avancée doit pouvoir permettre de trouver une ressemblance approximative.

Les résultats pourront être triés selon différents critères (en particulier : date, ordre alphabétique, etc.)

## Trouver des films ou personnes en commun

Après avoir sélectionné deux films ou deux personnes, trouver les personnes (ou les films) en commun pour les deux. Par exemple, Thierry Lhermitte et Gérard Jugnot ont joués tous les deux dans Fallait Pas, Grosse Fatigue, Le père Noël est une ordure, Les 1001 nuits, Les Bronzés, Les Bronzés font du ski, Les Bronzés 3, Les Secrets professionnels du Dr Apfelglück, Papy fait de la résistance, Trafic d’influence, Vous n’aurez pas l’Alsace et la Lorraine.

## Rapprochement de films

On veut pouvoir relier deux films ou personnes par une chaîne de personnes et films la plus courte possible suivant la relation “X a participé au film Y”. Par exemple, on peut passer de John Travolta à Harrison Ford en passant par Pulp Fiction, Rosanna Arquette, Le Grand Bleu, Jean Reno, Léon, Natalie Portman, Star Wars III : Revenge of the Sith, Ewan McGregor, Star Wars VII : The Force Awakens, Harrison Ford. Est-ce qu’il y a plus court ?



---

## Auteurs

- [OKI Samy](https://github.com/Samy93000)
- [Alioui Scander](https://github.com/a-scander)

