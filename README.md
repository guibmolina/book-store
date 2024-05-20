##
## Book Store

## Local deployment

Make clone in your local

```bash
git clone git@github.com:guibmolina/book-store.git
```

**For deployment with docker is required to install [Docker](https://docs.docker.com/desktop/)**

With docker installed run on terminal  `docker-compose up -d`.

Copy filw `.env.example` e rename for  `.env` like the example.

```bash
cp .env.example .env
```

After creating the `.env` file, it will be necessary to access the application container to run some Laravel configuration commands..

For access container run `docker exec -it book-store bash`.

Type the following commands inside the container bash:

```bash
composer install
php artisan key:generate
php artisan migrate
```
## Endpoints

## Auth
###  Register User

Request
```
POST  api/v1/register

{
    "name":"Guilherme Molina",
    "email":"example@email.com",
    "password":"123456789",
}

```
Response
```
{
	"token": "XPTO123243452",
}
```
Field       | Type      | Require   
----------- | :------:  | :------:        
name        | string    	 | true                 
email	    | string         | true      
password    | string (min:4) | true

###  Login User

Request
```
POST  api/v1/login

{
    "email":"example@email.com",
    "password":"123456789",
}

```
Response
```
{
	"token": "XPTO123243452",
}
```
Field       | Type           | Require   
----------- | :------:       | :------:                      
email	    | string         | true      
password    | string         | true    

###  Logout User

Request
```
POST  api/v1/logout
Auth Bearer {token}
{}

```
Response
```
{}
```
   
###  List stores

Request
```bash
GET  /api/v1/stores
Auth Bearer {token}
```
Response
```
{
	"data": [
		{
			"id": 1,
			"name": "Best Store",
			"address": "1 Shakespeare Pl, Sydney NSW 2000",
			"active": 1,
			"books": []
		},
		{
			"id": 2,
			"name": "City of Sydney library",
			"address": "31 Alfred St, Sydney NSW 2000, Australia",
			"active": 1,
			"books": [
				{
					"id": 1,
					"name": "Maps of World"
					"isnb": 121546542,
					"value": 12.01
				}
			]
		},
	]
}
```

###  Show store by id

Request
```bash
GET  /api/v1/stores/{id}
Auth Bearer {token}
```
Response
```
{
	"data": {
			"id": 1,
			"name": "Best Store",
			"address": "1 Shakespeare Pl, Sydney NSW 2000",
			"active": 1,
			"books": [
				{
					"id": 1,
					"name": "Maps of World"
					"isnb": 121546542,
					"value": 12.01
				}
			]
		},
}
```

###  Create Store

Request
```
POST  api/v1/stores
Auth Bearer {token}

{
	"name": "Customs House Library",
	"address": "31 Alfred St, Sydney NSW 2000",
	"active": true
}

```
Response
```
{
	"data": {
		"id": 6,
		"name": "Customs House Library",
		"address": "31 Alfred St, Sydney NSW 2000",
		"active": 1,
        "books" : []
	}
}
```
Field       | Type           | Require   
----------- | :------:       | :------:                      
name	    | string         | true      
address     | string         | true   
active      | bool           | true   
book_ids    | array          | false   

###  Update Store

Request
```
PUT  api/v1/stores/{id}
Auth Bearer {token}

{
	"name": "Customs House Library",
	"address": "31 Alfred St, Sydney NSW 2000",
	"active": false,
    "book_ids" : [1]
}

```
Response
```
{
	"data": {
		"id": 6,
		"name": "Customs House Library",
		"address": "31 Alfred St, Sydney NSW 2000",
		"active": 0,
        "books": [
            {
            "id": 1,
            "name": "Maps of World"
            "isnb": 121546542,
            "value": 12.01
            }
        ]
	}
}
```
Field       | Type           | Require   
----------- | :------:       | :------:                      
name	    | string         | true      
address     | string         | true   
active      | bool           | true   
book_ids    | array          | false  

###  Delete Store

Request
```
DELETE  api/v1/stores/{id}
Auth Bearer {token}

{}
```
Response
```
{}
```
###  List books

Request
```bash
GET  /api/v1/books
Auth Bearer {token}
```
Response
```
{
	"data": [
		{
			"id": 4,
			"name": "Golden book",
			"isnb": 121546542,
			"value": 1222.01,
			"stores": [
				{
					"id": 3,
					"name": "Customs House Library",
					"address": "31 Alfred St, Sydney NSW 2000",
					"active": 1
				}
			]
		},
		{
			"id": 5,
			"name": "Silver book",
			"isnb": 1215465567,
			"value": 1122.01,
			"stores": [
				{
					"id": 3,
					"name": "Customs House Library",
					"address": "31 Alfred St, Sydney NSW 2000",
					"active": 1
				}
			]
		}
	]
}
```

###  Show  book by id

Request
```bash
GET  /api/v1/books/{id}
Auth Bearer {token}
```
Response
```
{
	"data": {
			"id": 4,
			"name": "Golden book",
			"isnb": 121546542,
			"value": 1222.01,
			"stores": [
				{
					"id": 3,
					"name": "Customs House Library",
					"address": "31 Alfred St, Sydney NSW 2000",
					"active": 1
				}
			]
		},
}
```

###  Create book

Request
```
POST  api/v1/books
Auth Bearer {token}

{
	"name": "Golden book",
	"isnb": 123454789,
	"value": 1222.00
}

```
Response
```
{
	"data": {
		"id": 5,
		"name": "Golden book",
		"isnb": 123454789,
		"value": 1222
	}
}
```
Field       | Type           | Require   
----------- | :------:       | :------:                      
name	    | string         | true      
isnb     	| int            | true   
value       | float          | true   
  

###  Update Book


Request
```
PUT  api/v1/books/{id}
Auth Bearer {token}

{
	"name": "Golden book",
	"isnb": 123454789,
	"value": 2222.00
}

```
Response
```
{
	"data": {
		"id": 5,
		"name": "Golden book",
		"isnb": 123454789,
		"value": 2222
	}
}
```
Field       | Type           | Require   
----------- | :------:       | :------:                      
name	    | string         | true      
isnb     	| int            | true   
value       | float          | true   


###  Delete book

Request
```
DELETE  api/v1/book/{id}
Auth Bearer {token}

{}
```
Response
```
{}
```
