import helpers from './helpers';

const loading = {};

loading.loadingElement = '.loading-spinner'
loading.target = document.querySelector('#content');

loading.createElement = function (target) {
    const element = document.createElement('div');
    element.classList.add('loading-spinner');
    const image = document.createElement('img');
    image.src = '/admin/img/loading.svg';
    element.appendChild(image);

    this.loadingElementHTML = element;
}

loading.setTarget = function (element) {
    this.target = document.querySelector(element);
}

loading.addSpinner = function () {
    this.createElement();
    this.target.insertAdjacentElement('afterbegin', this.loadingElementHTML);
}

loading.removeSpinner = function () {
    const loadingEl = document.querySelector(this.loadingElement);
    helpers.fadeOutEffect(loadingEl, () => loadingEl.parentNode.removeChild(loadingEl));
}

export default loading;