/*jshint browser:true jquery:true*/
/*global alert*/
define([
    'jquery'
], function ($) {
    'use strict';

    /** Override default place order action and add agreement_ids to request */
    return function (paymentData) {
        var fieldsForm,
            fieldsData;

        fieldsForm = $('.form.payments div[data-role=customer-comment] textarea');
        fieldsData = fieldsForm.serializeArray();

        if (paymentData['extension_attributes'] === undefined) {
            paymentData['extension_attributes'] = {};
        }

        fieldsData.forEach(function (item) {
            paymentData['extension_attributes'][item.name] = item.value;
        });
    };
});
