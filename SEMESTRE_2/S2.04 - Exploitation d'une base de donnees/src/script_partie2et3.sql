-- les vues partie 2

CREATE view nombre_etudiants as
    SELECT count(*) 
        from etudiant as nombre_etudiants;

CREATE view notes_matiere AS
    SELECT Matiere,Controle,Note, Nom, Prenom
        FROM Matiere natural join Controle
            natural join Notes natural join Etudiant
        order by matiere, controle;

CREATE view controles_matiere AS
    SELECT matiere,controle
        FROM Matiere natural join Controle
        where matiere.matiere_id=controle.matiere_id;

CREATE view moy_groupes AS
    SELECT Etudiant.nomgroupe, avg(note)::decimal(4,2) as moyenne
        from notes natural join etudiant natural join groupe
        group by nomgroupe
        order by moyenne;

CREATE VIEW moyennes_matiere AS
    SELECT Etudiant.Etudiant_id, Nom, Prenom, Matiere.matiere, round(avg(note),2) as moyenne
        FROM Etudiant natural join Notes natural join 
        Controle natural join Matiere
        WHERE (Matiere.Matiere_id=Controle.Matiere_id
            AND Controle.Controle_id =Notes.Controle_id
            AND Notes.Etudiant_id =Etudiant.Etudiant_id)
        GROUP BY Etudiant.etudiant_id, Nom, Prenom, Matiere.matiere;

-- les procédures partie 2

CREATE or REPLACE FUNCTION moy_grp_specifique(in grp varchar, out nomgroupe varchar, out moyenne numeric)
returns setof record
AS $$
    SELECT Etudiant.nomgroupe, avg(note)::decimal(4,2) as moyenne
        from notes natural join etudiant natural join groupe
        where nomgroupe=grp
        group by nomgroupe;

$$ language SQL;

CREATE or REPLACE FUNCTION moy_general_etudiant( in id integer, out nom varchar,out prenom varchar,out decimal(4,2))
AS $$
    select nom,prenom, avg(note)::decimal(4,2) as moyenne
        from notes natural join etudiant
        where etudiant_id=id
        group by nom,prenom;

$$ language SQL;

CREATE or REPLACE FUNCTION moy_matiere( in mat varchar, out matiere varchar, out decimal(4,2))
AS $$
    select matiere,avg(note)::decimal(4,2) as moyenne
        from matiere natural join controle 
            natural join notes natural join etudiant
        where matiere=mat
        group by matiere;

$$ language SQL;

CREATE or REPLACE FUNCTION etudiant_grp( in grp varchar, out nom varchar, out prenom varchar)
returns setof record
AS $$
    SELECT nom,prenom
        FROM Etudiant 
            natural join Groupe
        where etudiant.nomgroupe=grp;

$$ language SQL;

CREATE or REPLACE FUNCTION notes_groupe(in grp varchar, out matiere varchar, 
                                        out controle varchar, out note numeric, 
                                        out nom varchar, out prenom varchar)
returns setof record
AS $$
    select Matiere, Controle, Note, nom, prenom
        from matiere natural join controle 
            natural join notes natural join etudiant
        where etudiant.nomgroupe=grp;

$$ language SQL;

-- les accès (roles, permissions) partie 3

CREATE ROLE administrateur ADMIN role_membre PASSWORD "iut_villetaneuse_2023_admin";
CREATE ROLE responsable_matiere ADMIN role_membre PASSWORD "iut_villetaneuse_2023_matiere";
CREATE ROLE enseignant ADMIN role_membre PASSWORD "iut_villetaneuse_2023";
CREATE ROLE etudiant;

GRANT (INSERT,UPDATE,DELETE,SELECT) ON * TO administrateur WITH GRANT OPTION;
GRANT (INSERT,UPDATE,DELETE,SELECT) ON (Competences,Matiere) TO responsable_matiere WITH GRANT OPTION;
GRANT (INSERT,UPDATE,DELETE,SELECT) ON (Controle, Notes) TO enseignant WITH GRANT OPTION;
GRANT SELECT ON (notes_etudiant, Matiere, Competences, Etudiant, Groupe) TO etudiant WITH GRANT OPTION;

REVOKE INSERT,UPDATE,DELETE ON * FROM etudiant;

CREATE view notes_etudiant AS
    SELECT Matiere,Controle,Note
        FROM Matiere natural join Controle
            natural join Notes natural join Etudiant
        WHERE nom=current_user OR prenom=current_user;

CREATE view etudiants_de_son_grp AS
    SELECT etudiant_id,nom,prenom
        FROM etudiant
        WHERE nomgroupe=(select nomgroupe from etudiant where nom=current_user);