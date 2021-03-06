import ko from 'knockout';
import $ from 'jquery';
import Quill from 'quill';

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

const toolbarOptions = [
    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
    ['bold', 'italic', 'underline'],
    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
    [{ 'align': [] }],
    ['link'],
    [{ 'color': [] }, { 'background': [] }],
    ['clean']
  ];

ko.bindingHandlers.quill = {

    init: function (element, valueAccessor, allBindings, viewModel, bindingContext) {
        var params = valueAccessor();

        // Check whether the value observable is either placed directly or in the paramaters object.
        if (!(ko.isObservable(params) || params["html"] || params["text"])) {
            throw ("You need to define an observable value for the 'quill' binding. " +
                "Either pass the observable directly or as the 'html' or 'text' " +
                "field in the parameters.");
        }

        // Initialize the quill editor, and store it in the data section of the
        // element using jQuery.
        var quill = new Quill(element, {
            theme: "snow",
            modules: {
                toolbar: toolbarOptions
            } 
        });
        $.data(element, "quill", quill);

        // Extract the knockout observables and set the initial value.
        var htmlObservable = null;
        var textObservable = null;
        var toolbarSelector = null;
        if (ko.isObservable(params)) {
            htmlObservable = params;
            quill.setContents(ko.unwrap(htmlObservable));
        }
        else {
            htmlObservable = params["html"];
            textObservable = params["text"];
            toolbarSelector = params["toolbar"];

            if (htmlObservable) {
                quill.setContents(ko.unwrap(htmlObservable) || "");
            } else if (textObservable) {
                quill.setText(ko.unwrap(textObservable) || "");
            }
            if (toolbarSelector) {
                quill.addModule("toolbar", { container: toolbarSelector });
            }
        }

        // Make sure we update the observables when the editor contents change.
        quill.on("text-change", function (delta, source) {
            if (htmlObservable && ko.isObservable(htmlObservable)) {
                const current_value = quill.getContents();
                current_value.html = quill.root.innerHTML;
                quill.getSelection() || htmlObservable(current_value);
            }
            if (textObservable && ko.isObservable(textObservable)) {
                quill.getSelection() || textObservable(quill.getText());
            }
        });

        quill.on("selection-change", range => {
            // range looks like: `{start: Number, end: Number}`
            // range.start === range.end <=> nothing selected

            if (range) { // cursor is in the text area

                // make sure focus observable is true but don't trigger an update
                if (textObservable && ko.isObservable(textObservable)) {
                    textObservable(true);
                }

            } else { // cursor just left the selection area
                if (textObservable && ko.isObservable(textObservable)) {
                    textObservable(false);
                }

                const current_value = quill.getContents();

                if (current_value === "<div><br></div>") {
                    // Quill likes to set empty panes to "<div><br></div>"; detect it and
                    // update the observable to null
                    if (htmlObservable && ko.isObservable(htmlObservable)) {
                        htmlObservable(null);
                    }
                } else {
                    // update the observable to current editor contents
                    if (htmlObservable && ko.isObservable(htmlObservable)) {
                        current_value.html = quill.root.innerHTML;
                        htmlObservable(current_value);
                    }
                }
            }
        });
    },

    update: function (element, valueAccessor, allBindings, viewModel, bindingContext) {
        // Extract the knockout observables.
        var params = valueAccessor();
        var htmlObservable = null;
        var textObservable = null;
        var enableObservable = null;
        if (ko.isObservable(params)) {
            htmlObservable = params;
        } else {
            htmlObservable = params["html"];
            textObservable = params["text"];
            enableObservable = params["enable"];
        }

        // Update the relevant values in the Quill editor.
        var quill = $.data(element, "quill");
        var selection = quill.getSelection();
        if (htmlObservable) {
            quill.setContents(ko.unwrap(htmlObservable) || "");
        } else if (textObservable) {
            quill.setText(ko.unwrap(textObservable) || "");
        }
        if (enableObservable) {
            quill.editor.enable(ko.unwrap(enableObservable));
        }
        quill.setSelection(selection);
    }

};