//-- Code by: Vu Thanh Lai - SinhVienIT.net
//-- Vui lÚng ko s?a ch˙ thÌch khi d˘ng l?i code

//===========More Button ==============//
jQuery(document).ready(function(){
	jQuery('a.more').click(function(){
		jQuery('.dropmore').css('left',Math.floor(jQuery('a.more').position().left+jQuery('a.more').width()-jQuery('.dropmore').width()));
		jQuery('.dropmore').slideToggle(100);
	});

	jQuery('.dropmore').hover(function(){
		//No thing
	},
	function(){
		jQuery('.dropmore').slideUp(100);
	});
});

//===========Spoiler ==============//
jQuery(document).ready(function(){
	jQuery('.spoilerbtn').click(function(){

		var obj=jQuery(this).parent().parent().find('.spoiler-body')[0];
		
		jQuery(obj).slideToggle('fast',function(){
			var btnobj=jQuery(this).parent().find('.spoilerbtn')[0];
			var titleobj=jQuery(this).parent().find('.title')[0];
			
			if(jQuery(this).css('display')=='none')
			{
				jQuery(titleobj).html('N?i dung d„ du?c thu g?n, B?m n˙t "Hi?n ra" d? xem h?t n?i dung');
				jQuery(btnobj).html('Hi?n ra');
			}
			else
			{
				jQuery(titleobj).html('B?m n˙t "Thu g?n" d? thu g?n n?i dung');
				jQuery(btnobj).html('Thu g?n');
			}
		});
	});
});
 
//===========Change Language ==============//
jQuery(document).ready(function(){
	var curLang=(document.cookie.indexOf('svit_languageid=3')==-1)?'vn':'en';
	if(curLang=='en')
	{
		jQuery('.footerlink .langbtn').html('Ti?ng Vi?t');
		jQuery('.footerlink .langbtn').attr('title','Chuy?n sang Ti?ng Vi?t');
	}
	jQuery('.footerlink .langbtn').click(function(){
		
		var newLang='langid=3';
		if(curLang=='en')
			newLang='langid=2';
		//--
		var curUrl=window.location.href;
		var postfix='',prefix='';
		if(curUrl.indexOf('#')!=-1)
		{
			var arr=curUrl.split('#');
			postfix='#'+arr[1];
			prefix=arr[0];
		}
		else
		{
			prefix=curUrl;
		}
		if(curUrl.indexOf('langid=')!=-1)
		{
			var reg=/langid\=\d+/i;
			prefix=prefix.replace(reg,newLang);
		}
		else
		{
			if(curUrl.indexOf('?')!=-1)
			{
				prefix+=newLang;
			}
			else
			{
				prefix+='?'+newLang;
			}
		}
		window.location.replace(prefix+postfix);
	});
});
//===========Update Timestamp ==============//
function updateTimestamp()
{
	var curDate=Math.floor((new Date()).getTime()/1000);
	jQuery('.timestamp').each(function(){
		var timestamp=jQuery(this).attr('timestamp');
		if(timestamp.length==10)
		{
			timestamp=parseInt(timestamp);
			var diff=curDate-timestamp;
			var t='';
			if(diff>0)
			{
				if(diff>=84600)
				{
					t=Math.floor(diff/84600)+' ng‡y tru?c.';
				}
				else if(diff>=3600)
				{
					t=Math.floor(diff/3600)+' gi? tru?c.';
				}
				else if(diff>=60)
				{
					t=Math.floor(diff/60)+' ph˙t tru?c.';
				}
				else
				{
					t=Math.floor(diff/60)+' gi‚y tru?c.';
				}
				jQuery(this).html(t);
			}
		}
	});
	setTimeout('updateTimestamp()',1000);
}

jQuery(document).ready(function(){
	updateTimestamp();
});



//===========Edit Search Input Bg ==============//
function changeInputBG()
{
	if(jQuery('#gsc-i-id1').length>0)
	{	
		jQuery('#gsc-i-id1').css('background-image','none');
		jQuery('#gsc-i-id1').blur(function(){
			if(jQuery('#gsc-i-id1').css('background-image')!='none')
			{
				jQuery('#gsc-i-id1').css('background-image','none');
			}
		});
	}
	else
	{
		setTimeout('changeInputBG()',100);
	}
}
jQuery(document).ready(function(){
	changeInputBG();
});

