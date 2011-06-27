/*
 * TwittonButton Built Over the "customRetweet" jQuery Plugin.
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * 2011 | Twitton Button Team:
 * - Monir Abu Hilal ( @MonirAbuHilal )
 * - Omar Muwahed ( @i_omar )
 * - Mohamed Salem ( @mwsalem )
 * - Mohamed Saleh ( @MohKanaan )
 =========================
 * Copyright (C) 2010 Joel Sutherland
 * Licenced under the MIT license
 * http://www.gethifi.com/blog/a-jquery-plugin-for-custom-css-styled-retweet-buttons
 *
 * Available tags for templates:
 * General: count, title, url, account, shortURL, allTweetsURL
 * Topsy: all(count), influential, contains, topsy_trackback_url (http://code.google.com/p/otterapi/wiki/Resources?tm=6#/stats)
 * Bit.ly: url, hash, global_hash, long_url, new_hash (http://code.google.com/p/bitly-api/wiki/ApiDocumentation#/v3/shorten)
 */
 
(function ($) {
    $.fn.twittonButton = function (settings, callback) {
        settings = $.extend({
            // topsy settings
            topsyAPI: 'http://otter.topsy.com/stats.js?url=',
			
            // Link Shortining settings
            useqsrli: true,
            shorten: true,
			
            bitlyLogin: 'customRetweet', // bit.ly Login Username
            bitlyKey: 'R_be029e1ffd35d52dd502e1495752f0c2', // bit.ly Key
            bitlyAPI: 'http://api.bit.ly/v3/shorten?format=json&', // bit.ly API Path
			
            qsrliToken: "afa31459af243cb34f7df1ba4dc38230", // Qsr.li Token
            qsrliAPI: "http://dev.qsr.li/api.php?action=shorturl&format=jsonp&", // Qsr.li API Path
			
            // template values
            url: location.href, // Default Tweet URL
            title: document.title, // Default Tweet title
            useHindiNumbers: false, // Boolean to enable Hindi Numbers
            account: 'mwsalem', // Twitter Account to be retweeted from.
			
            // templates
			retweetTemplate: '{{title}} | {{shortURL}} | via @{{account}}', //retweetTemplate: 'RT @{{account}} | {{title}} | {{shortURL}}'
            template: 'Number of Tweets: {{count}} | <a href="{{allTweetsURL}}">All Tweets</a> | <a href="{{retweetURL}}">Retweet</a>'
        }, settings);

        // Returns replaced string
        function template(tmpl, data) {
            var template = tmpl;
            for (var key in data) {
                var rgx = new RegExp('{{' + key + '}}', 'g');
                if (key.toLowerCase() == "count" && (settings.useHindiNumbers == true)) {
                    template = template.replace(rgx, convertToHindi(data[key]));
                } else {
                    template = template.replace(rgx, data[key]);
                }

            }
            return template;
        }
        function convertToHindi(input) {
            input = input + "";

            // alert( input.split("") );
            var origNumbers = input.split("");
            var result = "";
            for (var i = 0; i < origNumbers.length; i++) {
				var newChar = origNumbers[i];
				var charCode = parseInt( newChar.charCodeAt(0) );
				// http://ar.wikipedia.org/wiki/%D8%A3%D8%B1%D9%82%D8%A7%D9%85_%D8%B9%D8%B1%D8%A8%D9%8A%D8%A9
				// Check if it's a Number between 0 and 9
				if( charCode >= 48 && charCode <= 57 ){
					// Hindi Nymbers Starts from AsciiCode: 1632
					newChar = String.fromCharCode( 1632 + parseInt( origNumbers[i] ) );
				}
                result += newChar;
            }
            return result;
        }
		
        // Returns (flattish) object of template vars
        function buildData(twitter, shortener) {
            var tmplvars = {};

            // Twitter Vars
            if (twitter !== undefined) {
                tmplvars.count = twitter.all;
                tmplvars.allTweetsURL = twitter.topsy_trackback_url;
            }
            else {
                tmplvars.count = '?';
                tmplvars.allTweetsURL = '#';
            }
            if (settings.useqsrli) {

                if (shortener.url !== undefined) { tmplvars.shortURL = 'http://qsr.li/' + shortener.url.keyword; }
                else { tmplvars.shortURL = settings.url }
            }
            else {
                // Shortener Vars
                if (shortener.url !== undefined) { tmplvars.shortURL = 'http://bit.ly/' + shortener.global_hash; }
                else { tmplvars.shortURL = settings.url }
            }
            tmplvars = $.extend(twitter, shortener, settings, tmplvars);
            tmplvars.retweetURL = 'http://localhost:8223/?t=' + escape(template(settings.retweetTemplate, tmplvars));
            tmplvars.retweetURL = "javascript:twittonPopup('" + tmplvars.retweetURL + "');";

            return tmplvars;
        }

        // Build the button and handle data being empty
        function buildButton($container, data) {
            $container.append(template(settings.template, buildData(data.twitter, data.shortener)));
        }

        // Assemble URLs
        var topsyURL = settings.topsyAPI + settings.url;
        var bitlyURL = settings.bitlyAPI + 'login=' + settings.bitlyLogin + '&apiKey=' + settings.bitlyKey + '&uri=' + settings.url;
        var qsrliURL = settings.qsrliAPI + 'token=' + settings.qsrliToken + '&url=' + encodeURIComponent( settings.url );


        function qsrliRequest(twitter, $container) {

            $.ajax({
                url: qsrliURL,
                dataType: 'jsonp',
                success: function (results) {
                    debugger;
                    buildButton($container, { twitter: twitter, shortener: results });
                },
                error: function () {
                    buildButton($container, { twitter: twitter });
                }
            });
        }

        function bitlyRequest(twitter, $container) {
            $.ajax({
                url: bitlyURL,
                dataType: 'jsonp',
                success: function (results) {
                    buildButton($container, { twitter: twitter, shortener: results.data });
                },
                error: function () {
                    buildButton($container, { twitter: twitter });
                }
            });
        }
        return $(this).each(function () {
            var callRequest;
            if (settings.useqsrli) { callRequest = qsrliRequest; } else { callRequest = bitlyRequest; }
            var $container = $(this);
            // Topsy request
            $.ajax({
                url: topsyURL,
                dataType: 'jsonp',
                success: function (results) {
                    if (results.response.errors)
                        callRequest(undefined, $container);
                    else
                        callRequest(results.response, $container);
                },
                error: function () {
                    callRequest(undefined, $container);
                }
            });
        });
    }
})(jQuery);

function twittonPopup(inputURL){
    mywindow = window.open(inputURL, "mywindow", "location=0,status=1,scrollbars=1,width=800,height=400");
}
