# Show Users Data as Table

*Show Users Data as Table* is a WordPress plugin that displays users' data, retrieve by api request, as an HTML table.

## Requirements
* PHP 7.0 or later
* WordPress 5.0 or later

## Installation

#### Through WordPress admin menu
After downloading files from here, just go to the plugin menu of your WordPress site then install the plugin by uploading the downloaded files, and so activate the plugin. That's all.

## Usage
To use this plugin it is quite simple, just go to the url `yourSiteHomeLink/users-table` and then the users' table will show up. You can click on each link in the table to display the details about the user of the row that you clicked on.

## How does it work?
When the url `yourSiteHomeLink/users-table` is launched, an api request is sent to this endpoint: https://jsonplaceholder.typicode.com/users/.
Then users list is getting from this request response, the response is cached for *3600 seconds (one hour)* using WordPress's function *set_transient* under two keys: *shudat_users* and *shudat_users_detail*.

What are those two keys used to?

* *shudat_users* is used to avoid a new request, to retrieve all users, less than one hour the previous; 
* the second one, *shudat_users_detail* holds each user's details, then a new request to get a user detail will not be performed if we already have this data in the cache. So if a link is clicked on the table to show a user details, an api request will be run if those details do not exist in the cache, and the api response will be saved in the cache under the key *shudat_users_detail* for one hour.

### Head's up

* To override the template of the rendered page, just create a template file named `ShowTable.php` and put it in the theme root directory.

### Composer dependencies usage

After installing the plugin, make sure the file _composer.json_ is present then run:
```
composer install
```

After that to run all PHPUnit tests use this command:

```
vendor/bin/phpunit
```

To check all the code against Inpsyde coding standards simply run:
```
vendor/bin/phpcs
```

## License and Copyright

_Show Users Data as Table_ code is licensed under GPLv2 or later.

Copyright (c) 2022 AZOUA Mauriac.
