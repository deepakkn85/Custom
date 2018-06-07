jQuery(function(){
    SyntaxHighlighter.all();
});
jQuery(window).load(function(){
    jQuery('.flexslider').flexslider({
    animation: "slide",
    start: function(slider){
        jQuery('body').removeClass('loading');
    }
});
});
