# dusker
Stand-alone Laravel Dusk test suit, which does not require Laravel framework itself.

<a href="https://travis-ci.org/laravel/dusk"><img src="https://travis-ci.org/unglud/dusker.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/unglud/dusker"><img src="https://poser.pugx.org/unglud/dusker/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/unglud/dusker"><img src="https://poser.pugx.org/unglud/dusker/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/unglud/dusker"><img src="https://poser.pugx.org/unglud/dusker/license.svg" alt="License"></a>

<p><img src="https://laravel.com/assets/img/components/logo-dusk.svg"></p>

<a href="https://github.com/laravel/dusk">Laravel Dusk</a> provides an expressive, easy-to-use browser automation and testing API. By default, Dusk does not require you to install JDK or Selenium on your machine. Instead, Dusk uses a standalone Chrome driver. However, you are free to utilize any other Selenium driver you wish.

## Installation
To get started, you should add the unglud/dusker Composer dependency to your project:
```
composer require --dev unglud/dusker
```

Next, you need to copy all necessary files to your working directory. The command below will do it for you. It creates (or use existing) `tests` directory and put files there. Also, it copies `artisan` console utility to your project root directory. **If you already have this file, it will be overwritten!**

The file `.env.dusk` will be in your project root as well, which you will need rename to `.env` or copy it content to your existing one.
```
composer run-script post-install-cmd -d ./vendor/unglud/dusker
```

If you would like these files to update automatically each time you update this package, you can add this to your `composer.json` file:
```
"scripts": {
  "post-install-cmd": [
    "Dusker\\CopyFile::copy"
  ],
  "post-update-cmd": [
    "Dusker\\CopyFile::copy"
  ]
},
"extra": {
  "copy-file": {
    "vendor/unglud/dusker/src/example/": "tests/",
    "vendor/unglud/dusker/artisan": "artisan"
  }
}
```

As you notice file `.env.dusk` not included there to simplify things.

After installing the package, Artisan commands will be available from your root project. Run the `dusk:install` Artisan command:

```
php artisan dusk:install
```

Now try to run test to make sure everything works
```
php artisan dusk
```

## How to use
After this part you can use official documentation for Dusk on the [Laravel website](https://laravel.com/docs/master/dusk), `cuz it will work exactly as it was designed by [Taylor Otwell](https://github.com/taylorotwell).

## Authentication
Often, you will be testing pages that require authentication. You can use Dusk's loginAs method in order to avoid interacting with the login screen during every test. The loginAs method accepts a user `login` and `password`:

```
$this->browse(function (Browser $browser) {
    $browser->loginAs('username', 'password')
          ->visit('/home');
});
```
After using the loginAs method, the user session will be maintained for all tests within the file.

### Authentication Setup
Since we do not have access to native `Auth` and `Router` from Laravel, because we use it without Laravel we need to setup login functionality.
In `.env` you should specify `LOGIN_ENDPOINT` -- path to your public directory where Dusker will copy the file which will be accessible from a browser. By default its `http://example.com/_dusker/login.php`. Second `LOGIN_IMPLEMENTATION` -- path to your class, which utilize logic of your project allowing Authentication. You can use `/tests/LoginManagerExample.php` as an example of how it should look.

## License

Dusker is released under the MIT Licence. See the bundled [LICENSE](https://github.com/unglud/dusker/blob/master/LICENSE) file for details.

