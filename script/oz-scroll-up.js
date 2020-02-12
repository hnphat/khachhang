/*
	Plugin Name : oz-scroll-up
	Created By : Osama Elzero
	Website : elzero.info
*/
/*global $, jQuery, alert*/
/*
 ---------Insert code below in style in header -----------------------
        #oz-scroll {
            position:fixed;
            bottom:80px;
            right:-80px;
            height:48px;
            width:48px;
            overflow:hidden;
            display:none;
            zoom:1;
            filter:alpha(opacity=60);
            opacity:.6;
            -webkit-transition:all .5s ease-in-out;
            -moz-transition:all .5s ease-in-out;
            -ms-transition:all .5s ease-in-out;
            -o-transition:all .5s ease-in-out;
            transition:all .5s ease-in-out;
        }
        #oz-scroll img {max-width:100%}
        #oz-scroll:hover {opacity:1}
        .style2 {background-image:url('image/oz-scroll-up/style2.png')}
 ---------Insert code below before body tab------------
<a id="oz-scroll" class="style2" href="#"></a>
<script src="script/oz-scroll-up.js">
 */

$(function () {
    "use strict";
	var $ele = $('#oz-scroll');
    $(window).scroll(function () {
        if ($(this).scrollTop() >= 200) {
            $ele.show(10).animate({right: '15px'}, 10);
        } else {
            $ele.animate({right: '-80px'}, 10);
        }
    });
    $ele.click(function (e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: 0
        }, 600);
    });
});
  
