DROP TABLE IF EXISTS Competences;
DROP TABLE IF EXISTS Groupe;
DROP TABLE IF EXISTS Notes;
DROP TABLE IF EXISTS Controle;
DROP TABLE IF EXISTS Matiere;
DROP TABLE IF EXISTS Moyenne;
DROP TABLE IF EXISTS Etudiant;

CREATE TABLE Etudiant (
    Etudiant_id serial primary key,
    Nom varchar(50),
    Prenom varchar(50),
    NomGroupe varchar(50)
);
 
CREATE TABLE Moyenne (
    Moyenne_id int primary key,
    Moyenne float
);
 
CREATE TABLE Matiere(
    Matiere_id varchar(10) primary key,
    Matiere varchar,
    Coefficient int
);
 
CREATE TABLE Controle (
    Controle_id serial primary key,
    Matiere_id varchar(10) references Matiere(Matiere_id),
    Controle varchar
);
 
CREATE TABLE Notes (
    Etudiant_id int references Etudiant(Etudiant_id),
    Controle_id int references Controle(Controle_id),
    Moyenne_id int references Moyenne(Moyenne_id),
    Note decimal(4,2),
    primary key(Etudiant_id,Controle_id,Moyenne_id)
);
 
 
CREATE TABLE Groupe (
    Groupe_id int primary key,
    NomGroupe varchar(50)
);
 
CREATE TABLE Competences(
    Competence_id int primary key,
    Matiere_id varchar(10) references Matiere(Matiere_id),
    Competence varchar(50)
);

SELECT * from Etudiant;
SELECT * from Moyenne;
SELECT * from Matiere;
SELECT * from Controle;
SELECT * from Notes;
SELECT * from Groupe;
SELECT * from Competences;