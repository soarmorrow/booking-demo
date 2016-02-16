$(function() {
    // Start materialzing
    $.material.init();


    var $myCarousel = $('#carousel-example-generic');

// Initialize carousel
    $myCarousel.carousel({
        interval: 4000
    });

    function doAnimations(elems) {
        var animEndEv = 'webkitAnimationEnd animationend';

        elems.each(function() {
            var $this = $(this),
                    $animationType = $this.data('animation');

            // Add animate.css classes to
            // the elements to be animated
            // Remove animate.css classes
            // once the animation event has ended
            $this.addClass($animationType).one(animEndEv, function() {
                $this.removeClass($animationType);
            });
        });
    }

// Select the elements to be animated
// in the first slide on page load
    var $firstAnimatingElems = $myCarousel.find('.item:first')
            .find('[data-animation ^= "animated"]');

// Apply the animation using our function
    doAnimations($firstAnimatingElems);

// Pause the carousel
    $myCarousel.carousel('pause');

// Attach our doAnimations() function to the
// carousel's slide.bs.carousel event
    $myCarousel.on('slide.bs.carousel', function(e) {
        // Select the elements to be animated inside the active slide
        var $animatingElems = $(e.relatedTarget)
                .find("[data-animation ^= 'animated']");
        doAnimations($animatingElems);
    });

// prevent dropdown menu being closed from clicking inside
    $('ul.dropdown-menu li').on('click', function(event) {
        event.stopPropagation();
    });
//    $('body').on('click', function(e) {
//        if (!$('li.dropdown').is(e.target)
//                && $('li.dropdown').has(e.target).length === 0
//                && $('.open').has(e.target).length === 0
//                ) {
//            $('li.dropdown').removeClass('open');
//        }
//    });

// Initialize Selectize
    $(".centre-language, .centre").selectize({
        sortField: 'text'
    });

    // time picker
    var fourDaysForward = new moment().add(4, 'day');
    $(".end-date").bootstrapMaterialDatePicker({weekStart: 0,time:false, format : 'DD/MM/YYYY',currentDate: fourDaysForward.format('DD/MM/YYYY')});
    $(".start-date").bootstrapMaterialDatePicker({weekStart: 0,time:false,format : 'DD/MM/YYYY',currentDate: moment()}).on('change', function(e, date)
    {
        $(".end-date").bootstrapMaterialDatePicker('setMinDate', date);
    });
    
//    Initilaize Tooltip
  $('[data-toggle="tooltip"]').tooltip();
});