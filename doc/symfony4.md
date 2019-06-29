# Installation steps for Symfony 4

### Require the package

```bash
$ composer require ekyna/payum-monetico-bundle
```

### Register the bundle

Add the bundle to the kernel:

```php
// config/bundles.php
return [
    // ...
    Ekyna\Bundle\PayumMoneticoBundle\EkynaPayumMoneticoBundle::class => ['all' => true],
];
```

### Setup the configuration
Declare the Monetico gateway:

```yaml
# config/packages/payum.yaml
payum:
    gateways:
        ...
    
        monetico:
            factory: monetico
```

Setup the API parameters:

```yaml
# config/packages/ekyna_payum_monetico.yaml
ekyna_payum_monetico:
    api:
        bank : 'CIC'     # enum from Ekyna\Component\Payum\Monetico\Api\Api
        mode : 'TEST'    # enum from Ekyna\Component\Payum\Monetico\Api\Api
        tpe : 'your-tpe' # value from your Monetico account
        key : 'your-key' # value from your Monetico account
        company : 'acme' # value from your Monetico account
        debug : true
```
