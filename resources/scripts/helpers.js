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

export default helpers;