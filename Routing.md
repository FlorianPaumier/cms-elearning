# cms-elearning

Projet annuel sur la création d'un cms



# Documentation
## Index.php

- Chargement autoload
- définition des chemins principaux. 
- Si l'environnement est en DEV, autorisations d'afficher les erreurs du serveurs
- Instanciation du kernel qui va gérer l'application
- Chargement de toutes les configs et parsing des supers globals

## Routing
- Matching
    - Suppression du dernier slach dans l'uri
    - Test des routes pour voir si elle sont bien formater
    - Test de la présence de paramètre. 
        - Si non => **Route simple** 
        - Si oui => **Route complex**
 - ### Route Simple 

    - Test si l'uri correspond à l'url de la route en cours de test
        - Si oui on retourne l'entrée sinon null
    
- ### Route Complex

    - Test le nombre de partie de l'url
    - Test si chaque partie qui n'est pas un paramètre,  est le même dans l'uri que dans la configuration
    - Récupération des paramètres
        - ```/{(\w+)<{1}(\\\\\w+\+)>{1}\??}/m``` 
            1. récupération d'une string (nom de paramètre)
            1. récupération du type (nullable)
    - Pour chaque paramètre, test s'il existe et s'il a le bon type
    - Si récupération des paramètres, ajout une entré params a la route

### Execution
- Test si une route a bien matché
- Test si la méthode demandé est respecter
- Execution de la route
    - Test si la route necessite au authentification et un rôle
    - Instantiation du controller et test si la méthod peut être appelée
    - Test si les paramètres sont vide ou non pour les injecter dans la méthode
  