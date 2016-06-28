jQuery(document).ready(function(){
		jQuery(".colorboxinline").colorbox({inline:true, onComplete:function(){
			jQuery.fn.colorbox.resize();
		}});
});