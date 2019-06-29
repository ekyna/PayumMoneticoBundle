# Installation steps for Symfony 3 

### Require the package

```bash
$ composer require ekyna/payum-monetico-bundle
```

### Register the bundle

Add the bundle to your kernel:

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

### Setup the configuration

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
        bank : 'CIC'     # enum from Ekyna\Component\Payum\Monetico\Api\Api
        mode : 'TEST'    # enum from Ekyna\Component\Payum\Monetico\Api\Api
        tpe : 'your-tpe' # value from your Monetico account
        key : 'your-key' # value from your Monetico account
        company : 'acme' # value from your Monetico account
        debug : true
```
