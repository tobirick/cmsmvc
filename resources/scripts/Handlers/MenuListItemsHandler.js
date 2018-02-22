const MenuListItemsHandler = {};

MenuListItemsHandler.loadMenuListItems = async function(id) {
    const url = `/admin/menus/${id}/menuitems`;
    const response = await fetch(url, {
        method: 'GET',
        credentials: 'include'
    });

    const data = await response.json();

    return data;
}

MenuListItemsHandler.handleAddMenuListItem = function(data, menuID) {
    const url = `/admin/menus/${menuID}/menuitems`;
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

MenuListItemsHandler.handleUpdateMenuListItem = function(data, menuID, menuItemID) {
    data['_METHOD'] = 'PUT';
    const url = `/admin/menus/${menuID}/menuitems/${menuItemID}`;

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

MenuListItemsHandler.handleUpdateMenuListItemPositions = function(data, menuID) {
    const url = `/admin/menus/${menuID}/menuitems/position`;

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

MenuListItemsHandler.handleDeleteMenuListItem = function(data, menuID, menuItemID) {
    data['_METHOD'] = 'DELETE';
    const url = `/admin/menus/${menuID}/menuitems/${menuItemID}`;

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

export default MenuListItemsHandler;