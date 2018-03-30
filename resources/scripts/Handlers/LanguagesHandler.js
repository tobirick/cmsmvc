const LanguagesHandler = {};

LanguagesHandler.fetchLanguages = async function(data) {
    const url = `/languages`;
    return fetch(url, {
        body: JSON.stringify(data),
        headers: {
            'content-type': 'application/json'
        },
        credentials: 'include',
        method: 'POST'
    })
        .then(response => response.json())
        .then(data => ({message: 'success', languages: data.languages, csrfToken: data.csrfToken}))
        .catch(data => ({message: 'error'}));

    return data;
}

export default LanguagesHandler;