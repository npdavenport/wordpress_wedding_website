jQuery(document).ready(function ($)
{
    /**
     *  This script controls the scroll-to-top arrow functionality.
     *
     *  @package One Eleven Wedding Photography Customization
	 *  @subpackage includes/js
	 *  @since 1.0.0
     */

    /*
     * Determine whether or not to show the scroll-to-top arrow.
     */
    $(document).on('scroll', function ()
    {
        if ($(window).scrollTop() > 100)
        {
            $('.scroll-top-wrapper').addClass('show');
        } else
        {
            $('.scroll-top-wrapper').removeClass('show');
        }
    });

    /*
     *  Scroll to the top of the page when scroll-to-top
     *  arrow is clicked.
     */
    $('.scroll-top-wrapper').on('click', scrollToTop);

    function scrollToTop()
    {
        verticalOffset = typeof (verticalOffset) != 'undefined' ? verticalOffset : 0;
        element = $('body');
        offset = element.offset();
        offsetTop = offset.top - 100;
        $('html, body').animate({ scrollTop: offsetTop }, 500, 'linear');
    }

    /*
     *  Hide scroll-to-top arrow when Envira Gallery lightbox is opened.
     */
    $(document).on('DOMNodeInserted', function (e)
    {
        if ($(e.target).is('.envirabox-overlay'))
        {
            $('.scroll-top-wrapper.show').css({ visibility: "hidden" });
        }
    });

    /*
     *  Show scroll-to-top arrow when Envira Gallery lightbox is closed.
     */
    $(document).on('DOMNodeRemoved', function (e)
    {
        if ($(e.target).is('.envirabox-overlay'))
        {
            $('.scroll-top-wrapper.show').css({visibility: "visible"});
        }
    });

});