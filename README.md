# asgardcms-iplaces

## Settings
    - Api maps from Google

## General Status (For Places and other else)
    - INACTIVE = 0;
    - ACTIVE = 1;
  
## Api Examples


### Places

#### List all places with relations

https://mydomain.com/api/iplace/places?include=category,schedule,zone,province,city,services

#### List all places with Relations,Pagination and Filter

https://mydomain.com/api/iplace/places?include=category,schedule,zone,province,city,services&page=1&filter={"categories":[1,2],"gama":[0],"qperson":10,"zones":[2]}

#### Get a place (Parameter = ID )

https://mydomain.com/api/iplace/places/1?include=category,schedule,zone,province,city,services

#### Get a place (Parameter = slug )

https://mydomain.com/api/iplace/places/prueba-1?include=category,schedule,zone,province,city,services

### Categories

#### List all categories with relations

https://mydomain.com/api/iplace/categories

#### Get a category (Parameter = ID or Slug )

https://mydomain.com/api/iplace/categories/40


### Shedules
    - List All = Same that category
    - One = By id or title

### Services
    - List All = Same that category
    - One = Same that category

### Zones
    - List All = Same that category
    - One = By id or title

