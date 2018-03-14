const MediaHandler = {};

MediaHandler.fetchMediaElements = async function() {
    const url = `/media`;
    const response = await fetch(url, {
        method: 'POST',
        credentials: 'include'
    });

    const data = await response.json();

    return data;
}

MediaHandler.addFolder = function(data) {
    const url = `/admin/media`;

    return fetch(url, {
        body: JSON.stringify(data),
        headers: {
            'content-type': 'application/json'
        },
        credentials: 'include',
        method: 'POST'
    })
        .then(response => response.json())
        .then(data => ({message: 'success', csrfToken: data.csrfToken, element: data.element}))
        .catch(data => ({message: 'error', csrfToken: data.csrfToken}));
}

MediaHandler.deleteMediaElement = function(data) {
    const url = `/admin/media/${data.element.id}`;
    data['_METHOD'] = 'DELETE';
    return fetch(url, {
        body: JSON.stringify(data),
        headers: {
            'content-type': 'application/json'
        },
        credentials: 'include',
        method: 'POST'
    })
        .then(response => response.json())
        .then(data => ({message: 'success', csrfToken: data.csrfToken}))
        .catch(data => ({message: 'error', csrfToken: data.csrfToken}));
}

export default MediaHandler;