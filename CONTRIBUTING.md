# Contributing

Lorsque vous contribuez à ce projet, veuillez d'abord discuter de la modification que vous souhaitez apporter via une Issue, un mail ou toute autre méthode avec les propriétaires de ce projet avant d'effectuer toute modification.

Veuillez noter que nous avons un code de conduite, veuillez le suivre dans toutes vos interactions avec le projet.

## Code de conduite

### Notre engagement

Afin de favoriser un environnement ouvert et accueillant, nous
les contributeurs et les mainteneurs s'engagent à participer à notre projet et notre communauté pour une expérience sans harcèlement pour tout le monde, peu importe l'âge, la taille, l'handicap, l'origine ethnique, l'identité, le niveau d'expérience, la nationalité, l'apparence personnelle, la religion ou l'orientation sexuelle.

### Nos normes communautaires

Les exemples de comportements qui contribuent à créer un environnement positif incluent :

* Utiliser un langage accueillant et inclusif (non sexiste)
* Être respectueux des différents points de vue et expériences de chacun
* Accepter gracieusement les critiques constructives
* Se concentrer sur ce qui est le mieux pour la communauté
* Faire preuve d'empathie envers les autres membres de la communauté

Voici des exemples de comportement inacceptables :

* L'utilisation de langage ou d'images à caractère pornographique
* Commentaires insultants / désobligeants et attaques personnelles ou politiques
* Harcèlement public ou privé
* Publier les informations privées d'autrui, comme une adresse mail, sans autorisation explicite
* Autres comportements qui pourraient raisonnablement être considérés comme inappropriés dans un cadre professionnel

### Nos normes de développement

L'ensemble du projet doit réspecter des normes de nommage qui sont les suivantes :

1. Les classes : `class.class.php`
2. Les vues : `view.view.php`
3. Les templates : `tpl.tpl.php`
4. Les services : `service.service.php`
5. Les variables : toutes les variables doivent êtres nommées en `anglais`.
6. Les commentaires : tous les commentaires doivent être rédigés `en anglais et en français`.
7. Les fonctions : chaque fonction ne doit pas dépasser `30 lignes`.

À chaque fin de fonctionnalité, il faut rédiger une petite documentation afin d'expliquer les changements qu'apportent cette fonctionnalité, comment nous nous en servons, etc...

## Workflow

### Branches

* `Master` est la branche de production et `Develop` est la branche de développement.
* Pour chaque fonctionnalité, il faut créer une branche attitrée (Exemple : Fonctionnalité de chat -> branche `dev_chat`).

### Commits

Pour chaque commit, il faut rédiger un titre clair et une description en français.

### Merges

Pour merge la branche d'une fonctionnalité dans `Master`, il faut tout d'abord merge la branche de la fonctionnalité dans `Develop`, puis merge `Develop` dans `Master`.

### Issues

Pour déclarer la correction d'une issue, nommer le fix avec la norme suivante : `fix-(n° de l'issue)`

## Processus Pull Request

1. Mettre à jour le fichier README.md avec les détails des modifications apportées à l'interface, cela inclut les nouvelles variables d'environnement, ports exposés, emplacements de fichiers utiles et paramètres de conteneurs.

2. Augmentez les numéros de version dans tous les fichiers d'exemples et le fichier README.md à la nouvelle version que ce Pull Request représenterait.

3. Vous pouvez fusionner la Pull Request une fois que vous avez la signature de deux autres développeurs, ou si vous n'êtes pas autorisés à le faire, vous pouvez demander à un `Maintainer` de le fusionner pour vous.