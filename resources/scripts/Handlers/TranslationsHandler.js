const TranslationsHandler = {};

TranslationsHandler.fetchTranslations = async function (data) {
    const url = `/admin/translations`;
    const response = await fetch(url, {
        body: JSON.stringify(data),
        headers: {
            'content-type': 'application/json'
        },
        method: 'POST',
        credentials: 'include'
    });

    return await response.json();
};

TranslationsHandler.updateTranslations = async function (data) {
    const url = `/admin/translations/edit`;
    const response = await fetch(url, {
        body: JSON.stringify(data),
        headers: {
            'content-type': 'application/json'
        },
        method: 'POST',
        credentials: 'include'
    });

    return await response.json();
}

TranslationsHandler.addTranslation = async function (data) {
    const url = `/admin/translations/create`;
    const response = await fetch(url, {
        body: JSON.stringify(data),
        headers: {
            'content-type': 'application/json'
        },
        method: 'POST',
        credentials: 'include'
    });

    return await response.json();
}

TranslationsHandler.deleteTranslation = async function (data) {
    const url = `/admin/translations/${data.translationID}/delete`;
    const response = await fetch(url, {
        body: JSON.stringify(data),
        headers: {
            'content-type': 'application/json'
        },
        method: 'POST',
        credentials: 'include'
    });

    return await response.json();
}


export default TranslationsHandler;