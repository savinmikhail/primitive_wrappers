# Object-Oriented Primitive Wrappers

This PHP library provides object-oriented wrappers for primitive data types, aiming to improve code readability, 
maintainability, and error handling compared to traditional procedural approaches. 

The initial focus of the library is 
on providing convenient and robust wrappers for string manipulation, with plans to extend support to other primitive 
types in future releases. 

Worth to mention, that some other programming languages like Java or Python have it built-in.

## Features

- **Object-Oriented Design**: The library offers object-oriented wrappers for primitive types, allowing developers to 
work with primitives in a more intuitive and structured manner.


- **Enhanced Error Handling**: By encapsulating logic within object-oriented wrappers, the library provides more robust 
error handling mechanisms, reducing the likelihood of runtime errors and promoting consistent error reporting, so you 
don't have to remember to check whether some `json_decode` returned false, or null, or empty string.


- **Improved Readability**: Clear and descriptive method names, along with encapsulated behavior, enhance code 
readability and maintainability, leading to more understandable and maintainable codebases, so you don't have to worry 
whether function calls `str_split` or `strSplit` or just `split`

### Example Usage

```php
use Mikhail\PrimitiveWrappers\Str;

// Create a string wrapper
$str = new Str('Hello, world!');

// Get the length of the string
$length = $str->length();
echo "Length: $length\n";

// Check if the string is multibyte
$isMultibyte = $str->isMultibyte();
echo "Is multibyte: " . ($isMultibyte ? 'true' : 'false') . "\n";

// Convert the string to lowercase
$lowercase = $str->toLowerCase();
echo "Lowercase: $lowercase\n";

// Convert the string to uppercase
$uppercase = $str->toUpperCase();
echo "Uppercase: $uppercase\n";
```

## Contributing

Contributions are welcome! If you encounter any issues or have suggestions for improvements, please feel free to open 
an issue or submit a pull request on GitHub.

---

