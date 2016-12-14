/*jshint browser:true jquery:true*/
/*global alert*/
define([
    'jquery',
    'mage/utils/wrapper',
    'METMEER_CustomerComment/js/model/fields-assigner'
], function ($, wrapper, fieldsAssigner) {
    'use strict';

    return function (placeOrderAction) {

        /** Override default place order action and add agreement_ids to request */
        return wrapper.wrap(placeOrderAction, function (originalAction, paymentData, messageContainer) {
            fieldsAssigner(paymentData);

            return originalAction(paymentData, messageContainer);
        });
    };
});
