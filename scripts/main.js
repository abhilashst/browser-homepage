function setHomepage() {
	//Condition to set home page in IE
	if (document.all) {
		document.body.style.behavior = 'url(#default#homepage)';
		document.body.setHomePage('http://localhost/home/');
	}
	//Condition to set home page in Mozilla
	else if (window.sidebar) {
		if (window.netscape) {
			try {
				netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
			}
			catch (e) {
				alert("this action was aviod by your browser,if you want to enable,please enter about:config in your address line,and change the value of signed.applets.codebase_principal_support to true");
			}
		}
		var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
		prefs.setCharPref('browser.startup.homepage', 'http://localhost/home/');
	}
}

function getAllIconsWithCatId(catId){

	var dataString 	= 'catId='+catId;
	var path  		= "ajax/loadIcons.php";
	
	$('.sh_slider').html("<img src='images/delay.gif'/>");
	
	$.ajax({
		type: "POST",
		url: path,
		data: dataString,
		success: function(str){
			$('.sh_slider').html(str);
		}
	});	
}

function registration(){
	
	var userName 	= document.getElementById('sh_reg_username_input').value;
	var email 		= document.getElementById('sh_reg_email_input').value;
	var password 	= document.getElementById('sh_reg_password_input').value;
	var repassword 	= document.getElementById('sh_reg_repassword_input').value;
	var dataString 	= 'username='+userName+'&email='+email+'&password='+password+'&repassword='+repassword;
	var path  		= "ajax/register.php";
		
	$('#sh_reg_validationInfo').html("<img src='images/delay.gif'/>");
	
	$.ajax({
		type: "POST",
		url: path,
		data: dataString,
		success: function(str){
		
			if( str == "sucess" ){
				$('#sh_reg_validationInfo').html("");
				document.getElementById('sh_login_modal').style.visibility	= 'hidden';
				$(".reveal-modal-bg").css("display","none");
				$("#sh_login").css("display","none");
				$("#sh_logout").css("display","block");
				return true;
			}
			else{
				
				$('#sh_reg_validationInfo').html(str);
				
			}
			return false;
		}
	});	
}

function login(){
	
	var userName = document.getElementById('sh_email_input').value;
	var password = document.getElementById('sh_password_input').value;
	var dataString = 'password='+password+'&username='+userName;
	var path  = "ajax/login.php";
		
	$('#sh_validationInfo').html("<img src='images/delay.gif'/>");
	
	$.ajax({
		type: "POST",
		url: path,
		data: dataString,
		success: function(str){
			if( str == "sucess" ){
				$('#sh_validationInfo').html("");
				document.getElementById('sh_login_modal').style.visibility	= 'hidden';
				$(".reveal-modal-bg").css("display","none");
				$("#sh_login").css("display","none");
				$("#sh_logout").css("display","block");
				return true;
			}
			else{
				$('#sh_validationInfo').html(str);
			}
			return false;
		}
	});	
}
function logout(){
	var path  = "ajax/logout.php";
	$.ajax({
		type: "POST",
		url: path,
		data: "",
		success: function(str){
			if( str == "logout" ){
				$("#sh_logout").css("display","none");
				$("#sh_login").css("display","block");
				return true;
			}
			return false;
		}
	});	
}
$(document).ready(function() {
	
	$('.sh_leftMenu').tinyscrollbar();
	
	$('.catagoryList').sortable();
	
	$('.connected').sortable({
		connectWith: '.sh_item'
	});
	$('.sh_item').sortable({
		connectWith: '.connected'
	});
	
	$('.sh_iosSlider').iosSlider({
		scrollbar: true,
		snapToChildren: true,
		desktopClickDrag: true,
		scrollbarLocation: 'bottom',
		scrollbarMargin: '10px 10px 0 10px',
		scrollbarBorderRadius: '0',
		responsiveSlideWidth: true,
		navSlideSelector: $('.sh_iosSliderButtons .sh_button'),
		infiniteSlider: false,
		startAtSlide: '1',
		onSlideChange: slideContentChange,
		onSlideComplete: slideContentComplete,
		onSliderLoaded: slideContentLoaded
	});
	
	function slideContentChange(args) {
		
		/* indicator */
		$(args.sliderObject).parent().find('.sh_iosSliderButtons .sh_button').removeClass('.sh_selected');
		$(args.sliderObject).parent().find('.sh_iosSliderButtons .sh_button:eq(' + (args.currentSlideNumber - 1) + ')').addClass('.sh_selected');
		//alert(args.currentSlideNumber);
	}
	
	function slideContentComplete(args) {
		/* animation */
		$(args.sliderObject).find('.sh_text1, .sh_text2').attr('style', '');
			
		$(args.currentSlideObject).children('.sh_text1').animate({
			right: '100px',
			opacity: '1'
		}, 400, 'easeOutQuint');
			
		$(args.currentSlideObject).children('.sh_text2').delay(200).animate({
			right: '50px',
			opacity: '1'
		}, 400, 'easeOutQuint');
		
	}
		
	function slideContentLoaded(args) {
		
		/* animation */
		$(args.sliderObject).find('.sh_text1, .sh_text2').attr('style', '');
			
		$(args.currentSlideObject).children('.sh_text1').animate({
			right: '100px',
			opacity: '1'
		}, 400, 'easeOutQuint');
			
		$(args.currentSlideObject).children('.sh_text2').delay(200).animate({
			right: '50px',
			opacity: '1'
		}, 400, 'easeOutQuint');
			//alert(args.currentSlideNumber);
		/* indicator */
		$(args.sliderObject).parent().find('.sh_iosSliderButtons .sh_button').removeClass('sh_selected');
		$(args.sliderObject).parent().find('.sh_iosSliderButtons .sh_button:eq(' + (args.currentSlideNumber - 1) + ')').addClass('sh_selected');
		
	}
	
	$('#sh_addNew').click(function(e) { // Button which will activate our modal
		$('#sh_addNew_modal').reveal({ // The item which will be opened with reveal
			animation: 'fade',                   // fade, fadeAndPop, none
			animationspeed: 60,                       // how fast animtions are
			closeonbackgroundclick: true,              // if you click background will modal close?
			dismissmodalclass: 'close'    // the class of a button or element that will close an open modal
		});
		return false;
	});
	
	$('#sh_login').click(function(e) { // Button which will activate our modal
		$('#sh_login_modal').reveal({ // The item which will be opened with reveal
			animation: 'fade',                   // fade, fadeAndPop, none
			animationspeed: 60,                       // how fast animtions are
			closeonbackgroundclick: true,              // if you click background will modal close?
			dismissmodalclass: 'close'    // the class of a button or element that will close an open modal
		});
		return false;
	});
	$('.sh_register').click(function(e) { // Button which will activate our modal
		$('#sh_register_modal').reveal({ // The item which will be opened with reveal
			animation: 'fade',                   // fade, fadeAndPop, none
			animationspeed: 60,                       // how fast animtions are
			closeonbackgroundclick: true,              // if you click background will modal close?
			dismissmodalclass: 'close'    // the class of a button or element that will close an open modal
		});
		return false;
	});
	
	$('#sh_save').click(function(e) { // Button which will activate our modal
		$('#sh_save_modal').reveal({ // The item which will be opened with reveal
			animation: 'fade',                   // fade, fadeAndPop, none
			animationspeed: 60,                       // how fast animtions are
			closeonbackgroundclick: true,              // if you click background will modal close?
			dismissmodalclass: 'close'    // the class of a button or element that will close an open modal
		});
		return false;
	});
	
});