//===========Edit Href Permanet link # ==============//
jQuery(document).ready(function(){
	if(THIS_SCRIPT!=undefined && THIS_SCRIPT=='showthread')
	{
		var vtlaiUrlSplit=window.location.href.split('#');
		jQuery('a[name^=post]').each(function(){
			jQuery(this).attr('href',vtlaiUrlSplit[0]+'#'+jQuery(this).attr('name'));
			jQuery(this).click(function(){
				jQuery('html, body').animate({
							 scrollTop: jQuery('#'+jQuery(this).attr('name').replace('post','post_')).offset().top-50
				}, 1000);
				if(window.history.pushState!=undefined)
				{
					window.history.pushState(null,null, jQuery(this).attr('href'));
					return false;
				}
				return true;
			});
		});
	}
});
//===========Scroll If # ==============//
jQuery(document).ready(function(){
	jQuery(window).load(function(){
		if(window.location.href.indexOf('#')!=-1)
		{
			var vtlaiSplit=window.location.href.split('#');
			if(vtlaiSplit.length>1)
			{
				if(vtlaiSplit[1].indexOf('post')==0)
					vtlaiSplit[1]=vtlaiSplit[1].replace('post','post_');
				if(jQuery('#'+vtlaiSplit[1]).length>0)
				{
					var diff=jQuery('#'+vtlaiSplit[1]).offset().top-jQuery('body').scrollTop();
					if(diff<200 && diff>-200)
					{
						jQuery('html, body').animate({
								 scrollTop: jQuery('#'+vtlaiSplit[1]).offset().top-50
						}, 1000);
					}
				}
			}
		}
	});
});

