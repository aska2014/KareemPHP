// JavaScript Document


var timer_interval;
$(document).ready(function(){


	// Make content height
	if($("#content").height() < $("#right_panel").height())
		$("#content").height($("#right_panel").height());
				
    $(window).scroll(function() {
    	if($(window).scrollTop() > 1000)
    	{
    		if($("#scrollTop").css('opacity') == 0)
	    		$("#scrollTop").animate({opacity:1});
    	}
    	else
    	{
    		if($("#scrollTop").css('opacity') == 1)
	    		$("#scrollTop").animate({opacity:0});
    	}
    });

	//Track links
	trackLink();

	//Scroll
	makeAScroll();
	
	$(".year").find('.arrow_img').each(function(){
		$(this).click(function(){
			$(this).parent().find('ul').toggle('fast');
			
			if($(this).css('background-position') == "0px 50%")
			{
				$(this).css({'background-position':'-10px'});
			}
			else
			{
				$(this).css({'background-position':'0px'});
			}
		});
	});
	
	//timer_interval = setInterval('timer()',1000);

	$("#featured").hover(
		function(){
			$("#featured > .hide").show();
		},
		function(){
			$("#featured > .hide").hide();
		}
	);

	$("#search_txt").width(130);
	$("#search_txt").focus(function()
	{
		$(this).animate({
			width:230
		});
	});
	$("#search_txt").blur(function()
	{
		$(this).animate({
			width:130
		});
	})

	////////////// Comment form

	$("#commentForm").submit(function()
	{
		var name = $("#comment_name").val();
		var body = $("#comment_body").val();
		var email = $("#comment_email").val();

		if($("#comment_img").length > 0)
			var img_url = $("#comment_img").val();
		else
			var img_url = '';

		if($("#reply_id").length > 0)
			var reply_id = String($("#reply_id").val());
		else
			var reply_id = "";

		var stringReg = new RegExp(/^[a-zA-Z ]*$/i);
		var emailReg = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);

		if(body == '' || name == '')
		{
			$("#comment_error").html('Please make sure you entered your name and the comment body');
			return false;
		}

		if(name.length > 30 || (!emailReg.test(email) && email != ''))
		{
			$("#comment_error").html('Please make sure you entered a valid name and/or valid email address');
			return false;
		}


		$("#commentForm").fadeTo(200,'0.2');
		$("#commentForm > .sbmt").attr('disabled','disabled');
		$.ajax({
			cache:false,
			url:'',
			type: 'POST',
			data: {
				smsma:"addComment",
				comment_name:name,
				comment_email:email,
				comment_body:body,
				reply_id:reply_id,
				img_url:img_url
			},
			success:function(d)
			{
				if(d.indexOf('true') < 0)
				{
					$("#comment_error").html(d);
				}
				else
				{
					var img_tag = '<img src="' +  base_url + '/public/style/images/default_member.png" />';
					if(img_url != '')
						img_tag = '<img src="' + img_url + '" />';
					$("#comment_error").html('');
					$("#comments").append('<div style="display:none;" class="comment">' + img_tag + '<div class="comment_info"><div class="name"><span>' + name + '</span> says:</div><span class="datetime">' + sqlNow + '</span><div class="c_body">' + body + '</div></div><div class="clr"></div></div>');
					$(".comment").slideDown('fast');
					$("#comment_email").val('');
					$("#comment_body").val('');
				}
				$("#commentForm").fadeTo(500,'1');
				$("#commentForm > .sbmt").removeAttr('disabled');
			},
			error:function()
			{
				$("#comment_error").html('Something wrong with the AJAX request, please try again');
				$("#commentForm").fadeTo(500,'1');
			}
		});
		return false;
	});

	$(".comment").hover(
		function()
		{
			var reply_id = $(this).attr('id').replace('comment','');
			$(this).find('.grey').html('<a class="scroll" href="#addCommentTitle" onclick="replyComment(' + reply_id + ');">Reply</a>');
			makeAScroll();
		},
		function()
		{
			$(this).find('.grey').html('');
		}
	);
});


