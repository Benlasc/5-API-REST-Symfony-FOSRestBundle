BileMo est une API permettant aux entreprises de consulter un catalogue de smartphones et gérer des clients.

### Environnement de développement

## Pré-requis

PHP >= 7.2.5
Composer

## Installer les dépendances

```bash
composer install
```

## Installer la base de données et les tables

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

## Charger les smartphones et les utilisateurs de l'API dans la base de donnnées

```bash
composer require --dev orm-fixtures
php bin/console doctrine:fixtures:load
```

## Lancer le serveur de développement

```bash
php bin/console server:run
```

## URI pour accéder à la documentation de l'API

/api/doc
