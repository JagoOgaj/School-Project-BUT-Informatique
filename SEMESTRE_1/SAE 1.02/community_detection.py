##############
# SAE S01.01 #
##############

def liste_amis(amis, prenom):
    """
        Retourne la liste des amis de prenom en fonction du tableau amis.
    """
    prenoms_amis = []
    i = 0
    while i < len(amis)//2:
        if amis[2 * i] == prenom:
            prenoms_amis.append(amis[2*i+1])
        elif amis[2*i+1] == prenom:
            prenoms_amis.append(amis[2*i])
        i += 1
    return prenoms_amis

def nb_amis(amis, prenom):
    """ Retourne le nombre d'amis de prenom en fonction du tableau amis. """
    return len(liste_amis(amis, prenom))


def personnes_reseau(amis):
    """ Retourne un tableau contenant la liste des personnes du réseau."""
    people = []
    i = 0
    while i < len(amis):
        if amis[i] not in people:
            people.append(amis[i])
        i += 1
    return people

def taille_reseau(amis):
    """ Retourne le nombre de personnes du réseau."""
    return len(personnes_reseau(amis))

def lecture_reseau(path):
    """ Retourne le tableau d'amis en fonction des informations contenues dans le fichier path."""
    f = open(path, "r", encoding="utf-8")
    l = f.readlines()
    f.close()
    amis = []
    i = 0
    while i < len(l):
        fr = l[i].split(";")
        amis.append(fr[0].strip())
        amis.append(fr[1].strip())
        i += 1
    return amis

def dico_reseau(amis):
    """ Retourne le dictionnaire correspondant au réseau."""
    dico = {}
    people = personnes_reseau(amis)
    i = 0
    while i < len(people):
        dico[people[i]] = liste_amis(amis, people[i])
        i += 1
    return dico

def nb_amis_plus_pop (dico_reseau):
    """ Retourne le nombre d'amis des personnes ayant le plus d'amis."""
    personnes = list(dico_reseau)
    maxi = len(dico_reseau[personnes[0]])
    i = 1
    while i < len(personnes):
        if maxi < len(dico_reseau[personnes[i]]):
            maxi = len(dico_reseau[personnes[i]])
        i += 1
    return maxi


def les_plus_pop (dico_reseau):
    """ Retourne les personnes les plus populaires, c'est-à-dire ayant le plus d'amis."""
    max_amis = nb_amis_plus_pop(dico_reseau)
    most_pop = []
    personnes = list(dico_reseau)
    i = 1
    while i < len(personnes):
        if len(dico_reseau[personnes[i]]) == max_amis:
            most_pop.append(personnes[i])
        i += 1
    return most_pop

##############
# SAE S01.02 #
##############

def create_network(list_of_friends):
    """
    Crée un dictionnaire représentant un réseau social à partir d'un tableau de paires d'amis.
    
    Paramètres:
    - tableau (list): un tableau contenant des paires d'amis. Chaque élément du tableau doit être une paire d'amis (deux chaînes de caractères).

    Retourne:
    dict: un dictionnaire représentant un réseau social, avec les noms des personnes en tant que clés et les listes d'amis de ces personnes en tant que valeurs.
    """
    
     # Initialisation d'un dictionnaire vide
    network = {}
    # Initialisation d'un compteur pour parcourir les paires d'amis du tableau
    i = 0
    while i < len(list_of_friends):
        # Vérifie si la première personne de la paire n'est pas déjà dans le dictionnaire
        if not list_of_friends[i] in network:
            # Si non, ajout de cette personne dans le dictionnaire avec son ami en valeur
            network[list_of_friends[i]] = [list_of_friends[i+1]]
            # Ajout de l'ami dans le dictionnaire avec la première personne en valeur
            network[list_of_friends[i+1]] = [list_of_friends[i]]
        else:
             # Ajout de l'ami à la liste d'amis de la première personne déjà présente dans le dictionnaire
            network[list_of_friends[i]].append(list_of_friends[i+1])
            # Vérifie si l'ami n'est pas déjà dans le dictionnaire
            if not list_of_friends[i+1] in network:
                # Si non, ajout de cet ami dans le dictionnaire avec la première personne en valeur
                network[list_of_friends[i+1]] = [list_of_friends[i]]
            else:
                # Ajout de la première personne dans la liste d'amis de l'ami déjà présent dans le dictionnaire
                network[list_of_friends[i+1]].append(list_of_friends[i])
        i += 2
     # Retourne le dictionnaire
    return network

