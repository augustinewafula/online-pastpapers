# online-pastpapers
Online past papers is system enable students view and download pastpapers. It can also recommend a sample exam to students. It is built on [Laravel](https://laravel.com)

## Installation

* Clone the repo ` git clone https://github.com/AugustineTreezy/online-pastpapers `
* `cd ` to project folder. 
* Run ` composer install `
* Save as the `.env.example` to `.env` and set your database information 
* Run ` php artisan key:generate` to generate the app key
* Run ` npm install ` 
* Run ` php artisan migrate:fresh --seed ` 
* Done !!!

## Note
To process queues, make sure to add ` php artisan schedule:run ` to cron jobs or run the ` automate.sh ` file incase of windows server