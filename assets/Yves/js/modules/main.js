/**
 * Copyright (c) 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

'use strict';

var paymentMethod = require('./payment-method');

$(document).ready(function() {
    paymentMethod.init({
        formSelector: '[name="paymentForm"]',
        paymentMethodSelector: '#paymentForm_paymentSelection input[type="radio"]',
        currentPaymentMethodSelector: '#paymentForm_paymentSelection input[type="radio"]:checked',
        cardholderInput: '#paymentForm_Payone_credit_card_cardholder',
        cardpanInput: '#Payone_credit_card_cardpan',
        cardtypeInput: '#paymentForm_Payone_credit_card_cardtype',
        cardexpiremonthInput: '#paymentForm_Payone_credit_card_cardexpiredate_month',
        cardexpireyearInput: '#paymentForm_Payone_credit_card_cardexpiredate_year',
        cardcvc2Input: '#Payone_credit_card_cardcvc2',
        clientApiConfigInput: '#paymentForm_Payone_credit_card_payone_client_api_config',
        pseudocardpanInput: '#paymentForm_Payone_credit_card_pseudocardpan',
    });
});