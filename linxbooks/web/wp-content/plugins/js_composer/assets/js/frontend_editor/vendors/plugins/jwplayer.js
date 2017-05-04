(function ($) {
    var minHeight = '340px';

    function vc_jwplayer_resize(target) {
        jwplayer(target).onReady(function () {
            $(this.container).css('min-height', minHeight);
         //  this.resize("inherit", "inherit");
        });
        $(jwplayer(target).container).css('min-height', minHeight);
       // jwplayer(target).resize("inherit", "inherit");
    }

    $(document).on('ready', function () {
        $("div").filter(function () {
            return this.id.match(/^jwplayer\-\d+$/);
        }).each(function () {
            vc_jwplayer_resize(this)
        });
    });
    $(window).on('vc_reload', function () {
        $("div").filter(function () {
            return this.id.match(/^jwplayer\-\d+$/);
        }).each(function () {
            vc_jwplayer_resize(this)
        });
    });

})(jQuery);