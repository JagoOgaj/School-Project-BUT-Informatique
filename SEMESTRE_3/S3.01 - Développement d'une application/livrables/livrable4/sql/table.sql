DROP TABLE IF EXISTS name_basics CASCADE;
CREATE TABLE IF NOT EXISTS name_basics (
  nconst VARCHAR(11) PRIMARY KEY,
  primaryName TEXT,
  birthyear INTEGER,
  deathYear INTEGER,
  primaryProfession TEXT,
  knownForTitles TEXT
);

DROP TABLE IF EXISTS title_akas CASCADE;
CREATE TABLE IF NOT EXISTS title_akas (
  titleId TEXT,
  ordering INTEGER,
  title TEXT,
  region TEXT,
  language TEXT,
  types TEXT,
  attributes TEXT,
  isOriginalTitle INTEGER,
  PRIMARY KEY(titleId, ordering)
);

DROP TABLE IF EXISTS title_basics CASCADE;
CREATE TABLE IF NOT EXISTS title_basics (
  tconst VARCHAR(11) PRIMARY KEY,
  titleType TEXT,
  primaryTitle TEXT,
  originalTitle TEXT,
  isAdult INTEGER,
  startYear INTEGER,
  endYear TEXT,
  runtimeMinutes INTEGER,
  genres TEXT
);

DROP TABLE IF EXISTS title_crew CASCADE;
CREATE TABLE IF NOT EXISTS title_crew (
  tconst VARCHAR(11) PRIMARY KEY,
  directors TEXT,
  writers TEXT
);

DROP TABLE IF EXISTS title_episode CASCADE;
CREATE TABLE IF NOT EXISTS title_episode (
  tconst VARCHAR(11) PRIMARY KEY,
  parentTconst TEXT,
  seasonNumber INTEGER,
  episodeNumber INTEGER
);

DROP TABLE IF EXISTS title_principals CASCADE;
CREATE TABLE IF NOT EXISTS title_principals (
  tconst TEXT,
  ordering INTEGER,
  nconst TEXT,
  category TEXT,
  job TEXT,
  characters TEXT,
  PRIMARY KEY(tconst, ordering)
);

DROP TABLE IF EXISTS title_ratings CASCADE;
CREATE TABLE IF NOT EXISTS title_ratings (
  tconst VARCHAR(11) PRIMARY KEY,
  averageRating DOUBLE PRECISION,
  numVotes INTEGER
);
-- Création de la table UserData
DROP TABLE IF EXISTS UserData CASCADE;
CREATE TABLE UserData (
    userId SERIAL PRIMARY KEY,
    username TEXT,
    password TEXT,
    connectionTime TIMESTAMP,
    email TEXT,
    name TEXT,
    country TEXT
);

-- Création de la table RechercheData
DROP TABLE IF EXISTS RechercheData CASCADE;
CREATE TABLE RechercheData (
    rechercheId SERIAL PRIMARY KEY,
    motCle TEXT,
    userId INT,
    typeRecherche TEXT,
    rehcercheTime TIMESTAMP,
    FOREIGN KEY (userId) REFERENCES UserData(userId)
);

DROP TABLE IF EXISTS ResetPassWord CASCADE;
CREATE TABLE ResetPassWord (
    resetId SERIAL PRIMARY KEY,
    userId INT,
    resetToken TEXT,
    FOREIGN KEY (userId) REFERENCES UserData(userId)
);

DROP TABLE IF EXISTS FavorieFilm CASCADE;
CREATE TABLE FavorieFilm (
    favorieFilmId SERIAL PRIMARY KEY,
    userId INT,
    filmId TEXT,
    FOREIGN KEY (userId) REFERENCES UserData(userId)
);

DROP TABLE IF EXISTS FavorieActeur CASCADE;
CREATE TABLE FavorieActeur (
    favorieActeurId SERIAL PRIMARY KEY,
    userId INT,
    acteurId TEXT,
    FOREIGN KEY (userId) REFERENCES UserData(userId)
);

DROP TABLE IF EXISTS CommentaryMovie CASCADE;
CREATE TABLE CommentaryMovie (
    CommentaryMovieID SERIAL PRIMARY KEY,
    userId INT,
    MovieId TEXT,
    TitreCom TEXT,
    Commentary TEXT,
    Anonyme BOOLEAN,
    Rating INT,
    FOREIGN KEY (userId) REFERENCES UserData(userId)
);

DROP TABLE IF EXISTS CommentaryActor CASCADE;
CREATE TABLE CommentaryActor (
    CommentaryActorID SERIAL PRIMARY KEY,
    userId INT,
    ActorID TEXT,
    TitreCom TEXT,
    Commentary TEXT,
    Anonyme BOOLEAN,
    Rating INT,
    FOREIGN KEY (userId) REFERENCES UserData(userId)
);
