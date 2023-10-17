In order to run the project properly follow the steps below:

run "php artisan migrate" on the command line
next run "php artisan db:seed" in the command line

The endpoint "/users/{user}/achievements" will only work if the above two commands have been run sequentially as the endpoint needs data to return a result.
