define(['jquery'], function($) {
    'use strict';

    return function(productListToolbarForm) {
        $.widget('mage.productListToolbarForm', productListToolbarForm, {
            /** @inheritdoc */
            _create: function() {
                this._bind(
                    $(this.options.modeControl),
                    this.options.mode,
                    this.options.modeDefault
                );
                this._bind(
                    $(this.options.limitControl),
                    this.options.limit,
                    this.options.limitDefault
                );
                this._bindOrder($(this.options.orderControl));
            },

            /** @inheritdoc */
            _bindOrder: function(element) {
                var eventType = 'change';

                if (!element.is('select')) {
                    eventType = 'click';
                }
                element.on(eventType, {}, $.proxy(this._processSorting, this));
            },

            /**
             * @param {jQuery.Event} event
             * @private
             */
            _processLink: function(event) {
                event.preventDefault();

                this.changeUrl([
                    {
                        name: event.data.paramName,
                        default: event.data.default,
                        value: $(event.currentTarget).data('value'),
                    },
                ]);
            },

            /**
             * @param {jQuery.Event} event
             * @private
             */
            _processSelect: function(event) {
                this.changeUrl([
                    {
                        name: event.data.paramName,
                        default: event.data.default,
                        value:
                            event.currentTarget.options[
                                event.currentTarget.selectedIndex
                            ].value,
                    },
                ]);
            },

            /**
             * @param {jQuery.Event} event
             * @private
             */
            _processSorting: function(event) {
                event.preventDefault();
                var eventType = event.type,
                    eventTarget = event.currentTarget,
                    sortingDirection,
                    sortingField;

                if (eventType === 'change') {
                    sortingDirection = $(
                        eventTarget.options[eventTarget.selectedIndex]
                    ).data('direction');
                    sortingField =
                        eventTarget.options[eventTarget.selectedIndex].value;
                } else {
                    sortingDirection = $(eventTarget).data('direction');
                    sortingField = $(eventTarget).data('value');
                }

                this.changeUrl([
                    {
                        name: 'product_list_order',
                        default: '',
                        value: sortingField,
                    },
                    {
                        name: 'product_list_dir',
                        default: '',
                        value: sortingDirection,
                    },
                ]);
            },

            /**
             * Method was modified to allow multiple parameters at once. It is needed to change sorting field and direction
             * at the same time.
             * @param {*} params
             */
            changeUrl: function(params) {
                var decode = window.decodeURIComponent,
                    urlPaths = this.options.url.split('?'),
                    baseUrl = urlPaths[0],
                    urlParams = urlPaths[1] ? urlPaths[1].split('&') : [],
                    paramData = {},
                    parameters,
                    i;

                for (i = 0; i < urlParams.length; i++) {
                    parameters = urlParams[i].split('=');
                    paramData[decode(parameters[0])] =
                        parameters[1] !== undefined
                            ? decode(parameters[1].replace(/\+/g, '%20'))
                            : '';
                }

                params.forEach(function(item) {
                    paramData[item.name] = item.value;

                    if (item.value == item.default) {
                        //eslint-disable-line eqeqeq
                        delete paramData[item.name];
                    }
                });

                paramData = $.param(paramData);

                location.href =
                    baseUrl + (paramData.length ? '?' + paramData : '');
            },
        });

        return $.mage.productListToolbarForm;
    };
});
