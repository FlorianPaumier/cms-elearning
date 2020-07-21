@extend(templates/front)

@section(body)
<div class="row">

<div id="stream-container"></div>
<iframe frameborder="0"
        scrolling="no"
        id="chat_embed"
        src="https://www.twitch.tv/embed/<?= $stream ?>/chat?parent=<?= $host ?>"
        height="720"
        width="350">
</iframe>
</div>
@endsection

@section(javascript)
<script src= "https://player.twitch.tv/js/embed/v1.js"></script>

<script type="text/javascript">
    var options = {
            width: 1280,
        height: 720,
        channel: "<?= $stream ?>",
        // only needed if your site is also embedded on embed.example.com and othersite.example.com
        parent: ["<?= $host ?>"]
    };
    var player = new Twitch.Player("stream-container", options);
    player.setVolume(0.5);
</script>
@endsection