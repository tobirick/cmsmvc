var changeLangEl = document.querySelector('#changePublicLang');
if(changeLangEl) {
    var currentLang = changeLangEl.value;
    var changeLanguage = function(e) {
       var newLang = changeLangEl.value;
       window.location.href = window.location.origin + newLang;
    }
    
    changeLangEl.addEventListener('change', changeLanguage);
}