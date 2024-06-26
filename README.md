<p align="center">
    <a href="https://www.elegantobjects.org">
        <img src="https://www.elegantobjects.org/badge.svg" alt="EO principles respected here">
    </a>
    <a href="https://scrutinizer-ci.com/g/savinmikhail/primitive_wrappers/?branch=main">
        <img src="https://scrutinizer-ci.com/g/savinmikhail/primitive_wrappers/badges/coverage.png?b=main" alt="Code Coverage">
    </a>
    <a href="https://scrutinizer-ci.com/g/savinmikhail/primitive_wrappers/?branch=main">
        <img src="https://scrutinizer-ci.com/g/savinmikhail/primitive_wrappers/badges/quality-score.png?b=main" alt="Quality Score">
    </a>
</p>

# Object-Oriented Primitive Wrappers

This PHP library provides object-oriented wrappers for primitive data types, aiming to improve code readability, 
maintainability, and error handling compared to traditional procedural approaches. 

Worth to mention, that some other programming languages like Java, Python etc have it built-in.

## Features

- **Object-Oriented Design**: The library offers object-oriented wrappers for primitive types, allowing developers to 
work with primitives in a less imperative style.


- **Enhanced Error Handling**: The library provides more robust 
error handling mechanisms, so you 
don't have to remember to check whether some `json_decode` returned false, or null, or empty string,
or threw Error or Exception.


- **Improved Readability**: Clear and descriptive method names enhance code 
readability and maintainability, so you don't have to worry 
whether function calls `str_split` or `strSplit` or `split`. Either to remember what some `strpbrk` mean


- **Advanced Methods**: You can convert cases (e.g. from camel to snake) fluently, or get words from a string, and many more!

## Installation

Run

`composer require savinmikhail/primitive_wrappers`

## Example Usage

```php
use Mikhail\PrimitiveWrappers\Str;

// Create a string wrapper
$str = new Str('Hello, world!');

// Get the length of the string
$length = $str->length();

// Use methods as a builder
$lowercaseCapitalized = $str->toLower()->capitalize();

//use some more advanced methods
$snake = (new Str('Lorem ipsum dolor sit amet'))->snake(); //lorem_ipsum_dolor_sit_amet
```

## Similar projects
[Symfony string](https://github.com/symfony/symfony/blob/7.0/src/Symfony/Component/String/UnicodeString.php)

[Illuminate Str](https://github.com/laravel/framework/blob/9.x/src/Illuminate/Support/Str.php)

[Primitive objects](https://github.com/dobryakov/php-primitive-objects)

## Contributing

Contributions are welcome! If you encounter any issues or have suggestions for improvements, please feel free to open 
an issue or submit a pull request on GitHub.

## License

This library is released under the [MIT license](LICENSE).

---

