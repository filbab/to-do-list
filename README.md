## Project setup
Prerequisite: Docker installed

To run the project, simply open terminal at project's root and run:

```
./vendor/bin/sail up
```

(You can use "-d" option to run in detached mode)

### **Important!** 

All the PHP commands you can find below should be executed from within the Sail container.

First, list the running containers using:
```
docker ps
```
You should see now a list like this:
![alt text](docker_ps.png "Container list")

In this case it's the first container listed (by default named _todo-list-laravel.test-1_). Now we can run:
```
docker exec -it todo-list-laravel.test-1 bash
```


## Running tests
Use the command:
```
php artisan test
```
To run all PHPUnit tests

## API documentation
With the project running, you can browse the API documentation at
[http://localhost/docs](http://localhost/docs)

## Testing the api with manually executed requests:

To populate the _task_statuses_ table with the statuses needed, run:

```
php artisan db:seed --class=TaskStatusSeeder
```

If you need some dummy users for testing, use this command (the example below creates 10 of them):
```
php artisan create:users --count=10
```