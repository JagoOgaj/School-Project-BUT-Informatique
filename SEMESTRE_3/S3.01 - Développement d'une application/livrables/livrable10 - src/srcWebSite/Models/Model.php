<?php

class Model
{
    /**
     * Attribut contenant l'instance PDO
     */
    private $bd;

    /**
     * Attribut statique qui contiendra l'unique instance de Model
     */
    private static $instance = null;

    /**
     * Constructeur : effectue la connexion à la base de données.
     */
    private function __construct()
    {
        include "./credentials.php";
        $this->bd = new PDO($dsn, $login, $mdp);
        $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->bd->query("SET nameS 'utf8'");
    }

    /**
     * Méthode permettant de récupérer un modèle car le constructeur est privé (Implémentation du Design Pattern Singleton)
     */
    public static function getModel()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getInformationsActeur($id){

        $requete = $this->bd->prepare("SELECT 
            nconst, primaryname, birthyear, deathyear, primaryprofession
            FROM name_basics
            WHERE nconst = :id ;");

        $requete->bindParam(':id', $id, PDO::PARAM_STR);
        $requete->execute();
        return $requete->fetch(PDO::FETCH_ASSOC);

    }

    public function getInformationsFilmParticipant($id) {
        // Récupération des knownForTitles
        $requete = $this->bd->prepare("WITH tconst_list AS (
            SELECT unnest(string_to_array(knownForTitles, ',')) AS tconst
            FROM name_basics
            WHERE nconst = :id
          )
          SELECT tb.tconst, tb.primaryTitle, tb.startYear
          FROM title_basics tb
          JOIN tconst_list tl ON tb.tconst = tl.tconst;
          ");
        $requete->bindParam(':id', $id, PDO::PARAM_STR);
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);

    }
    
    
   
 

     
    public function getInformationsActeurParticipant($id){

        $requete = $this->bd->prepare("SELECT 
        tp.nconst,
        nb.primaryName AS nomActeur,
        COALESCE(nb.birthyear::TEXT, 'Inconnu') AS dateActeur,
        COALESCE(tp.category::TEXT, 'Inconnu') AS nomDeScene
        
        
    FROM 
        title_principals tp
    LEFT JOIN 
        name_basics nb ON tp.nconst = nb.nconst
    WHERE 
       tp.tconst = :id ;");

        $requete->bindParam(':id', $id, PDO::PARAM_STR);
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);

    }
    
