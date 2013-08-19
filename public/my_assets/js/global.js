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
	});


    makeCloseable();
});

function makeCloseable()
{
    $(".close").on("click", function(){
        $(this).parent().hide('slow');
    });
}


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