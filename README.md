# Ride: Validation Library

Validation library of the PHP Ride framework.

## What's In This Library

- [Filters](#filters)
  * [AllowCharacterFilter](#allowcharacterfilter-characters)
  * [LowerCaseFilter](#lowercasefilter-lower)
  * [ReplaceFilter](#replacefilter-replace)
  * [SafeStringFilter](#safestringfilter-safestring)
  * [StripTagsFilter](#striptagsfilter-striptags)
  * [TrimFilter](#trimfilter-trim)
  * [UpperCaseFilter](#uppercasefilter-upper)
- [Validators](#validators)
  * [ClassValidator](#classvalidator-class)
  * [DsnValidator](#dsnvalidator-dsn)
  * [EmailValidator](#emailvalidator-email)
  * [FileExtensionValidator](#fileextensionvalidator-extension)
  * [JsonValidator](#jsonvalidator-json)
  * [MinMaxValidator](#minmaxvalidator-minmax)
  * [NumericValidator](#numericvalidator-numeric)
  * [RegexValidator](#regexvalidator-regex)
  * [RequiredValdiator](#requiredvalidator-required)
  * [SizeValidator](#sizevalidator-size)
  * [UrlValidator](#urlvalidator-url)
  * [WebsiteValdiator](#websitevalidator-website)
- [Constraints](#constraints)
  * [GenericConstraint](#genericconstraint-generic)
  * [OrConstraint](#orconstraint-or)
  * [EqualsConstraint](#equalsconstraint-equals)
  * [ConditionalConstraint](#conditionalconstraint-conditional)
  * [ChainConstraint](#chainconstraint-chain)
- [ValidationFactory](#validationfactory)
- [ValidationError](#validationerror)
- [ValidationException](#validationexception)
- [Code Sample](#code-sample)

### Filters

The _Filter_ interface is used to pre-process a value to fix input automatically.
A filter should return the original value if it can't handle the input type.

Different implementations are available.

#### AllowCharacterFilter (characters)

Filters all non-allowed characters from a string.

This filter has the following option:

- __characters__: all allowed characters, characters not found in this string, will be trimmed out (string)

#### LowerCaseFilter (lower)

Transforms all upper case characters to lower case.

This filter has no options.

#### ReplaceFilter (replace)

Replaces values in a string.

This filter has the following options:

- __search__: string to search for (string)
- __replacement__: replacement for the matches of search (string|optional)

#### SafeStringFilter (safeString)

- __replacement__: replacement for special characters, defaults to - (string|optional)
- __lower__: transform to lower case, defaults to true (boolean|optional)

#### StripTagsFilter (stripTags)

Strips HTML and PHP tags from a string, using PHP's internal [strips_tags](http://php.net/manual/en/function.strip-tags.php) function

This filter has the following option:

* __allowedTags__: a set of html tags that are allowed and won't be stripped, for example: `<p><strong>`.

#### TrimFilter (trim)

Trims the provided value from spaces.

This filter has the following options:

* __trim.lines__: trim all lines, or values if the provided value is an array (boolean|optional)
* __trim.empty__: remove empty lines or values, only when _trim.lines_ is enabled (boolean|optional)

#### UpperCaseFilter (upper)

Transforms all lower case characters to upper case.

This filter has no options.

### Validators

The _Validator_ interface is used to validate a single value.

Different implementations are available.

#### ClassValidator (class)

Checks if the provided string is a valid class name

This validator has the following options:

* __class__: class which the provided class should implement or extend (string|optional)
* __required__: flag to see if a value is required (boolean|optional)

This validator generates the following errors:

* __error.validation.class__: default error message
* __error.validation.class.extends__: when the class does not extend the required class
* __error.validation.class.implements__: when the class does not implement the required interface

#### DsnValidator (dsn)

Checks if the provided string is a valid DSN.

This validator has the following option:

* __required__: flag to see if a value is required (boolean|optional)

This validator generates the following errors:

* __error.validation.dsn__: default error message (string|optional)
* __error.validation.required__: required error message (string|optional)

#### EmailValidator (email)

Checks if the provided value is a valid email address.

This validator has the following option:

* __required__: flag to see if a value is required (boolean|optional)

This validator generates the following errors:

* __error.validation.email__: default error message
* __error.validation.required__: required error message

#### FileExtensionValidator (extension)

Checks if the provided path string has an allowed extension.

This validator has the following options:

* __extensions__: allowed extensions (array)
* __required__: flag to see if a value is required (boolean|optional)

This validator generates the following errors:

* __error.validation.file.extension__: default error message
* __error.validation.required__: required error message

#### JsonValidator (json)

Checks if the json string is valid.

This validator has the following options:

* __required__: flag to see if a value is required (boolean|optional)

This validator generates the following errors:

* __error.validation.json__: default error message
* __error.validation.required__: required error message

#### MinMaxValidator (minmax)

Checks if the provided numeric value is in the provided range.

This validator has the following options:

* __error.minimum__: error code when the value is less then minimum (string|optional)
* __error.maximum__: error code when the value is more then maximum (string|optional)
* __error.minimum.maximum__: error code when the value is not between minimum and maximum (string|optional)
* __error.numeric__: error code when the value is not numeric (string|optional)
* __minimum__: minimum value (numeric|optional)
* __maximum__: maximum value (numeric|optional)
* __required__: flag to see if a value is required (boolean|optional)

_Note: Minimum and maximum are both optional both at least one of them is required.
The values for minimum and maximum are included in the range._

This validator generates the following errors:

* __error.validation.minimum__: when the value is less then the provided minimum
* __error.validation.maximum__: when the value is greater then the provided maximum
* __error.validation.minmax__: when the value is less then the provided minimum or greater then the provided maximum
* __error.validation.required__: required error message

#### NumericValidator (numeric)

Checks if the provided value is a numeric value.

This validator has the following options:

* __error.numeric__: error code when the value is not numeric (string|optional)
* __required__: flag to see if a value is required (boolean|optional)

This validator generates the following error:

* __error.validation.numeric__: default error message
* __error.validation.required__: required error message

#### RegexValidator (regex)

Checks if the provided string matches a regular expression.

This validator has the following options:

* __error.regex__: error code when the value did not match the regular expression (string|optional)
* __error.required__: error code when the required value was empty (string|optional)
* __regex__: regular expression to match (string)
* __required__: flag to see if a value is required (boolean|optional)

This validator generates the following errors:

* __error.validation.regex__: default error message
* __error.validation.required__: required error message

#### RequiredValdiator (required)

Checks if a value is provided

This validator has the following option:

* __error.required__: error code when no value is provided (string|optional)

This validator generates the following error:

* __error.validation.required__: required error message

#### SizeValidator (size)

Checks if the length of the provided string or the size of the provided array.

This validator has the following options:

* __minimum__: minimum value (numeric|optional)
* __maximum__: maximum value (numeric|optional)

_Note: Minimum and maximum are both optional both at least one of them is required.
The values for minimum and maximum are included in the range._

This validator generates the following errors:

* __error.validation.maximum.array__: when the number of array elements is greater then the provided maximum
* __error.validation.maximum.string__: when the size of a string is greater then the provided maximum
* __error.validation.minimum.array__: when the number of array elements is less then the provided minimum
* __error.validation.minimum.string__: when the size of a string is less then the provided minimum
* __error.validation.minmax.array__: when the number of array elements is less then the provided minimum or greater then the provided maximum
* __error.validation.minmax.string__: when the size of a string is less then the provided minimum or greater then the provided maximum
* __error.validation.object__: when the value is an object

#### UrlValidator (url)

Checks if the provided string is a valid URL.

This validator has the following option:

* __required__: flag to see if a value is required (boolean|optional)

This validator generates the following errors:

* __error.validation.required__: required error message
* __error.validation.url__: default error message

#### WebsiteValdiator (website)

Checks if the provided string is a valid website.
This is the same as the URL validator but limited to http(s)://.

This validator has the following option:

* __required__: flag to see if a value is required (boolean|optional)

This validator generates the following errors:

* __error.validation.required__: required error message
* __error.validation.website__: default error message

### Constraints

The _Constraint_ interface is used to validate a data container.
A data container can be an array or an object.

Different implementations are available.

#### GenericConstraint (generic)

The _GenericConstraint_ is a combination of filters and validators which can be applied on specific properties of the data container.

```php
<?php

use ride\library\validation\factory\ValidationFactory;

function foo(ValidationFactory $factory) {
    $trimFilter = $factory->createFilter('trim');
    $requiredValidator = $factory->createValidator('required');
    
    $constraint = $factory->createConstraint('generic');
    $constraint->addFilter($trimFilter, 'name');
    $constraint->addFilter($trimFilter, 'description');
    $constraint->addValidator($requiredValidator, 'name');
    $constraint->addValidator($requiredValidator, 'description');
    
    return $constraint;
}
```

This constraint will trim and require the _name_ and _description_ properties to pass.

#### OrConstraint (or)

The _OrConstraint_ defines a set of properties for which at least one has to be provided.
When constraining, it will add a validation error to all properties when none of them is provided.

```php
<?php

use ride\library\validation\factory\ValidationFactory;

function foo(ValidationFactory $factory) {
    $constraint = $factory->createConstraint('or');
    $constraint->addProperty('firstName');
    $constraint->addProperty('displayName');
    
    // optionally, you can override the default error code
    $constraint->setError('error.validation.custom');
    
    return $constraint;
}
```

This constraint will fail when both _firstName_ and _displayName_ are empty.

#### EqualsConstraint (equals)

The _EqualsConstraint_ defines a set of properties which have to have the same value.
Usefull when asking to repeat a new password.

```php
<?php

use ride\library\validation\factory\ValidationFactory;

function foo(ValidationFactory $factory) {
    $constraint = $factory->createConstraint('equals');
    $constraint->addProperty('password');
    $constraint->addProperty('repeatPassword');
    
    // optionally, you can override the default error code
    $constraint->setError('error.validation.custom');
    
    return $constraint;
}
```

This constraint will fail when _password_ and _repeatPassword_ are not the same value.

#### ConditionalConstraint (conditional)

The _ConditionalConstraint_ is a generic constraint which only validates when defined properties contain a specific value.
Usefull for properties which are dependant on a type or status.

```php
<?php

use ride\library\validation\factory\ValidationFactory;

function foo(ValidationFactory $factory) {
    $requiredWebsiteValidator = $factory->createValidator('website', array('required' => true));
    
    $constraint = $factory->createConstraint('conditional');
    $constraint->addValueCondition('type', 'url');
    $constraint->addValidator($requiredWebsiteValidator, 'url');
    
    return $constraint;
}
```

This constraint will require the _url_ property when the _type_ property is set to _"url"_.

#### ChainConstraint (chain)

The _ChainConstraint_ is used to combine different constraints together into one.
Usefull to build a full validation for a complex data type.

```php
<?php

use ride\library\validation\factory\ValidationFactory;

function createConstraint(ValidationFactory $factory) {
    $trimFilter = $factory->createFilter('trim');
    $requiredValidator = $factory->createValidator('required');
    $requiredWebsiteValidator = $factory->createValidator('website', array('required' => true));
    
    $generalConstraint = $factory->createConstraint('generic');
    $generalConstraint->addFilter($trimFilter, 'name');
    $generalConstraint->addFilter($trimFilter, 'description');
    $generalConstraint->addValidator($requiredValidator, 'name');
    $generalConstraint->addValidator($requiredValidator, 'description');
    $generalConstraint->addValidator($requiredValidator, 'type');
    
    $typeUrlConstraint = $factory->createConstraint('conditional');
    $typeUrlConstraint->addValueCondition('type', 'url');
    $typeUrlConstraint->addFilter($trimFilter, 'url');
    $typeUrlConstraint->addValidator($requiredWebsiteValidator, 'url');
    
    $typeNodeConstraint = $factory->createConstraint('conditional');
    $typeNodeConstraint->addValueCondition('type', 'node');
    $typeNodeConstraint->addValidator($requiredWebsiteValidator, 'node');
    
    $chain = $factory->createConstraint('chain');
    $chain->addConstraint($generalConstraint);
    $chain->addConstraint($typeUrlConstraint);
    $chain->addConstraint($typeNodeConstraint);
    
    return $chain;
}
```

This constrain will trim and require the _name_ and _description_ property.
The _type_ property is also required.
When the value for the _type_ property is _"url"_, the _url_ property is required after being trimmed.
The same for the _node_ property when the value of the _type_ property is _"node"_.

### ValidationFactory

The _ValidationFactory_ is used to construct new validation instances from this library.
You can use is to create filters, validators and constraints on a name basis.

### ValidationError

A _ValidationError_ is an error of a single validator.
Validators will keep the errors of the last validate call.
Constraints will gather the occured errors and collect them in a _ValidationException_.

### ValidationException

A _ValidationException_ is thrown by the constraint implementations after validation is done.
It contains all the occured errors which can be obtained in their entirety or only for specific properties.  

## Code Sample

```php
<?php

use ride\library\validation\exception\ValidationException;
use ride\library\validation\factory\ValidationFactory;

function foo(ValidationFactory $factory) {
    // filter some values
    $trimFilter = $factory->createFilter('trim');
    
    $result = $trimFilter->filter(null); // null
    $result = $trimFilter->filter($trimFilter); // $trimFilter
    $result = $trimFilter->filter('  My Title  '); // 'My Title'
    
    // validate some values
    $requiredValidator = $factory->createValidator('required');
    
    $result = $requiredValidator->isValid(null); // false
    $result = $requiredValidator->isValid($requiredValidator); // true
    
    // constrain a data container
    // we're using an array but this can be an object with getters and setters as well
    $data = array(
        'title' => ' My Title  ',
        'description' => null,
        'type' => 'url',
        'node' => null,
        'url' => null,
    );
    
    // see the chain constraint sample for the chain build up
    $constraint = createConstraint($factory);
    
    try {
        $result = $contraint->constrain($data);
    } catch (ValidationException $exception) {
        // url is required in this situation
        $result = $exception->getAllErrors();
        $result = $exception->getErrors('url');
    }
}
```

### Implementations

For more examples, you can check the following implementation of this library:
- [ride/app-validation](https://github.com/all-ride/ride-app-validation)

## Installation

You can use [Composer](http://getcomposer.org) to install this library.

```
composer require ride/lib-validation
```

