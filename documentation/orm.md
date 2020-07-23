#cms-elearning

# Structure
 ## 1) QueryBuilder
 Ce fichier Permet de faire le dialogue entre notre cms et la base de données. 
 La connection s'effectue grâce à un Singelton.
 Cette partie ne contient que des fonctions permettant de générer une requete SQL et de récupérer des informations.
 ## 2) L'hydration
 Ce helper permet à toutes les classes dialoguant avec la base de données ou bien une classe qui souhaite 
 transformer une entité de récupérer les informations ou d'insérer des valeurs depuis un tableau.
 
 - Hydrate
    - La fonction permet d'insérer le résultat d'une requête sql dans un objet. Elle transforme les valeurs reçu en valeurs utilisables par 
    l'objet. Si l'une des valeurs en une clé étrangère, elle va allez chercher la valeur dans un maximum de 6 recherches et empêche les boucles infini si une entité à déjà été demandée.
 - HydrateRelation
    - Fait la même chose qu'au dessus mais pour les requêtes join.
 - GetData
    - Cette fonction permet de récupérer les valeurs de l'entité sous forme d'un tableau en transformant les valeurs pour qu'elles soit injectable dans le sql.
 ## 3) Entity Manager
 Cette classe va permettre de gérer l'insertion, la modification et la suppression des informations dans la base de données.
 Elles étend QueryBuilder.
 - Persist
    - Cette fonction va permettre d'ajouter ou bien de mettre à jours en fonction de la présence d'un Id dans l'objet. Elle récupère les informations
    via hydrator puis les ajoutes à une queue en attente d'un flush. Les objets qui sont passer, le sont par référence.
 - Delete
    - Elle permet de supprimer un objet dans la base de données.
 - flush
    - Cette fonction permet de clear la queue et ainsi executé toutes les requêtes d'un coup.
 ## 4) Repository
 Cette dernière partie est réalisée avec le design pattern Repository. Elle permet de récupérer les informations des classes via des fonctions
 pré-défini mais elle permet de créer des fonctions personnalisés.
 - findAll : Trouve toutes les entrées
 - find : Trouve l'entré avec l'id donnée
 - findBy : Trouve les entrés selon les critères données 
 - findOneBy : Trouve l'entré selon les critères données
 - exist : Regarde s'il existe des entrés selon les critères données
 - paginate : Récupère toutes les entrés dans la range demandé et créer une pagination qui correspond
 - join : Retourne les informations avec une jonction selon le type demandé