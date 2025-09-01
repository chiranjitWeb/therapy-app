Add the following line inside `bootstrap/app.php` within the `withProviders([...])` call:

->withProviders([
    App\Providers\ServiceBindingServiceProvider::class,
])
