jQuery(document).ready(function ($)
{
    /**
    *  This script controls sliding of answers for FAQ page.
    *
    *  @package One Eleven Wedding Photography Customization
    *  @subpackage includes/js
    *  @since 1.0.0
    */

    // Hide answers on page load.
    $(".faq-list_body.answer").toggle();

    // Toggle sibling answer on question click
    $(".question").click(function ()
    {
        if ($(this).next().is(":hidden"))
        {
            $(this).next().slideDown("slow");
        }
        else
        {
            $(this).next().slideUp("slow");
        }
    })
});