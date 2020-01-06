/*
 * Copyright © 2020 Studio Raz. All rights reserved.
 * See LICENSE.txt for license details.
 */

define([
    'jquery',
    'underscore',
    'Magento_Ui/js/lib/validation/utils',
    'moment',
    'tinycolor',
    'jquery/validate',
    'mage/translate'
], function ($, _, utils, moment, tinycolor) {
    'use strict';

    return function (validator) {
        var validators = {
            'validate-identifier': [
                function (value) {
                    return utils.isEmptyNoTrim(value) || /^[a-z0-9][a-z0-9_\/-]+(\.[a-z0-9_-]+)|(?:[\u0590-\u05FF]+|\w+)+?$/.test(value);
                },
                $.mage.__('Please enter a valid URL Key (Ex: "example-page", "example-page.html" or "anotherlevel/example-page").')//eslint-disable-line max-len
            ],
        };

        validators = _.mapObject(validators, function (data) {
            return {
                handler: data[0],
                message: data[1]
            };
        });

        return $.extend(validator, validators);
    };
});