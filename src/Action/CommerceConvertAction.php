<?php

namespace Ekyna\Bundle\PayumMoneticoBundle\Action;

use Ekyna\Component\Commerce\Payment\Model\PaymentInterface;
use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Exception\RuntimeException;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayAwareTrait;
use Payum\Core\Request\Convert;
use Payum\Core\Request\GetCurrency;

/**
 * Class CommerceConvertAction
 * @package Ekyna\Bundle\PayumMoneticoBundle
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class CommerceConvertAction implements ActionInterface, GatewayAwareInterface
{
    use GatewayAwareTrait;

    /**
     * {@inheritDoc}
     *
     * @param Convert $request
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        /** @var PaymentInterface $payment */
        $payment = $request->getSource();

        $model = ArrayObject::ensureArrayObject($payment->getDetails());

        if (false == $model['amount']) {
            $this->gateway->execute($currency = new GetCurrency($payment->getCurrency()->getCode()));
            if (3 < $currency->exp) {
                throw new RuntimeException('Unexpected currency exp.');
            }

            $model['currency'] = (string)$currency->alpha3;
            $model['amount'] = (string)round($payment->getAmount(), $currency->exp);
        }

        $sale = $payment->getSale();

        if (false == $model['reference']) {
            $model['reference'] = $payment->getNumber();
        }
        if (false == $model['comment']) {
            $comment = "Order: {$sale->getNumber()}";
            if (null !== $customer = $sale->getCustomer()) {
                $comment .= ", Customer: {$customer->getNumber()}";
            }
            $model['comment'] = $comment;
        }
        if (false == $model['email']) {
            $model['email'] = $sale->getEmail();
        }

        $request->setResult((array)$model);
    }

    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return $request instanceof Convert
            && $request->getSource() instanceof PaymentInterface
            && $request->getTo() == 'array';
    }
}
