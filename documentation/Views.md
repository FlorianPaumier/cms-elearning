# Gestion des vues
## L'utilisation
1) Dans les controllers

Pour utilisé une vue dans un controller il faut retourné la function render() avec le chemin depuis le dossier views ou bien le chemin absolue. L'utilisation de l'extention n'est pas
obligatoire si celle-ci est dans les extensions enregistrées.

2) Le contenu

Le HTML, le CSS, le PHP, Le JS sont autorisés. Pour le php, une balise fermante est obligatoire.
L'insertion des données peuvent ce faire via le php <?= $var ?> ou bien via les tags {{ var }}. Pour ce qui est des boucles, conditions elles ce font via le php.

3) Gestion des Includes et Extend

Pour étendre ou bien inclure des fichiers, il faut utilisé @extend() ou bien @include() avec le chemin depuis le dossier views

## Le fonctionnement

-> Utilisation de la fonction render
    -> On récupère le fichier
        -> On test si le fichier existe selon plusieurs critères
    -> Si le fichier exsite on sauvegarde les données dans une variable avec certaines options
        -> Si le fichier ce trouve dans le cache, on le récupère
        -> Sinon on commence le parsing de la vue par charger son contenu puis étendre le fichier si besoin
            -> Pour étendre, on recherche le tag qui correspond, puis on recherche le fichier demander
                -> On récupère les fichiers à inclure si besoin et on répète l'action tant qu'il est nécessaire
            -> On inclu les fichiers si besoin et on les parses tant qu'il est nécessaire
        -> Si la vue doit être directement rendu, on la compile
        -> Sinon on la retourne
    -> Le kernel va appeler la fonction compile si l'objet render est retourné sinon il display la string
        -> On parse le contenu pour récupérer les fonctions et les tags
        -> Si des fonctions sont trouvées, on va allez remplacer le tag par le résultat de la fonction
        -> Si la variable tags est à true, on va
            -> mettre en cache le squelette.
            -> On reparse la vue et on remplace les tags et fonctions si nécessaire.
        -> Si la fonction render est demandée, on retourne directement le résultat
        ->Sinon on affiche la vue avec un include qui permet de générer le php
    ->Sinon on faire remonter une erreur 404

La recherche des différents tags ce fait via des regexs
