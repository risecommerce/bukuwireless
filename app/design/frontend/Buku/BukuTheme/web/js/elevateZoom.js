define([
    "jquery",
    "js/jquery.elevatezoom"
], function($){
    return function (config, element) {
        return $(element).elevateZoom(config);
    }
});