//===========Auto Tag ==============//
jQuery(document).ready(function(){
	if(THIS_SCRIPT!=undefined && THIS_SCRIPT=='newthread')
	{
		var commonWords=['the','name','of','very','to','through','and','just','a','form','in','much','is','great','it','think','you','say','that','help','he','low','was','line','for','before','on','turn','are','cause','with','same','as','mean','I','differ','his','move','they','right','be','boy','at','old','one','too','have','does','this','tell','from','sentence','or','set','had','three','by','want','hot','air','but','well','some','also','what','play','there','small','we','end','can','put','out','home','other','read','were','hand','all','port','your','large','when','spell','up','add','use','even','word','land','how','here','said','must','an','big','each','high','she','such','which','follow','do','act','their','why','time','ask','if','men','will','change','way','went','about','light','many','kind','then','off','them','need','would','house','write','picture','like','try','so','us','these','again','her','animal','long','point','make','mother','thing','world','see','near','him','build','two','self','has','earth','look','father','more','head','day','stand','could','own','go','page','come','should','did','country','my','found','sound','answer','no','school','most','grow','number','study','who','still','over','learn','know','plant','water','cover','than','food','call','sun','first','four','people','thought','may','let','down','keep','side','eye','been','never','now','last','find','door','any','between','new','city','work','tree','part','cross','take','since','get','hard','place','start','made','might','live','story','where','saw','after','far','back','sea','little','draw','only','left','round','late','man','run','year','came','while','show','press','every','close','good','night','me','real','give','life','our','few','under','stop','open','ten','seem','simple','together','several','next','vowel','white','toward','children','war','begin','lay','got','against','walk','pattern','example','slow','ease','center','paper','love','often','person','always','money','music','serve','those','appear','both','road','mark','map','book','science','letter','rule','until','govern','mile','pull','river','cold','car','notice','feet','voice','care','fall','second','power','group','town','carry','fine','took','certain','rain','fly','eat','unit','room','lead','friend','cry','began','dark','idea','machine','fish','note','mountain','wait','north','plan','once','figure','base','star','hear','box','horse','noun','cut','field','sure','rest','watch','correct','color','able','face','pound','wood','done','main','beauty','enough','drive','plain','stood','girl','contain','usual','front','young','teach','ready','week','above','final','ever','gave','red','green','list','oh','though','quick','feel','develop','talk','sleep','bird','warm','soon','free','body','minute','dog','strong','family','special','direct','mind','pose','behind','leave','clear','song','tail','measure','produce','state','fact','product','street','black','inch','short','lot','numeral','nothing','class','course','wind','stay','question','wheel','happen','full','complete','force','ship','blue','area','object','half','decide','rock','surface','order','deep','fire','moon','south','island','problem','foot','piece','yet','told','busy','knew','test','pass','record','farm','boat','top','common','whole','gold','king','possible','size','plane','heard','age','best','dry','hour','wonder','better','laugh','true .','thousand','during','ago','hundred','ran','am','check','remember','game','step','shape','early','yes','hold','hot','west','miss','ground','brought','interest','heat','reach','snow','fast','bed','five','bring','sing','sit','listen','perhaps','six','fill','table','east','travel','weight','less','language','morning','among'];
		jQuery('.vbform').submit(function(){
			if(jQuery.trim(jQuery('#tagpopup_ctrl').val())=='')
			{
				var sj=jQuery('#subject').val();
				//--Chu?n hÛa title
				var reg=/[^a-zA-Z\s????????????????????·‡?„?‚a¡¿?√?¬A??????????ÈË???Í…»??? ÌÏ?i?ÕÃ?I?????????‘???????????ÛÚ?ı?Ùo”“?’?‘O??????????˙˘?u?u⁄Ÿ?U?U˝????›????d–]/i;
				while(reg.test(sj)){
					sj=sj.replace(reg,' ');
				}
				while(sj.indexOf('  ')!=-1){
					sj=sj.replace('  ',' ');
				}
				//--L?y 10 tag d?u
				var arr=sj.split(' ',10);
				//--Tag qu· d‡i ho?c ng?n thÏ b?
				for(var i=0;i<arr.length;i++)
				{
					if(arr[i].length<3 || arr[i].length>20)
					{
						arr[i]='';
					}
					if(arr[i]=='')
						continue;
					for(var x=0;x<commonWords.length;x++)
					{
						if(arr[i].toLowerCase()==commonWords[x])
						{
							arr[i]='';
							break;
						}
					}
				}
				//--Tag l‡ t? thÙng d?ng thÏ b?
				
				//--
				var tags=arr.join(',');
				while(tags.indexOf(',,')!=-1)
				{
					tags=tags.replace(',,',',');
				}
				jQuery('#tagpopup_ctrl').val(tags);
			}
		});
	}
});
//===========remove link in subject ==============//
jQuery(document).ready(function(){
	if(THIS_SCRIPT!=undefined && THIS_SCRIPT=='newthread')
	{
		jQuery('.vbform').submit(function(){
			if(jQuery.trim(jQuery('#subject').val())!='')
			{
				var sj=jQuery('#subject').val();
				while(sj.indexOf('http://')!=-1)
				{
					sj=sj.replace('http://','');
				}
				jQuery('#subject').val(sj);
			}
		});
	}
});
//===========Remove Border Of Small Image ==============//
jQuery(document).ready(function(){
	jQuery('.postcontent img').each(function(){
		if(jQuery(this).width()<200)
		{
			jQuery(this).css('border-width','0px');
		}
	});
});
//===========Add Google Search ==============//
jQuery(document).ready(function(){
	 (function() {
		var cx = '009233608606446996455:gxkfopg7xg4';
		var gcse = document.createElement('script'); gcse.type = 'text/javascript'; gcse.async = true;
		gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
			'//www.google.com.vn/cse/cse.js?cx=' + cx;
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(gcse, s);
	  })();
});

//===========Delete All Old Cookie ==============//
jQuery(document).ready(function(){
/*
	var cookies = document.cookie.split(";");
	for (var i = 0; i < cookies.length; i++) {
		var cookie = cookies[i];
		var eqPos = cookie.indexOf("=");
		var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
		if(name.indexOf('bb')==0 || name.indexOf('svit__')==0)
		{
			try{
				document.cookie = name + "=;domain=."+location.host+";expires=Thu, 01 Jan 1970 00:00:00 GMT" + ";path=/";
				document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT" + ";path=/";
			}catch(err)
			{
				document.cookie = name + "=;domain=;expires=Thu, 01 Jan 1970 00:00:00 GMT" + ";path=/";
			}
		}
	}
*/
});