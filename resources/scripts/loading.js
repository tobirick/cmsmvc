const loading = {};

loading.loadingElement = '.loading-spinner'

loading.createElement = function() {
  const element = document.createElement('div');
  element.classList.add('loading-spinner');
  const image = document.createElement('img');
  image.src = '/admin/img/loading.svg';
  element.appendChild(image);

  this.loadingElementHTML = element;
}

loading.addSpinner = function() {
  this.createElement();
  document.getElementById('content').insertAdjacentElement('afterbegin', this.loadingElementHTML);
}

loading.removeSpinner = function() {
  const loadingEl = document.querySelector(this.loadingElement);
  loadingEl.parentNode.removeChild(loadingEl);
}

export default loading;