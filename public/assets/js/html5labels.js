var func = func || {};

$(document).ready(function ()
{
    var msie    = /MSIE/i.test(navigator.userAgent) 
               && (   /9.0/.test(navigator.userAgent) 
                   || /8.0/.test(navigator.userAgent)
                   || /7.0/.test(navigator.userAgent)
                   || /10.0/.test(navigator.userAgent)
                   || /6.0/.test(navigator.userAgent) ) ;

    if (msie)
    {
        $('.sr-only').removeClass('sr-only');
    }
});
