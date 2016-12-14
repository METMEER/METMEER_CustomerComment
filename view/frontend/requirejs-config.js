/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
/*jshint browser:true jquery:true*/
/*global alert*/
var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/place-order': {
                'METMEER_CustomerComment/js/model/place-order-mixin': true
            },
            'Magento_Checkout/js/action/set-payment-information': {
                'METMEER_CustomerComment/js/model/set-payment-information-mixin': true
            }
        }
    }
};
