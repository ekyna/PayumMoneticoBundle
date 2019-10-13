<?php

namespace Ekyna\Bundle\PayumMoneticoBundle\Functional;

use Payum\Core\GatewayInterface;
use Payum\Core\Model\Payment;
use Payum\Core\Request\Convert;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GatewayTest extends KernelTestCase
{
    public function testGatewayIsAvailable()
    {
        $container = static::bootKernel()->getContainer();

        /** @var \Payum\Core\Payum $payum */
        $payum = $container->get('payum');

        $gateway = $payum->getGateway('monetico');

        $this->assertInstanceOf(GatewayInterface::class, $gateway);
    }

    public function testCustomConvertAction()
    {
        $container = static::bootKernel()->getContainer();

        /** @var \Payum\Core\Payum $payum */
        $payum = $container->get('payum');

        $gateway = $payum->getGateway('monetico');

        $payment = new Payment();
        $payment->setNumber(substr(uniqid(), 0, 12));
        $payment->setCurrencyCode('EUR');
        $payment->setTotalAmount('123');
        $payment->setDescription('A description');
        $payment->setClientId('anId');
        $payment->setClientEmail('foo@exmaple.org');

        $gateway->execute($convert = new Convert($payment, 'array'));

        $result = $convert->getResult();

        $this->assertEquals($result['context']['billing'], [
            'addressLine1' => 'the address',
            'city'         => 'the city',
            'postalCode'   => 'the postal code',
            'country'      => 'the country',
        ]);
    }
}
