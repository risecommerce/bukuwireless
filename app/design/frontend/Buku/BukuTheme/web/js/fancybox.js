define([
    "jquery",
    "js/jquery.fancybox"
], function($){
    return function (config, element) {
        return $(element).fancybox(config);
    }
});