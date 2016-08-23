<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone;

use Spryker\Yves\Kernel\AbstractFactory;
use Spryker\Yves\Payone\Form\CreditCardSubForm;
use Spryker\Yves\Payone\Form\DataProvider\CreditCardDataProvider;
use Spryker\Yves\Payone\Form\DataProvider\DirectDebitDataProvider;
use Spryker\Yves\Payone\Form\DataProvider\EPSOnlineTransferDataProvider;
use Spryker\Yves\Payone\Form\DataProvider\EWalletDataProvider;
use Spryker\Yves\Payone\Form\DataProvider\GiropayOnlineTransferDataProvider;
use Spryker\Yves\Payone\Form\DataProvider\IdealOnlineTransferDataProvider;
use Spryker\Yves\Payone\Form\DataProvider\InstantOnlineTransferDataProvider;
use Spryker\Yves\Payone\Form\DataProvider\InvoiceDataProvider;
use Spryker\Yves\Payone\Form\DataProvider\PostfinanceCardOnlineTransferDataProvider;
use Spryker\Yves\Payone\Form\DataProvider\PostfinanceEfinanceOnlineTransferDataProvider;
use Spryker\Yves\Payone\Form\DataProvider\PrePaymentDataProvider;
use Spryker\Yves\Payone\Form\DataProvider\Przelewy24OnlineTransferDataProvider;
use Spryker\Yves\Payone\Form\DirectDebitSubForm;
use Spryker\Yves\Payone\Form\EPSOnlineTransferSubForm;
use Spryker\Yves\Payone\Form\EWalletSubForm;
use Spryker\Yves\Payone\Form\GiropayOnlineTransferSubForm;
use Spryker\Yves\Payone\Form\IdealOnlineTransferSubForm;
use Spryker\Yves\Payone\Form\InstantOnlineTransferSubForm;
use Spryker\Yves\Payone\Form\InvoiceSubForm;
use Spryker\Yves\Payone\Form\PostfinanceCardOnlineTransferSubForm;
use Spryker\Yves\Payone\Form\PostfinanceEfinanceOnlineTransferSubForm;
use Spryker\Yves\Payone\Form\PrePaymentForm;
use Spryker\Yves\Payone\Form\Przelewy24OnlineTransferSubForm;
use Spryker\Yves\Payone\Handler\PayoneHandler;
use Spryker\Yves\Payone\Plugin\PayoneCreditCardSubFormPlugin;
use Spryker\Yves\Payone\Plugin\PayonePrePaymentSubFormPlugin;

class PayoneFactory extends AbstractFactory
{

    /**
     * @return \Spryker\Yves\Payone\Form\PrePaymentForm
     */
    public function createPrePaymentForm()
    {
        return new PrePaymentForm($this->getPayoneClient());
    }

    /**
     * @return \Spryker\Yves\Payone\Form\DataProvider\PrePaymentDataProvider
     */
    public function createPrePaymentFormDataProvider()
    {
        return new PrePaymentDataProvider();
    }

    /**
     * @return \Spryker\Yves\Payone\Form\InvoiceSubForm
     */
    public function createInvoiceSubForm()
    {
        return new InvoiceSubForm($this->getPayoneClient());
    }

    /**
     * @return \Spryker\Yves\Payone\Form\DataProvider\InvoiceDataProvider
     */
    public function createInvoiceSubFormDataProvider()
    {
        return new InvoiceDataProvider();
    }

    /**
     * @return \Spryker\Yves\Payone\Handler\PayoneHandler
     */
    public function createPayoneHandler()
    {
        return new PayoneHandler();
    }

    /**
     * @return \Spryker\Yves\Payone\Plugin\PayonePrePaymentSubFormPlugin
     */
    public function createPrePaymentSubFormPlugin()
    {
        return new PayonePrePaymentSubFormPlugin();
    }

    /**
     * @return \Spryker\Yves\Payone\Plugin\PayoneCreditCardSubFormPlugin
     */
    public function createCreditCardSubFormPlugin()
    {
        return new PayoneCreditCardSubFormPlugin();
    }

    /**
     * @return \Spryker\Yves\Payone\Form\CreditCardSubForm
     */
    public function createCreditCardSubForm()
    {
        return new CreditCardSubForm($this->getPayoneClient());
    }

    /**
     * @return \Spryker\Yves\Payone\Form\DataProvider\CreditCardDataProvider
     */
    public function createCreditCardSubFormDataProvider()
    {
        return new CreditCardDataProvider();
    }

    /**
     * @return \Spryker\Yves\Payone\Form\EWalletSubForm
     */
    public function createEWalletSubForm()
    {
        return new EWalletSubForm($this->getPayoneClient());
    }

