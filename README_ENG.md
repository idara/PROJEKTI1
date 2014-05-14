## Requirements

- HTTP server
 - Apache in use
 - Has to support CakePHP
- Database software
 - Used with MySQL
 - Has to support CakePHP
- PHP5
- [CakePHP requirements](http://book.cakephp.org/1.3/en/The-Manual/Developing-with-CakePHP/Requirements.html)

## Setup guide

1. Install HTTP server, database software and PHP
2. [Download](https://github.com/cakephp/cakephp/archive/1.3.16.zip) and install CakePHP 1.3.16. CakePHP's generalized installation instructions in [here](http://book.cakephp.org/1.3/en/The-Manual/Developing-with-CakePHP/Installation.html).
3. Download SoftGIS package [newer](https://github.com/rikukala/PROJEKTI1) or [previous version](https://github.com/GISPROJEKTI/PROJEKTI1).
4. Extract SoftGIS package over CakePHP setup so that file `index.php` and folder `app/` are replaced.
5. Settings
 1. Go to folder `app/config`
 2. Rename `core.php.default` -> `core.php`
 3. Rename `database.php.default` -> `database.php`
 4. Set database settings into `database.php`
 5. Set your own security salt into `core.php`
6. Creating the database with CakePHP console
 1. Go to folder `app/` 
 2. Run command `../cake/console/cake schema create -file app.php App`
 3. Command will create necessary tables into database
 4. [Instructions for console](http://book.cakephp.org/1.3/en/The-Manual/Core-Console-Applications.html)
 5. If console is not in operation, you can create database manyally with file `Gis tietokannan taulujen luontikomennot.txt`
7. Other settings
 1. Set sufficient user rights to temporary folders: `app/tmp`, `app/tmp/cache`, `app/tmp/cache/models`, `app/tmp/cache/presistent` and `app/tmp/cache/views`.
 2. For importing map images, set user rights also to folder `\app\webroot\img\overlays`
 3. If site is operational, good. If not, it might be that your server's mod_rewrite (.htaccess) function is not in use. [More info](http://book.cakephp.org/1.3/en/The-Manual/Developing-with-CakePHP/Installation.html)
  1. If you have problems with the setup, ignore part 4. 'Extract SoftGIS package...' in this guide and do rest of the parts. At this time CakePHP's front page will give some hints.
8. You can create a user account by going to address [your server's gis software's setup path]/authors/register. 'Identifier' for registeration is found from software's setup directory's file app/controllers/authors_controller.php, from line 26, variable's $secret value. It is recommended to change this identifier to something else, so that anyone who knows the software can not register new user account into your system.


## Information security
- Blocking SQL injections:
 - CakePHP's data sanitization: http://book.cakephp.org/1.3/en/The-Manual/Common-Tasks-With-CakePHP/Data-Sanitization.html#data-sanitization


