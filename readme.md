# API

## Étudiants
- Léo STEVENOT
- Nathan PONCET

## Installation
```shell
composer install
php8.2 bin/console doctrine:database:create 
php8.2 bin/console doctrine:schema:update --complete --force
php8.2 bin/console doctrine:fixtures:load --append
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
- [GET] Liste des entreprises : https://127.0.0.1:8000/api-ouverte-ent-liste
- [GET] Une entreprise : https://127.0.0.1:8000/api-ouverte-ent-liste/{SIREN}
- [POST] Créer une entreprise : https://127.0.0.1:8000/api-ouverte-ent