    /**
     * @return \Spryker\Yves\Payone\Form\DataProvider\EWalletDataProvider
     */
    public function createEWalletSubFormDataProvider()
    {
        return new EWalletDataProvider();
    }

    /**
     * @return \Spryker\Yves\Payone\Form\DirectDebitSubForm
     */
    public function createDirectDebitSubForm()
    {
        return new DirectDebitSubForm($this->getPayoneClient());
    }

    /**
     * @return \Spryker\Yves\Payone\Form\DataProvider\DirectDebitDataProvider
     */
    public function createDirectDebitSubFormDataProvider()
    {
        return new DirectDebitDataProvider();
    }

    /**
     * @return \Spryker\Yves\Payone\Form\EPSOnlineTransferSubForm
     */
    public function createEPSOnlineTransferSubForm()
    {
        return new EPSOnlineTransferSubForm($this->getPayoneClient());
    }

    /**
     * @return \Spryker\Yves\Payone\Form\DataProvider\EPSOnlineTransferDataProvider
     */
    public function createEPSOnlineTransferSubFormDataProvider()
    {
        return new EPSOnlineTransferDataProvider();
    }

    /**
     * @return \Spryker\Yves\Payone\Form\GiropayOnlineTransferSubForm
     */
    public function createGiropayOnlineTransferSubForm()
    {
        return new GiropayOnlineTransferSubForm($this->getPayoneClient());
    }

    /**
     * @return \Spryker\Yves\Payone\Form\DataProvider\GiropayOnlineTransferDataProvider
     */
    public function createGiropayOnlineTransferSubFormDataProvider()
    {
        return new GiropayOnlineTransferDataProvider();
    }

    /**
     * @return \Spryker\Yves\Payone\Form\InstantOnlineTransferSubForm
     */
    public function createInstantOnlineTransferSubForm()
    {
        return new InstantOnlineTransferSubForm($this->getPayoneClient());
    }

    /**
     * @return \Spryker\Yves\Payone\Form\DataProvider\InstantOnlineTransferDataProvider
     */
    public function createInstantOnlineTransferSubFormDataProvider()
    {
        return new InstantOnlineTransferDataProvider();
    }

    /**
     * @return \Spryker\Yves\Payone\Form\IdealOnlineTransferSubForm
     */
    public function createIdealOnlineTransferSubForm()
    {
        return new IdealOnlineTransferSubForm($this->getPayoneClient());
    }

    /**
     * @return \Spryker\Yves\Payone\Form\DataProvider\IdealOnlineTransferDataProvider
     */
    public function createIdealOnlineTransferSubFormDataProvider()
    {
        return new IdealOnlineTransferDataProvider();
    }

    /**
     * @return \Spryker\Yves\Payone\Form\PostfinanceEfinanceOnlineTransferSubForm
     */
    public function createPostfinanceEfinanceOnlineTransferSubForm()
    {
        return new PostfinanceEfinanceOnlineTransferSubForm($this->getPayoneClient());
    }

    /**
     * @return \Spryker\Yves\Payone\Form\DataProvider\PostfinanceEfinanceOnlineTransferDataProvider
     */
    public function createPostfinanceEfinanceOnlineTransferSubFormDataProvider()
    {
        return new PostfinanceEfinanceOnlineTransferDataProvider();
    }

    /**
     * @return \Spryker\Yves\Payone\Form\PostfinanceCardOnlineTransferSubForm
     */
    public function createPostfinanceCardOnlineTransferSubForm()
    {
        return new PostfinanceCardOnlineTransferSubForm($this->getPayoneClient());
    }

    /**
     * @return \Spryker\Yves\Payone\Form\DataProvider\PostfinanceCardOnlineTransferDataProvider
     */
    public function createPostfinanceCardOnlineTransferSubFormDataProvider()
    {
        return new PostfinanceCardOnlineTransferDataProvider();
    }

    /**
     * @return \Spryker\Yves\Payone\Form\PostfinanceCardOnlineTransferSubForm
     */
    public function createPrzelewy24OnlineTransferSubForm()
    {
        return new Przelewy24OnlineTransferSubForm($this->getPayoneClient());
    }

    /**
     * @return \Spryker\Yves\Payone\Form\DataProvider\PostfinanceCardOnlineTransferDataProvider
     */
    public function createPrzelewy24OnlineTransferSubFormDataProvider()
    {
        return new Przelewy24OnlineTransferDataProvider();
    }

    /**
     * @return \Spryker\Client\Payone\PayoneClientInterface
     */
    public function getPayoneClient()
    {
        return $this->getProvidedDependency(PayoneDependencyProvider::CLIENT_PAYONE);
    }

    /**
     * @return \Spryker\Client\Customer\CustomerClientInterface
     */
    public function createCustomerClient()
    {
        return $this->getProvidedDependency(PayoneDependencyProvider::CLIENT_CUSTOMER);
    }

}
