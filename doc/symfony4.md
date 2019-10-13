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

### Configure Monetico

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
        mode : 'TEST'    # enum from Ekyna\Component\Payum\Monetico\Api\Api
        tpe : 'your-tpe' # value from your Monetico account
        key : 'your-key' # value from your Monetico account
        company : 'acme' # value from your Monetico account
        debug : true
```

### Next steps

[Implement convert action and notify controller](https://github.com/ekyna/PayumMoneticoBundle/blob/master/doc/develop.md)