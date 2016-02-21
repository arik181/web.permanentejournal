$(document).ready(function ()
{
    var badBrowser = function()
    {
        var android = /Android/i.test(navigator.userAgent) ;

        var msie    = /MSIE/i.test(navigator.userAgent) 
                   && (   /8.0/.test(navigator.userAgent) 
                       || /7.0/.test(navigator.userAgent)
                       || /9.0/.test(navigator.userAgent)
                       || /10.0/.test(navigator.userAgent)
                       || /6.0/.test(navigator.userAgent) ) ;

        var ios     = /iOS/i.test(navigator.userAgent) 
                   && /Safari/i.test(navigator.userAgent) 
                   && (   /7.0/.test(navigator.userAgent)
                       || /7.1/.test(navigator.userAgent) ) ;

        var samsung = /SAMSUNG/i.test(navigator.userAgent);

        return android || msie || ios || samsung ;
    };

    var goodBrowser = function()
    {
        var chrome  = /Chrome/i.test(navigator.userAgent);
        var safari  = /Safari/i.test(navigator.userAgent);
        return chrome || safari;
    };

    if ( badBrowser() == true || (! goodBrowser() == true ) ) 
    {
        console.log('wut');
        $('#browser-modal').modal();
    }
});
