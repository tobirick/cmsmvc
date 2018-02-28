const PagebuilderHandler = {};

PagebuilderHandler.loadPagebuilderElements = async function() {
    const url = `/pagebuilder/items`;
    const response = await fetch(url, {
        method: 'POST',
        credentials: 'include'
    });

    const data = await response.json();

    return data;
}

export default PagebuilderHandler;