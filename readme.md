# silverstripe-dominantcolor

Enhance the Image class by providing the dominant color from an image. Uses [Color Thief PHP](https://github.com/ksubileau/color-thief-php).

The latest version only supports SilverStripe 4, see the `1.0` branch for a SilverStripe 3.x compatible version.


## Usage

Adds the `DominantColor()` method to `Image` which the primary dominant color of this Image as hex (i.e. `'#bada55'`.)

```html
…
<div style="background-color:$SomeImage.DominantColor">
…
```

```php
…
$color = Image::get()->find(…)->DominantColor();
…
```

## Requirements

- Silverstripe 3+
- GD, Imagick or Gmagick

## Installation

The recommended way to install is through Composer:

```
composer require jacobbuck/silverstripe-dominantcolor
```
