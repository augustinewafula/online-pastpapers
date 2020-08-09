# online-pastpapers

Online past papers is system enable students view and download pastpapers. It can also recommend a sample exam to students. It is built on [Laravel](https://laravel.com)

## Installation

* Clone the repo ` git clone https://github.com/augustinewafula/online-pastpapers `
* `cd ` to project folder. 
* Run ` composer install `
* Save as the `.env.example` to `.env` and set your database information 
* Run ` php artisan key:generate` to generate the app key
* Run ` npm install ` 
* Run ` php artisan migrate:fresh --seed ` 
* Done !!!

## Usage

To login as an admin go to `admin/login` url and provide credentials from the `AdminsTableSeeder` seeders. If you need more admins add them via seeder.

Go to root url to login as a student.

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)