jQuery(function ($) {

    $('.lsow-odometers').waypoint(function (direction) {

        $(this.element).find('.lsow-odometer .lsow-number').each(function () {

            var odometer = $(this);

            setTimeout(function () {
                var data_stop = odometer.attr('data-stop');
                $(odometer).text(data_stop);

            }, 100);


        });

    }, { offset: Waypoint.viewportHeight() - 100,
        triggerOnce: true});


});