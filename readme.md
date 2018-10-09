## Laravel Deployer based on Roles Permissions Admin (Spatie version)

This is a Laravel 5.6 deployer starter project with roles-permissions management based on [Spatie Laravel-permission package](https://github.com/spatie/laravel-permission), [AdminLTE theme](https://adminlte.io/) and [Datatables.net](https://datatables.net).

## Usage

This is full Laravel project that you should use as a deployer boilerplate, and then add your own custom functionality.

- Clone the repository with `git clone`
- Copy `.env.example` file to `.env` and edit database credentials there
- Run `composer install`
- Run `php artisan key:generate`
- Run `php artisan migrate`
- Run `php artisan db:seed` (it has some seeded data - see below)
- That's it: launch the main URL and login with default credentials `admin@admin.com` - `password`

This boilerplate has two roles (`administrator`, `deployer`), three permissions (`users_manage`, `projects_manage`, `deploy`) and two users.

With that user you can create more roles/permissions/users, and then use them in your code, by using functionality like `Gate` or `@can`, as in default Laravel, or with help of Spatie's package methods.

## License

The [MIT license](http://opensource.org/licenses/MIT).

## Notice

We are not responsible for any functionality or bugs in **AdminLTE**, **Laravel-permission** or **Datatables** packages or their future versions, if you find bugs there - please contact vendors directly.
