<?php
include_once 'coreSettings.php';
include_once BASE_PATH.'/main/user-class.php';
include_once BASE_PATH.'/main/main-class.php';

$main = new main();
$user = new sh_user();
$logined = $user->_authenticate() ;

if(!isset($_GET['catId']) || $_GET['catId'] == '' ){

$publicIcons = $main->getAllIcons();

}else{

$publicIcons = $main->getAllIconsWithCatId($_GET['catId']);

}

$launchPadIcons = $main->getAllLaunchPadIcons();

$categorys = $main->getAllCategory();
?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-38357012-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<?php
//$width = "<script>document.write(screen.width); </script>";
//$height = " <script>document.write(screen.height); </script>";
//echo "width = ".$width;
//echo "height = ".$height;
//$num = (int)$width * 1;

//$maxUsableWidth =  (int)$width * .3;


//echo "maxUsableWidth = ".$num;
?>

<html>
<head>
   <meta name="msvalidate.01" content="9A206043B845A02EA713B08ACB978F11" />
   <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
	<meta content="smart home, bookmark, top websits, easy, launcher, leopard, favourite, page, url, websites, top classifieds, top search engines,top mail services, top shopping sites,top news sites " name="keywords">
	<meta content="Welcome to smart home." name="description">
	<meta content="no-cache" http-equiv="cache-control">
	<title>oneihome</title>
	<link type="image/x-icon" href="images/oneIhome.ico" rel="shortcut icon">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link href="css/popUpStyles.css" rel="stylesheet" type="text/css">
	<script src="scripts/jquery.min.js"></script>
	<!-- <script type="text/javascript" src = "scripts/jquery-1.4.min.js"></script> -->
	<script type="text/javascript" src = "scripts/jquery.easing-1.3.js"></script>
	
	<!-- iosSlider plugin -->
	<script src = "scripts/jquery.iosslider.js"></script>
	
	<!-- pop up window plugin -->
	<script src="scripts/jquery.reveal.js"></script>
	
	<!-- pop up drop sort and drag plugin -->
	<script src="scripts/jquery.sortable.js"></script>
	
	<!-- tinyscrollbar plugin (vertical scroller) -->
	<script src="scripts/jquery.tinyscrollbar.min.js"></script>
	<script type="text/javascript" language="javascript" src="scripts/main.js"></script>
</head>
<body>
	<div class="sh_main">
		<div class="sh_clear"></div>
		<div class="sh_content">
			<div class="sh_leftMenu">
				<!-- <a title="Set as home" href="javascript:setHomepage();" class="sh_setAsHome" ></a> -->
				<!-- <a title="Set as home" href="javascript:setHomepage();" class="sh_setAsHome" ></a> -->
				<h1 class="sh_Logo"><a href="index.php">oneIhome</a></h1>
				<div class="sh_left_top_menu">
					<!--<ul>
						<li><a>profile</a></li>
						<li><a>settings</a></li>
						<li><a>addNew</a></li>
					</ul>-->
				</div>
				<div id="scrollbar1">
    <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
    <div class="viewport">
        <div class="overview">
					<ul class="catagoryList">
					<?php
				
						echo "<li><a href=\"index.php\" title=\"All\" >All</a></li>";
					
						if(is_array($categorys)){
							foreach ( $categorys as $category )
								echo "<li><a href=\"index.php?catId=".$category[0]."\" title=\"".$category[1]."\" >".$category[1]."</a></li>";
						}
					?>
					</ul>
				</div>
				</div>
    </div>
				
				<!--
				<div id="scrollbar1">
		
</div>   -->
				
				
				
				
			</div>
			<div class="sh_header">
				<ul style="display:none;">
					<?php if( $logined ){ ?>
						<li><a href="javascript:void(0);" title="login" style="display:none;"id="sh_login">Login</a></li>
						<li><a href="javascript:void(0);" onclick="logout();" title="logout" style="display:block;" id="sh_logout">Logout</a></li>
					<?php } else {?>
				
					<li><a href="javascript:void(0);" title="login" id="sh_login">Login</a></li>
					<li><a href="javascript:void(0);" onclick="logout();" title="logout" style="display:none;" id="sh_logout">Logout</a></li>
					<?php } ?>
				</ul>
			</div>
			<div class="sh_canvas">
				<div class="sh_iosSlider">
					<div class="sh_slider">
						<?php
							if(is_array($publicIcons)){
								
								echo "<ul class='sh_item' >";
								$i=0;
								
								foreach ( $publicIcons as $one_row )
								{
									$i++;
									echo "<li>";
									echo "<a target='blank' href=\"".$one_row[3]."\" title=\"".$one_row[1]."\" class=\"tileIcon\" style=\"background: url('".$one_row[13]."') no-repeat scroll center top transparent;\"><span></span><div class=\"sh_iconDesc\">".$one_row[1]."</div></a>";
									echo "</li>";
									if(($i%28) == 0)
										echo "</ul><ul class='sh_item' >";
								}
								echo "</ul>";
							}
						?>
					</div>
				</div>
				<div class='sh_iosSliderButtons'>
					<?php 
						
						$totalIcons = count($publicIcons);
						$noOfPages = ceil($totalIcons/28);
						
						if($noOfPages > 1 )
							for($i = 0; $i < $noOfPages;$i++)
								if($i==0)
									echo "<div class='sh_button'></div>";
								else
									echo "<div class='sh_button'></div>";
						
					?>
				</div>
			</div>
			<div class="sh_Ads">
			<script type="text/javascript">
