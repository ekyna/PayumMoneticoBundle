# Installation steps for Symfony 3 

### Require the package

```bash
$ composer require ekyna/payum-monetico-bundle
```

### Register the bundle

Add the bundle to the kernel:

```php
// app/Kernel.php
public function registerBundles()
{
    $bundles = [
        // ...
        new \Ekyna\Bundle\PayumMoneticoBundle\EkynaPayumMoneticoBundle(),
    ];
    
    // ...
}
```

### Configure Monetico

Declare the Monetico gateway:

```yaml
# app/config/config.yml
payum:
    gateways:
        ...
    
        monetico:
            factory: monetico
```

Setup the API parameters:

```yaml
# app/config/config.yml
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
