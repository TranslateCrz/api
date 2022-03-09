# MT5-Fullstack-project

- Sujet : Outil de localisation/internationalisation du code

- Nom : à définir

Crée un package de gestion de traduction, afin de proposer une alternative à localise/phraseapp, plus simple a installer pour des petit projet

## Principe de fonctionnement:

- FRONT - Component React/Vue pour la gestion des trad en front
- BACK - API REST pour crud des trad et export de fichier 
- BACK - Component Admin pour la gestion du crud 
- BACK - Worker pour proposé une première traduction (avec l'utilisation de DeepL)
- Infra - Gestion de monté de charge

## Feature:

Pour un PO/Admin/Client: Crud de traduction via un back-office, exportation de fichier sous csv

Pour un Dev: Crud de traduction via soi composant Front ou back-office, exportation des clés de traduction pour utilisation

## Launch API

* Create docker images : ```docker compose up -d```
* Go inside the php container : ```docker exec -it localize-app sh```
* Install dependencies : ```composer install```
* Create the database, execute migrations and load fixtures :```make clear```

## API documentation

The swagger documentation is available in [localhost:8000/doc.json](localhost:8000/doc.json)
