### Create your convert action

Monetico requires you to __provide billing information for 3DSecure v2__. As such data cannot be fetched from the defaut payum payment model, this bundle can't include a working solution to convert payments. You need to implement your own convert action.

See [this example](https://github.com/ekyna/PayumMonetico/blob/master/tests/Functional/Acme/Action/ConvertAction.php).

Register your action as a service:

```xml
    <service id="App\Payum\Action\ConvertAction" public="true">
        <tag name="payum.action" factory="monetico"/>
    </service>
```
or
```yaml
    App\Payum\Action\ConvertAction:
        public: true
        tags:
            - { name: payum.action, factory: monetico }
```

### Create your notify controller

With monetico you can't configure IPN url for each payments. Monetico technicians will configure a unique notification POST URL for all payments. In the following example: https://example.org/monetico/notify.   

```php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class MoneticoController
{
    /**
     * @Route("/monetico/notify")
     */
    public function notifyAction(Request $request)
    {
        // Get the reference you set in your ConvertAction
        if (null === $reference = $request->request->get('reference')) {
            throw new NotFoundHttpException();
        }
    
        // Find your payment entity
        $payment = $this
            ->get('acme.repository.payment')
            ->findOneBy(['number' => $reference]);
    
        if (null === $payment) {
            throw new NotFoundHttpException();
        }
    
        $payum = $this->get('payum');
    
        // Execute notify & status actions.
        $gateway = $payum->getGateway('monetico');
        $gateway->execute(new Notify($payment));
        $gateway->execute(new GetHumanStatus($payment));
    
        // Get the payment identity
        $identity = $payum->getStorage($payment)->identify($payment);
    
        // Invalidate payment tokens
        $tokens = $payum->getTokenStorage()->findBy([
            'details' => $identity,
        ]);
        foreach ($tokens as $token) {
            $payum->getHttpRequestVerifier()->invalidate($token);
        }
    
        // Return expected response
        return new Response(\Ekyna\Component\Payum\Monetico\Api\Api::NOTIFY_SUCCESS);
    }
```
Register your controller as a service if needed.