import psycopg2
import threading
import queue
import time
from dataclasses import dataclass, field


@dataclass
class rapoFilm:
    tconstDebut : str
    tconstFin : str
    mode: str
    config: dict
    modeSql: list = field(default_factory=lambda: [])
    resultQueue : queue.Queue = field(default_factory=queue.Queue)
    resultPath: queue.Queue = field(default_factory=queue.Queue)
    multiPathForMultiMatch: queue.Queue = field(default_factory=queue.Queue)
    condition : threading.Condition = field(default_factory=threading.Condition)
    traitementAccepter: bool = field(default_factory=lambda: False)
    cheminF: tuple = field(default_factory=lambda: ())
    i: int = field(default_factory=lambda: 0)
    dic_debut: dict = field(default_factory=lambda: {})
    dic_fin: dict = field(default_factory=lambda: {})
    chemin_debut: list = field(default_factory=lambda: [])
    chemin_fin: list = field(default_factory=lambda: [])
    con: psycopg2.extensions.connection = field(init=False)
    branchTraiteThreadDebut: dict = field(default_factory=lambda: {}) 
    branchTraiteThreadFin: dict = field(default_factory=lambda: {}) 
    listeForGetNextBegin: list = field(default_factory=lambda: [])
    listeForGetNextEnd: list = field(default_factory=lambda: [])

    def __post_init__(self):
    
        self.con = self.getCon()
    
    def getCon(self) -> psycopg2.connect:
    
        con = psycopg2.connect(
            host=self.config['host'],
            database=self.config['database'],
            user=self.config['user'],
            password=self.config['password']
        )

        return con


    def communNode(self) -> list:
    
        return list(set(self.dic_debut[len(self.dic_debut)-1]) & set(self.dic_fin[len(self.dic_fin)-1]))
    
    def communBranch(self) -> dict:
    
        result = {}
        dic_debut = {}
        dic_fin = {}
        keys_1 = self.dic_debut[len(self.dic_debut) - 1].keys()
        keys_2 = self.dic_fin[len(self.dic_fin) - 1].keys()
        for k in keys_1:
            for key in keys_2:
                commun = list(set(self.dic_debut[len(self.dic_debut)-1][k]) & set(self.dic_fin[len(self.dic_fin)-1][key]))
                if commun :
                    dic_debut[k]=commun
                    dic_fin[key]=commun
                    result["debut"]=dic_debut
                    result["fin"]=dic_fin
                    result["commun"]=commun
        return result
    
    def checkBranchDebut(self, branch: str) -> bool:
        if branch in self.branchTraiteThreadDebut and self.i - self.branchTraiteThreadDebut[branch] >=2:
            return False
        else :
            self.branchTraiteThreadDebut[branch] = self.i
            return True
        
    def checkBranchFin(self, branch: str) -> bool:
        if branch in self.branchTraiteThreadFin and self.i - self.branchTraiteThreadFin[branch] >=2:
            return False
        else :
            self.branchTraiteThreadFin[branch] = self.i
            return True
    def findKeyFromSpecificDict(self, dic: dict, val: str):
        return [key for key, value in dic.items() if val in value]
        
    def findKeysWithValueBegin(self, val: str):
        resultForBegin: list = []
        for global_key, inner_dict in self.dic_debut.items():
            for local_key, value_list in inner_dict.items():
                if val in value_list:
                    resultForBegin.append([global_key, local_key, val])
        return resultForBegin
    
    def findKeysWithValueEnd(self, val: str):
        resultForEnd: list = []
        for global_key, inner_dict in self.dic_fin.items():
            for local_key, value_list in inner_dict.items():
                if val in value_list:
                    resultForEnd.append([global_key, local_key, val])
        return resultForEnd
    
    def getNextIndexBegin(self, vals: list):
        for val in vals :
            result: int = self.findKeysWithValueBegin(val)
            if len(result) > 1 :
                if not min(result) in self.listeForGetNextBegin:
                    self.listeForGetNextBegin.append(min(result))
        
        result = min(self.listeForGetNextBegin)
        index = result[0]
        self.chemin_debut.append(result[2])
        self.chemin_debut.append(result[1])
        return [index, result[1]]
    
    def getNextIndexEnd(self, vals: list):
        for val in vals :
            result: int = self.findKeysWithValueEnd(val)
            if len(result) > 1 :
                if not min(result) in self.listeForGetNextEnd:
                    self.listeForGetNextEnd.append(min(result))
        
        result = min(self.listeForGetNextEnd)
        index = result[0]
        self.chemin_fin.append(result[2])
        self.chemin_fin.append(result[1])
        return [index, result[1]]


    def MultiMatchPath(self, indexDicDebut : int, indexDicFin: int, valeur_branch_dicDebut : list, valeur_branch_dicFin: list) -> list :
        path: list = []
        while indexDicDebut > 0 :
            key: list = self.getNextIndexBegin(valeur_branch_dicDebut)
            indexDicDebut: int = key[0]
            valeur_branch_dicDebut: list = self.dic_debut[indexDicDebut][key[1]]
        
        while indexDicFin > 0 :
            key = self.getNextIndexEnd(valeur_branch_dicFin)
            indexDicFin = key[0]
            valeur_branch_dicFin = self.dic_fin[indexDicFin][key[1]]
        
        self.chemin_debut.append(self.nconstDebut)
        self.chemin_debut = self.chemin_debut[::-1]
        
        for element in self.chemin_debut :
            if self.chemin_debut.count(element) > 1:
                self.chemin_debut.remove(element)
        for element in self.chemin_fin:
            if self.chemin_fin.count(element) > 1:
                self.chemin_fin.remove(element)
        
        
        for e in self.chemin_debut:
            path.append(e)
        for e in self.chemin_fin:
            path.append(e)
        path.append(self.nconstFin)
        self.listeForGetNextBegin = []
        self.listeForGetNextEnd = []
        return path
    
    def getAccuracyOfPath(self, path: list) -> int :
        fautes = 0
        referentiel = path[0][0]
        for i in range(1, len(path)):
            if referentiel == path[i][0]:
                fautes += 1
            referentiel = path[i][0]
        return fautes

    def selectorBestPath(self, listPath: list) -> list :
        pathSelected: any = ''
        size: int = len(listPath[0])
        accuracy: int = self.getAccuracyOfPath(listPath[0])
        for path in listPath:
            if len(path) <= size and self.getAccuracyOfPath(path) <= accuracy:
                pathSelected = path
        return pathSelected
        
    
    def threadPathBegin(self, indexDicDebut : int, valeur_branch_dicDebut: list) -> None:
       
        dic = {"type" : "debut"}
        while indexDicDebut > 0 :
            key: list = self.getNextIndexBegin(valeur_branch_dicDebut)
            indexDicDebut: int = key[0]
            valeur_branch_dicDebut: list = self.dic_debut[indexDicDebut][key[1]]
        
        dic["result"] = self.chemin_debut
        self.resultPath.put(dic)
    
    def threadPathEnd(self, indexDicFin : int, valeur_branch_dicFin: list) -> None:
        
        dic = {"type" : "fin"}
        while indexDicFin > 0 :
            key = self.getNextIndexEnd(valeur_branch_dicFin)
            indexDicFin = key[0]
            valeur_branch_dicFin = self.dic_fin[indexDicFin][key[1]]
        
        dic["result"] = self.chemin_fin
        self.resultPath.put(dic)

    def path(self, branchCommunDetected={}, nodeCommunDetected=[]) -> list:
        
        indexDicDebut = len(self.dic_debut)-1
        indexDicFin = len(self.dic_fin)-1

        if indexDicFin == 0 and indexDicDebut == 0:
            if branchCommunDetected :
                return [
                    self.tconstDebut, branchCommunDetected['commun'][0], self.tconstFin
                ]
            elif nodeCommunDetected:
                return [
                    self.tconstDebut, nodeCommunDetected[0], self.tconstFin
                ]

        if nodeCommunDetected :
            if len(nodeCommunDetected) > 0 :
                nbPossibility: int = len(nodeCommunDetected)
                result_paths: list = []
                for i in range (0, nbPossibility):
                    valeur_branch_dicDebut = self.dic_debut[indexDicDebut][nodeCommunDetected[i]]
                    valeur_branch_dicFin = self.dic_fin[indexDicFin][nodeCommunDetected[i]]
                    self.chemin_debut.append(nodeCommunDetected[i])
                    path = self.MultiMatchPath(indexDicDebut, indexDicFin, valeur_branch_dicDebut, valeur_branch_dicFin)
                    result_paths.append(path)
                    self.chemin_debut = []
                
                return self.selectorBestPath(result_paths)

            else :
                valeur_branch_dicDebut = self.dic_debut[indexDicDebut][nodeCommunDetected[0]]
                valeur_branch_dicFin = self.dic_fin[indexDicFin][nodeCommunDetected[0]]
                self.chemin_debut.append(nodeCommunDetected[0])
        
        elif branchCommunDetected :
            if len(branchCommunDetected['commun']) > 0:
                nbThread: int = len(branchCommunDetected['commun'])
                threads: list = []
                #key_debut = list(branchCommunDetected['debut'].keys())
                #key_fin = list(branchCommunDetected['fin'].keys())
                #valeur_branch_dicDebut = self.dic_debut[indexDicDebut][random.choice(key_debut)]
                #valeur_branch_dicFin = self.dic_fin[indexDicFin][random.choice(key_fin)]

                result_paths: list = []
                for i in range (0, nbThread):
                    key_debut = self.findKeyFromSpecificDict(branchCommunDetected['debut'], branchCommunDetected['commun'][i])
                    key_fin = self.findKeyFromSpecificDict(branchCommunDetected['fin'], branchCommunDetected['commun'][i])
                    if len(key_debut) - i != -1 and len(key_fin) - i != -1 :
                        valeur_branch_dicDebut = self.dic_debut[indexDicDebut][key_debut[i]]
                        valeur_branch_dicFin = self.dic_debut[indexDicFin][key_fin[i]]
                    else :
                        valeur_branch_dicDebut = self.dic_debut[indexDicDebut][key_debut[len(key_debut) - 1]]
                        valeur_branch_dicFin = self.dic_debut[indexDicFin][key_fin[len(key_fin) - 1]]

                    #self.chemin_fin.append(branchCommunDetected['commun'][i])
                    if len(key_debut) - i != -1 and len(key_fin) - i != -1 :
                        #self.chemin_fin.append((key_fin[i]))
                        self.chemin_debut.append(key_debut[i])
                    else :
                        #self.chemin_fin.append((key_fin[len(key_fin) - 1]))
                        self.chemin_debut.append(key_debut[len(key_debut) - 1])
                        
                    path = self.MultiMatchPath(indexDicDebut, indexDicFin, valeur_branch_dicDebut, valeur_branch_dicFin)
                    result_paths.append(path)
                    self.chemin_debut = []
                    self.chemin_fin = []
                
                return self.selectorBestPath(result_paths)

            
            else :
                key_debut = self.findKeyFromSpecificDict(branchCommunDetected['debut'], branchCommunDetected['commun'][0])
                key_fin = self.findKeyFromSpecificDict(branchCommunDetected['fin'], branchCommunDetected['commun'][0])
                valeur_branch_dicDebut = self.dic_debut[indexDicDebut][key_debut[0]]
                valeur_branch_dicFin = self.dic_fin[indexDicFin][key_fin[0]]
                #self.chemin_fin.append(branchCommunDetected['commun'][0])
                #self.chemin_fin.append(key_fin[0])
                self.chemin_debut.append(key_debut[0])
                #self.chemin_debut.append(branchCommunDetected['commun'][0])
                #self.chemin_debut.append(self.nconstDebut)
        #S'attaque sur le dic d'en dessous
        path = []

        threadPathBegin = threading.Thread(target=self.threadPathBegin, daemon=True, args=[indexDicDebut, valeur_branch_dicDebut])
        threadPathEnd = threading.Thread(target=self.threadPathEnd, daemon=True, args=[indexDicFin, valeur_branch_dicFin])

        threadPathBegin.start()
        threadPathEnd.start()

        threadPathBegin.join()
        threadPathEnd.join()

        result1 = self.resultPath.get()
        result2 = self.resultPath.get()

        if result1.get("type") == "debut" and result2.get("type") == "fin":
            self.chemin_debut = result1["result"][::-1]
            self.chemin_fin = result2["result"]
        else :
            self.chemin_debut = result2["result"][::-1]
            self.chemin_fin = result1["result"]

        #chemin_debut = chemin_debut[::-1]

        for element in self.chemin_debut :
            if self.chemin_debut.count(element) > 1:
                self.chemin_debut.remove(element)
        for element in self.chemin_fin:
            if self.chemin_fin.count(element) > 1:
                self.chemin_fin.remove(element)

        path.append(self.nconstDebut)
        for e in self.chemin_debut:
            path.append(e)
        for e in self.chemin_fin:
            path.append(e)
        path.append(self.nconstFin)
        return path
        #return self.chemin_debut, self.chemin_fin


    def threadDebut(self) -> None:
        
        cur = self.con.cursor()
        dic = {"type": "debut"}
        #Initialisation
        tab_noeud_traite = []
        tab_branch_traite = set()
        sql = self.modeSql[0]
        value = {"tconst": self.tconstDebut}
        cur.execute(sql, value)
        tabs_nconst_noeud = [noeud[0] for noeud in cur.fetchall()]
        while True:
            tab_nconst_branche = []
            for noeud in tabs_nconst_noeud:
                tab_noeud_traite.append(noeud)
                sql = self.modeSql[1]
                value = {"nconst": noeud}
                cur.execute(sql, value)
                for e in cur.fetchall() :
                    #if e[0] != self.nconstDebut and tab_branch_traite.count(e[0]) < 2:
                    if e[0] != self.tconstDebut and self.checkBranchDebut(e[0]):
                        tab_nconst_branche.append(e[0])
                        tab_branch_traite.add(e[0])
                dic[noeud] = tab_nconst_branche
                tab_nconst_branche = []
                #{"type": "debut", noeud1 : ['Acteur1'], noeud2 : ['Acteur']}
        
            #envoie du résultat 
            with self.condition:
                #envoie de la réponce au thread traitement
                self.resultQueue.put(dic)
                #mise en attente 
                self.condition.wait()

                if self.traitementAccepter == True:
                    break
                else :
                    dic = {"type": "debut"}


            #recup noeud (tconst) pour l'étape i+1
            tabs_nconst_noeud = []
            for tconst in tab_branch_traite :
                sql = self.modeSql[0]
                value = {"tconst": tconst}
                cur.execute(sql, value)
                for e in cur.fetchall():
                    if e [0] not in tab_noeud_traite:
                        tabs_nconst_noeud.append(e[0])
        cur.close()
    
    def threadFin(self) -> None:
        
        cur = self.con.cursor()
        #initialisation
        tab_noeud_traite = []
        tab_branch_traite = set()
        dic = {"type": "fin"}
        sql = self.modeSql[0]
        value = {"tconst": self.tconstFin}
        cur.execute(sql, value)
        tabs_nconst_noeud = [noeud[0] for noeud in cur.fetchall()]
        while True :
            tab_nconst_branch = []
            for noeud in tabs_nconst_noeud :
                
                tab_noeud_traite.append(noeud)
                sql = self.modeSql[1]
                value = {"nconst": noeud}
                cur.execute(sql, value)
                
                for e in cur.fetchall():
                    #if e[0] != self.nconstDebut and tab_branch_traite.count(e[0]) < 2:
                    if e[0] != self.tconstFin and self.checkBranchFin(e[0]):
                        tab_nconst_branch.append(e[0])
                        tab_branch_traite.add(e[0])
                dic[noeud] = tab_nconst_branch
                tab_nconst_branch = []
            
                #{"type": "fin", noeud1 : ['Acteur1','Acteur2], noeud2 : ['Acteur']}
        
            
            #envoie du résultat
            with self.condition:
                self.resultQueue.put(dic)
                #attente de résultat
                self.condition.wait()

                if self.traitementAccepter == True:
                    break
                else :
                    dic = {"type": "fin"}
    
            
            tabs_tconst_noeud = []
            for tconst in tab_branch_traite :
                sql = self.modeSql[0]
                value = {"tconst": tconst}
                cur.execute(sql, value)
                for e in cur.fetchall():
                    if e[0] not in tab_noeud_traite :
                        tabs_tconst_noeud.append(e[0])
        cur.close()
    
    def threadPasserelle(self) -> None:
        
        while self.i < 50 :

            #queue = [resultP1, resultP2]
            resultat1 = self.resultQueue.get()
            resultat2 = self.resultQueue.get()
            #queue = []

            
            if resultat1.get("type") == "debut" and resultat2.get("type") == "fin":
                del resultat1["type"]
                self.dic_debut[self.i] = resultat1

                del resultat2["type"]
                self.dic_fin[self.i] = resultat2
            else :
                del resultat1["type"]
                self.dic_fin[self.i] = resultat1

                del resultat2["type"]
                self.dic_debut[self.i] = resultat2
            
            with self.condition:
                nodeCommunDetected = self.communNode()
                branchCommunDetected = self.communBranch()
                if nodeCommunDetected:
                    self.cheminF = self.path({}, nodeCommunDetected)
                    self.traitementAccepter = True
                    self.condition.notify_all()
                    break
                elif branchCommunDetected:
                    self.cheminF = self.path(branchCommunDetected, [])
                    self.traitementAccepter = True
                    self.condition.notify_all()
                    break
                else :
                    self.traitementAccepter = False
                    self.condition.notify_all()
            self.i+=1
        with self.condition:
            self.traitementAccepter = True
            self.condition.notify_all()
            self.con.close()

    def Start(self) -> dict:
    
        if self.mode == "soft":
            self.modeSql = [
                "SELECT nconst FROM title_principals WHERE tconst = %(tconst)s;",
                "SELECT tconst FROM title_principals WHERE nconst = %(nconst)s;"
            ]
        elif self.mode == "hard":
            self.modeSql = [
                "SELECT tp.nconst FROM title_principals tp WHERE tp.tconst = %(tconst)s AND (tp.category = 'actor' OR tp.category = 'actress');",
                "SELECT tp.tconst FROM title_principals tp JOIN title_basics tb ON tp.tconst = tb.tconst WHERE tp.nconst = %(nconst)s AND tb.titleType = 'movie';"
            ]
        
        dic_f = {}
        thread_de_recherche_debut = threading.Thread(target=self.threadDebut, daemon=True)
        thread_de_recherche_fin = threading.Thread(target=self.threadFin, daemon=True)
        thread_de_validation = threading.Thread(target=self.threadPasserelle)

        tic = time.time()
        # Démarrage des threads
        thread_de_recherche_debut.start()
        thread_de_recherche_fin.start()
        thread_de_validation.start()

        # Attente de la fin des threads de création
        thread_de_recherche_debut.join()
        thread_de_recherche_fin.join()

        # Attente de la fin du thread de traitement
        thread_de_validation.join()
        tac = time.time()

        if self.cheminF :
            dic_f = {"Message" : "OK",
                     "data" : {
                         "path" : self.cheminF,
                         "time" : round(tac-tic, 3)
                        }
                     }
        else :
            dic_f = {"Message" : "KO"}
        return dic_f
