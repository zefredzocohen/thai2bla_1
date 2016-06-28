/*
 This software is allowed to use under GPL or you need to obtain Commercial or Enterprise License 
 to use it in non-GPL project. Please contact sales@dhtmlx.com for details
 */
gantt.config.quickinfo_buttons = ["icon_delete", "icon_edit"], gantt.config.quick_info_detached = !0, gantt.attachEvent("onTaskClick", function(t) {
    return gantt.showQuickInfo(t), !0
}), function() {
    for (var t = ["onEmptyClick", "onViewChange", "onLightbox", "onBeforeTaskDelete", "onBeforeDrag"], e = function() {
        return gantt._hideQuickInfo(), !0
    }, n = 0; n < t.length; n++)
        gantt.attachEvent(t[n], e)
}(), gantt.templates.quick_info_title = function(t, e, n) {
    return n.text.substr(0, 50)
}, gantt.templates.quick_info_content = function(t, e, n) {
    return n.details || n.text
}, gantt.templates.quick_info_date = function(t, e, n) {
    return gantt.templates.task_time(t, e, n)
}, gantt.showQuickInfo = function(t) {
    if (t != this._quick_info_box_id) {
        this.hideQuickInfo(!0);
        var e = this._get_event_counter_part(t);
        e && (this._quick_info_box = this._init_quick_info(e), this._fill_quick_data(t), this._show_quick_info(e))
    }
}, gantt._hideQuickInfo = function() {
    gantt.hideQuickInfo()
}, gantt.hideQuickInfo = function(t) {
    var e = this._quick_info_box;
    if (this._quick_info_box_id = 0, e && e.parentNode) {
        if (gantt.config.quick_info_detached)
            return e.parentNode.removeChild(e);
        "auto" == e.style.right ? e.style.left = "-350px" : e.style.right = "-350px", t && e.parentNode.removeChild(e)
    }
}, dhtmlxEvent(window, "keydown", function(t) {
    27 == t.keyCode && gantt.hideQuickInfo()
}), gantt._show_quick_info = function(t) {
    var e = gantt._quick_info_box;
    if (gantt.config.quick_info_detached) {
        e.parentNode && "#document-fragment" != e.parentNode.nodeName.toLowerCase() || gantt.$task_data.appendChild(e);
        var n = e.offsetWidth, i = e.offsetHeight, a = this.getScrollState(), s = this.$task.offsetWidth + a.x - n;
        e.style.left = Math.min(Math.max(a.x, t.left - t.dx * (n - t.width)), s) + "px", e.style.top = t.top - (t.dy ? i : -t.height) - 55 + "px"
    } else
        e.style.top = "20px", 1 == t.dx ? (e.style.right = "auto", e.style.left = "-300px", setTimeout(function() {
            e.style.left = "-10px"
        }, 1)) : (e.style.left = "auto", e.style.right = "-300px", setTimeout(function() {
            e.style.right = "-10px"
        }, 1)), e.className = e.className.replace("dhx_qi_left", "").replace("dhx_qi_left", "") + " dhx_qi_" + (1 == t ? "left" : "right"), gantt._obj.appendChild(e)
}, gantt._init_quick_info = function() {
    if (!this._quick_info_box) {
        var t = this._quick_info_box = document.createElement("div");
        t.className = "dhx_cal_quick_info", gantt.$testmode && (t.className += " dhx_no_animate");
        var e = '<div class="dhx_cal_qi_title"><div style="display:none" class="dhx_cal_qi_tcontent"></div><div  class="dhx_cal_qi_tdate"></div></div><div style="font-weight:bold" class="dhx_cal_qi_content"></div>';
        e += '<div class="dhx_cal_qi_controls">';
        for (var n = gantt.config.quickinfo_buttons, i = 0; i < n.length; i++)
            e += '<div class="dhx_qi_big_icon ' + n[i] + '" title="' + gantt.locale.labels[n[i]] + "\"><div class='dhx_menu_icon " + n[i] + "'></div><div>" + gantt.locale.labels[n[i]] + "</div></div>";
        e += "</div>", t.innerHTML = e, dhtmlxEvent(t, "click", function(t) {
            t = t || event, gantt._qi_button_click(t.target || t.srcElement)
        }), gantt.config.quick_info_detached && dhtmlxEvent(gantt.$task_data, "scroll", function() {
            gantt.hideQuickInfo()
        })
    }
    return this._quick_info_box
}, gantt._qi_button_click = function(t) {
    var e = gantt._quick_info_box;
    if (t && t != e) {
        var n = t.className;
        if (-1 != n.indexOf("_icon")) {
            var i = gantt._quick_info_box_id;
            gantt.$click.buttons[n.split(" ")[1].replace("icon_", "")](i)
        } else
            gantt._qi_button_click(t.parentNode)
    }
}, gantt._get_event_counter_part = function(t) {
    for (var e = gantt.getTaskNode(t), n = 0, i = 0, a = e; a && "gantt_task" != a.className; )
        n += a.offsetLeft, i += a.offsetTop, a = a.offsetParent;
    var s = this.getScrollState();
    if (a) {
        var r = n + e.offsetWidth / 2 - s.x > gantt._x / 2 ? 1 : 0, o = i + e.offsetHeight / 2 - s.y > gantt._y / 2 ? 1 : 0;
        return{left: n, top: i, dx: r, dy: o, width: e.offsetWidth, height: e.offsetHeight}
    }
    return 0
}, gantt._fill_quick_data = function(t) {
    var e = gantt.getTask(t), n = gantt._quick_info_box;
    gantt._quick_info_box_id = t;
    var i = n.firstChild.firstChild;
    i.innerHTML = gantt.templates.quick_info_title(e.start_date, e.end_date, e);
    var a = i.nextSibling;
    a.innerHTML = gantt.templates.quick_info_date(e.start_date, e.end_date, e);
    var s = n.firstChild.nextSibling;
    s.innerHTML = gantt.templates.quick_info_content(e.start_date, e.end_date, e)
};