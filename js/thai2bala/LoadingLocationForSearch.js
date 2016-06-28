
$(document).ready(function () {
    $("select").selecter();
    StoreListSlide();
   
    $("#selectProvince").change(function () {
        $(".location_item").hide();

        if ($(this).val() == 0) {
            $(".location_item").show();

            var district = $('#selectDistrict');
            district.val(0);
            district.parent().find('span.selecter-selected').html(district.find('option:selected').text());
            district.find("option").each(function (index, value) {
                if (index > 0) {
                    $(value).toggleOption(false);
                }
            });
            district.parent().find('span.selecter-item').hide();
        }
        else {
            var province = $(this).val();
            var district = $('#selectDistrict');

            district.val(0);
            district.parent().find('span.selecter-selected').html(district.find('option:selected').text());
            district.find("option").each(function (index, value) {
                if (index > 0) {
                    $(value).toggleOption(true);
                }
            });
            district.parent().find('span.selecter-item').show();

            district.find("option").each(function (index, value) {
                if (index > 0) {
                    var opt = $(this);
                    if (opt.attr('data-province-id') != province) {
                        opt.toggleOption(false);
                        district.parent().find('[data-value="' + opt.attr('value') + '"]').hide();
                    }
                }
            });

            //$.each($("#selectDistrict option"), function (index, value) {
            //    if ($(this).attr('data-province-id') == province) {
            //        $(this).show();
            //        $("#selectDistrict").val(0)
            //    }
            //    else { $(this).hide(); }
            //})            
        }

        loadlocation($("#selectProvince option:selected").val(), "province")
       // StoreListSlide();
    })
    $("#selectDistrict").change(function () {
		//var selected = $("#selectDistrict option:selected").val();
		//if (selected == undefined) {
		//	selected = $("#selectDistrict").parent().find('.selecter-options .selected').attr('data-value');
		//}
		var selected = $("#selectDistrict").parent().find('.selecter-options .selected').attr('data-value');
		if (selected != 0) {
        	loadlocation(selected, "district")
		}
		else {
			loadlocation($("#selectProvince option:selected").val(), "province")
		}
        //StoreListSlide();
    })

  
    $(".location_item").click(function () {
        var offsetx = $(this).attr("offsetx");
        var offsety = $(this).attr("offsety");
        var zoom = $(this).attr("zoom");
        var imagelink = $(this).attr("imagelink");
        $("#map").html("");
        $("#bigimage").html("");
        loadimage(imagelink);
        $("#bigmap").show();
        init(offsetx, offsety, this, parseInt(zoom));
        checkshowhide();
    });
    $(".tabs").click(function () {
        if ($('div').hasClass('active')) {
            $('.active').removeClass('active');
            $($(this).attr('rel')).hide();
        }
        $(this).addClass('active');
        checkshowhide();
    });
    //beginloader();
   
})
$(window).load(function () { beginloader()});
function beginloader() {
    var topimage = $("#top-image").attr("urlimage");
    loadimage(topimage);


    $("#bigmap").show();
    var offsetx = $("#offset").attr("offsetx");
    var offsety = $("#offset").attr("offsety");
    var zoom = $("#offset").attr("zoom");
    // đối tượng map được khởi tạo ở trên
    init(offsetx, offsety, "#top-info", parseInt(zoom));
    $("#bigimage").addClass("beginload");

    var province = $('#selectProvince');
    province.val(0);
    province.parent().find('span.selecter-selected').html(province.find('option:selected').text());

    var district = $('#selectDistrict');
    district.val(0);
    district.parent().find('span.selecter-selected').html(district.find('option:selected').text());
    district.find("option").each(function (index, value) {
        if (index > 0) {
            $(value).toggleOption(false);
        }
    });
    district.parent().find('span.selecter-item').hide();
}
function StoreListSlide() {
    $('#va-accordion').removeAttr('style');
    $('#va-accordion .va-slice').each(function(index,value){
        var slide = $(this);
        slide.removeAttr('style');
        slide.removeData('position');
        slide.removeData('expanded');
    });

    $('#va-accordion').vaccordion({
        accordionW: 404,
        accordionH: 518,
        itemHeight: 130,
        expandedHeight: 110,
        animSpeed: 500,
        animEasing: 'easeInOutBack',
        animOpacity: 0.4
    });
};
function loadlocation(locationname, type) {
  	console.log(locationname);
    var fDiv = null;
    $("#bigmap").hide();
    $("#bigimage").hide();
    $("#store-list").find("." + type).each(function (index, value) {
        var divItem = $(this).parents('.location_item');
        var liItem = divItem.parent();

        divItem.hide();
        liItem.addClass('hidden');     
		
        if ($(this).attr('data-' + type + '-id') == locationname || locationname == 0) {

                divItem.show();
                liItem.removeClass('hidden'); 
     
                if (fDiv == null) {
                    fDiv = this;
                }
            }
    })
    StoreListSlide();
    $(fDiv).parents(".location_item").click();
}
function init(offsetx, offsety, info, zoom) {
    var myLatlng = new google.maps.LatLng(parseFloat(offsetx), parseFloat(offsety));
    var myOptions = {
        zoom: zoom,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
    }
    var map = new google.maps.Map(document.getElementById("map"), myOptions);
    var $map = $('#map');

    var marker = new google.maps.Marker({
        position: myLatlng,//vị trí này sẽ xuất hiện điểm đánh dấu với icon mặc định của google.
        icon: $map.attr('data-icon'),
        title: ""
    });
    marker.setMap(map);
    loadinformation(info);
}
function loadimage(imagelink) {
    $("#bigimage").append("<img src='" + imagelink + "'/>");

}
function checkshowhide() {
    $("#bigimage").removeClass("beginload");
    if ($("#image-tabs").hasClass("active")) {
        $("#bigimage").show();
        $("#bigmap").hide();
    }
    else {
        $("#bigimage").hide();
        $("#bigmap").show();

    }   
}
function loadinformation(info) {
    $("#store-description").html($(info).html());
    var storePhone = $(info).attr('data-storePhone');
    var storeEmail = $(info).attr('data-storeEmail');
    var storePhoneLabel = $(info).attr('data-storePhoneLabel');
    var storeEmailLabel = $(info).attr('data-storeEmailLabel');
    if (storePhone != "") {
        var html = "<p id='phone'><strong>" + storePhoneLabel + ": </strong><span>" + storePhone + "</span></p>";
    }
    if (storeEmail != "" ) {
        html += "<p><strong>" + storeEmailLabel + ": </strong><span>" + storeEmail + "</span></p>";
    }
    if(isBigOrder==true) {
        $("#store-description").css("color", "white");
        $("#store-description").css("font-size", "16px");
        $("#store-description").find(".title").css("color", "white");
    }
    $("#store-description").append(html);
    $("#store-description").find('.sl-phone').hide();
}

$.fn.toggleOption = function (show) {
    $(this).toggle(show);
    if (show) {
        if ($(this).parent('span.toggleOption').length)
            $(this).unwrap();
    } else {
        if ($(this).parent('span.toggleOption').length == 0)
            $(this).wrap('<span class="toggleOption" style="display: none;" />');
    }
};