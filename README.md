# ekyna/PayumMoneticoBundle

Payum Bundle for Monetico (Credit Mutuel/CIC) payment gateway.

This bundle facilitates the integration of [ekyna/payum-monetico](https://github.com/ekyna/PayumMonetico) in a Symfony application.

[![Build Status](https://travis-ci.org/ekyna/PayumMoneticoBundle.svg?branch=master)](https://travis-ci.org/ekyna/PayumMoneticoBundle)

## Installation / Configuration

Only these few installation and configuration steps are needed, provided that you have a functional project with Symfony and Payum.

### Get the files with Composer

```bash
$ composer require ekyna/payum-monetico-bundle:dev-master ekyna/payum-monetico:dev-master
```

### Register the bundle

Add the dependency to your AppKernel.php file:
```php
public function registerBundles()
{
    return array_merge(parent::registerBundles(), [
        ...
        
        new \Ekyna\Bundle\PayumMoneticoBundle\EkynaPayumMoneticoBundle(),
    ]);
}
```

### Setup the configuration
Declare the Monetico gateway in your `app/config/config.yml` file:

```yaml
# app/config/config.yml
payum:
    gateways:
        ...
    
        monetico:
            factory: monetico
```

Setup the API parameters in your `app/config/config.yml` file:

```yaml
# app/config/config.yml
ekyna_payum_monetico:
        api:
            bank : 'CIC'     # enum from Ekyna\Component\Payum\Monetico\Api\Api
            mode : 'TEST'    # enum from Ekyna\Component\Payum\Monetico\Api\Api
            tpe : 'your-tpe' # value from your Monetico account
            key : 'your-key' # value from your Monetico account
            company : 'acme' # value from your Monetico account
            debug : true
```
