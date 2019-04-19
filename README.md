TakeAway Demo App
=================

This is a demo app created as an homework for takeaway.

This app is developed with Symfony. to install the app you first need to have composer installed in your system.

[Composer](http://getcomposer.org).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the application:

```bash
php composer.phar install
```
During installation the system prompt for some parameters, such as:
 database host,
 database name,
 database user,
 database password,
 
also for testing/dev the system will prompt for :

 test_database host,
 test_database name,
 test_database user,
 test_database password
 
 after installing run the following command to optimize autoload files
 
 ```bash
php composer.phar dump-autoload
```

Then create database using this command if you haven't already

for production

```bash
php bin/console doctrine:database:create  --env=prod
```

and for dev

```bash
php bin/console doctrine:database:create  --env=dev
```

Next create the schema

```bash
php bin/console doctrine:schema:create --env=prod
```

and for dev environment

```bash
php bin/console doctrine:schema:create --env=dev
```

Now that the application is ready, you can start using the application by importing the csv sample data into database. To do that, run this command:

first set the environment to production
```bash
php bin/console cache:clear --env=prod --no-debug

```

then import the provided sample data:

```bash
php bin/console takeaway:csv:import
```

when prompt write yes/y then hit enter. This command will also validate data, so any data is malformed, that particular field will be skipped.

you can also mention your custom directory and file name by adding argument:

```bash
php bin/console takeaway:csv:import --dir=data --fileName=data.csv
```

Now, you can run the application in your preferred server, or you can use built in web server by running:

```bash
php bin/console server:run 127.0.0.1:8000
```

Hurray!! your api is now ready to serve your requests.

now from your browser/ postman go to :

```http request
http://127.0.0.1:8000/app_dev.php/api/restaurant/
```

you will see the list of restaurants which we imported earlier. This application comes with a api documentation as well. you can visit:

```http request
http://127.0.0.1:8000/app_dev.php/api/doc
```

To keep the application very simple and easy to manage, we will be using only end point for our current requirement.

The initial requirement for this assignment are:

Use the following priority of the sorting (from the highest to the lowest priority):
● Openings state : Restaurant is either open (top), you can order ahead (middle) or a
restaurant is currently closed (bottom).
● Sorting : Always one sort option is chosen and this can be best match , newest ,
rating average , popularity , average product price , delivery costs or the
minimum order amount costs .
● Search : Filter restaurants list by searching for restaurant name.

The api will list restaurants by default with opening state ( 2 as open, 1 as order ahead and 0as currently closed))

For sorting with best match, use this endpoint:

```http request
http://127.0.0.1:8000/app_dev.php/api/restaurant?order_by[best_match]=DESC
```

Then to order by newest, use this end point:

```http request
http://127.0.0.1:8000/app_dev.php/api/restaurant?order_by[newest_score]=DESC
```

and so on.. you can order by ASC( ascending ) or by DESC(descending). Also you can use combination of multiple params as a query parameter to sort your result.

To search restaurant by name you can use filters in query parameter. for example:

```http request
http://127.0.0.1:8000/app_dev.php/api/restaurant?filters[name]=Kerklaan Express
``` 

This will give you a payload of this queried restaurant. of course it's not ideal solution for for searching, we could use elastic search or sphinx to make the search more efficient and bring result with suggestive search, mis spelled search etc.