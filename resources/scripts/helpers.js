const helpers = {};

helpers.mediaElementFormat = function(value) {
    value = value.toLowerCase();

    value = value.replace(/ä/g, 'ae');
    value = value.replace(/\u00c4/g, "ae")

    value = value.replace(/ö/g, 'oe');
    value = value.replace(/\u00d6/g, "oe")

    value = value.replace(/ü/g, 'ue');
    value = value.replace(/\u00dc/g, "ue")

    value = value.replace(/ß/g, 'ss');
    value = value.replace(/\u00df/g, "ss")

    value = value.replace(/ /g,"_");

    return value;
}

helpers.isJsonString = function(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

helpers.createSlug = (text) => {
    return text.toString().toLowerCase()
    .replace(/\s+/g, '-')
    .replace(/[^\w\-]+/g, '')
    .replace(/\-\-+/g, '-')
    .replace(/^-+/, '')
    .replace(/-+$/, ''); 
}

helpers.fadeOutEffect = (target, callback) => {
    const fadeTarget = target;
    const fadeEffect = setInterval(function () {
        if (!fadeTarget.style.opacity) {
            fadeTarget.style.opacity = 1;
        }
        if (fadeTarget.style.opacity < 0.1) {
            clearInterval(fadeEffect);
            callback();
        } else {
            fadeTarget.style.opacity -= 0.01;
        }
    }, 5);

}

export default helpers;