/* actions to preform when document has finished loading, using jQuery */
$(document).ready(function () {
    /* hide Javascript required message */
    $('#jsMsg').hide();
    /* enable submit button */
    $('#submitBtn').removeAttr('disabled');
    $('#submitBtn').removeClass('disabled');
    /* focus on username field */
    $("#username").focus();
    /* prevent Login form being submitted more than once */
    $("form").submit(function() {
        if (this.beenSubmitted) {
            return false;
        } else {
            this.beenSubmitted = true;
            return true;
        }
    });
});