export const updateCSRF = (newCsrfToken) => {
    const csrfElements = document.querySelectorAll('input[name="csrf_token"]');
    
    csrfElements.forEach(csrfElement => {
        csrfElement.value = newCsrfToken;
    });
};