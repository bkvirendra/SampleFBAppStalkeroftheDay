  <?php

    require 'facebook.php';

    $facebook = new Facebook(array(
    'appId'  => ' ', // Your APP ID
    'secret' => ' ' // Your App secret
    ));
	
	$user = $facebook->getUser();

	if ($user) {
           try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
	$user_id= $user;
      } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
     }
   }

  $loginUrl   = $facebook->getLoginUrl(
            array(
                'scope'         => 'publish_stream',
                'redirect_uri'  => 'http://apps.facebook.com/stalkersoftheday/'
            )
    );
	$logoutUrl  = $facebook->getLogoutUrl();

	if ($user) 
		{
      try {
        $user_profile = $facebook->api('/me');
      } catch (FacebookApiException $e) 
		  {
        d($e);  
        $user = null;
      }
	}
	?>

<head>
<title>Stalker for the Day </title>
<style type="text/css">
<!--
.style1 {
	font-family: "Freestyle Script";
	font-size: 36px;
}
.myButton {
	-moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
	-webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
	box-shadow:inset 0px 1px 0px 0px #ffffff;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ededed), color-stop(1, #dfdfdf) );
	background:-moz-linear-gradient( center top, #ededed 5%, #dfdfdf 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ededed', endColorstr='#dfdfdf');
	background-color:#ededed;
	-moz-border-radius:28px;
	-webkit-border-radius:28px;
	border-radius:28px;
	border:2px solid #dcdcdc;
	display:inline-block;
	color:#777777;
	font-family:arial;
	font-size:19px;
	font-weight:bold;
	padding:11px 36px;
	text-decoration:none;
	text-shadow:-2px 0px 0px #ffffff;
}.myButton:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #dfdfdf), color-stop(1, #ededed) );
	background:-moz-linear-gradient( center top, #dfdfdf 5%, #ededed 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#dfdfdf', endColorstr='#ededed');
	background-color:#dfdfdf;
}.myButton:active {
	position:relative;
	top:1px;
}
-->
</style>
</head>
<body>
<p align="center"><img src="http://teckzone.in/stalkeroftheday/coollogo.png"></p>
<p align="center" class="style2"><a href="http://www.facebook.com/TheVirendraRajput" target="_blank" class="style1">A Virendra Rajput Production</a></p>

    <?php if ($user) { ?>
    <?php } else { ?>
	  <strong> <p align="center" class="style1">Welcome ! Click below to Enter !</strong>
      <p align="center"><a href="<?=$loginUrl?>" class="myButton">Click here to View Your Stalker of the Day</a></p>
    <?php } ?>

  <?php if ($user) { ?>

  <?php
    $access_token = $facebook->getAccessToken();
    $friends = $facebook->api('/me/friends');
    $rand_key = array_rand($friends['data']);
    $random_friend = $friends['data'][$rand_key];

	$attachment = array(
                'name' => 'Your Stalker of the Day!',
                'caption' => "Findout your stalker of the Day?",
                'link' => 'http://apps.facebook.com/stalkersoftheday/',
                'description' => 'Hey guys I am checking out my Stalker of the Day, Come check out yours!',
                'picture' => 'http://teckzone.in/stalkeroftheday/stakler.JPG',
                );

    $result = $facebook->api('/me/feed/?access_token='.$access_token,
                                'post',
                                $attachment);

?>
  <div align="center" class="fb-like" data-href="http://www.facebook.com/pages/Virendra-Rajput/262342713821995" data-send="true" data-width="450" data-show-faces="false"></div>
  <div align="center">
    <p class="style1">
	<h2 class="style1">
      And....!  </h2>
	<p class="style1">..</p>
	<p class="style1">.</p>
	<p class="style1">OMGGG !! Finally we have found your stalker for the Day</p>
	<h2 class="style1"><?php echo $random_friend['name']; ?></h2>
</div>

    <br />
	<div align="center">
    <img src='https://graph.facebook.com/<?php echo $random_friend['id']; ?>/picture?type=large' /></div>

 <p align="center" class="style1"><a onclick='postToFeed(); return false;'><img src="share-button.JPG"></a></p>
	<p align="center">&nbsp;</p>
	<?php } ?>

 <p align="center"><span class="style1">Powered by <a href="http://teckzone.in/" class="style2">TeckZone</a></span></p>

 <div id="fb-root">
 <script src='http://connect.facebook.net/en_US/all.js'></script>
  <script> 
      FB.init({appId: "204767992941746", status: true, cookie: true});

      function postToFeed() {

        // calling the API ...
        var obj = {
        method: 'feed',
        name: 'Your Stalker of the Day!',
        link: 'http://apps.facebook.com/stalkersoftheday/',
        picture: 'http://teckzone.in/stalkeroftheday/stakler.JPG',
        caption: 'Findout your stalker of the Day?',
        description: 'Today\'s stalker of the Day for you is <?php echo $random_friend['name']; ?>.',
        to: '<?php echo $random_friend['id']; ?>'
        };

        function callback(response) {
          document.getElementById('msg').innerHTML = "Post ID: " + response['post_id'];
        }

        FB.ui(obj, callback);
      }
    
    </script>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=204767992941746";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
</body>
</html>