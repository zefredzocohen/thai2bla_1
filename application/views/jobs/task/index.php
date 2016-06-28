<?php $this->load->view("partial/header");?>
<script src="<?php echo base_url(); ?>task/codebase/dhtmlxgantt.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>task/codebase/ext/dhtmlxgantt_quick_info.js" type="text/javascript" charset="utf-8"></script>
<!--<script src="../../codebase/ext/dhtmlxgantt_tooltip.js" type="text/javascript" charset="utf-8"></script>-->
<link rel="stylesheet" href="<?php echo base_url(); ?>task/codebase/dhtmlxgantt.css" type="text/css" media="screen" title="no title" charset="utf-8">
<!--<link rel="stylesheet" href="<?php echo base_url(); ?>task/codebase/skins/dhtmlxgantt_broadway.css" type="text/css" media="screen" title="no title" charset="utf-8">-->
<div class="filters_wrapper" id="filters_wrapper">
	<ul id="tab_show" style="float: left;  margin-bottom: 10px;  margin-left:50px;">
		<div style="display:none">
			<li class="active"><a href="<?php echo base_url() ?>jobs">Quản lý dự án</a></li>
			<li><a href="<?php echo base_url() ?>jobs_employee">Quản lý công việc</a></li>
		</div>
		<li><a href="<?php echo base_url() ?>jobs_report"  target="_blank">Quản lý báo cáo</a></li>
		<li><a href="<?php echo base_url() ?>file"  target="_blank">Quản lý tài liệu</a></li>      
	</ul>
</div>
<div id="gantt_here" style="width:100%;height:100%;clear:both;"></div>
<?php
	//$this->load->model('Employee');
	//$session_user=$this->Employee->get_id_users();
   /*  print $session_user; */
?>
<script type="text/javascript">
					
gantt.config.grid_width = 580;
gantt.config.add_column = true;
gantt.ignore_time = function(date) {
var monthStart = gantt.date.month_start(new Date(date));
        var monthEnd = gantt.date.add(monthStart, 1, 'month');
        if (!gantt.getTaskByTime(monthStart, monthEnd).length) {
return true;
}
return false;
};
gantt.config.fit_tasks = true;
dhtmlx.message("Hãy bắt đầu tạo dự án - công việc mới!");
gantt.config.work_time = true;
gantt.config.correct_work_time = true;
gantt.config.scale_unit = "day";
gantt.config.date_scale = "%D ngày %d";
gantt.config.min_column_width = 60;
gantt.config.duration_unit = "day";
gantt.config.scale_height = 20 * 3;
gantt.config.row_height = 30;
var weekScaleTemplate = function(date) {
var dateToStr = gantt.date.date_to_str("%d %M");
        var weekNum = gantt.date.date_to_str("(Tuần %W)");
        var endDate = gantt.date.add(gantt.date.add(date, 1, "week"), - 1, "day");
        return dateToStr(date) + " - " + dateToStr(endDate) + " " + weekNum(date);
};
gantt.config.subscales = [
{unit: "month", step: 1, date: "%F %Y"},
{unit: "week", step: 1, template: weekScaleTemplate}
];
                    //không thể giao việc vào ngày nghỉ week_end
