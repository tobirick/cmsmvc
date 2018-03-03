const PagebuilderHandler = {};

PagebuilderHandler.loadPagebuilderElements = async function(data) {
    const url = `/pagebuilder/items`;
    return fetch(url, {
        body: JSON.stringify(data),
        headers: {
            'content-type': 'application/json'
        },
        credentials: 'include',
        method: 'POST'
    })
        .then(response => response.json())
        .then(data => data);
}

PagebuilderHandler.savePagebuilder = async function(data) {
    console.log(data);
    const url = `/pagebuilder`;
    return fetch(url, {
        body: JSON.stringify(data),
        headers: {
            'content-type': 'application/json'
        },
        credentials: 'include',
        method: 'POST'
    })
        .then(response => response.json())
        .then(data => data);
}

PagebuilderHandler.fetchSections = async function(pageID) {
    const url = `/pages/${pageID}/pagebuilder/sections`;
    return fetch(url, {
        credentials: 'include',
        method: 'GET'
    })
        .then(response => response.json())
        .then(data => data);
}

PagebuilderHandler.fetchRows = async function(sectionID) {
    const url = `/pages/pagebuilder/sections/${sectionID}/rows`;
    return fetch(url, {
        credentials: 'include',
        method: 'GET'
    })
        .then(response => response.json())
        .then(data => data);
}

PagebuilderHandler.fetchColumnRows = async function(rowID) {
    const url = `/pages/pagebuilder/sections/rows/${rowID}/columnrows`;
    return fetch(url, {
        credentials: 'include',
        method: 'GET'
    })
        .then(response => response.json())
        .then(data => data);
}

PagebuilderHandler.fetchColumns = async function(columnRowID) {
    const url = `/pages/pagebuilder/sections/rows/columnrows/${columnRowID}/columns`;
    return fetch(url, {
        credentials: 'include',
        method: 'GET'
    })
        .then(response => response.json())
        .then(data => data);
}

PagebuilderHandler.fetchElement = async function(columnID) {
   const url = `/pages/pagebuilder/sections/rows/columnrows/columns/${columnID}/element`;
   return fetch(url, {
       credentials: 'include',
       method: 'GET'
   })
       .then(response => response.json())
       .then(data => data);
}

export default PagebuilderHandler;