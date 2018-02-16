export default class Form {
    constructor() {
        this.submitBtnEl = document.getElementById('submit-form-btn');
        this.submitFormEl = document.getElementById('submit-form')

        if(this.submitBtnEl && this.submitFormEl) this.setEventListeners();
    }

    setEventListeners() {
        this.submitBtnEl.addEventListener('click', this.submitForm.bind(this));
    }

    submitForm() {
        this.submitFormEl.submit();
    }
}