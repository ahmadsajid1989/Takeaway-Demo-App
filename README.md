# TakeAway Demo App


This is a demo app created as an homework for takeaway.

* [Installation](#installation)
    * [Importing Data](#importing-data)
* [Usage](#usage)
* [API](#api)
* [Extras](#extras)
    * [Bonus Assignment](#bonus-assignment)
* [Code Coverage](#code-coverage-report)
* [Notes](#notes)

### Installation

This app is developed with Symfony. to install the app you first need to have composer installed in your system.

[Get composer here.](http://getcomposer.org).

1. Install Composer

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

2. run the Composer command to install the application:

```bash
php composer.phar install
```
During installation the system will prompt for the following parameters:

* database host,
* database name,
* database user,
* database password,

also for testing/development purpose, the system will prompt for :

* test_database host,
* test_database name,
* test_database user,
* test_database password

3. after installing, run the following command to optimize autoload files:

```bash
php composer.phar dump-autoload
```

4. create database using this command if you haven't already

**for production environment**

```bash
php bin/console doctrine:database:create  --env=prod
```

**for development environment**

```bash
php bin/console doctrine:database:create  --env=dev
```

5. create the schema

**production**

```bash
php bin/console doctrine:schema:create --env=prod
```

**development**

```bash
php bin/console doctrine:schema:create --env=dev
```

The Application is ready now.

#### Importing Data

you can start using the application by importing the csv sample data into database.

1. Delete the production cache

```bash
php bin/console cache:clear --env=prod --no-debug

```

2. import the provided sample data:

```bash
php bin/console takeaway:csv:import
```

when prompted, write yes/y and hit enter. This command will also validate data, so if any data is malformed, that particular field will be skipped.

you can also mention your custom directory and file name by adding argument:

```bash
php bin/console takeaway:csv:import --dir=data --fileName=data.csv
```

3. you can run the application in your preferred server, or you can use built in web server by running:

```bash
php bin/console server:run 127.0.0.1:8000
```

Hurray!! your api is now ready to serve your requests.

### Usage

From your browser/ postman go to :

```
http://127.0.0.1:8000/api/restaurant/
```

you will see the list of restaurants which we imported earlier. This application comes with a api documentation as well. you can visit:

```
http://127.0.0.1:8000/api/doc
```

To keep the application very simple and easy to manage, we will be using only end point for our current requirement. The default limit of result is 20, you can use:

```
?limit=40
```
to increase the limit. also to paginate you can use offset with limit. for example:

```
http://127.0.0.1:8000/api/restaurant?limit=5&offset=10
```

### API

The initial requirement for this assignment are:

Use the following priority of the sorting (from the highest to the lowest priority):
* Openings state : Restaurant is either open (top), you can order ahead (middle) or a
restaurant is currently closed (bottom).
* Sorting : Always one sort option is chosen and this can be best match , newest ,
rating average , popularity , average product price , delivery costs or the
minimum order amount costs .
* Search : Filter restaurants list by searching for restaurant name.

The api will list restaurants by default with opening state ( 2 as open, 1 as order ahead and 0as currently closed))

* For sorting with best match, use this endpoint:

```
http://127.0.0.1:8000/api/restaurant?order_by[best_match]=DESC
```

* to order by newest, use this end point:

```
http://127.0.0.1:8000/api/restaurant?order_by[newest_score]=DESC
```
and so on..

accepted parameters for sorting are :

* best_match
* newest_score
* rating_average
* popularity
* average_product_price
* delivery_costs
* minimum_order_amount

you can order by ASC( ascending ) or by DESC(descending). Also you can use combination of multiple params as a query parameter to sort your result.

* To search restaurant by name you can use filters in query parameter. for example:

```
http://127.0.0.1:8000/api/restaurant?filters[name]=Kerklaan Express
```

This will give you a payload of this queried restaurant. of course it's not ideal solution for for searching, we could use elastic search or sphinx to make the search more efficient and bring result with suggestive search, mis spelled search etc.

### Extras:


##### Bonus Assignment:

This api supports versioning by default. if you do not put

```
?version
```

in the query param the application properties will return its default result. This application supports versions in this order:

```php
- query
- custom_header
- media_type
```

query has been implemented others have no effect for now.

As per requirement, name property in Restaurant class has versioning. if you mention:

```
?version=v5.12.300
```

in your request, the api will return,

```json
{
    "RestaurantName": "La Gondolina",
    "id": 98001223,
    "branch": "",
    "phone": 641079539,
    "email": "info@lagondolina.nl",
    "logo": "/nl/3/logo.png",
    "address": "Karperweg",
    "housenumber": "3 hs",
    "postcode": "1075LA",
    "city": "Amsterdam",
    "latitude": 52.3486912,
    "longitude": 4.8570568,
    "url": "lagondolina",
    "open": 2,
    "best_match": 218,
    "newest_score": 1685,
    "rating_average": 9,
    "popularity": 91,
    "average_product_price": 10.93,
    "delivery_costs": 6.57,
    "minimum_order_amount": 6.57
 }
```

in all other cases the api will return :

```json
{
    "id": 98001223,
    "name": "La Gondolina",
    "branch": "",
    "phone": 641079539,
    "email": "info@lagondolina.nl",
    "logo": "/nl/3/logo.png",
    "address": "Karperweg",
    "housenumber": "3 hs",
    "postcode": "1075LA",
    "city": "Amsterdam",
    "latitude": 52.3486912,
    "longitude": 4.8570568,
    "url": "lagondolina",
    "open": 2,
    "best_match": 218,
    "newest_score": 1685,
    "rating_average": 9,
    "popularity": 91,
    "average_product_price": 10.93,
    "delivery_costs": 6.57,
    "minimum_order_amount": 6.57
}
```

### Code Coverage Report:

The code coverage report can be found in the coverage directory, in HTML format.

### Unit Tests:

To run the test case, please use this command:

````bash
./vendor/bin/phpunit
````


### Notes:

The unit testing configuration has dependency of its base test url. by default the url is set to:

````php
#phpunit.xml.dist
 <env name="TEST_BASE_URL" value="http://127.0.0.1:8000" />
````

if you run the app in another port or ip. please change the value accordingly. The tests will generate error if IP/ports do not match.
