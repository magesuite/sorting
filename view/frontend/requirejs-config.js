var config = {
    // map: {
    //     '*': {
    //         productListToolbarForm: 'MageSuite_Sorting/js/product/list/toolbar'
    //     }
    // }
    config: {
        mixins: {
            'Magento_Catalog/js/product/list/toolbar': {
                'MageSuite_Sorting/js/product/list/toolbar': true,
            },
        },
    },
};
