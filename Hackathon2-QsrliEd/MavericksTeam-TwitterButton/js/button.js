(function(){
    var TwitterButton = {
        BtnUrl: "http://test.com/button.php",
        defaultSettings: {
            pre_image: "",
            post_image: "",
            shortener: "default",
            image: "default_image",
            via: "",
            countCont: "twCountContainer"
        },
        tweetUrl: "",
        currentSettings: {},
        init: function(settings) {
            TwitterButton.currentSettings.domelement = settings.domelement != "" && settings.domelement != undefined ? settings.domelement : "";
            TwitterButton.currentSettings.image = settings.image != "" && settings.image != undefined ? settings.image : TwitterButton.defaultSettings.image;
            TwitterButton.currentSettings.title = settings.title != "" && settings.title != undefined ? settings.title : "";
            TwitterButton.currentSettings.url = settings.url != "" && settings.url != undefined ? settings.url : "";
            TwitterButton.currentSettings.shortener = settings.shortener != "" && settings.shortener != undefined ? settings.shortener : TwitterButton.defaultSettings.shortener;
            TwitterButton.currentSettings.pre_image = settings.pre_image != "" && settings.pre_image != undefined ? settings.pre_image : TwitterButton.defaultSettings.pre_image;
            TwitterButton.currentSettings.post_image = settings.post_image != "" && settings.post_image != undefined ? settings.post_image : TwitterButton.defaultSettings.post_image;
            TwitterButton.currentSettings.via = settings.via != "" && settings.via != undefined ? settings.via : TwitterButton.defaultSettings.via;
            TwitterButton.currentSettings.countCont = settings.countCont != "" && settings.countCont != undefined ? settings.countCont : TwitterButton.defaultSettings.countCont;
        },
        display: function(ret) {
            if(TwitterButton.currentSettings.title == "") {
                throw "No title specified";
                return;
            }
            if(TwitterButton.currentSettings.url == "") {
                throw "No title specified";
                return;
            }
            $.get('shortenUrl.php?url='+escape(TwitterButton.currentSettings.url)+'&shortener='+escape(TwitterButton.currentSettings.shortener), function(data) {
                TwitterButton.tweetUrl = TwitterButton.BtnUrl + "?url=" + escape(data) + "&title=" + escape(TwitterButton.currentSettings.title) + "&shortener=" + escape(TwitterButton.currentSettings.shortener) + "&via=" + escape(TwitterButton.currentSettings.via);
                var html = TwitterButton.currentSettings.pre_image + "<a id='tweetButton' href='javascript: void(0)' title='"+TwitterButton.currentSettings.title+"'><img src='"+TwitterButton.currentSettings.image+"' /></a>" + TwitterButton.currentSettings.post_image;
                
                document.getElementById(TwitterButton.currentSettings.domelement).innerHTML = html;
                twitter_tweet.updateTweetCount(data);

                addClickEvent();
            });
        }
    }
    if(!window.TwitterButton){
        window.TwitterButton = TwitterButton
        }
})();
jQuery.extend( {
    twitterButton: function(settings) {
        TwitterButton.init(settings);
        TwitterButton.display(true);
    }
});

function addClickEvent() {
    $('#tweetButton').click(function() {
        window.open (TwitterButton.tweetUrl, "tweetWindow","status=0,toolbar=0,width=450,height=350");
    });
}

function updateNumTweets(numTweets) {
    $(TwitterButton.currentSettings.countCont).html(numTweets);
}


var tweet_Place_Holder ;


twitter_tweet = function() { 
    jsnode = function (src) {
        var tag = document.createElement("script");
        tag.type = "text/javascript";
        tag.src = src;
        document.getElementsByTagName("HEAD")[0].appendChild(tag);
    };
	
    updateTweetCount = function (Url) {
        twitter_tweet.jsnode('http://urls.api.twitter.com/1/urls/count.json?url='+encodeURIComponent(Url)+'&callback=twitter_tweet.twCounters&rn=' + Math.random());
    };
	
    twCounters = function (result) {
        var tmp = document.getElementById(TwitterButton.currentSettings.countCont);
        if(tmp) {
            var NewValue = Math.floor(result.count);
            //assume it returns nothing!
            if(NewValue < 0 ){
                NewValue = 0;
            }
			
            tmp.innerHTML =  NewValue;
			
        }

    };
	
    add_event = function (elm, evType, fn, useCapture){
        if (elm.addEventListener){
            elm.addEventListener(evType, fn, useCapture);
            return true;
        }
        else if (elm.attachEvent) {
            var r = elm.attachEvent('on' + evType, fn);
            return r;
        }
        else {
            elm['on' + evType] = fn;
        }
    } ;
    return{
        jsnode:jsnode, 
        updateTweetCount:updateTweetCount , 
        twCounters:twCounters,
        add_event:add_event
    }
}();

//twitter_tweet.add_event(window,'load',twitter_tweet.updateTweetCount,false);