//                    gantt.templates.task_cell_class = function(task, date) {
//                    if (!gantt.isWorkTime(date))
//                            return "week_end";
//                            return "";
//                    };
//                    
//            gantt.config.columns = [
//                {name: "text", label: "Task name", tree: true, width: '*'},
//                {name: "progress", label: "Progress", width: 80, align: "center",
//                    template: function(item) {
//                        if (item.progress >= 1)
//                            return "Complete";
//                        if (item.progress == 0)
//                            return "Not started";
//                        return item.progress * 100 + "%";
//                    }
//                },
//                {name: "assigned", label: "Assigned to", align: "center", width: 100,
//                    template: function(item) {
//                        if (!item.user)
//                            return "Nobody";
//                        return item.user.join(", ");
//                    }
//                }
//            ];
                    gantt.config.lightbox.sections = [
<?php if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                        {name: "description", height: 30, map_to: "text", type: "textarea", focus: true},
                        {name: "report", height: 82, map_to: "report", type: "textarea", focus: true},
                        {name: "user", height: 22, map_to: "user", type: "select", options: gantt.serverList("persons", [])},
                        {name: "customer", height: 22, map_to: "customer", type: "select", options: gantt.serverList("customer", [])},
<? } else { ?>
                        {name: "description", height: 82, map_to: "text", disabled:"disabled", type: "textarea", focus: true},
                        {name: "user", height: 22, map_to: "user", type: "select", set_charset:"utf8", disabled:"disabled", options: gantt.serverList("person", [])},
                        {name: "customer", height: 22, map_to: "customer", disabled:"disabled", type: "select", options: gantt.serverList("customer", [])},
<?php } ?>
                    {name: "progress", height: 22, map_to: "progress", type: "select", options: [
                    {key: "0", label: "Chưa bắt đầu"},
                    {key: "0.1", label: "10%"},
                    {key: "0.2", label: "20%"},
                    {key: "0.3", label: "30%"},
                    {key: "0.4", label: "40%"},
                    {key: "0.5", label: "50%"},
                    {key: "0.6", label: "60%"},
                    {key: "0.7", label: "70%"},
                    {key: "0.8", label: "80%"},
                    {key: "0.9", label: "90%"},
                    {key: "1", label: "Hoàn thành"}
                    ]},
<?php if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                        {name: "parent", type: "parent", allow_root: "true", root_label: "Không thuộc dự án - công việc nào", filter: function(id, task) {
                        //			if(task.$level > 1){
                        //				return false;
                        //			}else{
                        //				return true;
                        //			}
                        return true;
                        }},
                        {name: "template", height: 16, type: "template", map_to: "my_template"},
                        {name: "time", height: 72, type: "time", map_to: "auto", time_format: ["%d", "%m", "%Y", "%H:%i"]},
<? } else { ?>
                        {name: "parent", type: "parent", allow_root: "true", root_label: "Không thuộc dự án - công việc nào", filter: function(id, task) {
                        //			if(task.$level > 1){
                        //				return false;
                        //			}else{
                        //				return true;
                        //			}
                        return true;
                        }},
                        {name: "template", height: 16, type: "template", map_to: "my_template", disabled:"disabled"},
                        {name: "time", height: 72, type: "time", map_to: "auto", time_format: ["%d", "%m", "%Y", "%H:%i"], disabled:"disabled"},
<?php } ?>
                    ];
                    gantt.locale.labels["section_progress"] = "Tiến trình ";
                    gantt.locale.labels["section_user"] = "Giao việc cho nhân viên";
                    gantt.locale.labels["section_customer"] = "Khách hàng";
                    gantt.locale.labels.section_template = "Chi tiết";
                    gantt.locale.labels["complete_button"] = "Hoàn thành";
                    gantt.locale.labels["section_parent"] = "Thuộc dự án công việc";
                    gantt.templates.task_class = function(start, end, task) {
                    if (task.progress == 1)
                            return "completed_task";
                            return "";
                    };
                    gantt.attachEvent("onLightboxButton", function(button_id, node, e) {
                    if (button_id == "complete_button") {
                    var id = gantt.getState().lightbox;
                            gantt.getTask(id).progress = 1;
                            gantt.updateTask(id)
                            gantt.hideLightbox();
                    }
                    });
                    gantt.config.buttons_left = ["dhx_save_btn", "dhx_cancel_btn", "complete_button"];
                    gantt.attachEvent("onBeforeLightbox", function(id) {
                    var task = gantt.getTask(id);
                            var holder2 = gantt.getLabel("user", task.user);
                            task.my_template = "<span id='title1'>Người thực hiện: </span>" + holder2 + "<span id='title2'>Tiến độ: </span>" + task.progress * 100 + " %";
                            return true;
                    });
                    gantt.attachEvent("onLightboxSave", function(id, item) {
                    if (!item.text) {
                    dhtmlx.message({type: "error", text: "Nhập mã cho dự án - công việc!"});
                            return false;
                    }
                    if (!item.user) {
                    dhtmlx.message({type: "error", text: "Chọn nhân viên thực hiện!"});
                            return false;
                    }
                    return true;
                    });
                    gantt.config.xml_date = "%Y-%m-%d %H:%i:%s";
                    gantt.init("gantt_here");
                    gantt.load("<?php echo base_url(); ?>task/common/connector.php");
                    var dp = new dataProcessor("<?php echo base_url(); ?>task/common/connector.php");
                    dp.init(gantt);
