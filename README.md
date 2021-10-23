# BileMo

**Projet pédagogique :** créer une API REST permettant aux entreprises de consulter un catalogue de smartphones et gérer des clients. 

## Sommaire
1.  __[Librairies utilisées](#Librairies-utilisées)__

2.  __[Pré-requis](#Pré-requis)__

3.  __[Télécharger le projet](#Télécharger-le-projet)__

4. __[Indiquer l'URL de la base de données](#Indiquer-l'URL-de-la-base-de-données)__

5. __[Créer des identifiants client OAuth 2.0](#Créer-des-identifiants-client-OAuth-2.0-pour-permettre-à-l'application-d'accéder-aux-API-de-Google)__

6. __[Installer les dépendances](#Installer-les-dépendances)__

7. __[Installer la base de données et les tables](#Installer-la-base-de-données-et-les-tables)__

8. __[Charger les smartphones et les utilisateurs de l'API dans la base de donnnées](#Charger-les-smartphones-et-les-utilisateurs-de-l'API-dans-la-base-de-donnnées)__

9. __[Lancer le serveur de développement](#Lancer-le-serveur-de-développement)__

10. __[URI pour accéder à la documentation de l'API](#URI-pour-accéder-à-la-documentation-de-l'API)__
---

## Librairies utilisées

**Création de l'API REST :** FriendsOfSymfony/FOSRestBundle 

**Authentification OAuth2 avec Google :** knpuniversity/oauth2-client-bundle et thephpleague/oauth2-google 

**Serializer :** jms/serializer-bundle

**Documentation de l'API :** nelmio/NelmioApiDocBundle

## Pré-requis

PHP >= 7.2.5
Composer

## Télécharger le projet

Téléchargez ou clonez le projet ([voir la documentation GitHub](https://docs.github.com/en/github/creating-cloning-and-archiving-repositories/cloning-a-repository)). 

## Indiquer l'URL de la base de données

Créez un fichier « .env.local » à la racine du projet et indiquez votre variable DATABASE_URL :

```bash
DATABASE_URL="mysql://..."
```
## Créer des identifiants client OAuth 2.0 pour permettre à l'application d'accéder aux API de Google 

**Connectez-vous à votre compte sur https://console.cloud.google.com** (ou créez un compte si besoin).

**Créez un nouveau projet :** cliquez sur « Sélectionner un projet » puis « Nouveau projet ».

**Choisissez un nom de projet (exemple BileMo) et cliquez sur « CRÉER ».**

**Créez un écran de consentement** (onglet « API et services » -> « Écran de consentement OAuth »).

Google présentera cet écran à l'utilisateur pour lui montrer un récapitulatif de votre projet et des règles qui s'y appliquent, ainsi que les périmètres d'accès demandés (nom, mail, ...). Si l'utilisateur rentre l'email et le mot de passe de son compte Google, il autorise Google à transmettre à l'application certaines données de son compte Google.

-> User Type : Externes

-> Informations sur l'application (informations qui apparaîtront dans l'écran de consentement pour permettre aux utilisateurs finaux de vous identifier et vous contacter.)

- Nom de l'application : choix arbitraire
- Adresse e-mail d'assistance : choix arbitraire

-> Les champs d'application (autorisations que vous demandez aux utilisateurs d'accorder à votre application)

- .../auth/userinfo.email
- .../auth/userinfo.profile
- openid

**Créez les identifiants de l'application** (onglet « Identifiants » -> « CRÉER DES IDENTIFIANTS » -> « ID client OAuth »).

-> Type d'application : Application Web

-> Nom : choix arbitraire

-> Origines JavaScript autorisées : ne rien mettre

-> URI de redirection autorisés : http://127.0.0.1:8000/connect/google/check

-> Cliquez sur « CRÉER »

**Copiez votre ID client et code secret dans le fichier .env.local :**

```bash
GOOGLE_ID=...
GOOGLE_SECRET=...
```

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
php bin/console doctrine:fixtures:load
```

## Lancer le serveur de développement

```bash
symfony server:start
```

## URI pour accéder à la documentation de l'API

/api/doc