def get_people(network):
    """
    Retourne la liste des noms des personnes dans le réseau social.

    Paramètres:
    network (dict): un réseau social représenté sous forme de dictionnaire, où les clés sont les noms des personnes et les valeurs sont les listes d'amis de ces personnes.
    
    Retourne:
    list: une liste contenant les noms des personnes dans le réseau social.
    """
    
    return list(network)

def are_friends(network, person1, person2):
    """
    Vérifie si person1 et person2 sont amis dans le réseau passé en paramètre.

    Paramètres:
    network (dict): Le réseau représenté sous forme de dictionnaire où les clés sont les noms des personnes et les valeurs sont des listes contenant leurs amis.
    person1 (str): Le nom de la première personne.
    person2 (str): Le nom de la deuxième personne.

    Retourne:
    bool: True si person1 et person2 sont amis, False sinon.
    """
    
    # On vérifie si person2 est dans la liste des amis de person1
    if person2 in network[person1]:
        return True
    return False

def all_his_friends(network, person, group):
    """
    Vérifie si toutes les personnes du groupe donné en paramètre sont amies avec la personne donnée en paramètre dans le réseau donné en paramètre.

    Paramètres:
    network (dict): Le réseau représenté sous forme de dictionnaire où les clés sont les noms des personnes et les valeurs sont des listes contenant leurs amis.
    person (str): Le nom de la personne (chaîne de caractères).
    group (list): Un groupe de personnes représentées par des chaînes de caractères (les noms de chaque personne).

    Retourne:
    bool: True si toutes les personnes du groupe sont amies avec la personne, False sinon.
    """
    
    i = 0
    error = True
    
    # On parcourt tous les éléments du groupe
    while i < len(group) and error:
        
        # Si la personne n'est pas amie avec un élément du groupe, on renvoie False
        if not are_friends(network, person, group[i]):
            error = False
        i += 1
        
    # Si la personne est amie avec tous les éléments du groupe, on renvoie True
    return error

def is_a_community(network, group):
    """
    Vérifie si le groupe de personnes passé en paramètre forme une communauté dans le réseau donné en paramètre.

    Paramètres:
    network (dict): Le réseau représenté sous forme de dictionnaire où les clés sont les noms des personnes et les valeurs sont des listes contenant leurs amis.
    group (list): Un groupe de personnes représentées par des chaînes de caractères (les noms de chaque personne).

    Retourne:
    bool: True si le groupe de personnes forme une communauté dans le réseau, False sinon.
    """
    
    # On parcourt chaque personne du groupe
    i = 0
    while i < len(group):
        # On crée une copie du groupe sans la personne courante
        tmp = group.copy()
        del(tmp[i])
        # On vérifie que la personne courante est amie avec toutes les autres personnes du groupe
        if not all_his_friends(network, group[i], tmp):
            return False
        # On passe à la personne suivante
        i += 1
    # Si toutes les personnes du groupe sont amies entre elles, alors le groupe est une communauté
    return True


def find_community(network, group):
    """
    Trouve une communauté de personnes dans le réseau passé en paramètre parmi les personnes du groupe donné en paramètre.

    Paramètres:
    network (dict): Le réseau représenté sous forme de dictionnaire où les clés sont les noms des personnes et les valeurs sont des listes contenant leurs amis.
    groupe (list): Un groupe de personnes représentées par des chaînes de caractères (les noms de chaque personne).

    Retourne:
    list: Une liste de chaînes de caractères représentant les noms des personnes de la communauté trouvée dans le réseau.
    """
    
    # On crée une liste vide pour stocker les personnes de la communauté trouvée
    tab = []
    # On ajoute la première personne du groupe à la communauté
    tab.append(group[0])
    # On parcourt le reste du groupe
    i = 1
    while i < len(group):
        # On vérifie si la personne actuelle est amie avec tous les membres de la communauté
        if are_friends(network, group[0], group[i]):
            # Si c'est le cas, on l'ajoute à la communauté
            tab.append(group[i])
        # On passe à la personne suivante
        i+=1
    # On retourne la communauté trouvée
    return tab

