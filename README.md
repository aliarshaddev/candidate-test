```diff
+  There are two branches in this repo.
+ I have implemented the login functionality in two ways:
+  1. Using Laravel login.
+  2. Using only sessions to login. 
+ Please have a look at both and let me know your reviews. You don't have to run database migrations for the branch.
```
##Set up & Deploy
1. Open project directory in terminal and run command 
```console
composer install
```
2. Setup .env file and Edit .env file to change database credentials and run command 
```console
php artisan key:generate
```
3. Run command 
```console
php artisan migrate
```
4. Run command
```console
 php artisan serve
```

To add author via command.
```console
php artisan app:add-author 
```
you can change the basic auth token for api in config/api.php 

Here is the working loom :-
https://www.loom.com/share/07e65b369bdc4238a88c5b19d06e7eec