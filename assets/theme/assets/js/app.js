!function(a){"use strict";a(".slimscroll").slimscroll({height:"auto",position:"right",size:"7px",color:"#ebf0f6",wheelStep:5,opacity:1,touchScrollStep:50}),a(window).width()<1025?a("body").addClass("enlarge-menu"):1!=a("body").data("keep-enlarged")&&a("body").removeClass("enlarge-menu"),a(".navigation-menu a").each(function(){var e=window.location.href.split(/[?#]/)[0];this.href==e&&(a(this).parent().addClass("active"),a(this).parent().parent().parent().addClass("active"),a(this).parent().parent().parent().parent().parent().addClass("active"))}),a(".navbar-toggle").on("click",function(e){a(this).toggleClass("open"),a("#navigation").slideToggle(400)}),a(".navigation-menu>li").slice(-2).addClass("last-elements"),a('.navigation-menu li.has-submenu a[href="#"]').on("click",function(e){a(window).width()<992&&(e.preventDefault(),a(this).parent("li").toggleClass("open").find(".submenu:first").toggleClass("open"))}),Waves.init()}(jQuery);