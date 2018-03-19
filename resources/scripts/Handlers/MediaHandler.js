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

MediaHandler.addFile = function(data) {
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

MediaHandler.updateMediaElement = function(data) {
    console.log(data);
    const url = `/admin/media/${data.element.id}`;
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
        .then(data => ({message: 'success', csrfToken: data.csrfToken, element: data.element}))
        .catch(data => ({message: 'error', csrfToken: data.csrfToken}));
}

export default MediaHandler;