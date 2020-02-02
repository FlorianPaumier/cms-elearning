# cms-elearning
Ce projet à pour but de simplifier la mise en place d'un site d'e-learning accessible à tous.
Ce cms va pouvoir donner l'opportunité à chacun de pour de pouvoir créer son propre environnement afin de donner des cours. 
En effet ce cms va vous permettre de mettre :
- Ajouter des cours en ligne 
- Un espace d'article (mis par l'administrateur du site)
## Getting Started

Pour commencer à utiliser le projet, vous aurez besoin d'installer : [here](#)

### Prerequisites

Les paquets à installer :

    Pour installer le serveur nginx il faudra mettre en place ce code :
        server {
    server_name localhost;
    root /var/www/html/public;

    location / {
       try_files $uri /index.php$is_args$args;
    }

    location ~ ^/index\.php(/|$) {
        client_max_body_size 50m;

        fastcgi_pass php:9000;
        fastcgi_buffers 16 16k;
        fastcgi_buffer_size 32k;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME /var/www/html/public/index.php;
    }

     error_log  /var/log/nginx/error.log;
     access_log /var/log/nginx/access.log;
}


| pdo_mysql | 

| pecl | 

| apcu | 

| libzip-dev |
| zlib1g-dev |
| libpq-dev | 
| libpng-dev |
| libfreetype6-dev |
| libyaml-dev |
| yaml | version 2.0.0 |


### Installing

```
Doit être mis à jour
```

## Running the tests

Expliquer comment effectuer les tests automatisés de ce système

## Deployment

Ajouter des notes supplémentaires sur la façon de déployer ce système en direct

## Contributing

Veuillez lire [CONTRIBUTING.md](CONTRIBUTING.md) pour obtenir des détails sur notre code de conduite et sur la procédure à suivre pour nous soumettre des pull requests.

## License

Ce projet est sous MIT License - voir le [LICENSE.md](LICENSE.md) dossier pour plus de détails

### Requirement
Pour voir le [requirement click here](/requirement.md)

### Info
Pour voir le [info click here](/info.md)

### Documentation
Pour voir le [documentation click here](/documentation.md)

### Issue
Pour voir le [Issue click here](/issue.md)

### Merge
Pour voir le [merge click here](/merge.md)

### Routing
Pour voir le [routing click here](/Routing.md)

### How to contribute ?
Click [here](/CONTRIBUTING.md)