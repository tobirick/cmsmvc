import ko from 'knockout';
import $ from 'jquery';

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
 init: function(element, valueAccessor, allBindings) {
   const value = valueAccessor();
   $(element).val(ko.utils.unwrapObservable(value));
   $(element).spectrum({
    preferredFormat: "rgb",
    showAlpha: true,
    showInput: true,
    showButtons: false
   });
   $(element).on('move.spectrum', function(e, color) {
      value(color.toRgbString());
    });
    $(element).on('hide.spectrum', function(e, color) { 
       value(color.toRgbString());
     });
 },
 update: function(element, valueAccessor) {
  const value = valueAccessor();
  ko.bindingHandlers.value.update(element,valueAccessor);
  $(element).val(ko.utils.unwrapObservable(valueAccessor()));
}
}

ko.bindingHandlers.numericText = {
  update: function(element, valueAccessor, allBindingsAccessor) {
     var value = ko.utils.unwrapObservable(valueAccessor()),
         precision = ko.utils.unwrapObservable(allBindingsAccessor().precision) || ko.bindingHandlers.numericText.defaultPrecision,
         formattedValue = value.toFixed(precision);

      ko.bindingHandlers.text.update(element, function() { return formattedValue; });
  },
  defaultPrecision: 1  
};