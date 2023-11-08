# API

## Étudiants
- Léo STEVENOT
- Nathan PONCET

## Installation
```shell
composer install                                              # Installation des dépendances
php8.2 bin/console doctrine:database:create                   # Créationde la BDD
php8.2 bin/console doctrine:schema:update --complete --force  # Synchronisation de la BDD
php8.2 bin/console doctrine:fixtures:load --append            # Ajout de la fixture utilisateur
```

## Server
```shell
symfony serve:start # Démarre un server local
```

## Routes 
### SIte
- Rechercher une entreprise : https://127.0.0.1:8000/entreprise/recherche
- Calcul salaire : https://127.0.0.1:8000/entreprise/salaire

### API
> [Collection Postman](api-entreprise.postman_collection.json) pour cette API
#### Publique 
- [GET] Liste des entreprises : https://127.0.0.1:8000/api-ouverte-ent-liste
- [GET] Une entreprise : https://127.0.0.1:8000/api-ouverte-ent-liste/{SIREN}
- [POST] Créer une entreprise : https://127.0.0.1:8000/api-ouverte-ent
#### Privée
- [PATCH] MAJ d'une entreprise : https://127.0.0.1:8000/api-protege/{SIREN}
- [DELETE] Suppression d'une entreprise : https://127.0.0.1:8000/api-protege/{SIREN}