//            gantt.templates.task_row_class = function(start_date, end_date, item) {
//                if (item.progress == 0)
//                    return "red";
//                if (item.progress > 0)
//                    return "green";
//            };
                    gantt.config.add_column = false;
                    gantt.config.columns = [
                    {name: "text", label: "Tên công việc", tree: true, width: '130px'},
                    {name: "start_date", label: "Ngày bắt đầu", align: "center", tree: false, width: '80px'},
                    {name: "duration", label: "Thời hạn", align: "center", tree: false, width: '80px'},
                    {name: "progress", label: "Tiến độ", width: 80, align: "center",
                            template: function(item) {
                            if (item.progress >= 1)
                                    return "Hoàn thành";
                                    if (item.progress == 0)
                                    return "Chưa bắt đầu";
                                    return item.progress * 100 + "%";
                            }
                    },
//                {name: "assigned", label: "Người thực hiện", align: "center", width: 120,
//                    template: function(item) {
//                        if (!item.users)
//                            return "Nobody";
//                        return item.users.join(", ");
//                    }
//                },
<?php if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                        {name: "add", width: '44px'}
<?php } ?>
                    ];
                    gantt.templates.link_class = function(link) {
                    var types = gantt.config.links;
                            switch (link.type) {
                    case types.finish_to_start:
                            return "finish_to_start";
                            break;
                            case types.start_to_start:
                            return "start_to_start";
                            break;
                            case types.finish_to_finish:
                            return "finish_to_finish";
                            break;
                    }
                    };
                    gantt.templates.rightside_text = function(start, end, task) {
                    var holder2 = gantt.getLabel("user", task.user);
                            return "Người thực hiện: " + holder2;
                    };
                    gantt.templates.leftside_text = function(start, end, task) {
                    return task.duration + " days";
                    };
                    gantt.attachEvent("onAfterTaskDrag", function(id, mode){
                    var task = gantt.getTask(id);
                            if (mode == gantt.config.drag_mode.progress){
                    var pr = Math.floor(task.progress * 100 * 10) / 10;
                            dhtmlx.message(task.text + " bây giờ là " + pr + "% hoàn thành!");
                    } else{
                    var convert = gantt.date.date_to_str("%H:%i, %F %j");
                            var s = convert(task.start_date);
                            var e = convert(task.end_date);
                            dhtmlx.message(task.text + " bắt đầu vào " + s + " và kết thúc vào " + e);
                    }
                    });
                    gantt.attachEvent("onBeforeTaskChanged", function(id, mode, old_event){
                    var task = gantt.getTask(id);
                            if (mode == gantt.config.drag_mode.progress){
                    if (task.progress < old_event.progress){
                    dhtmlx.message(task.text + " tiến độ công việc không thể được hoàn tác!");
                            return false;
                    }
                    }
                    return true;
                    });
                    gantt.attachEvent("onBeforeTaskDrag", function(id, mode){
                    var task = gantt.getTask(id);
                            var message = task.text + " ";
                            if (mode == gantt.config.drag_mode.progress){
                    message += "tiến độ đã được cập nhật";
                    } else{
                    message += "is being ";
                            if (mode == gantt.config.drag_mode.move)
                            message += "moved";
                            else if (mode == gantt.config.drag_mode.resize)
                            message += "resized";
                    }

                    dhtmlx.message(message);
                            return true;
                    });
