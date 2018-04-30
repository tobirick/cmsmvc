const MediaHandler = {};

MediaHandler.fetchMediaElements = async function(dir) {
    const url = `/media`;
    return fetch(url, {
        body: JSON.stringify(dir),
        headers: {
            'content-type': 'application/json'
        },
        credentials: 'include',
        method: 'POST'
    })
        .then(response => response.json())
        .then(data => ({message: 'success', elements: data}))
        .catch(data => ({message: 'error'}));

    return data;
}

MediaHandler.fetchImages = async function() {
    const url = `/media/images`;
    return fetch(url, {
        body: JSON.stringify(),
        headers: {
            'content-type': 'application/json'
        },
        credentials: 'include',
        method: 'POST'
    })
        .then(response => response.json())
        .then(data => ({message: 'success', elements: data.elements}))
        .catch(data => ({message: 'error'}));

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
        .then(data => ({message: 'success', csrfToken: data.csrfToken, element: data.element, error: data.error}))
        .catch(data => ({message: 'error', csrfToken: data.csrfToken}));
}

MediaHandler.addFiles = function(data) {
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
        .then(data => ({message: 'success', csrfToken: data.csrfToken, element: data.element, error: data.error}))
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
        .then(data => ({message: 'success', csrfToken: data.csrfToken, error: data.error}))
        .catch(data => ({message: 'error', csrfToken: data.csrfToken}));
}

MediaHandler.updateMediaElement = function(data) {
    const url = `/admin/media/${data.element ? data.element.id : 999999}`;
    data['_METHOD'] = 'PUT';

    return fetch(url, {
        body: JSON.stringify(data),
        headers: {
            'content-type': 'application/json'
        },
        credentials: 'include',
        method: 'POST'
    })
        .then(response => response.json())
        .then(data => ({message: 'success', csrfToken: data.csrfToken, element: data.element, error: data.error}))
        .catch(data => ({message: 'error', csrfToken: data.csrfToken}));
}

export default MediaHandler;