const ThemeHandler = {};

ThemeHandler.fetchThemeSettings = async function (data) {
    const url = `/admin/themes/${data.themeID}`;
    const response = await fetch(url, {
        body: JSON.stringify(data),
        headers: {
            'content-type': 'application/json'
        },
        method: 'POST',
        credentials: 'include'
    });

    const themeData = await response.json();

    return themeData;
};

ThemeHandler.updateThemeSettings = async function (data) {
    const url = `/admin/themes/${data.themeID}/settings`;
    const response = await fetch(url, {
        body: JSON.stringify(data),
        headers: {
            'content-type': 'application/json'
        },
        method: 'POST',
        credentials: 'include'
    });

    const themeData = await response.json();

    return themeData;
};

export default ThemeHandler;