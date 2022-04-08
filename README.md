# TranslateCrz Api

This API is part of the [TranslateCrz Project](https://github.com/TranslateCrz), it is RESTFull and fully tested.

---
This API was originally made for a school project, it was missing some important features like Testing, CI / CD and documentation.

## Database structure

[MySQL](https://www.mysql.com/) is used for data storage

![localize](https://user-images.githubusercontent.com/33249071/162433351-b0273f3d-7cb1-49ea-a00d-ce113d6caebf.png)
## File structure

This API is made with [PHP](https://www.php.net/) 8.1 and [Symfony](https://symfony.com/) 5.4
```
<API>/
├─ config/
├─ docker/
├─ migrations/
├─ public/
├─ src/
|   └─ Application/
|       └─ Dto/
|       └─ Exception/
|       └─ Repository/
|       └─ Service/
|       └─ Validator/
|   └─ Controller/
|       └─ AccountController.php
|       └─ AdminController.php
|       └─ TranslationController.php
|   └─ DataFixtures/
|   └─ Domain/
|       └─ Factory/
|       └─ Service/
|   └─ Entity/
|       └─ Account.php
|       └─ Translation.php
|   └─ Repository/
|   └─ Security/
|       └─ EmailAuthenticator.php
|   └─ View/
├─ tests/
|   └─ Functional/
|   └─ Unit/
├─ .env
├─ docker-compose.yml
├─ composer.json
├─ Makfile
└─ README.md
```

## Launch on dev

* Create docker images : ```docker compose up -d```
* Go inside the php container : ```docker exec -it localize-app sh```
* Install dependencies : ```composer install```
* Create the database, execute migrations and load fixtures :```make clear```

## API documentation

The swagger documentation is available in [localhost:8000/doc.json](http://localhost:8000/doc.json)
