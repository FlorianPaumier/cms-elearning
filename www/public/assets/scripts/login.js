var working = false;
$('.state').on('click', function(e) {
    console.log("Helllop");
    e.preventDefault();
    if (working) return;
    working = true;
    var $this = $("form"),
        $state = $this.find('button.state');
    $this.addClass('loading');
    $state.html('Authenticating');
    setTimeout(function() {
        $this.addClass('ok');
        $state.html('Welcome back!');
        setTimeout(function() {
            $state.html('Log in');
            $this.removeClass('ok loading');
            working = false;
        }, 4000);
    }, 3000);
});