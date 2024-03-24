import psycopg2
import threading
import queue
import time
from dataclasses import dataclass, field



@dataclass
class trouver:
    element1: str
    element2: str
    config: dict
    typeResult1: str = field(default_factory=lambda: '')
    typeResult2: str = field(default_factory=lambda: '')
    value: list = field(default_factory=lambda: [])
    resultQueue : queue.Queue = field(default_factory=queue.Queue)
    result: list = field(default_factory=lambda: [])
    sql: list = field(default_factory=lambda: [])
    con: psycopg2.extensions.connection = field(init=False)


    def __post_init__(self):
    
        self.con: psycopg2 = self.getCon()
    
    def getCon(self) -> psycopg2.connect:
    
        con: psycopg2 = psycopg2.connect(
            host=self.config['host'],
            database=self.config['database'],
            user=self.config['user'],
            password=self.config['password']
        )

        return con
    
    
    def link(self, tab1: list, tab2: list) -> list :
        return list(set(tab1) & set(tab2))


    def threadOne(self) -> None:
        cur: psycopg2 = self.con.cursor()
        value: dict = {self.typeResult1: self.element1}
        cur.execute(self.sql[0], value)
        
        result: list = [element[0] for element in cur.fetchall()]
        result2: list = []
        for element in result:
            value: dict = {self.typeResult2 : element}
            cur.execute(self.sql[1], value)
            for e in cur.fetchall():
                if e != self.element1:
                        result2.append(e[0])

        self.resultQueue.put({"result1" : result, "result2" : result2})
        return 


    def threadTwo(self) -> None:
        cur: psycopg2 = self.con.cursor()
        value: dict = {self.typeResult1 : self.element2}
        cur.execute(self.sql[0], value)
        
        result: list = [element[0] for element in cur.fetchall()]
        result2: list = []
        for element in result:
                value: dict = {self.typeResult2 : element}
                cur.execute(self.sql[1], value)
                for e in cur.fetchall():
                    if e != self.element2:
                        result2.append(e[0])

        self.resultQueue.put({"result1" : result, "result2" : result2})
        return 

    def threadTree(self) -> list:
        result1: dict = self.resultQueue.get()
        result2: dict = self.resultQueue.get()
        
        self.result = self.link(result1.get("result1"), result2.get("result1"))

        if len(self.result) == 0:
            self.result = self.link(result1.get("result2"), result2.get("result2"))
        return self.result



    def main(self) -> dict:
        if self.element1[0] == "n" and self.element2[0] == "n":
            self.sql: list = [
                "SELECT tp.tconst FROM title_principals tp JOIN title_basics tb ON tp.tconst = tb.tconst WHERE tp.nconst = %(nconst)s AND tb.titleType = 'movie';",
                "SELECT tp.nconst FROM title_principals tp WHERE tp.tconst = %(tconst)s AND (tp.category = 'actor' OR tp.category = 'actress');"
            ]
            self.typeResult1: str = 'nconst'
            self.typeResult2: str = 'tconst'
        elif self.element1[0] == "t" and self.element2[0] == "t":
            self.sql: list = [
                "SELECT tp.nconst FROM title_principals tp WHERE tp.tconst = %(tconst)s AND (tp.category = 'actor' OR tp.category = 'actress');",
                "SELECT tp.tconst FROM title_principals tp JOIN title_basics tb ON tp.tconst = tb.tconst WHERE tp.nconst = %(nconst)s AND tb.titleType = 'movie';"
            ]
            self.typeResult1: str = 'tconst'
            self.typeResult2: str = 'nconst'
        
        threadOne: threading.Thread = threading.Thread(target=self.threadOne,daemon=True)
        threadTwo: threading.Thread = threading.Thread(target=self.threadTwo,daemon=True)
        threadTree: threading.Thread = threading.Thread(target=self.threadTree)

        tic: time = time.time()
        # Démarrage des threads
        threadOne.start()
        threadTwo.start()
        threadTree.start()

        # Attente de la fin des threads de création
        threadOne.join()
        threadTwo.join()

        # Attente de la fin du thread de traitement
        threadTree.join()
        tac: time = time.time()
        

        if self.result:
            return {
                "Message" : "OK",
                "result" : self.result,
                "time" : round(tac-tic, 3)
            }
        else :
            return {
                "Message" : "KO",
                "time" : round(tac-tic, 3)
            }