def order_by_decreasing_popularity(network, group):
    """
    Trie le groupe de personnes passé en paramètre selon leur popularité décroissante dans le réseau donné en paramètre.

    Paramètres:
    network (dict): Le réseau représenté sous forme de dictionnaire où les clés sont les noms des personnes et les valeurs sont des listes contenant leurs amis.
    group (list): Un groupe de personnes représentées par des chaînes de caractères (les noms de chaque personne).

    Retourne:
    list: Une liste de chaînes de caractères représentant les noms des personnes du groupe triées selon leur popularité décroissante dans le réseau.
    """
    
    # Initialisation d'une liste vide qui va contenir les personnes du groupe triées par popularité décroissante
    result = []
    # On crée une copie de la liste de personnes à trier
    tmp = group.copy()
    # On parcourt la liste des personnes du groupe
    j = 0
    while j < len(group):
        # On cherche la personne la plus populaire (c'est-à-dire celle qui a le plus d'amis) parmi celles qui restent à trier
        i = 0
        iindex = 0
        while i < len(tmp):
            if len(tmp[i]) < len(tmp[iindex]):
                iindex = i
            i += 1
        # On ajoute la personne la plus populaire trouvée à la liste de résultat
        result.append(tmp[iindex])
        # On retire la personne la plus populaire de la liste de personnes à trier
        tmp.pop(iindex)
        j += 1
    # On retourne la liste de personnes triée
    return result


def find_community_by_decreasing_popularity(network):
    """
    Trouve une communauté dans le réseau donné en triant les personnes dans le réseau par popularité décroissante et en retournant la communauté trouvée en appliquant l'heuristique de trouver une communauté maximale.

    Paramètres:
    network (dict): Le réseau représenté sous forme de dictionnaire où les clés sont les noms des personnes et les valeurs sont des listes contenant leurs amis.

    Retourne:
    list: Une liste de chaînes de caractères représentant les noms des personnes de la communauté trouvée.
    """
    
    # trouve la communauté maximale en parcourant toutes les personnes du réseau
    x = find_community(network, list(network))
    
    # trie la communauté trouvée en fonction de la popularité décroissante de chaque personne
    result = order_by_decreasing_popularity(network, x)
    
    # retourne la communauté triée
    return result

def find_community_from_person(network, person):
    """ Retourne une communauté maximale contenant la personne spécifiée selon l'heuristique """
    
    community = [person]
    
    friends = network[person]
    
    friends = order_by_decreasing_popularity(network, friends)
    
    i = 0
    while i < len(friends):
        community.append(friends[i])
        i += 1
   
    return community

def find_max_community(network):
    """
    Recherche la communauté ayant le plus grand nombre de personnes dans le réseau passé en paramètre.

    Paramètres:
    network (dict): Le réseau représenté sous forme de dictionnaire où les clés sont les noms des personnes et les valeurs sont des listes contenant leurs amis.

    Retourne:
    list : La liste de personnes de la communauté ayant le plus grand nombre de personnes.
    """
    
    # Initialisation d'un tableau pour stocker les différentes communautés
    tab = []
    # Récupération de la liste des clés (personnes) du réseau
    keys = list(network)
    # Initialisation d'un compteur pour parcourir les personnes du réseau
    i = 0
    # Boucle while pour parcourir les personnes du réseau
    while i < len(keys) :
        # Recherche de la communauté à partir d'une personne donnée
        x = find_community_from_person(network, keys[i])
        # Ajout de la communauté trouvée dans le tableau
        tab.append(x)
        # Incrémentation du compteur
        i+=1
    # Recherche de la communauté ayant le plus grand nombre de personnes dans le tableau
    t = max(tab)
    # Tri de la communauté ayant le plus grand nombre de personnes
    t.sort()
    # Retourne la communauté ayant le plus grand nombre de personnes
    return t