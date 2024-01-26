/* eslint-disable no-undef */
// jscs:disable jsDoc

require([
    'jquery',
], function (jQuery) {
    'use strict';

    var parentRadioElmClass = '.radio-icons-list';
    var valueRadioFieldClass = '.field-value';
    var previewButtonClass = '.instant-button';
    var btnLightSrc = window.rezolveBtnLightSrc ?? '';
    var btnDarkSrc = window.rezolveBtnDarkSrc ?? '';
    var pdpFieldsetId = '#rezolve_ic_button_ic_button_on_product_page';
    var plpFieldsetId = '#rezolve_ic_button_ic_button_on_product_listing';
    var buttonConfig = {
        'button_width': ['narrow', 'wide', 'custom-width'],
        'button_height': ['height-large', 'height-small'],
        'button_corners': ['corner-round', 'corner-rounded', 'corner-square'],
        'button_colour': ['dark', 'light'],
    }

    function changeTextForRadioBtn(text, $element) {
        let parentElm = $element.closest(parentRadioElmClass);
        let valueField = parentElm.find(valueRadioFieldClass);

        valueField.text(text);
    }

    function updatePreviewClass(sectionId, btnType, btnValue) {
        let button = jQuery(sectionId).find(previewButtonClass);
        let buttonValues = buttonConfig[btnType] ?? '';
        let buttonImage = button.find('img');

        if (btnType == null || btnValue == null) {
            console.error('Incorrect values', btnType, btnValue);
            return;
        }

        if (!buttonValues) {
            console.error('There is no config button values for', btnType);
            return;
        }

        if (btnType === 'button_colour') {
            if (btnLightSrc && btnDarkSrc) {
                buttonImage.attr('src', (btnValue === 'light') ? btnLightSrc : btnDarkSrc);
            } else {
                console.error('There is no button image source.');
            }
        }

        setTimeout(function() {
            if (btnType === 'button_width' && btnValue === 'custom-width') {
                let customWidthValue = (sectionId === pdpFieldsetId) ?
                    jQuery('#rezolve_ic_button_ic_button_on_product_page_button_custom_width').val() ?? '140'
                    : jQuery('#rezolve_ic_button_ic_button_on_product_listing_button_custom_width').val() ?? '140';

                button.attr('style', 'width:' + customWidthValue + 'px;');
            } else {
                button.attr('style', '');
            }
            jQuery.each(buttonValues, function (idx, val) {
                button.removeClass(val);
            })
            button.addClass(btnValue);
        }, 100);
    }

    jQuery('.radio-icons-list').on('click', '.control-field-label span', function (e){
        let elm = jQuery(this);
        let parentSection = elm.closest('fieldset.config')  ;
        let text = elm.text();
        let inputBtn = elm.closest('.row-field-option').find('.control-radio');
        let elmType =  elm.data('type') ?? '';
        let elmValue =  elm.data('value') ?? '';

        if (inputBtn.hasClass('disabled')) {
            return false;
        }
        changeTextForRadioBtn(text, elm);
        if (parentSection.attr('id') === 'rezolve_ic_button_ic_button_on_product_page') {
            updatePreviewClass(pdpFieldsetId, elmType, elmValue);
        } else {
            updatePreviewClass(plpFieldsetId, elmType, elmValue);
        }
    });
});
