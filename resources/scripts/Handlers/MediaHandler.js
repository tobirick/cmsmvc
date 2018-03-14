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

export default MediaHandler;