    public function getFavorieActeur($username){
        $sql = "SELECT * FROM FavorieActeur
                WHERE userId = :userId;
                ";
        $query = $this->bd->prepare($sql);
        $userId = $this->getUserId($username)["userid"];
        $query->bindValue(":userId", $userId, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFavorieFilm($username){
        $sql = "SELECT * FROM FavorieFilm
                WHERE userId = :userId;
                ";
        $query = $this->bd->prepare($sql);
        $userId = $this->getUserId($username)["userid"];
        $query->bindValue(":userId", $userId, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEpisode($id){
        $sql = "SELECT * 
        FROM title_episode te 
        JOIN title_basics tb ON te.tconst=tb.tconst  
        WHERE parenttconst = :id 
        ORDER BY te.seasonnumber , te.episodenumber ;";
       
       $query = $this->bd->prepare($sql);
        $query->bindValue(":id", $id, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNbSaison($id){
        $sql = "SELECT  max(seasonnumber) 
        FROM title_episode 
        WHERE parenttconst = :id ; ";
       
       $query = $this->bd->prepare($sql);
        $query->bindValue(":id", $id, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    public function getSaison($id){
        $sql = "SELECT  seasonnumber,episodenumber
        FROM title_episode 
        WHERE tconst = :id ; ";
       
       $query = $this->bd->prepare($sql);
        $query->bindValue(":id", $id, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    public function getNameSerie($id){
        $sql = "SELECT tb.primaryTitle AS seriesName
        FROM title_basics tb
        JOIN title_episode te ON tb.tconst = te.parentTconst
        WHERE te.tconst = :id ;";
       
       $query = $this->bd->prepare($sql);
        $query->bindValue(":id", $id, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getNbEpisode($id){
        $sql = "SELECT COUNT(*) 
        FROM title_episode te 
        JOIN title_basics tb ON te.tconst=tb.tconst 
         WHERE parenttconst = :id ; ";
       
       $query = $this->bd->prepare($sql);
        $query->bindValue(":id", $id, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    public function favorieExistActeur($userId, $acteurId){
        $sql = "SELECT 
                acteurId FROM FavorieActeur
                WHERE userId = :userId
                AND acteurId = :acteurId
                ;";

        $query = $this->bd->prepare($sql);
        $query->bindValue(":userId", $userId, PDO::PARAM_STR);
        $query->bindValue(":acteurId", $acteurId);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    public function favorieExistFilm($userId, $filmId){
        $sql = "SELECT 
                filmId FROM FavorieFilm
                WHERE userId = :userId
                AND filmId = :filmId
                ;";

        $query = $this->bd->prepare($sql);
        $query->bindValue(":userId", $userId, PDO::PARAM_STR);
        $query->bindValue(":filmId", $filmId);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    public function AddFavorieActeur($userId, $acteurId){
        $sql = "INSERT INTO FavorieActeur (userId, acteurId)
                VALUES (:userId, :acteurId);
                ";
        $query = $this->bd->prepare($sql);
        $query->bindValue("userId", $userId);
        $query->bindValue("acteurId", $acteurId);
        $query->execute();            
    }

    public function RemoveFavorieActeur($userId, $acteurId){
        $sql = "DELETE FROM FavorieActeur
                WHERE userId = :userId
                AND acteurId = :acteurId;
                ";
        $query = $this->bd->prepare($sql);
        $query->bindValue(":userId", $userId);
        $query->bindvalue(":acteurId", $acteurId);
        $query->execute();
    }

    public function AddFavorieFilm($userId, $filmId){
        $sql = "INSERT INTO FavorieFilm (userId, filmId)
                VALUES (:userId, :filmId)
                ;";
        $query = $this->bd->prepare($sql);
        $query->bindValue(":userId", $userId);
        $query->bindValue(":filmId", $filmId);
        $query->execute();
    }

    public function RemoveFavorieFilm($userId, $filmId){
        $sql = "DELETE FROM FavorieFilm
                WHERE userId = :userId
                AND filmId = :filmId;
                ";
        $query = $this->bd->prepare($sql);
        $query->bindValue(":userId", $userId);
        $query->bindValue(":filmId", $filmId);
        $query->execute();
    }



    public function getInformationsMovie($id) {
        $requete = $this->bd->prepare("SELECT
       tb.primaryTitle,tb.titletype, tb.startyear,tb.runtimeMinutes,tb.genres, tr.averagerating
        
       
    FROM
        title_basics tb
        LEFT JOIN title_ratings tr ON tb.tconst = tr.tconst
        
       
    WHERE
        tb.tconst = :id ;"
        );
   
        
        $requete->bindParam(':id', $id, PDO::PARAM_STR);
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }



    public function getInformationsDirector($id) {
        $requete = $this->bd->prepare("SELECT 
        tb.tconst,
       STRING_AGG(nb.primaryName, ', ') AS realisateur
    FROM 
        title_basics tb
    JOIN 
        title_principals tp ON tb.tconst = tp.tconst
    JOIN 
        name_basics nb ON tp.nconst = nb.nconst
    WHERE 
        tb.tconst = :id 
        AND tp.category = 'director'
    GROUP BY 
        tb.tconst
    HAVING 
        EXISTS (
            SELECT 1
            FROM title_principals
            WHERE tconst = :id AND category = 'director'
        ); ");
   


        
        $requete->bindParam(':id', $id, PDO::PARAM_STR);
        $requete->execute();
        return $requete->fetch(PDO::FETCH_ASSOC);
    }
    
    public function doublonFilm($titre, $category=null) {
        $titre = trim($titre);
       
            
            $sql = "SELECT COUNT(*)
        FROM title_basics
        WHERE lower(primarytitle) = lower(:titre)";
        
        
        if($category !== "all" && $category !==null){

            $sql .= " AND titletype = :category ";
        }
        
        
        $sql .= " ; ";
        $requete = $this->bd->prepare($sql);
        if($category !== "all" && $category !==null){

            $requete->bindParam(':category', $category, PDO::PARAM_STR);
        }
       
        $requete->bindParam(':titre', $titre, PDO::PARAM_STR);
        $requete->execute();
        return $requete->fetch(PDO::FETCH_COLUMN);  
    }

    public function listeDoublon($titre, $category = null) {
        $titre = trim($titre);
                    
            $sql = "SELECT *
        FROM title_basics
        WHERE lower(primarytitle) = lower(:titre)";
         if($category !== "all" && $category !== null){
            $sql .= " AND titletype = :category ";
         }
       
        $sql .= "; ";
        $requete = $this->bd->prepare($sql);
        if($category !== "all" && $category !== null){

            $requete->bindParam(':category', $category, PDO::PARAM_STR);
        }
        $requete->bindParam(':titre', $titre, PDO::PARAM_STR);
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    public function doublonActeur($personne) {
        $personne = trim($personne);
        $requete = $this->bd->prepare("SELECT COUNT(*) 
        FROM name_basics
        WHERE lower(primaryname) = lower(:personne) ;");
       
       
        $requete->bindParam(':personne', $personne, PDO::PARAM_STR);
        $requete->execute();
        return $requete->fetch(PDO::FETCH_COLUMN);  
        }

    public function listeDoublonActeur($personne) {
        $personne = trim($personne);
        $requete = $this->bd->prepare("SELECT * 
        FROM name_basics
        WHERE lower(primaryname) = lower(:personne) ;");
       
       
        $requete->bindParam(':personne', $personne, PDO::PARAM_STR);
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    public function voirtousresultat($mot,$type) {
        $mot = trim($mot);
        $mot = "%" . $mot . "%";
        
        if ($type == "personne") {
            $requete = $this->bd->prepare("SELECT nconst AS id, primaryname AS nom, birthyear as annee, primaryprofession AS details
                FROM name_basics
                WHERE primaryname ILIKE :mot ; ");
        } elseif ($type == "tout") {
            $requete = $this->bd->prepare("(
                SELECT nconst AS id, primaryname AS nom, birthyear as annee, primaryprofession AS details
                FROM name_basics
                WHERE primaryname ILIKE :mot
                
                
            ) UNION (
                SELECT tconst AS id, primarytitle AS nom, startyear as annee, genres AS details
                FROM title_basics
                WHERE primarytitle ILIKE :mot
                
               
            );");
        } else {
            $requete = $this->bd->prepare("SELECT tconst AS id, primarytitle AS nom, startyear as annee, genres AS details
                FROM title_basics
                WHERE primarytitle ILIKE :mot
                AND titletype = :category
                ;");
            $requete->bindParam(':category', $type, PDO::PARAM_STR);
        }
        
        $requete->bindParam(':mot', $mot, PDO::PARAM_STR);
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    public function suggestion($mot, $type) {
        $mot = trim($mot);
        $mot = "%" . $mot . "%";
        
        if ($type == "personne") {
            $requete = $this->bd->prepare("SELECT nconst AS id, primaryname AS nom, birthyear as annee, primaryprofession AS details
                FROM name_basics
                WHERE primaryname ILIKE :mot
                LIMIT 4;");
        } elseif ($type == "tout") {
            $requete = $this->bd->prepare("(
                SELECT nconst AS id, primaryname AS nom, birthyear as annee, primaryprofession AS details
                FROM name_basics
                WHERE primaryname ILIKE :mot
                LIMIT 4
                
            ) UNION (
                SELECT tconst AS id, primarytitle AS nom, startyear as annee, genres AS details
                FROM title_basics
                WHERE primarytitle ILIKE :mot
                LIMIT 4
               
            ) LIMIT 4;");
        } else {
            $requete = $this->bd->prepare("SELECT tb.tconst AS id, tb.primarytitle AS nom, tb.startyear as annee, tb.genres AS details
                FROM title_basics tb
                WHERE tb.primarytitle ILIKE :mot
                AND tb.titletype = :category
                LIMIT 4;");
            $requete->bindParam(':category', $type, PDO::PARAM_STR);
        }
        
        $requete->bindParam(':mot', $mot, PDO::PARAM_STR);
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function rechercheTitre($titre, $types, $dateSortieMin, $dateSortieMax, $dureeMin, $dureeMax, 
                                    $genres, $noteMin, $noteMax, $type_rech) {
        $sql = "SELECT tb.tconst, tb.primaryTitle, tb.titletype, tb.startyear, tb.runtimeminutes, tb.genres,tr.averagerating , tr.numvotes
                FROM title_basics tb
                LEFT JOIN title_ratings tr ON tr.tconst=tb.tconst
                WHERE 1=1 ";
    
        if ($type_rech == "similarity") {
            $sql .= " AND similarity(tb.primaryTitle, :titre) > 0.5";
        }
        else if ($type_rech == "like") {
            $sql .= " AND tb.primaryTitle ILIKE :titre";
        }
        else{
            $sql .= " AND LOWER(tb.primaryTitle) = LOWER(:titre)";
        }

        if(!empty($types)){
            $sql .= " AND (";
            foreach ($types as $index => $type) {
                if ($index > 0) {
                    $sql .= " OR ";
                }
                $sql .= "tb.titletype = :type$index";
            }
            $sql .= ")";
        }
    
        if ($dateSortieMin !== null) {
            $sql .= " AND tb.startyear >= :dateSortieMin";
        }
    
        if ($dateSortieMax !== null) {
            $sql .= " AND tb.startyear <= :dateSortieMax";
        }
    
        if ($dureeMin !== null) {
            $sql .= " AND tb.runtimeminutes >= :dureeMin";
        }
    
        if ($dureeMax !== null) {
            $sql .= " AND tb.runtimeminutes <= :dureeMax";
        }
    
        if ($genres !== null) {
            $sql .= " AND tb.genres ~* :genres";
        }
        if ($noteMin !== null) {
            $sql .= " AND tr.averageRating>= :noteMin";
        }
    
        if ($noteMax !== null) {
            $sql .= " AND tr.averageRating <= :noteMax";
        }
    

        $requete = $this->bd->prepare($sql);
    
        if ($type_rech == "similarity" || $type_rech == "like") {
            $titre =trim($titre);
            $titre = '%' . $titre . '%';
            $requete->bindParam(':titre', $titre, PDO::PARAM_STR);
        }
        else{
            $titre =trim($titre);
            $requete->bindParam(':titre', $titre, PDO::PARAM_STR);
        }
    
        if (!empty($types)) {
            foreach ($types as $index => $type) {
                $paramName = ":type$index";
                $requete->bindParam($paramName, $types[$index], PDO::PARAM_STR);
            }
        }
    
        if ($dateSortieMin !== null) {
            $requete->bindParam(':dateSortieMin', $dateSortieMin, PDO::PARAM_INT);
        }
    
        if ($dateSortieMax !== null) {
            $requete->bindParam(':dateSortieMax', $dateSortieMax, PDO::PARAM_INT);
        }
    
        if ($dureeMin !== null) {
            $requete->bindParam(':dureeMin', $dureeMin, PDO::PARAM_INT);
        }
    
        if ($dureeMax !== null) {
            $requete->bindParam(':dureeMax', $dureeMax, PDO::PARAM_INT);
        }
    
        if ($genres !== null) {
            $requete->bindParam(':genres', $genres, PDO::PARAM_STR);
        }
        if ($noteMin !== null) {
            $requete->bindParam(':noteMin', $noteMin, PDO::PARAM_INT);
        }
    
        if ($noteMax !== null) {
            $requete->bindParam(':noteMax', $noteMax, PDO::PARAM_INT);
        }
    
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    public function recherchepersonne($nom,$dateNaissanceMin,$dateNaissanceMax,$dateDecesMin,$dateDecesMax,$metier,$type_rech) {
     $sql = "SELECT nconst, primaryname, birthyear, deathyear, primaryprofession
            FROM name_basics
            WHERE 1=1 ";
            

            
            if ($type_rech == "similarity") {
                $sql .= " AND similarity(primaryname, :nom) > 0.5";
            }
            else if ($type_rech == "like") {
                $sql .= " AND primaryname ILIKE :nom";
            }
            else{
                $sql .= " AND LOWER(primaryname) = LOWER(:nom)";
            }
            if ($dateNaissanceMin !== null) {
                $sql .= " AND birthyear >= :dateNaissanceMin ";
            }
            if ($dateNaissanceMax !== null) {
                $sql .= " AND birthyear <= :dateNaissanceMax ";
            }
            if ($dateDecesMin !== null) {
                $sql .= " AND deathyear >= :dateDecesMin ";
            }
            if ($dateDecesMax !== null) {
                $sql .= " AND deathyear <= :dateDecesMax ";
            }
            if ($metier !== null) {
                $sql .= " AND primaryprofession ~* :metier";
                
            }
            $sql .= ";";

        $requete = $this->bd->prepare($sql);

            if ($type_rech == "similarity" || $type_rech == "like") {
                $nom =trim($nom);
                $nom = '%' . $nom . '%';
                $requete->bindParam(':nom', $nom, PDO::PARAM_STR);
            }
            else{
                $nom =trim($nom);
                $requete->bindParam(':nom', $nom, PDO::PARAM_STR);
            }    
            if ($dateNaissanceMin !== null) {
                $requete->bindParam(':dateNaissanceMin', $dateNaissanceMin, PDO::PARAM_INT);
            }
            if ($dateNaissanceMax !== null) {
                $requete->bindParam(':dateNaissanceMax', $dateNaissanceMax, PDO::PARAM_INT);
            }
            if ($dateDecesMin !== null) {
                $requete->bindParam(':dateDecesMin', $dateDecesMin, PDO::PARAM_INT);
            }
            if ($dateDecesMax !== null) {
                $requete->bindParam(':dateDecesMax', $dateDecesMax, PDO::PARAM_INT);
            }
            if ($metier !== null) {
                $requete->bindParam(':metier', $metier, PDO::PARAM_STR);
            }
        $requete->execute();

        return $requete->fetchAll(PDO::FETCH_ASSOC);

        
    }
    public function gettconstunique($titre,$category){

        $titre = trim($titre);
       
            $sql = "SELECT tconst 
        FROM title_basics
        WHERE lower(primarytitle) = lower(:titre) "; 
        
        if($category !== "all"){

            $sql .= " AND titletype = :category ";
            }
        
        
         $sql .= " ; ";
       
         $requete = $this->bd->prepare($sql);
        $requete->bindParam(':titre', $titre, PDO::PARAM_STR);
        $requete->bindParam(':category', $category, PDO::PARAM_STR);
        $requete->execute();
        return $requete->fetch(PDO::FETCH_COLUMN);        
    }
    public function getnconstunique($nom){

        $nom = trim($nom);
        $requete = $this->bd->prepare("SELECT nconst 
        FROM name_basics
        WHERE lower(primaryname) = lower(:nom) ; ");
       
       
        $requete->bindParam(':nom', $nom, PDO::PARAM_STR);
        $requete->execute();
        return $requete->fetch(PDO::FETCH_COLUMN);        
    }
    public function FilmEnCommun($primaryName1, $primaryName2)
    {
        

        $sql = "SELECT tb.tconst, tb.primaryTitle,tb.titletype, tb.startyear, tb.genres
        FROM title_basics AS tb
        JOIN title_principals AS tp1 ON tb.tconst = tp1.tconst
        JOIN title_principals AS tp2 ON tb.tconst = tp2.tconst
        JOIN name_basics AS nb1 ON tp1.nconst = nb1.nconst
        JOIN name_basics AS nb2 ON tp2.nconst = nb2.nconst
        WHERE nb1.nconst= :actor1 AND nb2.nconst = :actor2;"; //Type Acteur Facultatif
        
        $query = $this->bd->prepare($sql);
        $query->bindParam(':actor1', $primaryName1, PDO::PARAM_STR);
        $query->bindParam(':actor2', $primaryName2, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } 

    public function ActeurEnCommun($t1, $t2)
    {
       

        $sql = "SELECT DISTINCT nb1.nconst, nb1.primaryName, nb1.birthyear, nb1.primaryprofession
        FROM name_basics AS nb1
        JOIN title_principals AS tp1 ON nb1.nconst = tp1.nconst
        JOIN title_basics AS tb1 ON tp1.tconst = tb1.tconst
        JOIN title_principals AS tp2 ON nb1.nconst = tp2.nconst
        JOIN title_basics AS tb2 ON tp2.tconst = tb2.tconst
        WHERE tb1.tconst = :movie1 AND tb2.tconst = :movie2;"; //Type Acteur Facultatif
        $query = $this->bd->prepare($sql);
        $query->bindParam(':movie1', $t1, PDO::PARAM_STR);
        $query->bindParam(':movie2', $t2, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
}

    public function getCommentaryMovie($MovieId){
        $sql = "SELECT * FROM CommentaryMovie WHERE MovieId = :MovieId ORDER BY CommentaryMovieID DESC;";
        $query = $this->bd->prepare($sql);
        $MovieId = trim(e($MovieId));
        $query->bindParam(":MovieId", $MovieId, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getCommentaryActor($ActorID){
        $sql = "SELECT * FROM CommentaryActor WHERE ActorID = :ActorID ORDER BY CommentaryActorID DESC;";
        $query = $this->bd->prepare($sql);
        $ActorID = trim(e($ActorID));
        $query->bindParam(":ActorID", $ActorID, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addCommentaryMovie($data){
        $sql = "INSERT INTO CommentaryMovie (userId, MovieId, TitreCom, Commentary, Anonyme, Rating) 
                VALUES (:userId, :movieId, :TitreCom, :commentary, :anonyme, :rating)";
        $query = $this->bd->prepare($sql);
        $userId = trim(e($data["userId"]));
        $movieId = trim(e($data["movieId"]));
        $titreCom =  trim(e($data["TitreCom"]));
        $commentary = trim(e($data["commentary"]));
        $anonyme = trim(e($data["anonyme"]));
        $rating = trim(e($data["rating"]));

        $query->bindParam(":userId", $userId, PDO::PARAM_STR);
        $query->bindParam(":movieId", $movieId, PDO::PARAM_INT);
        $query->bindParam(":TitreCom", $titreCom, PDO::PARAM_STR);
        $query->bindParam(":commentary", $commentary, PDO::PARAM_STR);
        $query->bindParam(":anonyme", $anonyme, PDO::PARAM_BOOL);
        $query->bindParam(":rating", $rating, PDO::PARAM_INT);
        $query->execute();
    }

    public function addCommentaryActor($data){
        $sql = "INSERT INTO CommentaryActor (userId, ActorID, TitreCom, Commentary, Anonyme, Rating) 
                VALUES (:userId, :ActorID, :TitreCom, :commentary, :anonyme, :rating)";
        $query = $this->bd->prepare($sql);
        $userId = trim(e($data["userId"]));
        $ActorId = trim(e($data["ActorID"]));
        $titreCom =  trim(e($data["TitreCom"]));
        $commentary = trim(e($data["commentary"]));
        $anonyme = trim(e($data["anonyme"]));
        $rating = trim(e($data["rating"]));

        $query->bindParam(":userId", $userId, PDO::PARAM_STR);
        $query->bindParam(":ActorID", $ActorId, PDO::PARAM_INT);
        $query->bindValue (":TitreCom", $titreCom, PDO::PARAM_STR);
        $query->bindParam(":commentary", $commentary, PDO::PARAM_STR);
        $query->bindParam(":anonyme", $anonyme, PDO::PARAM_BOOL);
        $query->bindParam(":rating", $rating, PDO::PARAM_INT);
        $query->execute();
    }

    public function getNcont($primaryName){
        $sql = "SELECT nconst
                FROM name_basics
                WHERE lower(primaryname) = lower(:primaryName) ;";

        $query = $this->bd->prepare($sql);
        $PrimaryName = e($primaryName);
        $query->bindParam(':primaryName', $PrimaryName, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_NUM);
    }


    public function getTconst($primaryTitle){
        $sql = "SELECT tconst
                FROM title_basics
                WHERE lower(primarytitle) = lower(:primaryTitle); 
                ";
        $query = $this->bd->prepare($sql);
        $PrimaryTitle = e($primaryTitle);
        $query->bindParam(':primaryTitle', $PrimaryName, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_NUM);
    }
    
    public function getUserName($userId){
        $sql = "SELECT username FROM UserData WHERE userId = :userId";
        $query = $this->bd->prepare($sql);
        $query->bindParam(":userId", $userId, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserId($username) {
        $sql = "SELECT userId FROM UserData WHERE username = :username";
        $query = $this->bd->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getName($username){
        $sql = "SELECT name 
                FROM UserData
                WHERE username = :username
                AND name IS NOT NULL;
                ";
        $query = $this->bd->prepare($sql);
        $query->bindValue(":username", $username);
        return $query->fetch(PDO::FETCH_NUM);
    }

    public function removeToken($userId, $token){
        $sql = "DELETE FROM ResetPassWord
                WHERE userId = :userId
                AND resetToken = :token;
                ";
        $query = $this->bd->prepare($sql);
        $query->bindValue(":userId", $userId);
        $query->bindValue(":token", $token);
        $query->execute();
    }

    public function userExist($username) {
        $sql = "SELECT EXISTS(SELECT 1 FROM UserData WHERE username = :username) as exists";
        $query = $this->bd->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    public function emailExist($username) {
        $sql = "SELECT email
        FROM UserData
        WHERE username = :username
        AND email IS NOT NULL;";
        $query = $this->bd->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_NUM);

    }
    public function CreateToken($username){
        $userId = $this->getUserId($username)["userid"];

        $token = bin2hex(random_bytes(16));
        //$token_hash = password_hash($token, PASSWORD_BCRYPT);
        try{
            $sql = "INSERT INTO ResetPassWord (userId, resetToken)
                    VALUES (:userId, :token);
                    ";
            $query = $this->bd->prepare($sql);
            $query->bindValue(":userId", $userId);
            $query->bindValue(":token", $token); 
            $query->execute();

            return [
                "status" => "OK",
                "message" => "",
                "token" => $token
            ];

        }
        catch(PDOException $e){
            return [
                "satus" => "KO",
                "message" => "Une erreur est survenue"
            ];
        }   
    }

    public function getTokenExpire($userId){
        $sql = "SELECT resetTokenExpire
                FROM ResetPassWord
                WHERE userId = :userId;";
        $query = $this->bd->prepare($sql);
        $query->bindValue(":userId", $userId);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserIdWithToken($token){


        $sql = " SELECT userId
                FROM ResetPassWord
                WHERE resetToken = :token;
                ";
        
        $query = $this->bd->prepare($sql);
        $query->bindValue(':token', $token);
        $query->execute();
        $userId = $query->fetch(PDO::FETCH_NUM);
        
        if(empty($userId)){
            return [
                "status" => "KO",
                "type" => 1
            ];
        }
        else{
                return [
                    "status" => "OK",
                    "type" => 0,
                    "userId" => $userId
                ];

        }


    }

    public function getUserData($username) {
        $userId = $this->getUserId($username)["userid"];

        $totalSearchSql = "SELECT COUNT(*) AS totalRecherches FROM RechercheData WHERE userId = :userId";
        $totalSearchQuery = $this->bd->prepare($totalSearchSql);
        $totalSearchQuery->bindParam(':userId', $userId, PDO::PARAM_INT);
        $totalSearchQuery->execute();
        $totalSearch = $totalSearchQuery->fetch(PDO::FETCH_ASSOC);
        
        
        $sql = "SELECT
        MAX(CASE WHEN typeRecherche = 'Trouver' THEN rehcercheTime END) AS Trouver,
        MAX(CASE WHEN typeRecherche = 'Rapprochement' THEN rehcercheTime END) AS Rapprochement,
        MAX(CASE WHEN typeRecherche = 'Recherche' THEN rehcercheTime END) AS Recherche
        FROM
            RechercheData
        WHERE
            userId = :userId
        GROUP BY
            userId;
        ";
        $results = $this->bd->prepare($sql);
        $results->bindParam(':userId', $userId, PDO::PARAM_INT);
        $results->execute();

        $RechercheTime = $results->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT
        COUNT(CASE WHEN typeRecherche = 'Trouver' THEN 1 END) AS CountTrouver,
        COUNT(CASE WHEN typeRecherche = 'Rapprochement' THEN 1 END) AS CountRapprochement,
        COUNT(CASE WHEN typeRecherche = 'Recherche' THEN 1 END) AS CountRecherche
        FROM
            RechercheData
        WHERE
            userId = :userId;
        ";
        $results = $this->bd->prepare($sql);
        $results->bindParam(':userId', $userId, PDO::PARAM_INT);
        $results->execute();
        $TotalParType = $results->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT COUNT(*) AS favorieFilmCount
                FROM FavorieFilm
                WHERE userId = :userId;
                ";
        $valeur = $this->bd->prepare($sql);
        $valeur->bindParam(':userId', $userId, PDO::PARAM_INT);
        $valeur->execute();
        $TotalFavoriFilm = $valeur->fetch(PDO::FETCH_ASSOC);
    
        $sql = "SELECT COUNT(*) AS favorieActeurCount
                FROM FavorieActeur
                WHERE userId = :userId;
                ";
        $valeur2 = $this->bd->prepare($sql);
        $valeur2->bindParam(':userId', $userId, PDO::PARAM_INT);
        $valeur2->execute();
        $TotalFavoriActeur = $valeur2->fetch(PDO::FETCH_ASSOC);
        
        return [
            "Total" => $totalSearch,
            "RecherTime" => $RechercheTime,
            "TotalParType" => $TotalParType,
            "TotalFavorieFilm" => $TotalFavoriFilm,
            "TotalFavorieActeur" => $TotalFavoriActeur
        ];
    }

    public function addUser($data) {
        if ($this->userExist($data["username"])["exists"] == false) {
            try {
                $insertSql = "INSERT INTO UserData (username, password, connectionTime)
                VALUES (:username, :password, CURRENT_TIMESTAMP);";
                $insertQuery = $this->bd->prepare($insertSql);
                $insertQuery->bindParam(':username', $data["username"], PDO::PARAM_STR);
                $password = password_hash($data["password"], PASSWORD_BCRYPT);
                $insertQuery->bindParam(':password', $password, PDO::PARAM_STR);
                $insertQuery->execute();
    
                return [
                    "status" => "OK",
                    "message" => "Add Successfully"
                ];
            }
            catch(PDOException $e){
                return [
                    "status" => "KO",
                    "message" => "Error adding user : ". $e->getMessage()
                ];
            }
        } else {
            return [
                "status" => "KO",
                "message" => "This user already exists"
            ];
        }
    }

    public function addUserRecherche($data) {
        try {
            $userId = $this->getUserId($data["UserName"])["userid"];

            $sql = "INSERT INTO RechercheData (userId, typeRecherche, motCle, rehcercheTime) 
                    VALUES (:userId, :TypeRecherche, :MotsCles, CURRENT_TIMESTAMP)";
            $query = $this->bd->prepare($sql);
            $query->bindParam(':userId', $userId, PDO::PARAM_INT);
            $query->bindParam(':TypeRecherche', $data["TypeRecherche"], PDO::PARAM_STR);
            if(is_array($data["MotsCles"])){
                $MotCle = implode(", ", $data["MotsCles"]);
            }
            else{
                $MotCle = $data["MotsCles"];
            }
            $query->bindParam(':MotsCles', $MotCle, PDO::PARAM_STR);
            $query->execute();
        }
        catch(PDOException $e){
            return [
                "status" => "KO",
                "message" => "Error adding data: " . $e->getMessage()
            ];
        }
    }

    public function loginUser($data) {
    
        $pwdMatchSql = "SELECT password FROM UserData WHERE username = :username";
        $pwdMatchQuery = $this->bd->prepare($pwdMatchSql);
        $pwdMatchQuery->bindParam(':username', $data['username'], PDO::PARAM_STR);
        $pwdMatchQuery->execute();
        $pwd_match = $pwdMatchQuery->fetch(PDO::FETCH_ASSOC);
        $this->updateConnectionTime($this->getUserId($data['username'])["userid"]);
        if (password_verify($data["password"], $pwd_match["password"])) {
            return $this->getUserData($data["username"]);
        } else {
            return [
                "status" => "KO",
                "message" => "Password doesn't match"
            ];
        }
    }

    public function updateConnectionTime($userId){
        $sql = "UPDATE UserData SET connectionTime = CURRENT_TIMESTAMP WHERE userId = :userId";
        $query = $this->bd->prepare($sql);
        $query->bindParam(":userId", $userId, PDO::PARAM_INT);
        return $query->execute();
    }
    

    public function updatePassword($data) {
        try {
            $sql = "UPDATE UserData
            SET password = :nouveauPassword
            WHERE userId = :userId;";
            $query = $this->bd->prepare($sql);
            $password = password_hash($data["password"], PASSWORD_BCRYPT);
            $query->bindParam(':nouveauPassword', $password, PDO::PARAM_STR);
            $query->bindParam(':userId', $data["userId"], PDO::PARAM_STR);
            $query->execute();
    
            return [
                "status" => "OK",
                "message" => "Update Successfully"
            ];
        } catch (PDOException $e) {
            return [
                "status" => "KO",
                "message" => "Error updating password: " . $e->getMessage()
            ];
        }
    }
    
    public function updateUsername($data) {
        try {
            $sql = "UPDATE UserData
                    SET username = :nouveauUsername
                    WHERE userId = :userId;";
            $query = $this->bd->prepare($sql);
            $query->bindParam(':nouveauUsername', $data['username'], PDO::PARAM_STR);
            $query->bindParam(':userId', $data["userId"], PDO::PARAM_STR);
            $query->execute();
    
            return [
                "status" => "OK",
                "message" => "Update Successfully"
            ];
        } catch (PDOException $e) {
            return [
                "status" => "KO",
                "message" => "Error updating username: " . $e->getMessage()
            ];
        }
    }

    public function getUserDataSettings($username){
        $userId = $this->getUserId($username)["userid"];
        $sql = "SELECT * FROM UserData WHERE userId = :userId";
        $query = $this->bd->prepare($sql);
        $query->bindParam(":userId", $userId, PDO::PARAM_INT); // Utilisez :userId ici
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    public function updateSettings($ancien_username, $username, $name, $email, $newPassword, $country)
    {
    $updateFields = [];
    $updateParams = [];

    if ($username != null) {
        $updateFields[] = 'username = :username';
        $updateParams[':username'] = $username;
    }

    if ($name != null) {
        $updateFields[] = 'name = :name';
        $updateParams[':name'] = $name;
    }

    if ($email != null) {
        $updateFields[] = 'email = :email';
        $updateParams[':email'] = $email;
    }

    if ($newPassword != null) {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $updateFields[] = 'password = :password';
        $updateParams[':password'] = $hashedPassword;
    }

    if ($country != null) {
        $updateFields[] = 'country = :country';
        $updateParams[':country'] = $country;
    }

    if (!empty($updateFields)) {
        $sql = 'UPDATE UserData SET ' . implode(', ', $updateFields) . ' WHERE userId = :userId';
        $query = $this->bd->prepare($sql);
        $updateParams[':userId'] = $this->getUserId($ancien_username)['userid'];

        return $query->execute($updateParams);
    }
    return false;
    }

    public function getRechercherData($data){
        $userId = $this->getUserId($data["username"])["userid"];
        $sql = "SELECT *
                FROM RechercheData
                WHERE userId = :userId AND TypeRecherche = :typeData
                ORDER BY rehcercheTime DESC;";
        $query = $this->bd->prepare($sql);
        $query->bindParam(":userId", $userId, PDO::PARAM_STR);
        $query->bindParam(":typeData", $data["type"], PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filmpopulaire(){
        $api_key = "9e1d1a23472226616cfee404c0fd33c1";
        $url = "https://api.themoviedb.org/3/movie/popular?api_key=" . $api_key;
        
        // Utilisation de cURL pour récupérer les films actuellement en salle
        $movie_data = file_get_contents($url);
        $movies = json_decode($movie_data, true);
       return $movies;
    }

    public function filmmieuxnote(){
        $api_key = "9e1d1a23472226616cfee404c0fd33c1";
        $url = "https://api.themoviedb.org/3/movie/top_rated?api_key=" . $api_key;
        
        // Utilisation de cURL pour récupérer les films actuellement en salle
        $movie_data = file_get_contents($url);
        $movies = json_decode($movie_data, true);
        return $movies;
    }
    public function listhome($genre){

        $requete = $this->bd->prepare("SELECT tb.tconst, tb.primaryTitle, tb.startYear, tr.averageRating, tr.numVotes
        FROM title_basics tb
        JOIN title_ratings tr ON tb.tconst = tr.tconst
        WHERE tb.genres ILIKE :genre AND tr.numVotes > 100000
        AND tb.titletype='movie' 
        ORDER BY RANDOM()
        LIMIT 10 ;");
            $genre = '%' . $genre . '%';
            $requete->bindParam(':genre', $genre, PDO::PARAM_STR);
            $requete->execute();
            return $requete->fetchAll(PDO::FETCH_ASSOC);
        

    }
    public function getPersonnePhoto($id) {
        $apiKey = "9e1d1a23472226616cfee404c0fd33c1";
        $url = "https://api.themoviedb.org/3/find/{$id}?api_key={$apiKey}&language=fr&external_source=imdb_id";
    
        try {
            $response = file_get_contents($url);
            $data = json_decode($response, true);
    
            $posterPath = "./Images/depannage.jpg"; // Photo de dépannage par défaut
    
            if (isset($data['person_results']) && count($data['person_results']) > 0 && isset($data['person_results'][0]['profile_path'])) {
                $posterPath = "https://image.tmdb.org/t/p/w400" . $data['person_results'][0]['profile_path'];
            }
    
            return $posterPath;
        } catch (Exception $error) {
            error_log("Erreur lors de la récupération des données: " . $error->getMessage());
            return "./Images/depannage.jpg";
        }
    }

    public function getFilmPhoto($id) {
        $apiKey = "9e1d1a23472226616cfee404c0fd33c1";
        $url = "https://api.themoviedb.org/3/find/{$id}?api_key={$apiKey}&language=fr&external_source=imdb_id";
    
        try {
            $response = file_get_contents($url);
            $data = json_decode($response, true);
            
            $tableau = ["movie_results", "tv_results", "tv_episode_results", "tv_season_results"];
            $posterPath = "./Images/depannage.jpg";
            foreach($tableau as $element){
                if(isset($data[$element][0]['poster_path']) && sizeof($data[$element]) > 0){
                    $posterPath ="https://image.tmdb.org/t/p/w400".$data[$element][0]['poster_path'];
                    break;
                }
            }
            
            // Retourne le chemin de l'image de dépannage si aucun poster n'est trouvé
            return $posterPath;
        } catch (Exception $error) {
            error_log("Erreur lors de la récupération des données: " . $error->getMessage());
            return "./Images/depannage.jpg"; // Retourne le chemin vers une image de dépannage en cas d'erreur
        }
    }



    public function getInfoFilm($id){
        $sql = "SELECT * FROM title_basics WHERE tconst = :tconst";
        $query = $this->bd->prepare($sql);
        $query->bindParam(":tconst", $id, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getInfoActeur($id){
        $sql = "SELECT * FROM name_basics WHERE nconst = :nconst";
        $query = $this->bd->prepare($sql);
        $query->bindParam(":nconst", $id, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);

    }

}
