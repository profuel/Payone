<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Payone;

use Generated\Shared\Transfer\PayonePaymentTransfer;
use Generated\Shared\Transfer\PayoneStandardParameterTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\Payone\PayoneConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;
use Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject;

class PayoneConfig extends AbstractBundleConfig
{

    const PROVIDER_NAME = 'Payone';
    const PAYMENT_METHOD_CREDIT_CARD = 'payoneCreditCard';
    const PAYMENT_METHOD_E_WALLET = 'payoneEWallet';
    const PAYMENT_METHOD_DIRECT_DEBIT = 'payoneDirectDebit';
    const PAYMENT_METHOD_ONLINE_TRANSFER = 'payoneOnlineTransfer';
    const PAYMENT_METHOD_EPS_ONLINE_TRANSFER = 'payoneEpsOnlineTransfer';
    const PAYMENT_METHOD_INSTANT_ONLINE_TRANSFER = 'payoneInstantOnlineTransfer';
    const PAYMENT_METHOD_GIROPAY_ONLINE_TRANSFER = 'payoneGiropayOnlineTransfer';
    const PAYMENT_METHOD_IDEAL_ONLINE_TRANSFER = 'payoneIdealOnlineTransfer';
    const PAYMENT_METHOD_POSTFINANCE_EFINANCE_ONLINE_TRANSFER = 'payonePostfinanceEfinanceOnlineTransfer';
    const PAYMENT_METHOD_POSTFINANCE_CARD_ONLINE_TRANSFER = 'payonePostfinanceCardOnlineTransfer';
    const PAYMENT_METHOD_PRZELEWY24_ONLINE_TRANSFER = 'payonePrzelewy24OnlineTransfer';
    const PAYMENT_METHOD_PRE_PAYMENT = 'payonePrePayment';
    const PAYMENT_METHOD_INVOICE = 'payoneInvoice';

    /**
     * @return string
     */
    public function getMode()
    {
        $settings = $this->get(PayoneConstants::PAYONE);

        return $settings[PayoneConstants::PAYONE_MODE];
    }

    /**
     * @return string
     */
    public function getEmptySequenceNumber()
    {
        $settings = $this->get(PayoneConstants::PAYONE);

        return $settings[PayoneConstants::PAYONE_EMPTY_SEQUENCE_NUMBER];
    }

    /**
     * @return \Generated\Shared\Transfer\PayoneStandardParameterTransfer
     */
    public function getRequestStandardParameter()
    {
        $settings = $this->get(PayoneConstants::PAYONE);
        $standardParameter = new PayoneStandardParameterTransfer();

        $standardParameter->setEncoding($settings[PayoneConstants::PAYONE_CREDENTIALS_ENCODING]);
        $standardParameter->setMid($settings[PayoneConstants::PAYONE_CREDENTIALS_MID]);
        $standardParameter->setAid($settings[PayoneConstants::PAYONE_CREDENTIALS_AID]);
        $standardParameter->setPortalId($settings[PayoneConstants::PAYONE_CREDENTIALS_PORTAL_ID]);
        $standardParameter->setKey($settings[PayoneConstants::PAYONE_CREDENTIALS_KEY]);
        $standardParameter->setPaymentGatewayUrl($settings[PayoneConstants::PAYONE_PAYMENT_GATEWAY_URL]);

        $standardParameter->setCurrency(Store::getInstance()->getCurrencyIsoCode());
        $standardParameter->setLanguage(Store::getInstance()->getCurrentLanguage());

        $standardParameter->setRedirectSuccessUrl($settings[PayoneConstants::PAYONE_REDIRECT_SUCCESS_URL]);
        $standardParameter->setRedirectBackUrl($settings[PayoneConstants::PAYONE_REDIRECT_BACK_URL]);
        $standardParameter->setRedirectErrorUrl($settings[PayoneConstants::PAYONE_REDIRECT_ERROR_URL]);

        return $standardParameter;
    }

    /**
     * @param \Generated\Shared\Transfer\PayonePaymentTransfer $paymentTransfer
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     *
     * @return string
     */
    public function generatePayoneReference(PayonePaymentTransfer $paymentTransfer, SpySalesOrder $orderEntity)
    {
        return $orderEntity->getOrderReference();
    }

    /**
     * @param array $orderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject $data
     *
     * @return string
     */
    public function getNarrativeText(array $orderItems, SpySalesOrder $orderEntity, ReadOnlyArrayObject $data)
    {
        return $orderEntity->getOrderReference();
    }

    /**
     * @return string
     */
    protected function getYvesBaseUrl()
    {
        return $this->get(ApplicationConstants::HOST_YVES);
    }

    /**
     * @return string
     */
    public function getTranslationFilePath()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . PayoneConstants::GLOSSARY_FILE_PATH;
    }

}
