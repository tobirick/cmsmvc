const csrf = {};

csrf.csrfToken = document.getElementById('csrftoken');
csrf.csrfTokenVal = document.getElementById('csrftoken').value;

csrf.getToken = function() {
    return this.csrfTokenVal;
}

csrf.updateToken = function(newCsrfToken) {
    this.csrfTokenVal = newCsrfToken;
    this.csrfToken.value = newCsrfToken;
    const csrfTokenInputEls = document.querySelectorAll(
       'input[name="csrf_token"]'
    );
    csrfTokenInputEls.forEach(csrfTokenInputEl => {
       csrfTokenInputEl.value = newCsrfToken;
    });
}

export default csrf;