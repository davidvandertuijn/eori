# Economic Operators Registration and Identification system (EORI) Validator

<a href="https://packagist.org/packages/davidvandertuijn/eori"><img src="https://poser.pugx.org/davidvandertuijn/eori/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/davidvandertuijn/eori"><img src="https://poser.pugx.org/davidvandertuijn/eori/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/davidvandertuijn/eori"><img src="https://poser.pugx.org/davidvandertuijn/eori/license.svg" alt="License"></a>

![Economic Operators Registration and Identification system (EORI) Validator](https://cdn.davidvandertuijn.nl/github/eori.png)

The Economic Operators Registration and Identification (EORI) system is a crucial component in international trade, designed to streamline customs processes and enhance the efficiency of cross-border operations. The EORI Validator provides businesses and customs authorities with a reliable tool to verify the validity of EORI numbers assigned to economic operators within the European Union.

[!["Buy Me A Coffee"](https://www.buymeacoffee.com/assets/img/custom_images/orange_img.png)](https://www.buymeacoffee.com/davidvandertuijn)

## Install

```shell
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

## Strict

In this EORI Validation library, when strict mode is set to FALSE, the validation process is more flexible, especially in scenarios where the SOAP service is temporarily unavailable. In such cases, the validation will return TRUE, allowing the workflow to continue without disruption due to service timeouts or SOAP errors.

```php
$eori->setStrict(false); // default = true
```

## Cache

To optimize the validation process and reduce the dependency on the SOAP service, we recommend caching valid EORI numbers within your application. This approach minimizes repeated requests to the SOAP service and improves overall performance.
