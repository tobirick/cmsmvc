import ko from 'knockout';
import $ from 'jquery';
import select2 from 'select2';

ko.bindingHandlers.tabs = {
    init: function (element, valueAccessor, allBindingsAccessor, viewModel) {
        $('.popup__content').find('.tab-content').css('display', 'none');
        $('.popup__content').find('.tab-content:first-child').css('display', 'block');

        $(element).find('li').on('click', function () {
            const section = $(this).data('tabsection');
            $(element).find('li').removeClass('active');
            $(this).addClass('active');
            $('.popup__content').find('.tab-content').css('display', 'none');
            $('.popup__content').find('#' + section).css('display', 'block');
        });
    }
};

ko.bindingHandlers.colorPicker = {
    init: function (element, valueAccessor, allBindings) {
        const value = valueAccessor();
        $(element).val(ko.utils.unwrapObservable(value));
        $(element).spectrum({
            preferredFormat: "rgb",
            showAlpha: true,
            showInput: true,
            showButtons: false
        });
        $(element).on('move.spectrum', function (e, color) {
            value(color.toRgbString());
        });
        $(element).on('hide.spectrum', function (e, color) {
            value(color.toRgbString());
        });
    },
    update: function (element, valueAccessor) {
        const value = valueAccessor();
        ko.bindingHandlers.value.update(element, valueAccessor);
        $(element).val(ko.utils.unwrapObservable(valueAccessor()));
    }
}

ko.bindingHandlers.numericText = {
    update: function (element, valueAccessor, allBindingsAccessor) {
        var value = ko.utils.unwrapObservable(valueAccessor()),
            precision = ko.utils.unwrapObservable(allBindingsAccessor().precision) || ko.bindingHandlers.numericText.defaultPrecision,
            formattedValue = value.toFixed(precision);

        ko.bindingHandlers.text.update(element, function () { return formattedValue; });
    },
    defaultPrecision: 1
};

ko.bindingHandlers.select2 = {
    update: function (element, valueAccessor, allBindingsAccessor) {
        var $elm = $(element);
        var ctorArgs = ko.unwrap(valueAccessor());
        var allBindings = allBindingsAccessor();
        var optionsBinding = allBindings.options;
        var optionsCaptionBinding = allBindings.optionsCaption;
        var ensureOptionsValue = function () {
            var optionsCaption = ko.unwrap(optionsCaptionBinding);
            
            $elm.find('option').each(function (index, optionElm) {
                var $optionElm = $(optionElm);
                if ($optionElm.text() && optionsCaption !== $optionElm.text()) {
                    optionElm.value = optionElm.value || optionElm.index;
                } else {
                    $.extend(ctorArgs, { placeholder: optionsCaption });
                    $optionElm.text('').removeAttr('value');
                }
            });
        };
        
        if (ko.isObservable(optionsBinding)) {
            optionsBinding.subscribe(ensureOptionsValue);
        }
        if (ko.isObservable(optionsCaptionBinding)) {
            optionsCaptionBinding.subscribe(ensureOptionsValue);
        }

        ensureOptionsValue();

        $elm.select2(ctorArgs);
        
        $elm.on('change.select2', function (e) {
            if ($elm.find('option').length === 0 && !ko.unwrap(optionsCaptionBinding)) {
                $elm.select2('val', null);
            }
        });
        
        $elm.on('select2-selecting', function (e) {
            var multiple = $elm.data('select2').opts.multiple || $elm.prop('multiple');
            var data = e.choice || e.object;
            if (multiple) {
                var selectedIndices = $elm.data('select2-selected-indices') || [];
                selectedIndices.push(data.element[0].index);
                $elm.find('option').each(function (index, optionElm) {
                    optionElm.selected = $.inArray(optionElm.index, selectedIndices) > -1;
                });
                $elm.data('select2-selected-indices', selectedIndices);
            } else {
                $elm.val(data.id);
                $elm.trigger('change');
            }
        });
        
        $elm.on('select2-loaded', function(e) {
            console.log(e);
        });

        $elm.on('select2-removing', function (e) {
            var selectedIndices = $.grep($elm.data('select2-selected-indices') || [], function (value) {
                var data = e.object || e.choice;
                return value != data.element[0].index;
            });
            $elm.data('select2-selected-indices', selectedIndices)
        });
        
        ko.utils.domNodeDisposal.addDisposeCallback(element, function () {
            $elm.select2('destroy');
        });
    }
};