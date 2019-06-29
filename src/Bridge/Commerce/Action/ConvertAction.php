<?php

namespace Ekyna\Bundle\PayumMoneticoBundle\Bridge\Commerce\Action;

use Ekyna\Component\Commerce\Payment\Model\PaymentInterface;
use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayAwareTrait;
use Payum\Core\Request\Convert;
use Payum\Core\Request\GetCurrency;

/**
 * Class CommerceConvertAction
 * @package Ekyna\Bundle\PayumMoneticoBundle
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class ConvertAction implements ActionInterface, GatewayAwareInterface
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

            $amount = (string)round($payment->getAmount(), $currency->exp);

            if (0 < $currency->exp && false !== $pos = strpos($amount, '.')) {
                $amount = str_pad($amount, $pos + 1 + $currency->exp, '0', STR_PAD_RIGHT);
            }

            if (substr($amount, strrpos($amount, '.')) == 0) {
                $amount = (string)round($amount);
            }

            $model['currency'] = (string)$currency->alpha3;
            $model['amount'] = $amount;
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
