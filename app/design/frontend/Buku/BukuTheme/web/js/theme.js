define(["jquery"], function($){
	
	function resizeFunc(){
		
		var mediaQuery = $(window).width();
		var mediaXS = 0;
		var mediaSM = 768;
		var mediaMD = 960;
		var mediaLG = 1070;
		var mediaXL = 1280;
		
		if (mediaQuery < mediaSM) {
			$(".footer-menu-list").addClass("accordion");
		}
		else {
			$(".footer-menu-list").removeClass("accordion");
		}
		
		if (mediaQuery <= mediaLG) {
		var hamburgerPos = $("#nav-toggle").offset();
		var hamburgerPosTop = hamburgerPos.top;
		var hamburgerPosLeft = hamburgerPos.left;
		var navWidth = $(".navigation").width();
		/*if (!$("#nav-toggle").hasClass("menu-toggled")){
			$("#nav-toggle").css({
				"top" : hamburgerPosTop * -1 + "px",
				"left" : (hamburgerPosLeft * -1) + navWidth - 80 + "px"
			});
		}*/ }
	}
	
	resizeFunc();
	$(window).on("resize", function() {
	   window.requestAnimationFrame(resizeFunc);
	});

	var topLevel = $(".bottom-header .navigation .level0.parent");
	var midLevel = $(".bottom-header .navigation .level-top > .submenu");
	var bottomLevel = $(".bottom-header .navigation .level1.submenu");
	
	$("ul.level1.submenu").each(function(){
		var children = $(this).children();
		if (children.length == 0) {
			$(this).remove();
		}
	});
	$(".submenu-box").each(function(){
		var submenu = $(this).find("ul.submenu"),
		catImg = $(this).find("img"),
		originalSrc = catImg.attr("src");
		submenu.find("a").on("mouseover", function(){
			var newImg = $(this).attr("data-category-img");
			catImg.attr("src", newImg);
		});
	});
	
	/*midLevel.wrap("<div class='submenu-wrap'><div class='container'><div class='row'></div></div></div>");
	$(".bottom-header .navigation li.level1").addClass("col-lg-3 col-xs-12").wrapInner( "<div class='submenu-box'></div>");
	$(".submenu-box > a").after("<div class='menu-catalog-image'></div>");*/
	
	/*function menuImages(){
		$(".submenu-box > a").each(function(){
			var link = $(this);
			var menuImgArray = [];
			link.after("<div class='menu-catalog-image'></div>");
		});
	}*/
	
	/*$(".submenu a").on("mouseover", function(){
		var link = $(this);
		var imgArray = [];
		var href = link.attr("href");
		$.get(href, function ( data ){
			var urlData = data;
			console.log(urlData);
		});
	});*/
	
	topLevel.on("mouseover", function(){
		$(this).addClass("menu-active");
	});
	topLevel.on("mouseleave", function(){
		$(this).removeClass("menu-active");
	});
	
	$(".bottom-header .navigation li.level1").on("mouseover", function(){
		$(this).addClass("menu-active");
	});
	$(".bottom-header .navigation li.level1").on("mouseleave", function(){
		$(this).removeClass("menu-active");
	});
	
	var footerMenu = $(".footer-menu-list");
	
	function closeFooterMenu(){
        $(".footer-menu-list h3").removeClass("accordion-active");
        $(".footer-menu-list ul").removeClass("accordion-open");
	}
	footerMenu.each(function(){
		var link = $(this).find("h3");
		var list = $(this).find("ul");
		link.on("click", function(){
			if($(this).is(".accordion-active")){
				closeFooterMenu();
			} else {
				closeFooterMenu();
				$(this).addClass("accordion-active");
				list.addClass("accordion-open");
			}
		});
	});
	
	function toggleMenu(){
		resizeFunc();
		if ($("#nav-toggle").hasClass("menu-toggled")){
			$("#nav-toggle, .navigation").removeClass("menu-toggled");
		} else {
			$("#nav-toggle, .navigation").addClass("menu-toggled");
		}
	}
	
	$("#nav-toggle").on("click", function(){
		toggleMenu();
	});
	
	$(".search-toggle a").on("click", function(e){
		$(this).parent().append($(".block-search").removeClass("slide-out").addClass("slide-in").show());
		e.preventDefault();
	});
	$(".block-search .actions .close").on("click", function(e){
		$(".block-search").removeClass("slide-in").addClass("slide-out").hide();
		e.preventDefault();
	});
	
	function closeCatalogNav(){
		$(".catalog-navigation li.level0").removeClass("menu-active");
	}
	$(".catalog-navigation li.level0 > a").on("click", function (e){
		if(!$(this).parent().hasClass("menu-active")){
			closeCatalogNav();
			$(this).parent().addClass("menu-active");
		} else {
			closeCatalogNav();
		}
		e.preventDefault();
	});	
	$("#remember-me-box .tooltip a").on("click", function(e){
		var tooltip = $(this).siblings(".content");
		if (tooltip.is(":visible")){
			tooltip.fadeOut();
		} else {
			tooltip.fadeIn();
		}
		e.preventDefault();
	});
	$("#remember-me-box .close").on("click", function(e){
		$(this).parent(".content").fadeOut();
		e.preventDefault();
	});
	
	// Wholesale Apply
	
	$("a[href$='#apply']").on("click", function(e){
		$("#wholesale-block").fadeIn();
		$("#wholesale-block").find(".container").append("<button class='close'><i aria-hidden='true' class='fa fa-times fa-2x'></i></button>")
		e.preventDefault();
	});
	$("body").on("click", "#wholesale-block .close", function(e){
			$("#wholesale-block").fadeOut();
			e.preventDefault();
	});
	
	$('.account-activity a[href*="#trigger-compare"]').on("click", function(e){
		var compareBlock = $(".account-activity ~ .block-compare");
		if (compareBlock.is(":hidden")){
			compareBlock.fadeIn("fast");
		} else {
			compareBlock.fadeOut("fast");	
		}
		e.preventDefault();
	});
	$("body").on("click", "#close-compare-block", function(){
		$(".block-compare").fadeOut("fast");
	});
	
(function ($){
	$.fn.parallaxAttrs = function(width, height, horiz, diff){
		this.attr("data-img-width", width);
		this.attr("data-img-height", height);
		this.attr("data-oriz-pos", horiz + "%");
		this.attr("data-diff", diff);
		backgroundResize();
		parallaxPosition();
		return this;
	}
})(jQuery);

$(".sell-hero").parallaxAttrs(1920, 1000, 50, 100);
$("#sell-benefits").parallaxAttrs(1920, 1000, 50, 100);
$(".wholesale-hero").parallaxAttrs(1920, 1280, 50, 100);
$("#wholesale-faq").parallaxAttrs(1920, 1280, 50, 100);

/* detect touch */
if("ontouchstart" in window){
    document.documentElement.className = document.documentElement.className + " touch";
}
if(!$("html").hasClass("touch")){
    /* background fix */
    $(".parallax").css("background-attachment", "fixed");
}

/* resize background images */
function backgroundResize(){
    var windowH = $(window).height();
    $(".background").each(function(i){
        var path = $(this);
        // variables
        var contW = path.width();
        var contH = path.height();
        var imgW = path.attr("data-img-width");
        var imgH = path.attr("data-img-height");
        var ratio = imgW / imgH;
        // overflowing difference
        var diff = parseFloat(path.attr("data-diff"));
        diff = diff ? diff : 0;
        // remaining height to have fullscreen image only on parallax
        var remainingH = 0;
        if(path.hasClass("parallax") && !$("html").hasClass("touch")){
            var maxH = contH > windowH ? contH : windowH;
            remainingH = windowH - contH;
        }
        // set img values depending on cont
        imgH = contH + remainingH + diff;
        imgW = imgH * ratio;
        // fix when too large
        if(contW > imgW){
            imgW = contW;
            imgH = imgW / ratio;
        }
        //
        path.data("resized-imgW", imgW);
        path.data("resized-imgH", imgH);
        path.css("background-size", imgW + "px " + imgH + "px");
    });
}
$(window).resize(backgroundResize);
$(window).focus(backgroundResize);
backgroundResize();

/* set parallax background-position */
function parallaxPosition(e){
    var heightWindow = $(window).height();
    var topWindow = $(window).scrollTop();
    var bottomWindow = topWindow + heightWindow;
    var currentWindow = (topWindow + bottomWindow) / 2;
    $(".parallax").each(function(i){
        var path = $(this);
        var height = path.height();
        var top = path.offset().top;
        var bottom = top + height;
        // only when in range
        if(bottomWindow > top && topWindow < bottom){
            var imgW = path.data("resized-imgW");
            var imgH = path.data("resized-imgH");
            // min when image touch top of window
            var min = 0;
            // max when image touch bottom of window
            var max = - imgH + heightWindow;
            // overflow changes parallax
            var overflowH = height < heightWindow ? imgH - height : imgH - heightWindow; // fix height on overflow
            top = top - overflowH;
            bottom = bottom + overflowH;
            // value with linear interpolation
            var value = min + (max - min) * (currentWindow - top) / (bottom - top);
            // set background-position
            var orizontalPosition = path.attr("data-oriz-pos");
            orizontalPosition = orizontalPosition ? orizontalPosition : "50%";
            $(this).css("background-position", orizontalPosition + " " + value + "px");
        }
    });
}
if(!$("html").hasClass("touch")){
    $(window).resize(parallaxPosition);
    //$(window).focus(parallaxPosition);
    $(window).scroll(parallaxPosition);
    parallaxPosition();
}

if($(".form-4").length){
	$("#quantity").attr("type", "number");
	$("#quantity").attr("maxlength", "12");
	$("#quantity").attr("value", "1");
	require(["jquery", "mage/calendar"], function($){
	$("#order_date").calendar({
	    showsTime: false,
	    
	    dateFormat: "M/d/yy",
	    
	    buttonText: "Select Date"
	})	
	});
}
$(".quick-view").on("click", function (e){
	var title = $(this).parents(".product-item-info").find("h3.product-item-name").html();
	var anchor = $(this).attr("href");
	var quickImg = $(this).attr("data-quick-img");
	$("body").append("<div class='modals-overlay'></div><div id='quickView' class='ajax-loading'><button id='close-quickview'><i class='fa fa-times fa-2x' aria-hidden='true'></i></button><div class='quickview-inner container-fluid'><div class='title-wrap text-center'><h2>" + title + "</h2></div><div class='row'><div class='col-xs-12 col-sm-6 col-lg-7 col-xl-8'><div id='quickview-content'></div></div><div class='col-xs-12 col-sm-6 col-lg-5 col-xl-4'><img src='" + quickImg + "' /></div></div></div></div>");
	$(".modals-overlay").addClass("active").fadeIn();
	$("#quickview-content").load($(this).attr("href") + " #product-info-box", function(){
		$("#quickView").removeClass("ajax-loading").addClass("ajax-success");
		$("#quickView #product-addtocart-button").after("<a class='cta quickview-gotoproduct' href='" + anchor + "'>View <i class='fa fa-chevron-right' aria-hidden='true'></i></a>");
	});
	e.preventDefault();
});

$("body").on("click", "#close-quickview, .modals-overlay", function(){
	$("#quickView").fadeOut("slow").remove();
	$(".modals-overlay").fadeOut("slow").remove();
});

$(function() {
  $('a[href*="#"]:not([href="#"])').click(function() {
	if(!$(this).hasClass('no-scroll')){
	    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
	      var target = $(this.hash);
	      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
	      if (target.length) {
	        $('html, body').animate({
	          scrollTop: target.offset().top
	        }, 1000);
	        return false;
	      }
	    }
	}
  });
});


}); // END OF FILE