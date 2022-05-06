define([
  'jquery',
  'js/jquery.elevatezoom'
], function($){
 
  return function (config, element) {
   var elevateZoomConfig = {
   		zoomType : "inner"
   };
   $(element).elevateZoom(elevateZoomConfig);
  }
});