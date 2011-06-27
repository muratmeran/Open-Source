<?php
/**
 * Twitter Button Hackathon
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license available
 * http://en.wikipedia.org/wiki/BSD_licenses
 * @Author		Rakan Alhneiti, Abdelrahman Salem
 * @package    Twitter_Example
 * @copyright  Copyright (c) 2011 N2V. (http://www.n2v.com)
 * @license    http://en.wikipedia.org/wiki/BSD_licenses     new BSD license
 */
?>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/button.js"></script>

<script type="text/javascript">
    var settings = {
        domelement: "twBtn",
        image: "http://cache.twitdom.com/icon-twitter-tweet-button.jpg",
        title: "Rakan and Abed are participating in N2V Hackathon",
        url: "http://www.n2v.com",
        pre_image: "<div style='border:1px solid black'>",
        post_image: "</div>",
        shortener: "http://dev.qsr.li/api.php?token=5c917af867d5a0ba5f0a2bf2aa8792b6&action=shorturl&format=simple&url=",
        via: "@qsrli"
    }
    $(document).ready(function() {
        $.twitterButton(settings);
    });
</script>

<div id='twBtn'></div>
<div id='twCountContainer'></div>