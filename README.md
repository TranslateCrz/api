# TranslateCrz Api

## Launch on dev

* Create docker images : ```docker compose up -d```
* Go inside the php container : ```docker exec -it localize-app sh```
* Install dependencies : ```composer install```
* Create the database, execute migrations and load fixtures :```make clear```

## API documentation

The swagger documentation is available in [localhost:8000/doc.json](localhost:8000/doc.json)
