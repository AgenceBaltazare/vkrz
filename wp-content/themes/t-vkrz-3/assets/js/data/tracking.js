jQuery(document).ready(function ($) {

    function treatData(obj) {
        Object.keys(obj).forEach(function (key, i) {
            if (typeof obj[key] === "object") {
                treatData(obj[key]);
            }
            if (obj[key] === "" && obj[key] !== 0) {
                obj[key] = undefined;
            }
        })
        return obj;
    }

});