sa_client = "b2814b4df9d81309fba7e490b61ede18";
sa_code = "b3420e3e6e5e3575af919800fef99cde";
sa_protocol = ("https:"==document.location.protocol)?"https":"http";
sa_pline = "0";
sa_maxads = "4";
sa_bgcolor = "FEFEFE";
sa_bordercolor = "1A1F02";
sa_superbordercolor = "070801";
sa_linkcolor = "45464C";
sa_desccolor = "000000";
sa_urlcolor = "191B02";
sa_b = "0";
sa_format = "column_160x600";
sa_width = "160";
sa_height = "600";
sa_location = "0";
sa_radius = "0";
sa_borderwidth = "1";
sa_font = "0";
document.write(unescape("%3cscript type='text/javascript' src='"+sa_protocol+"://sa.entireweb.com/sense.js'%3e%3c/script%3e"));
</script>



		</div>
		<div class="sh_special">
		 <a href="http://www.oneihome.org/sslc"><img src="banner.gif"></a> 
		</div>
		
		
		<div class="sh_clear"></div>
		<div class="sh_bottomBodeOuter">
			<div class="sh_bottomBodeleft">
				<div class="sh_bottomBoderight">
					<div class="sh_bottomBodemiddle">
						<ul class="connected" >
							<!-- <li><a id="sh_basket" href="javascript:void(0);" title="Recyclebin" ></a></li> -->
							<?php
							foreach ( $launchPadIcons as $launchPadIcon ){
								echo "<li>";
									echo "<a target='blank' href=\"".$launchPadIcon[1]."\" title=\"".$launchPadIcon[0]."\" style=\"background: url('".$launchPadIcon[6]."') no-repeat scroll top center transparent;\">";
										echo "<span></span>";
										echo "<div class=\"sh_launchIconDesc\">".$launchPadIcon[0]."</div>";
								echo "</a>";
								echo "</li>";
							}
							?>
						</ul>
						<div class="sh_clear"></div>
						<div class="sh_footer">
							&#64; © Copyright 2013 grAphene electronics., All Rights Reserved.
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="sh_clear"></div>
	</div>
	<div id="sh_addNew_modal">
		<div id="heading"> Add new icon </div>
		<div id="content">
			
		</div>
	</div>
	<div id="sh_save_modal">
		<div id="heading"> Save </div>
		<div id="content">
			
		</div>
	</div>
	<div id="sh_login_modal">
		<div id="heading"> Login </div>
		<div id="content" style="height:170px;">
			<div id="sh_validationInfo"></div>
			<div class="sh_inputRow" >Email<input type="text" id="sh_email_input"/></div>
			<div class="sh_inputRow" >Password<input type="password" id="sh_password_input"/></div>
			<a href="#" class="sh_register button green close">New User</a>
			<a onclick="login();" class="button green">Login</a>
		</div>
	</div>
	<div id="sh_register_modal">
		<div id="heading"> Registration  </div>
		<div id="content" style="height:255px;">
			<div id="sh_reg_validationInfo"></div>
			<div class="sh_inputRow" >Username<input type="text" id = "sh_reg_username_input"/></div>
			<div class="sh_inputRow" >Email<input type="text" id = "sh_reg_email_input"/></div>
			<div class="sh_inputRow" >Password<input type="password" id = "sh_reg_password_input"/></div>
			<div class="sh_inputRow" >Re-password<input type="password" id = "sh_reg_repassword_input"/></div>
			<a href="#" class="button green close">No, thanks</a>
			<a onclick="registration();" class="button green" >Submit</a>
		</div>
	</div>
</body>
</html>