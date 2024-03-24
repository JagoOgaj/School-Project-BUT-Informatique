# Convertisseur de fichiers TSV en SQL

Ce script shell permet de décompresser et d'insérer des fichiers TSV dans une base de données PostgreSQL à l'aide de la commande COPY.

## Table des matières

1. [Introduction](#introduction)
2. [Configuration requise](#configuration-requise)
3. [Utilisation](#utilisation)
4. [Exemples](#exemples)

## Introduction

Le script shell `convertisseur.sh` prend en charge la décompression d'un fichier GZ contenant des données TSV, la suppression des guillemets du fichier résultant, et utilise la commande COPY de PostgreSQL pour insérer les données dans une table spécifiée.

## Configuration requise

Avant d'utiliser ce script shell, assurez-vous d'avoir installé PostgreSQL.

## Utilisation

Pour utiliser le script shell, suivez ces étapes :

1. Exécutez le script shell en spécifiant les paramètres nécessaires, tels que le fichier GZ, le nom de la table, l'utilisateur de la base de données, le nom de la base de données et le mot de passe de la base de données.

```bash
./convertisseur.sh fichier.gz nom_table utilisateur_db nom_db mot_de_passe_db

```

---

## Auteurs

- [OKI Samy](https://github.com/Samy93000)
- [Alioui Scander](https://github.com/a-scander)

