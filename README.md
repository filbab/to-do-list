## Project setup
Prerequisite: Docker installed

To run the project, simply open terminal at project's root and run:

`./vendor/bin/sail up`

(You can use "-d" option to run in detached mode)




Testing the api with manually executed requests:

Within the sail container run:

`php artisan db:seed --class=TaskStatusSeeder`

To generate some dummy users (precisely 10 using example below):
`php artisan create:users --count=10`