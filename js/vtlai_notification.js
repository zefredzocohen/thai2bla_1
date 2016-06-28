/*======================================================================*\
|| #################################################################### ||
|| # vt.Lai VBB Notification 1.0                                      # ||
|| # ---------------------------------------------------------------- # ||
|| # Copyright ©2010-2013 Vu Thanh Lai. All Rights Reserved.          # ||
|| # Please do not remove this comment lines.                         # ||
|| # -------------------- LAST MODIFY INFORMATION ------------------- # ||
|| # Last Modify: 27-03-2013 05:10:00 AM by: Vu Thanh Lai             # ||
|| #################################################################### ||
\*======================================================================*/
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*\
|*-------Please specify source when using my code or a part of them-----*|
\*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

jQuery(document).ready(function(){
	var notificationElemOk=1;
	var markAllLoading=0
	if(jQuery('#hunght_warning_debt').length==0)
	{
		console.log('Không tìm thấy nút bấm notification: #hunght_warning_debt');
		notificationElemOk=0;
	}
	if(jQuery('#hunght_warning_debt_box').length==0)
	{
		console.log('Không tìm thấy khung notification: #hunght_warning_debt_box');
		notificationElemOk=0;
	}
	if(jQuery('#hunght_warning_debt_markall').length==0)
	{
		console.log('Không tìm thấy nút đánh dấu đã đọc hết notification: #hunght_warning_debt_markall');
	}
	if(notificationElemOk)
	{
		jQuery('#hunght_warning_debt_box').css({'left':jQuery('#hunght_warning_debt').position().left-jQuery('#hunght_warning_debt_box').width()/2})
	}
	
	jQuery('#hunght_warning_debt').click(function(){
		if(jQuery('#hunght_warning_debt_box').css('display')!='none')
		{
			jQuery('#hunght_warning_debt_box').slideUp('fast',function(){
				jQuery('#hunght_warning_debt_loading').fadeOut('fast');
			});
		}
		else
		{
			if(N_ENDLIST)
			{
				jQuery('#hunght_warning_debt_box').slideDown('fast');
				return false;
			}
			if(N_BEGINLIST==0)
				jQuery('#hunght_warning_debt_list').html('');
			jQuery('#hunght_warning_debt_box').slideDown('fast',function(){
				jQuery('#hunght_warning_debt_loading').fadeIn('fast',function(){
					jQuery.ajax({
						url: 'hunght_warning_debt.ajax.php',
						type: 'POST',
						dataType: 'JSON',
						data: 'do=loadNotification&securitytoken='+SECURITYTOKEN+'&begin='+N_BEGINLIST
					}).done(function(data){
						if(data.status==1)
						{
							jQuery('#hunght_warning_debt_loading').fadeOut('fast',function(){
								if(N_BEGINLIST==0)
									jQuery('#hunght_warning_debt_list').html(data.html);
								else
									jQuery('#hunght_warning_debt_list').append(data.html);
								N_BEGINLIST=data.nextBegin;
								N_ENDLIST=data.end;
							});
						}
						else
						{
							alert('Lỗi:\n-'+data.errors.join('\n- '));
						}
					}).fail(function(jqXHR, textStatus, errorThrown){
						switch(textStatus)
						{
							case 'timeout':
								alert('Không nhận được trả lời từ máy chủ. Vui lòng thử lại.');
								break;
							case 'parsererror':
								alert('Dữ liệu máy chủ trả về bị lỗi. Vui lòng thử lại.');
								break;
							case 'error':
								if(errorThrown!=0)
									alert('Lỗi máy chủ: '+errorThrown+'. Vui lòng thử lại.');
								break;
							default:
								alert('Xảy ra lỗi, vui lòng thử lại.');
						}
					}).always(function(){
						jQuery('#hunght_warning_debt_loading').fadeOut('fast');
					});
				});
			});
		}
		return false;
	});
	
	jQuery('#hunght_warning_debt_markall').click(function(){
		if(markAllLoading)
		{
			return false;
		}
		jQuery('#hunght_warning_debt_markall').html('Đang xử lý ...');
		jQuery.ajax({
			url: 'hunght_warning_debt.ajax.php',
			type: 'POST',
			dataType: 'JSON',
			data: 'do=markReadAll&securitytoken='+SECURITYTOKEN
		}).done(function(data){
			if(data.status==1)
			{
				jQuery('#vtlai_notifynumber').html('0');
				jQuery('.notificationbit.unread').removeClass('unread');
			}
			else
			{
				alert('Lỗi:\n-'+data.errors.join('\n- '));
			}
		}).fail(function(jqXHR, textStatus, errorThrown){
			switch(textStatus)
			{
				case 'timeout':
					alert('Không nhận được trả lời từ máy chủ. Vui lòng thử lại.');
					break;
				case 'parsererror':
					alert('Dữ liệu máy chủ trả về bị lỗi. Vui lòng thử lại.');
					break;
				case 'error':
					if(errorThrown!=0)
						alert('Lỗi máy chủ: '+errorThrown+'. Vui lòng thử lại.');
					break;
				default:
					alert('Xảy ra lỗi, vui lòng thử lại.');
			}
		}).always(function(){
			jQuery('#hunght_warning_debt_markall').html('Đánh dấu đã đọc tất cả');
		});
		return false;
	});
	
	jQuery('#hunght_warning_debt_box,#hunght_warning_debt_box .notificationbit a').click(function(){
		return true;
	});
	jQuery(document).click(function(){
		if(jQuery('#hunght_warning_debt_box').css('display')!='none')
		{
			jQuery('#hunght_warning_debt_box').fadeOut('fast');
		}
	});
});