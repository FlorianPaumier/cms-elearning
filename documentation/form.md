#cms-elearning

#Le gestionnaire de formulaire
Les formtypes sont des structures permettant de générer le html dans la vue ainsi que les règle de validation. 
- buildForm
    - Cette fonction va permettre créer la structure via des *Type*.
    - Pour chaque inputs,
        - on va lui donner un nom qui va correspondre à un paramètres de l'entité si elle est défini
        - On lui donne un Type dans la liste 
        
        |  Nom          | Type                 |
        |---------------|----------------------|
        |  ButtonType   |  Button              | 
        |  CheckboxType |  Checkob Input       |
        |  DateTimeType |  Date Input          | 
        |  ChoiceType   |  Select Input        |   
        |  EmailType    |  Text Input          |   
        |  EntityType   |  Select Input        |   
        |  ImageType    |  File Input          |   
        |  IntegerType  |  Number Input        |   
        |  RadioType    |  Radio Input         |   
        |  OptionType   |  Select Option Input |   
        |  PhoneType    |  Text Input          |   
        |  SelectType   |  Select Input        |   
        |  SubmitType   |  Button              |   
        |  TextAreaType |  Textaera            |   
        |  TextType     |  Text Input          |
        
        - Ensuite on va lui données des paramètres pour générer l'élément html
         et les règles de validations. Certains inputs nécessite des paramètres obligatoire   

    - configureOption
        - Permet de donner des informations globals au formulaire comme l'entité utilisé comme model.
    - getBlockPrefix 
        - Permet de customiser et différencier les inputs de différents formulaire dans le cas où il y en aurais plusierus sur la même page.
        
#la création du formulaire
Lors de la création du formulaire, chaque entrées dans le buildForm va être transformer en un objet pouvant être traduit en un élément Html. 
Pour ça il y a une validation et une insertion des informations de l'entité passer en paramètre.

- SelectType, ChoiceType, CheckboxType, RadioType, EntityType
    - Transforme un tableau de données en éléments html avec les valeurs données

#la récupération des données

Via la fonction handleRequest, le formulaire va récupérer les informations transmis par le formulaire et les insérer dans l'entité.

#validation du formulaire
Grâce au contraintes donner dans le formtype, chaque inputs est vérifier et retourne une erreur en fonction de chaque contraintes au quel il n'a pas répondu
