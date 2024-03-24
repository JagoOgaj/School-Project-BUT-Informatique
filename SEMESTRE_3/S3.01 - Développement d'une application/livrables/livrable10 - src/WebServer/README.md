# FinderCine Python Api

Bienvenue sur le backend de FinderCine, responsable des fonctionnalités de rapprochement et de recherche via une API en utilisant Flask et une base de données PostgreSQL.

## Prérequis

Assurez-vous d'avoir les éléments suivants installés sur votre machine :

- **Python :** certaines fonctionnalités sont écrit en Python. Vous pouvez télécharger Python sur [le site officiel](https://www.python.org/downloads/).

- **Flask :** Utilisez la commande suivante pour installer Flask :
    ```python
    pip install Flask
    #ou
    pip3 install Flask
    ```

- **Psycopg2 :** Psycopg2 est utilisé pour la connexion à la base de données PostgreSQL. Vous pouvez l'installer avec :
    ```python
    pip install psycopg2
    #ou
    pip3 install psycopg2
    ```

## Configuration

Assurez-vous de configurer votre fichier `config.py` avec les détails de votre base de données PostgreSQL. Utilisez la fonction `get_db_config()` pour récupérer la configuration.

```python
# Exemple de config.py

def get_db_config():
    db_config = {
        'host': "localhost",
        'user': "votre_utilisateur",
        'password': "votre_mot_de_passe",
        'database': "votre_base_de_donnees"
    }
    return db_config
```

## Utilisation

1. Exécutez le fichier `main.py` pour lancer le serveur Flask.

    ```python
    python main.py
    #ou
    python3 main.py
    ```

2. Le serveur démarrera sur `http://localhost:5001`. Assurez-vous que le serveur Apache pour votre site de films est en cours d'exécution.

## Endpoints

- **/test (GET) :** Vérifiez si le serveur est en cours d'exécution.

- **/result (POST) :** Endpoint pour le rapprochement d'acteurs ou de films. Envoyez un JSON avec les paramètres nécessaires.

- **/trouver (POST) :** Endpoint pour la recherche. Envoyez un JSON avec les éléments à rechercher.


N'oubliez pas de personnaliser les informations selon les besoins spécifiques de votre projet, y compris le fichier de configuration `config.py` et les détails de votre base de données.

---

## Auteurs

- [OKI Samy](https://github.com/Samy93000)
- [Alioui Scander](https://github.com/a-scander)

