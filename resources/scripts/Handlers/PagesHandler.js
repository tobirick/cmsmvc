const PagesHandler = {};

PagesHandler.loadPageItems = async function() {
    const url = `/pages`;
    const response = await fetch(url, {
        method: 'POST',
        credentials: 'include'
    });

    const data = await response.json();

    return data;
};

export default PagesHandler;