//                    gantt.parse(users_data);
        </script>
		<script type="text/javascript">
                    function previousPage(){
                    window.history.back();
                            }
        </script>
<?php $this->load->view("partial/footer"); ?>

<style type="text/css">

/*        .gantt_task_progress{
			text-align:left;
			padding-left:10px;
			box-sizing: border-box;
			color:white;
			font-weight: bold;
		}*/

.complete_button{
	margin-top: 1px;
	background-image:url("<?php echo base_url(); ?>task/common/v_complete.png");
	width: 20px;
}
.dhx_btn_set.complete_button_set{
	background: #46AD51;
	color: #fff;
	border: 1px solid #46AD51;
}
.completed_task{
	border:1px solid #46AD51;
}
.completed_task .gantt_task_progress{
	background: #46AD51;
}

.dhtmlx-completed{
	border-color: #669e60;
}
.dhtmlx-completed div {
	background: #248A9F;
}
html, body{
	width: 100%;
	height: 100%;
	margin: 0;
}
#title1{
	padding-left:35px;
	color:black;
	font-weight:bold;
}
#title2{
	padding-left:15px;
	color:black;
	font-weight:bold;
}
.red .gantt_cell, .odd.red .gantt_cell,
.red .gantt_task_cell, .odd.red .gantt_task_cell{
	background-color: #FDE0E0;
}
.green .gantt_cell, .odd.green .gantt_cell,
.green .gantt_task_cell, .odd.green .gantt_task_cell {
	background-color: #BEE4BE;
}
.gantt_task_link.start_to_start .gantt_line_wrapper div{
	background-color: #dd5640;
}
.gantt_task_link.start_to_start:hover .gantt_line_wrapper div{
	box-shadow: 0 0 5px 0px #dd5640;
}
.gantt_task_link.start_to_start .gantt_link_arrow_right{
	border-left-color: #dd5640;
}


.gantt_task_link.finish_to_start .gantt_line_wrapper div{
	background-color: #7576ba;
}
.gantt_task_link.finish_to_start:hover .gantt_line_wrapper div{
	box-shadow: 0 0 5px 0px #7576ba;
}

.gantt_task_link.finish_to_start .gantt_link_arrow_right{
	border-left-color: #7576ba;
}


.gantt_task_link.finish_to_finish .gantt_line_wrapper div{
	background-color: #55d822;
}
.gantt_task_link.finish_to_finish:hover .gantt_line_wrapper div{
	box-shadow: 0 0 5px 0px #55d822;
}
.gantt_task_link.finish_to_finish .gantt_link_arrow_left{
	border-right-color: #55d822;
}
.meeting_task{
	border:2px solid #BFC518;
	color:#6ba8e3;
	background: #F2F67E;
}
.meeting_task .gantt_task_progress{
	background:#D9DF29;
}
/*            .gantt_task_cell.week_end{
				background-color: #EFF5FD;
			}
			.gantt_task_row.gantt_selected .gantt_task_cell.week_end{
				background-color: #F8EC9C;
			}*/
.meeting_task{
	border:2px solid #BFC518;
	color:#6ba8e3;
	background: #F2F67E;
}
.meeting_task .gantt_task_progress{
	background:#D9DF29;
}
ul {
	list-style: none outside none;
}
#tab_show li{
	float: left;
	list-style: none;
	border-right: 2px solid #FFF;
	cursor: pointer;
	background: CORNFLOWERBLUE;
	padding: 10px;
	color: #FFF;
	font-size: 14px;
	font-weight: bold;
}
#tab_show li a{
	color: #FFF;
	text-decoration: none;
}
#tab_show li a:hover{
	color: #000;
}
#tab_show li:hover{
	color: #000;
}
#tab_show li.active{
	background: #048CAD;

}
</style>
        
