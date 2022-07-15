# Economic Operators Registration and Identification system (EORI) Validator

<a href="https://packagist.org/packages/davidvandertuijn/eori"><img src="https://poser.pugx.org/davidvandertuijn/eori/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/davidvandertuijn/eori"><img src="https://poser.pugx.org/davidvandertuijn/eori/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/davidvandertuijn/eori"><img src="https://poser.pugx.org/davidvandertuijn/eori/license.svg" alt="License"></a>

![Economic Operators Registration and Identification system (EORI) Validator](https://cdn.davidvandertuijn.nl/github/eori.png)

## Install

```
composer require davidvandertuijn/eori
```

## Usage

```php
use Davidvandertuijn\Eori\Validator as EoriValidator;
```

**Validate**

```php
$eori = new EoriValidator;

$eori->validate('NL857117683'); // true

if ($eori->isValid()) {
    // true
}
```

## Strict (optional)

When strict is set to **false**, the EORI number validation returns **true** if the SOAP service is not available (CURL timeout or SoapFault).

```php
$eori->setStrict(false); // default = true
```

## Comments

We suggest that you cache the valid EORI numbers in your application to prevent multiple requests to the SOAP service.
