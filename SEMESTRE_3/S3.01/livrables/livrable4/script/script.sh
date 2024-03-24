#!/bin/bash

# Paramètres du script
gz_file="$1"
table_name="$2"
db_user="$3"
db_name="$4"
db_password="$5"

# Décompresser le fichier
tsv_file="${gz_file%.*}"
gunzip -c "$gz_file" > "$tsv_file"

# Supprimer tous les guillemets du fichier
sed -i '' 's/"//g' "$tsv_file"

# Utiliser la commande COPY de PostgreSQL pour insérer les données
# et mesurer le temps d'exécution
start_time=$(date +%s)
PGPASSWORD="$db_password" psql -U "$db_user" -d "$db_name" -c "\COPY $table_name FROM '$tsv_file' DELIMITER E'\t' NULL AS '\N' CSV HEADER"
end_time=$(date +%s)

execution_time=$(($end_time-$start_time))
echo "Temps d'insertion des données : $execution_time secondes"
