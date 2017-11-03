# dusker
Stand alone Laravel Dusk test suit, which do not require Laravel framework itself.

<a href="https://travis-ci.org/laravel/dusk"><img src="https://travis-ci.org/unglud/dusker.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/unglud/dusker"><img src="https://poser.pugx.org/unglud/dusker/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/unglud/dusker"><img src="https://poser.pugx.org/unglud/dusker/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/unglud/dusker"><img src="https://poser.pugx.org/unglud/dusker/license.svg" alt="License"></a>

<p><img src="https://laravel.com/assets/img/components/logo-dusk.svg"></p>

<a href="https://github.com/laravel/dusk">Laravel Dusk</a> provides an expressive, easy-to-use browser automation and testing API. By default, Dusk does not require you to install JDK or Selenium on your machine. Instead, Dusk uses a standalone Chromedriver. However, you are free to utilize any other Selenium driver you wish.

## Installation
To get started, you should add the unglud/dusker Composer dependency to your project:

```composer require --dev unglud/dusker```

After installing the package, Artisan commands will be available from your root project. Run the dusk:install Artisan command:

```php artisan dusk:install```

## How to use

Documentation for Dusk can be found on the [Laravel website](https://laravel.com/docs/master/dusk).

## License

Dusker is released under the MIT Licence. See the bundled [LICENSE](https://github.com/unglud/dusker/blob/master/LICENSE) file for details.

