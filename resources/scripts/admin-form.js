import { validator } from './validate';

export default class Form {
    constructor() {
        this.submitBtnEl = document.getElementById('submit-form-btn');
        this.submitFormEl = document.getElementById('submit-form');
        this.validator = validator.init('#submit-form');
        this.validator.addBasicRules();

        if (this.submitBtnEl && this.submitFormEl) this.setEventListeners();
    }

    setEventListeners() {
        this.submitBtnEl.addEventListener('click', this.submitForm.bind(this));
    }

    submitForm(e) {
        this.validator.validate(e);
        //this.submitFormEl.submit();
    }
}