function timer()
{
	var seconds = $("#timer_sec").html();
	var minutes = $("#timer_min").html();
	var hours = $("#timer_hr").html();
	var days = $("#timer_d").html();
	
	if(seconds > 0)
	{
		if((seconds - 1) < 10)
			$("#timer_sec").html("0" + (seconds - 1));
		else
			$("#timer_sec").html(seconds - 1);
	}
	else
	{
		$("#timer_sec").html("59");
		if(minutes > 0)
		{
			if((minutes - 1) < 10)
				$("#timer_min").html("0" + (minutes - 1));
			else
				$("#timer_min").html(minutes - 1);
		}
		else // seconds < 1 && minutes < 1
		{
			$("#timer_min").html("59");
			if(hours > 0)
			{
				if((hours - 1) < 10)
					$("#timer_hr").html("0" + (hours - 1));
				else
					$("#timer_hr").html(hours - 1);
			}
			else
			{
				if(days > 0)
				{
					$("#timer_hr").html("23");
					$("#timer_d").html(days - 1);
				}
				else // TIME FINISHED 
				{
					$("#timer_min").html("00");
					$("#timer_sec").html("00");
					clearInterval(timer_interval);
	notification("A new tutorial has been added!","Go to <a href='http://www.justdevelopwebsites.com'>Home Page</a> to check out this new tutorial",false);
				}
			}
		}
	}
}

function hideFeatured(featuredID)
{
	$("#featured").hide('slow');
	$("#content > .sep").hide('slow');
	setCookie("featured",featuredID,30);
}

function setCookie(name, value, seconds, path, domain_name, secure)
{
	var expire_date = new Date();
	expire_date.setSeconds(expire_date.getSeconds() + seconds);

	var data = name + "=" + escape(value) + "; expires="
					+expire_date.toUTCString();

	if(path)data += ";path="+escape(path);
	if(domain_name)data += ";domain="+escape(domain_name);
	if(secure)data += ";secure";

	document.cookie = data;
}

function replyComment(commentID)
{
	var commentName = $("#comment" + commentID + " > .comment_info > .name > span").html();
	if($("#reply_row").length > 0)
	{
		$("#reply_row > span").html('Replay to ' + commentName);
		$("#reply_id").val(commentID);
	}
	else
	{
		$("#commentForm").prepend('<div class="c_row" id="reply_row"><span style="color:#666">Reply to ' + commentName + '</span></div>');
		$("#commentForm").append('<input type="hidden" name="reply_id" id="reply_id" value = "' + commentID + '" />');
	}
}


// Any <a> tag with class scroll will be scrolled to if #id
function makeAScroll()
{
	$('a.scroll').click(function(){
		var el = $(this).attr('href');
		var elWrapped = $(el);
		scrollToDiv(elWrapped,40);
		return false;
	});
}

function scrollToDiv(element,navheight){
	var offset = element.offset();
	var offsetTop = offset.top;
	var totalScroll = offsetTop-navheight;
	
	$('body,html').animate({
			scrollTop: totalScroll
	}, 500);
}
////////////////////////////////////////////////////////////

// Notification
function notification(title, desc, bottom)
{
	if(!($(".notification").length && $(".notification").is(':visible')))
	{
		$("body").prepend("<div class='notification'><div class='n_title'>" + title + "</div><div class='n_desc'>" + desc + "</div></div>");
		
		var temp_height = $(".notification").height();
		$(".notification").fadeIn()
			.css({bottom:-200,position:'fixed'})
			.animate({bottom:0}, 800, function() {
			    //callback
		});
		removeSlow($(".notification"),7000);

	}
	
}

function removeSlow(element, time)
{
	setTimeout(function(){element.remove();},time + 1000);
	$(".notification").delay(time).animate({height:0});
}
///////////////////////////////////////////

// Tracking links , called from document ready
function trackLink()
{
	$("a").click(function()
	{
		setCookie('link_ref_id',$(this).attr('id'),10, '/');
	});
}
//////////////////////////////////////////////