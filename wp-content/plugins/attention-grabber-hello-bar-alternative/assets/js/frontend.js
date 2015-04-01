jQuery(document).ready(function($) {
    function identify(email, plan, track) {
        var t = parseInt(new Date().getTime(), 10);
        _cio.identify({
            id: email,
            email:email,
            created_at:t,
            name:"none",
            plan:plan,
            version: t % 2
        });

        if( track ) {
            _gaq.push(['_trackEvent', 'emailSignup', plan, 'Sign up for the ' + plan + ' email campaign']);
        }
    }

    function emailIsGood(email) {
        return email.indexOf('@') != -1 && email.indexOf('.', email.indexOf('@')) != -1;
    }

    function handleFormSubmit( ev, type ) {
        var emailEl = $("#ag-email");
        var email = emailEl.val();
        if( emailIsGood(email) ) {
            identify(email, type, true);
            $("#ag-container").hide("blind", {}, 500);
            $("#ag-thanks-container").show("blind", {}, 500);
            setTimeout(function() {
                hideBar($("#ag-go-away"));
            },5000);
        } else {
            if( $("#ag-error").text() == '' ) {
                $("#ag-additional").after('<span id="ag-error" style="display:none;">Sorry, that doesn\'t look like an email address...</span>');
                $("#ag-additional").hide("blind", {direction: "left"}, 100);
                $("#ag-error").show("blind", {direction: "right"}, 100);
            }
        }
        ev.preventDefault();
        return false;
    }

    function toggleVisibility(time) {
        if(typeof(time) !== "number") {
            time = 1000;
        }

        var arrowEl = $("#ag-go-away");

        visible = !visible;

        $.cookie('show_attention_grabber', visible, { expires: 30, path: '/' });
        outer.toggleClass('ag-slid-up', time);
        arrowEl.toggleClass("arrow-up");
        arrowEl.toggleClass("arrow-down");
    }


    var outer = $("#attention-grabber");
    var form = outer.find("form");

    var visible = $.cookie('show_attention_grabber');
    if( typeof(visible) === "undefined" ) {
        visible = true;
    } else if( visible === "false" ) {
        visible = false;
    }

    outer.prependTo("body");
    outer.toggleClass("hidden");

    $("#ag-email-form").submit(function(ev){
        handleFormSubmit(ev, 'general');
    });

    $("#ag-go-away").click(toggleVisibility);

    $("a#ag-submit").click(function() {
        toggleVisibility();
        _gaq.push(['_trackEvent', 'buttonClick', 'Click', 'Clicked the Attention Grabber button with text ' + $(this).text()]);
    });

    if( !visible ) {
        visible = true;
        toggleVisibility(0);
    }
});
