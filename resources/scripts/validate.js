export const validator = {
    data: {
        elements: [],
        rules: [],
        error: false,
        formEl: ''
    },

    init(form) {
        this.data.formEl = document.querySelector(form);
        this.data.formEl.addEventListener('submit', this.validate.bind(this))
        const elements = document.querySelectorAll(form + ' .validate');
        this.data.elements = elements;
    },

    addBasicRules() {
        this.addRule('email', {
            regex: /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/,
            minlength: 10,
            required: true,
            message: 'E-Mail is unvalid and required'
        });

        this.addRule('text', {
            minlength: 6,
            required: true,
            message: 'Please use minimal 6 characters'
        });

        this.addRule('password', {
            minlength: 6,
            required: true,
            message: 'Please use minimal 6 characters'
        });
    },
    
    addRule(name, rules) {
        this.data.rules.push({
            ...rules,
            name
        })
    },

    validate(e) {
        e.preventDefault();
        for (let element of this.data.elements) {
            for(let rule of this.data.rules) {
                if(element.type === rule.name) {
                    this.validateElement(element, rule);
                }
            }
        };
        this.submit();
    },

    addErrorToElement(element, rule) {
        this.data.error = true;
        element.classList.add('form-input__error');
        const span = document.createElement('span');
        span.classList.add('form-input__error-message');
        span.innerHTML = rule.message;
        const childNodes = element.parentNode.parentNode.childNodes;
        let hasError = false;
        for(let i = 0; i < childNodes.length; i++) {
            if(childNodes[i].nodeType === Node.ELEMENT_NODE) {
                if(childNodes[i].classList.contains('form-input__error-message')) {
                    hasError = true;
                    break;
                }
            }
        }
        if(!hasError) {
            element.parentNode.insertAdjacentElement('afterend', span);
        }
    },

    removeErrorFromElement(element, rule) {
        setTimeout(() => {element.classList.remove('form-input__error')}, 250);
        const spanEl = element.parentNode.nextSibling;
        element.parentNode.parentNode.removeChild(spanEl);
    },

    validateElement(element, rule) {
        if(rule.required) {
            if(element.value.length === 0) {
                this.addErrorToElement(element, rule);
            } else {
                this.removeErrorFromElement(element, rule);
            }
        }
        if(rule.regex) {
            if(!rule.regex.test(element.value)) {
                this.addErrorToElement(element, rule);
            } else {
                this.removeErrorFromElement(element, rule);
            }
        }
        if(rule.minlength) {
            if(element.value.length < rule.minlength) {
                this.addErrorToElement(element, rule);
            } else {
                this.removeErrorFromElement(element, rule);
            }
        }
    },

    submit() {
        if(!this.data.error) {
            this.data.formEl.submit();
        } else {
            this.data.error = false;
        }
    },
}