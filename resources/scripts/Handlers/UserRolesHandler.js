const UserRolesHandler = {};

UserRolesHandler.fetchUserRoles = async function (data) {
    const url = `/admin/roles`;
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

UserRolesHandler.fetchUserPermissions = async function (data) {
    const url = `/admin/roles/permissions`;
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

UserRolesHandler.fetchActivePermissions = async function (data) {
    const url = `/admin/roles/${data.id}/permissions`;
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

UserRolesHandler.updateUserRoles = async function (data) {
    const url = `/admin/roles/edit`;
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

UserRolesHandler.addUserRole = async function (data) {
    const url = `/admin/roles/create`;
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

UserRolesHandler.deleteUserRole = async function (data) {
    const url = `/admin/roles/delete`;
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

export default UserRolesHandler;