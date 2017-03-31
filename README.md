# avtr-io

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

API Wrapper for avtr.io

## Structure

If any of the following are applicable to your project, then the directory structure should follow industry best practises by being named the following.

```
bin/        
config/
src/
tests/
vendor/
```


## Install

Via Composer

``` bash
$ composer require Jamosaur/avtr-io
```

## Usage

``` php
require Jamosaur\Avtr;
$avtr = new Avtr('James Wallen-Jones');

echo '<img src="' . $avtr->toUrl() . '">';
```

## Available Options
```php
// Construct with email.
$avtr = new Avtr('j.wallen.jones@googlemail.com');

// Construct with name.
$avtr = new Avtr('James Wallen-Jones');

// Construct with initials.
$avtr = new Avtr('JW');

// Image Format. (png, jpg, gif)
$avtr->format(string);

// Setting a first name.
$avtr->firstName(string);

// Setting a last name.
$avtr->lastName(string);

// Setting the letter count. (1, 2)
// Anything below 1 will default to 1.
// Anything above 2 will default to 2.
$avtr->letterCount(int);

// Setting the background colour.
// Values below 0 will default to 0.
// Values above 255 will default to 255.
// Alpha value is 0.0 - 1.0
$avtr->background(r, g, b, a);

// Setting the image size.
// Values below 0 will default to 100
$avtr->size(500);

// Setting rounded corners.
$avtr->roundedCorners(bool);

// Setting Shape. (square, circle)
$avtr->shape(string);

// Setting theme. (material, flat)
$avtr->theme(string);

// Setting text Case. (lower, upper, title)
$avtr->textCase(string);

// Setting text colour.
// Values below 0 will default to 0.
// Values above 255 will default to 255.
// Alpha value is 0.0 - 1.0
$avtr->color(r, g, b, a);

// Setting font weight. (100-900)
// Values below 100 default to 100
// Values above 900 default to 900
$avtr->fontWeight(100);

// Setting font. (open-sans, source-sans-pro, roboto)
$avtr->font(string);

// Return a URL
$avtr->toUrl();

```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email j.wallen.jones@googlemail.com instead of using the issue tracker.

## Credits

- [James Wallen-Jones][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/Jamosaur/avtr-io.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/Jamosaur/avtr-io/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/Jamosaur/avtr-io.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/Jamosaur/avtr-io.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/Jamosaur/avtr-io.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/Jamosaur/avtr-io
[link-travis]: https://travis-ci.org/Jamosaur/avtr-io
[link-scrutinizer]: https://scrutinizer-ci.com/g/Jamosaur/avtr-io/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/Jamosaur/avtr-io
[link-downloads]: https://packagist.org/packages/Jamosaur/avtr-io
[link-author]: https://github.com/jamosaur
[link-contributors]: ../../contributors
