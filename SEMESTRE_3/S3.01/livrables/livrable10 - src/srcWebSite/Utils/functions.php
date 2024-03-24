<?php
function e($message)
{
    return htmlspecialchars($message, ENT_QUOTES);
}

function generatePaginationLink($page, $currentParams) {
    // Récupérer tous les paramètres de la requête actuelle
    $queryParams = $_POST;

    // Supprimer le paramètre 'page' s'il existe
    unset($queryParams['page']);

    // Fusionner les paramètres actuels avec ceux de la pagination
    $params = array_merge($queryParams, ['page' => $page]);

    // Générer le lien de pagination avec les paramètres de filtre
    $queryString = http_build_query($params);
    return "?controller=recherche&action=rechercher&$queryString";
}
