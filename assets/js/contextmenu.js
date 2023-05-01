(function ($, window) {
    $.fn.contextMenu = function (settings) {
        return this.each(function () {
            //console.log(this);
            // Open context menu
            $(this).on("contextmenu", function (e) {
                // return native menu if pressing control
                if (e.ctrlKey) return;

                $(settings.menuSelector)
                    .find('li').each(function (ix, el) {                         
                        if (settings.menuDisabled.includes($(el).find('a').attr('id')))                             
                            $(el).hide(); //$(el).prop('disabled', true)                        
                        else                          
                            $(el).show(); //$(el).prop('disabled', false);                        
                    })

                //open menu
                var $menu = $(settings.menuSelector)
                    .data("invokedOn", $(e.target))                    
                    .show()
                    .css({
                        position: "absolute",
                        left: getMenuPosition(e.clientX, 'width', 'scrollLeft'), 
                        top: getMenuPosition(e.clientY, 'height', 'scrollTop') 
                    })
                    .off('click')
                    .on('click', 'a', function (e) {
                        $menu.hide();

                        var $invokedOn = $menu.data("invokedOn");
                        var $selectedMenu = $(e.target);

                        settings.menuSelected.call(this, $invokedOn, $selectedMenu);
                    });

                return false;
            });

            //make sure menu closes on any click
            $('body').click(function () {
                $(settings.menuSelector).hide();
            });
        });

        function getMenuPosition(mouse, direction, scrollDir) {
            var win = $(window)[direction](),
                scroll = $(window)[scrollDir](),
                menu = $(settings.menuSelector)[direction](),
                position = mouse + scroll;

            // opening menu would pass the side of the page
            if (mouse + menu > win && menu < mouse)
                position -= menu;
            return position;
        }

    };
})(jQuery, window);