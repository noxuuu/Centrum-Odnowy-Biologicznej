jQuery(document).ready(function(){
    "use strict";

    jQuery('#main_menu_left li, #main_menu_right li').each(function()
    {
        var jQuerysublist = jQuery(this).find('ul:first');

        jQuery(this).hover(function()
            {
                jQuerysublist.addClass('visible');
            },
            function()
            {
                jQuerysublist.removeClass('visible');
            });

    });

    jQuery('#menu_wrapper .notice').verticalAlignMenu();
    jQuery('.main_menu_container').verticalAlignMenu();
    jQuery('.header_cart_wrapper').verticalAlignMenu();
    jQuery('#page_caption_wrapper').verticalAlign();
    jQuery('#page_caption_wrapper').addClass('visible');
    jQuery('#page_caption #social_share_wrapper').addClass('visible');
    jQuery('.header_cart_wrapper').addClass('visible');
    jQuery('.content_middle').verticalAlign();

    jQuery('#horizontal_gallery_wrapper tbody tr td .gallery_image_wrapper, .horizontal_gallery_wrapper tbody tr td .gallery_image_wrapper').children('.horizontal_gallery_img').each(function(index, value)
    {
        var calScreenWidth = jQuery(window).width();
        var calScreenHeight = jQuery(window).height()/2;

        jQuery(this).css('max-width', calScreenWidth+'px');
        jQuery(this).css('max-height', calScreenHeight+'px');
        jQuery(this).parent().addClass('visible');
    });

    var calScreenWidth = jQuery(window).width();

    jQuery('#horizontal_gallery, .horizontal_gallery').imagesLoaded(function(){
        if(calScreenWidth >= 480)
        {
            jQuery('#horizontal_gallery').addClass('visible');
        }
    });

    jQuery(window).resize(function() {
        jQuery('#horizontal_gallery_wrapper tbody tr td .gallery_image_wrapper, .horizontal_gallery_wrapper tbody tr td .gallery_image_wrapper').children('.horizontal_gallery_img').each(function(index, value)
        {
            var calScreenWidth = jQuery(window).width();
            var calScreenHeight = jQuery(window).height()/2;

            jQuery(this).css('max-width', calScreenWidth+'px');
            jQuery(this).css('max-height', calScreenHeight+'px');
            jQuery(this).parent().addClass('visible');
        });
    });

    jQuery(window).resize(function() {
        jQuery('#page_caption_wrapper').verticalAlign();
    });

    jQuery('a.fancy-gallery, .pp_gallery a').hover(
        function(e) {
            e.preventDefault();
        },
        function() { }
    );

    jQuery('.fancy_video, .lightbox_vimeo').magnificPopup({
        src: jQuery(this).attr('href'),
        type: 'inline',
        removalDelay: 300,
        mainClass: 'mfp-fade'
    });

    jQuery('a.fancy-gallery, .pp_gallery a').magnificPopup({
        type: 'image',
        removalDelay: 300,
        mainClass: 'mfp-fade',
        gallery:{
            enabled:true
        },
        callbacks: {
            imageLoadComplete: function() {
                var isDisableDragging = jQuery('#pp_enable_dragging').val();

                if(isDisableDragging!='')
                {
                    jQuery("img.mfp-img").mousedown(function(){
                        return false;
                    });
                }
            },
        }
    });

    jQuery('.img_frame').magnificPopup({
        type: 'image',
        removalDelay: 300,
        mainClass: 'mfp-fade',
        callbacks: {
            imageLoadComplete: function() {
                var isDisableDragging = jQuery('#pp_enable_dragging').val();

                if(isDisableDragging!='')
                {
                    jQuery("img.mfp-img").mousedown(function(){
                        return false;
                    });
                }
            },
        }
    });

    jQuery('.post_img').click(
        function(event){
            jQuery(this).children('a').trigger('click');
        }
    );

    var isDisableRightClick = jQuery('#pp_enable_right_click').val();

    if(isDisableRightClick!='')
    {
        jQuery(this).bind("contextmenu", function(e) {
            e.preventDefault();
        });
    }

    var isDisableDragging = jQuery('#pp_enable_dragging').val();

    if(isDisableDragging!='')
    {
        jQuery("img").mousedown(function(){
            return false;
        });
    }

    var windowWidth = jQuery(window).width();
    var $window = jQuery(window);
    var jQueryblogcontainer = jQuery('#blog_grid_wrapper, .blog_grid_wrapper');
    var blogGridColumn = 2;

    function reBlogLayout() {

        var currentContainerWidth = jQueryblogcontainer.width();

        var blogGridColumn = 3;
        if(jQuery(window).width() < 480)
        {
            blogGridColumn = 1;
        }
        else if(jQuery(window).width() >= 480 && jQuery(window).width() < 768)
        {
            blogGridColumn = 2;
        }

        var masonryOpts = {
            columnWidth: parseInt(currentContainerWidth/blogGridColumn)
        };

        jQueryblogcontainer.isotope({
            resizable: false, // disable resizing by default, we'll trigger it manually
            itemSelector : '.post.type-post',
            masonry: masonryOpts
        }).isotope();
    }

    // initialize masonry
    jQuery('#blog_grid_wrapper, .blog_grid_wrapper').imagesLoaded(function(){
        reBlogLayout();

        jQuery('#blog_grid_wrapper, .blog_grid_wrapper').children('.post.type-post').each(function(index, value){
            jQuery(this).addClass('animated'+(index+1));
            jQuery(this).addClass('visible');
        });

        $window.smartresize( reBlogLayout );
    });

    jQuery('#blog_grid_wrapper, blog_grid_wrapper').children('.post.type-post').waypoint(function(direction) {
        jQuery(this).addClass('visible', direction === 'down');

    } , { offset: '80%' });

    // filter items when filter link is clicked
    jQuery('#portfolio_wall_filters li a').click(function(){
        var selector = jQuery(this).attr('data-filter');
        jQueryblogcontainer.isotope({ filter: selector });
        jQuery('#portfolio_wall_filters li a').removeClass('active');
        jQuery(this).addClass('active');
        return false;
    });

    //Add to top button when scrolling
    jQuery(window).scroll(function() {
        var calScreenWidth = jQuery(window).width();

        if(calScreenWidth > 768)
        {
            if(jQuery(this).scrollTop() > 200) {
                jQuery('#toTop').stop().css({opacity: 1.0, "visibility": "visible"}).animate({"visibility": "visible"}, {duration:500,easing:"easeOutExpo"});
            } else if(jQuery(this).scrollTop() == 0) {
                jQuery('#toTop').stop().css({opacity: 0, "visibility": "hidden"}).animate({"visibility": "hidden"}, {duration:500,easing:"easeOutExpo"});
            }
        }
    });

    jQuery('#toTop').click(function() {
        jQuery('body,html').animate({scrollTop:0},800);
    });

    jQuery('#menu_close_icon').click(function() {
        jQuery('body').toggleClass('js_nav');

    });

    var supersizedWidth = jQuery('#supersized').width();
    var wrapperLeft = jQuery('#wrapper').css('left').replace(/[^-\d\.]/g, '');
    var calScreenWidth = jQuery(window).width();
    var calScreenHeight = jQuery(window).height();

    jQuery('#option_btn').click(
        function() {
            if(jQuery('#option_wrapper').css('left') != '0px')
            {
                jQuery('#option_wrapper').animate({"left": "0px"}, { duration: 500 });
                jQuery(this).animate({"left": "250px"}, { duration: 500 });
            }
            else
            {
                jQuery('#option_wrapper').animate({"left": "-255px"}, { duration: 500 });
                jQuery('#option_btn').animate({"left": "0px"}, { duration: 500 });
            }
        }
    );

    function launchFullscreen(element) {
        if(element.requestFullscreen) {
            element.requestFullscreen();
        } else if(element.mozRequestFullScreen) {
            element.mozRequestFullScreen();
        } else if(element.webkitRequestFullscreen) {
            element.webkitRequestFullscreen();
        } else if(element.msRequestFullscreen) {
            element.msRequestFullscreen();
        }
    }

    function exitFullscreen() {
        if(document.exitFullscreen) {
            document.exitFullscreen();
        } else if(document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if(document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        }
    }

    jQuery('#page_maximize').click(function(){
        if(jQuery(this).hasClass('minimize'))
        {
            exitFullscreen();
        }
        else
        {
            launchFullscreen(document.documentElement);
        }

        jQuery(this).toggleClass('minimize');
    });

    if(calScreenWidth > 960)
    {
        jQuery('#full_video_bg').css('width', calScreenWidth+'px');
        jQuery('#full_video_bg').css('height', calScreenHeight+'px');
        jQuery('.photo_wall_wrapper_cover').css('top', calScreenHeight-14+'px');
    }
    else if(calScreenWidth <= 960 && calScreenWidth > 480)
    {
        jQuery('#full_video_bg').css('width', calScreenWidth+'px');
        jQuery('#full_video_bg').css('height', calScreenHeight+'px');
        jQuery('.photo_wall_wrapper_cover').css('top', calScreenHeight+'px');
    }
    else if(calScreenWidth <= 480)
    {
        jQuery('#full_video_bg').css('width', calScreenWidth+'px');
        jQuery('#full_video_bg').css('height', calScreenHeight+'px');
        jQuery('.photo_wall_wrapper_cover').css('top', calScreenHeight+25+'px');
    }

    jQuery(window).resize(function() {
        var calScreenWidth = jQuery(window).width();
        var calScreenHeight = jQuery(window).height();

        if(calScreenWidth > 960)
        {
            jQuery('#full_video_bg').css('width', calScreenWidth+'px');
            jQuery('#full_video_bg').css('height', calScreenHeight+'px');
            jQuery('.photo_wall_wrapper_cover').css('top', calScreenHeight-14+'px');
        }
        else if(calScreenWidth <= 960 && calScreenWidth > 480)
        {
            jQuery('#full_video_bg').css('width', calScreenWidth+'px');
            jQuery('#full_video_bg').css('height', calScreenHeight+'px');
            jQuery('.photo_wall_wrapper_cover').css('top', calScreenHeight+'px');
        }
        else if(calScreenWidth <= 480)
        {
            jQuery('#full_video_bg').css('width', calScreenWidth+'px');
            jQuery('#full_video_bg').css('height', calScreenHeight+'px');
            jQuery('.photo_wall_wrapper_cover').css('top', calScreenHeight+25+'px');
        }
    });

    if(jQuery('#pp_menu_display').val()=='true')
    {
        jQuery('#menu_close_icon').trigger('click');
    }

    window.onbeforeunload = function(e){
        jQuery('body').addClass('loading');
    }

    jQuery('div[data-type="background"]').each(function(){
        var bgobj = jQuery(this);

        jQuery(window).scroll(function() {
            var yPos = -(jQuery(window).scrollTop() / bgobj.data('speed'));

            var coords = '50% '+ yPos + 'px';

            bgobj.css({ backgroundPosition: coords });
        });
    });

    jQuery('.progress_bar').each(function(){
        jQuery(this).addClass('fadeIn');
        var progressContent = jQuery(this).children('.progress_bar_content');
        var progressWidth = progressContent.data('score');

        progressContent.css({'width': progressWidth+'%'});
    });

    // Isotope
    // modified Isotope methods for gutters in masonry
    jQuery.Isotope.prototype._getMasonryGutterColumns = function() {
        var gutter = this.options.masonry && this.options.masonry.gutterWidth || 0;
        var containerWidth = this.element.width();

        this.masonry.columnWidth = this.options.masonry && this.options.masonry.columnWidth ||
            // or use the size of the first item
            this.$filteredAtoms.outerWidth(true) ||
            // if there's no items, use size of container
            containerWidth;

        this.masonry.columnWidth += gutter;

        this.masonry.cols = Math.floor( ( containerWidth + gutter ) / this.masonry.columnWidth );
        this.masonry.cols = Math.max( this.masonry.cols, 1 );
    };

    jQuery.Isotope.prototype._masonryReset = function() {
        // layout-specific props
        this.masonry = {};
        // FIXME shouldn't have to call this again
        this._getMasonryGutterColumns();
        var i = this.masonry.cols;
        this.masonry.colYs = [];
        while (i--) {
            this.masonry.colYs.push( 0 );
        }
    };

    jQuery.Isotope.prototype._masonryResizeChanged = function() {
        var prevSegments = this.masonry.cols;
        // update cols/rows
        this._getMasonryGutterColumns();
        // return if updated cols/rows is not equal to previous
        return ( this.masonry.cols !== prevSegments );
    };

    // cache jQuery window
    var $window = jQuery(window);

    // cache container
    var $container = jQuery('#photo_wall_wrapper, .photo_wall_wrapper');

    // start up isotope with default settings
    $container.imagesLoaded( function(){
        reLayout();

        jQuery(this).children('.wall_entry').each(function(index, value){
            if(jQuery(this).hasClass('masonry'))
            {
                var imgWidth = jQuery(this).find('.portfolio_img:first').width();
                var imgHeight = jQuery(this).find('.portfolio_img:first').height();
                jQuery(this).find('.mask_image_content:first').css('width', imgWidth-20+'px');
                jQuery(this).find('.mask_image_content:first').css('height', imgHeight-20+'px');
            }
        });

        $window.smartresize( reLayout );
    });

    jQuery('#photo_wall_wrapper, .photo_wall_wrapper').children('.wall_entry').waypoint(function(direction) {
        jQuery(this).addClass('visible', direction === 'down');

    } , { offset: '80%' });

    jQuery(window).resize(function() {
        var $container = jQuery('#photo_wall_wrapper, .photo_wall_wrapper');

        $container.children('.wall_entry').each(function(index, value){
            if(jQuery(this).hasClass('masonry'))
            {
                var imgWidth = jQuery(this).find('.portfolio_img:first').width();
                var imgHeight = jQuery(this).find('.portfolio_img:first').height();
                jQuery(this).find('.mask_image_content:first').css('width', imgWidth-20+'px');
                jQuery(this).find('.mask_image_content:first').css('height', imgHeight-20+'px');
            }
        });
    });

    function reLayout() {

        var currentContainerWidth = $container.width();

        var columnCount = 3;
        if(jQuery(window).width() < 480)
        {
            columnCount = 1;
        }
        else if(jQuery(window).width() >= 1400 && jQuery(window).width() < 1720)
        {
            columnCount = 4;
        }
        else if(jQuery(window).width() >= 1720 && jQuery(window).width() < 2200)
        {
            columnCount = 5;
        }
        else
        {
            columnCount = 6;
        }
        //alert(parseInt(currentContainerWidth/columnCount));
        var masonryOpts = {
            columnWidth: parseInt(currentContainerWidth/columnCount)
        };

        $container.isotope({
            resizable: false, // disable resizing by default, we'll trigger it manually
            itemSelector : '.wall_entry',
            masonry: masonryOpts
        }).isotope( 'reLayout' );
    }

    jQuery('.animate').waypoint(function(direction) {
        jQuery(this).addClass('visible', direction === 'down');

    } , { offset: '80%' });

    jQuery('#page_content_wrapper.fixed .animate').addClass('visible');

    var topbarHeight = jQuery('.top_bar').height();
    topbarHeight+= parseInt(jQuery('.top_bar').css('paddingTop'));
    topbarHeight+= parseInt(jQuery('.top_bar').css('paddingBottom'));


    if(jQuery('#pp_fixed_menu').val()=='true')
    {
        jQuery(window).scroll(function(){

            if(jQuery(this).scrollTop() >= 200){
                jQuery('.top_bar').addClass('fixed');
                jQuery('.top_bar').addClass('visible');
                jQuery('.main_menu_container').verticalAlignMenu();
                jQuery('#menu_wrapper .notice').verticalAlignMenu();
                jQuery('.header_cart_wrapper').verticalAlignMenu();
            }
            else if(jQuery(this).scrollTop() < 200)
            {
                jQuery('.top_bar').removeClass('fixed');
                jQuery('.top_bar').removeClass('visible');
                jQuery('.main_menu_container').verticalAlignMenu();
                jQuery('#menu_wrapper .notice').verticalAlignMenu();
                jQuery('.header_cart_wrapper').verticalAlignMenu();

                if(jQuery('#pp_page_frame').val()=='true')
                {
                    jQuery('#wrapper').css('paddingTop', '20px');
                }
                else
                {
                    jQuery('#wrapper').css('paddingTop', '0px');
                }
            }
        });
    }

    jQuery('#mobile_nav_icon').click(function() {
        jQuery('body,html').animate({scrollTop:0},100);
        jQuery('body').toggleClass('js_nav');
    });

    jQuery('#close_mobile_menu').click(function() {
        jQuery('body').removeClass('js_nav');
    });

    jQuery('.mobile_menu_close a').click(function() {
        jQuery('body').removeClass('js_nav');
    });

    jQuery('.top_bar #searchform button').click(function(e)
    {
        e.preventDefault();

        if(jQuery(this).hasClass('active'))
        {
            jQuery(this).removeClass('active');
            jQuery('.nav').removeClass('hide');
            jQuery('#overlay_background').removeClass('visible');
        }
        else
        {
            jQuery(this).addClass('active');
            jQuery('.nav').addClass('hide');
            jQuery('#overlay_background').addClass('visible');
        }

        jQuery('.top_bar #searchform input').toggle();
        jQuery('.top_bar #searchform input').focus();
    });

    jQuery("#s").keypress(function(event) {
        if (event.which == 13) {
            event.preventDefault();
            jQuery("form#searchform").submit();
        }
    });

    if (is_touch_device())
    {
        jQuery('.parallax').each(function(){
            var dataImgURL = jQuery(this).data('image');
            if(jQuery.type(dataImgURL) != "undefined")
            {
                jQuery(this).css('background-image', 'url('+dataImgURL+')');
                jQuery(this).css('background-size', 'cover');
                jQuery(this).css('background-position', 'center center');
            }
        });
    }
    else
    {
        jQuery.stellar({
            horizontalScrolling: false,
            responsive: true
        });
    }
});

jQuery(window).load(function(){
    jQuery('.slider_wrapper').each(function(){
        var autoPlay = jQuery(this).data('autoplay');
        if(autoPlay==1)
        {
            autoPlay = true;
        }
        else
        {
            autoPlay = false;
        }
        var timer = parseInt(1000*jQuery(this).data('timer'));

        jQuery(this).flexslider({
            animation: "fade",
            animationLoop: true,
            itemMargin: 0,
            minItems: 1,
            maxItems: 1,
            slideshow: autoPlay,
            controlNav: false,
            smoothHeight: false,
            slideshowSpeed: timer,
            move: 1
        });
    });
});
