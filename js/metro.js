

$(document).ready(function ()
{

    $("#email_receipt").click(function ()
    {
        $.get($(this).attr('href'), function ()
        {
            alert("<?php echo lang('sales_receipt_sent'); ?>")
        });

        return false;
    });
    $('#date').datePicker({startDate: '<?php echo get_js_start_of_time_date(); ?>'});
    $("#sales_delete_form").submit(function ()
    {
        if (!confirm('Bạn có chắc muốn xóa đơn hàng này? Hành động này không thể hoàn tác'))
        {
            return false;
        }
    });

    $("#sales_undelete_form").submit(function ()
    {
        if (!confirm('<?php echo lang("sales_undelete_confirmation"); ?>'))
        {
            return false;
        }
    });

    $('#sales_edit_form').validate({
        submitHandler: function (form)
        {
            $(form).ajaxSubmit({
                success: function (response)
                {
                    if (response.success)
                    {
                        set_feedback(response.message, 'success_message', false);
                    }
                    else
                    {
                        set_feedback(response.message, 'error_message', true);

                    }
                },
                dataType: 'json'
            });

        },
        errorLabelContainer: "#error_message_box",
        wrapper: "li",
        rules:
                {
                },
        messages:
                {
                }
    });
});

$(document).ready(function ()
{
    setTimeout(function () {
        $(":input:visible:first", "#item_form").focus();
    }, 100);

    $('#start_year,#start_month,#start_day,#end_year,#end_month,#end_day').change(function ()
    {
        $("#hdn_start_date").val($("#start_year").val() + '-' + $("#start_month").val() + '-' + $('#start_day').val());
        $("#hdn_end_date").val($("#end_year").val() + '-' + $("#end_month").val() + '-' + $('#end_day').val());
    });
});
/*script file report*/
//detailed_receivings.php-->

$(document).ready(function ()
{
    $('#start-date').datePicker({startDate: '01-01-1950'}).bind(
            'dpClosed',
            function (e, selectedDates)
            {
                var d = selectedDates[0];
                if (d) {
                    d = new Date(d);
                    $('#end-date').dpSetStartDate(d.addDays(0).asString());
                }
            }
    );
    $('#end-date').datePicker().bind(
            'dpClosed',
            function (e, selectedDates)
            {
                var d = selectedDates[0];
                if (d) {
                    d = new Date(d);
                    $('#start-date').dpSetEndDate(d.addDays(0).asString());
                }
            }
    );

});
//end detailed_receivings.php

//date_input_excel_export.php
$(document).ready(function ()
{
    $("#generate_report15").click(function ()
    {

        //var sale_type = $("#sale_type").val();
        //var item_type = $("#item_type").val();
        var export_excel = 0;
        if ($("#export_excel_yes").attr('checked'))
        {
            export_excel = 1;
        }
        var cost_type = $("#cost_type").val();
        if ($("#simple_radio").attr('checked'))
        {
            window.location = window.location + '/' + $("#report_date_range_simple option:selected").val() + '/' + export_excel + '/' + cost_type;
        }
        else
        {
            var start_date = $("#start_year").val() + '-' + $("#start_month").val() + '-' + $('#start_day').val() + ' ' + $('#start_hour').val() + ':' + $('#start_minute').val() + ':00';
            var end_date = $("#end_year").val() + '-' + $("#end_month").val() + '-' + $('#end_day').val() + ' ' + $('#end_hour').val() + ':' + $('#end_minute').val() + ':00';

            window.location = window.location + '/' + start_date + '/' + end_date + '/' + export_excel + '/' + cost_type;
        }
    });

    $("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").change(function ()
    {
        $("#complex_radio").attr('checked', 'checked');
    });

    $("#report_date_range_simple").change(function ()
    {
        $("#simple_radio").attr('checked', 'checked');
    });

});


//dungbv bc th thanh toán
$(document).ready(function ()
{
    $("#generate_report16").click(function ()
    {
        var sale_type = $("#sale_type").val();
        var export_excel = 0;
        if ($("#export_excel_yes").attr('checked'))
        {
            export_excel = 1;
        }

        if ($("#simple_radio").attr('checked'))
        {
            window.location = window.location + '/' + $("#report_date_range_simple option:selected").val() + '/' + sale_type + '/' + export_excel;
        }
        else
        {
            var start_date = $("#start_year").val() + '-' + $("#start_month").val() + '-' + $('#start_day').val() + ' ' + $('#start_hour').val() + ':' + $('#start_minute').val() + ':00';
            var end_date = $("#end_year").val() + '-' + $("#end_month").val() + '-' + $('#end_day').val() + ' ' + $('#end_hour').val() + ':' + $('#end_minute').val() + ':00';

            window.location = window.location + '/' + start_date + '/' + end_date + '/' + sale_type + '/' + export_excel;
        }
    });

    $("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").change(function ()
    {
        $("#complex_radio").attr('checked', 'checked');
    });

    $("#report_date_range_simple").change(function ()
    {
        $("#simple_radio").attr('checked', 'checked');
    });

});


$(document).ready(function ()
{
    $("#generate_report17").click(function ()
    {
        var sale_type = $("#sale_type").val();
        var export_excel = 0;
        if ($("#export_excel_yes").attr('checked'))
        {
            export_excel = 1;
        }
        var item_type = $("#item_type").val();
        if ($("#simple_radio").attr('checked'))
        {
            window.location = window.location + '/' + $("#report_date_range_simple option:selected").val() + '/' + sale_type + '/' + export_excel + '/' + item_type;
        }
        else
        {
            var start_date = $("#start_year").val() + '-' + $("#start_month").val() + '-' + $('#start_day').val() + ' ' + $('#start_hour').val() + ':' + $('#start_minute').val() + ':00';
            var end_date = $("#end_year").val() + '-' + $("#end_month").val() + '-' + $('#end_day').val() + ' ' + $('#end_hour').val() + ':' + $('#end_minute').val() + ':00';

            window.location = window.location + '/' + start_date + '/' + end_date + '/' + sale_type + '/' + export_excel + '/' + item_type;
        }
    });

    $("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").change(function ()
    {
        $("#complex_radio").attr('checked', 'checked');
    });

    $("#report_date_range_simple").change(function ()
    {
        $("#simple_radio").attr('checked', 'checked');
    });

});

//end date_input_excel_export.php

//hung audi 27-6-15 
//date_input_summary_suppliers.php
$(document).ready(function () {
    $("#generate_report8").click(function () {
        var sale_type = $("#sale_type").val();
        var export_excel = 0;
        if ($("#export_excel_yes").attr('checked')) {
            export_excel = 1;
        }
        if ($("#simple_radio").attr('checked')) {
            window.location = window.location + '/' + $("#report_date_range_simple option:selected").val() + '/' + sale_type + '/' + export_excel;
        } else {
            var start_date = $("#start_year").val() + '-' + $("#start_month").val() + '-' + $('#start_day').val() + ' ' + $('#start_hour').val() + ':' + $('#start_minute').val() + ':00';
            var end_date = $("#end_year").val() + '-' + $("#end_month").val() + '-' + $('#end_day').val() + ' ' + $('#end_hour').val() + ':' + $('#end_minute').val() + ':00';

            window.location = window.location + '/' + start_date + '/' + end_date + '/' + sale_type + '/' + export_excel;
        }
    });
    $("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").change(function () {
        $("#complex_radio").attr('checked', 'checked');
    });
    $("#report_date_range_simple").change(function () {
        $("#simple_radio").attr('checked', 'checked');
    });
});
//end date_input_summary_suppliers.php

//<!--date_input.php-->
$(document).ready(function ()
{
    $("#generate_report2").click(function ()
    {
        var sale_type = $("#sale_type").val();

        if ($("#simple_radio").attr('checked'))
        {
            window.location = window.location + '/' + $("#report_date_range_simple option:selected").val() + '/' + sale_type;
        }
        else
        {
            var start_date = $("#start_year").val() + '-' + $("#start_month").val() + '-' + $('#start_day').val();
            var end_date = $("#end_year").val() + '-' + $("#end_month").val() + '-' + $('#end_day').val();

            window.location = window.location + '/' + start_date + '/' + end_date + '/' + sale_type;
        }
    });

    $("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").change(function ()
    {
        $("#complex_radio").attr('checked', 'checked');
    });

    $("#report_date_range_simple").change(function ()
    {
        $("#simple_radio").attr('checked', 'checked');
    });

});
//<!--end date_input.php-->

/*date_input_excel_register_log.php*/
$(document).ready(function ()
{
    $("#generate_report3").click(function ()
    {
        var export_excel = 0;
        if ($("#export_excel_yes").attr('checked'))
        {
            export_excel = 1;
        }

        if ($("#simple_radio").attr('checked'))
        {
            window.location = window.location + '/' + $("#report_date_range_simple option:selected").val() + '/' + export_excel;
        }
        else
        {
            var start_date = $("#start_year").val() + '-' + $("#start_month").val() + '-' + $('#start_day').val();
            var end_date = $("#end_year").val() + '-' + $("#end_month").val() + '-' + $('#end_day').val();

            window.location = window.location + '/' + start_date + '/' + end_date + '/' + export_excel;
        }
    });

    $("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").change(function ()
    {
        $("#complex_radio").attr('checked', 'checked');
    });

    $("#report_date_range_simple").change(function ()
    {
        $("#simple_radio").attr('checked', 'checked');
    });

});
/*end date_input_excel_register_log.php*/

/*detailed_giftcards_input.php*/
$(document).ready(function ()
{
    $("#generate_report4").click(function ()
    {
        var export_excel = 0;
        if ($("#export_excel_yes").attr('checked'))
        {
            export_excel = 1;
        }
        window.location = window.location + '/' + $('#specific_input_data').val() + '/' + export_excel;

    });
});
/*end detailed_giftcards_input.php*/

/*do_congnokh.php*/
function print_receipt()
{
    $('#print_button').hide();
    window.print();
}
/*end do_congnokh.php*/

/*do_item_inventory.php*/

/*end do_item_inventory.php*/


/*excel_export.php*/
$(document).ready(function ()
{
    $("#generate_report5").click(function ()
    {

        var export_excel = 0;
        if ($("#export_excel_yes").attr('checked'))
        {
            export_excel = 1;
        }

        window.location = window.location + '/' + export_excel;
    });
});
/*end excel_export.php*/
/*sales_generator_tabular_details.php*/
$(document).ready(function ()
{
    $(".tablesorter a.expand").click(function (event)
    {
        $(event.target).parent().parent().next().find('td.innertable').toggle();

        if ($(event.target).text() == '+')
        {
            $(event.target).text('-');
            $(".expand").css({"width": "19px"});
        }
        else
        {
            $(event.target).text('+');
        }
        return false;
    });

    $(".tablesorter a.expand_all").click(function (event)
    {
        $('td.innertable').toggle();

        if ($(event.target).text() == '+')
        {
            $(event.target).text('-');
        }
        else
        {
            $(event.target).text('+');
        }
        return false;
    });

});
/*end sales_generator_tabular_details.php*/
/*specific_input.php*/
$(document).ready(function () {
    $("#generate_report6").click(function () {
        if ($.trim($("#specific_input_data").val()) == '') {
            alert(notice);
            return false;
        }
        var sale_type = $("#sale_type").val();
        var report_type = $("#report_type").val();
        var export_excel = 0;

        if ($("#export_excel_yes").attr('checked'))
        {
            export_excel = 1;
        }

        if ($("#simple_radio").attr('checked'))
        {
            window.location = window.location + '/' + $("#report_date_range_simple option:selected").val() + '/' + $('#specific_input_data').val() + '/' + sale_type + '/' + report_type + '/' + export_excel;
        }
        else
        {
            var start_date = $("#start_year").val() + '-' + $("#start_month").val() + '-' + $('#start_day').val() + ' ' + $('#start_hour').val() + ':' + $('#start_minute').val() + ':00';
            var end_date = $("#end_year").val() + '-' + $("#end_month").val() + '-' + $('#end_day').val() + ' ' + $('#end_hour').val() + ':' + $('#end_minute').val() + ':00';

            window.location = window.location + '/' + start_date + '/' + end_date + '/' + $('#specific_input_data').val() + '/' + sale_type + '/' + report_type + '/' + export_excel;
        }
    });

    $("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").change(function ()
    {
        $("#complex_radio").attr('checked', 'checked');
    });

    $("#report_date_range_simple").change(function ()
    {
        $("#simple_radio").attr('checked', 'checked');
    });

});


$(document).ready(function () {
    $("#generate_report18").click(function () {
        if ($.trim($("#specific_input_data").val()) == '') {
            alert(notice);
            return false;
        }
        var sale_type = $("#sale_type").val();
        //var report_type=$("#report_type").val();
        var export_excel = 0;

        if ($("#export_excel_yes").attr('checked'))
        {
            export_excel = 1;
        }

        if ($("#simple_radio").attr('checked'))
        {
            window.location = window.location + '/' + $("#report_date_range_simple option:selected").val() + '/' + $('#specific_input_data').val() + '/' + sale_type + '/' + export_excel;
        }
        else
        {
            var start_date = $("#start_year").val() + '-' + $("#start_month").val() + '-' + $('#start_day').val() + ' ' + $('#start_hour').val() + ':' + $('#start_minute').val() + ':00';
            var end_date = $("#end_year").val() + '-' + $("#end_month").val() + '-' + $('#end_day').val() + ' ' + $('#end_hour').val() + ':' + $('#end_minute').val() + ':00';

            window.location = window.location + '/' + start_date + '/' + end_date + '/' + $('#specific_input_data').val() + '/' + sale_type + '/' + export_excel;
        }
    });

    $("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").change(function ()
    {
        $("#complex_radio").attr('checked', 'checked');
    });

    $("#report_date_range_simple").change(function ()
    {
        $("#simple_radio").attr('checked', 'checked');
    });

});

//Created by Loi
$(document).ready(function () {
    $("#generate_report_revenue").click(function () {

        var export_excel = 0;
        if ($("#export_excel_yes").attr('checked'))
        {
            export_excel = 1;
        }

        if ($("#simple_radio").attr('checked'))
        {
            window.location = window.location + '/' + $("#report_date_range_simple option:selected").val() + '/' + export_excel;
        }
        else
        {
            var start_date = $("#start_year").val() + '-' + $("#start_month").val() + '-' + $('#start_day').val() + ' ' + $('#start_hour').val() + ':' + $('#start_minute').val() + ':00';
            var end_date = $("#end_year").val() + '-' + $("#end_month").val() + '-' + $('#end_day').val() + ' ' + $('#end_hour').val() + ':' + $('#end_minute').val() + ':00';

            window.location = window.location + '/' + start_date + '/' + end_date + '/' + export_excel;
        }
    });

    $("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").change(function ()
    {
        $("#complex_radio").attr('checked', 'checked');
    });

    $("#report_date_range_simple").change(function ()
    {
        $("#simple_radio").attr('checked', 'checked');
    });

});
$(document).ready(function () {
    $("#generate_report_revenue_cat").click(function () {

        var cat_id = $("#category").val();
        var export_excel = 0;
        if ($("#export_excel_yes").attr('checked'))
        {
            export_excel = 1;
        }

        if ($("#simple_radio").attr('checked'))
        {
            window.location = window.location + '/' + $("#report_date_range_simple option:selected").val() + '/' + cat_id + '/' + export_excel;
        }
        else
        {
            var start_date = $("#start_year").val() + '-' + $("#start_month").val() + '-' + $('#start_day').val() + ' ' + $('#start_hour').val() + ':' + $('#start_minute').val() + ':00';
            var end_date = $("#end_year").val() + '-' + $("#end_month").val() + '-' + $('#end_day').val() + ' ' + $('#end_hour').val() + ':' + $('#end_minute').val() + ':00';

            window.location = window.location + '/' + start_date + '/' + end_date + '/' + cat_id + '/' + export_excel;
        }
    });

    $("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").change(function ()
    {
        $("#complex_radio").attr('checked', 'checked');
    });

    $("#report_date_range_simple").change(function ()
    {
        $("#simple_radio").attr('checked', 'checked');
    });

});
$(document).ready(function () {
    $("#generate_report_detail_sale").click(function () {
        if ($.trim($("#specific_input_data").val()) == '') {
            alert(notice);
            return false;
        }
        var sale_type = $("#sale_type").val();
        var report_type = $("#report_type").val();
        var export_excel = 0;
        if ($("#export_excel_yes").attr('checked'))
        {
            export_excel = 1;
        }

        if ($("#simple_radio").attr('checked'))
        {
            window.location = window.location + '/' + $("#report_date_range_simple option:selected").val() + '/' + $('#specific_input_data').val() + '/' + sale_type + '/' + report_type + '/' + export_excel;
        }
        else
        {
            var start_date = $("#start_year").val() + '-' + $("#start_month").val() + '-' + $('#start_day').val() + ' ' + $('#start_hour').val() + ':' + $('#start_minute').val() + ':00';
            var end_date = $("#end_year").val() + '-' + $("#end_month").val() + '-' + $('#end_day').val() + ' ' + $('#end_hour').val() + ':' + $('#end_minute').val() + ':00';

            window.location = window.location + '/' + start_date + '/' + end_date + '/' + $('#specific_input_data').val() + '/' + sale_type + '/' + report_type + '/' + export_excel;
        }
    });

    $("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").change(function ()
    {
        $("#complex_radio").attr('checked', 'checked');
    });

    $("#report_date_range_simple").change(function ()
    {
        $("#simple_radio").attr('checked', 'checked');
    });

});
$(document).ready(function () {
    $("#generate_report_ive").click(function () {
        var store = $("#specific_input_data").val();
        var export_excel = 0;
        if ($("#export_excel_yes").attr('checked')) {
            export_excel = 1;
        }
        if ($("#simple_radio").attr('checked')) {
            window.location = window.location + '/' + $("#report_date_range_simple option:selected").val() + '/' + export_excel + '/' + store;
        } else {
            var start_date = $("#start_year").val() + '-' + $("#start_month").val() + '-' + $('#start_day').val() + ' ' + $('#start_hour').val() + ':' + $('#start_minute').val() + ':00';
            var end_date = $("#end_year").val() + '-' + $("#end_month").val() + '-' + $('#end_day').val() + ' ' + $('#end_hour').val() + ':' + $('#end_minute').val() + ':00';
            window.location = window.location + '/' + start_date + '/' + end_date + '/' + export_excel + '/' + store;
        }
    });
    $("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").change(function () {
        $("#complex_radio").attr('checked', 'checked');
    });
    $("#report_date_range_simple").change(function () {
        $("#simple_radio").attr('checked', 'checked');
    });
});
$(document).ready(function () {
    $("#generate_report_inventory").click(function () {
        var store = $("#store").val();
        var export_excel = 0;
        if ($("#export_excel_yes").attr('checked')) {
            export_excel = 1;
        }
        window.location = window.location + '/' + store + '/' + export_excel;
    });
});
$(document).ready(function ()
{
    $("#generate_report12").click(function ()
    {

        var sale_type = $("#sale_type").val();
        var export_excel = 0;
        if ($("#export_excel_yes").attr('checked'))
        {
            export_excel = 1;
        }

        if ($("#simple_radio").attr('checked'))
        {
            window.location = window.location + '/' + $("#report_date_range_simple option:selected").val() + '/' + sale_type + '/' + export_excel;
        }
        else
        {
            var start_date = $("#start_year").val() + '-' + $("#start_month").val() + '-' + $('#start_day').val() + ' ' + $('#start_hour').val() + ':' + $('#start_minute').val() + ':00';
            var end_date = $("#end_year").val() + '-' + $("#end_month").val() + '-' + $('#end_day').val() + ' ' + $('#end_hour').val() + ':' + $('#end_minute').val() + ':00';

            window.location = window.location + '/' + start_date + '/' + end_date + '/' + sale_type + '/' + export_excel;
        }
    });

    $("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").change(function ()
    {
        $("#complex_radio").attr('checked', 'checked');
    });

    $("#report_date_range_simple").change(function ()
    {
        $("#simple_radio").attr('checked', 'checked');
    });

});


$(document).ready(function ()
{
    $("#generate_report1").click(function ()
    {

        var sale_type = $("#sale_type").val();

        var export_excel = 0;
        if ($("#export_excel_yes").attr('checked'))
        {
            export_excel = 1;
        }
        var item_type = $("#item_type").val();
        if ($("#simple_radio").attr('checked'))
        {
            window.location = window.location + '/' + $("#report_date_range_simple option:selected").val() + '/' + sale_type + '/' + export_excel + '/' + item_type;
        }
        else
        {
            var start_date = $("#start_year").val() + '-' + $("#start_month").val() + '-' + $('#start_day').val() + ' ' + $('#start_hour').val() + ':' + $('#start_minute').val() + ':00';
            var end_date = $("#end_year").val() + '-' + $("#end_month").val() + '-' + $('#end_day').val() + ' ' + $('#end_hour').val() + ':' + $('#end_minute').val() + ':00';

            window.location = window.location + '/' + start_date + '/' + end_date + '/' + sale_type + '/' + export_excel + '/' + item_type;
        }
    });

    $("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").change(function ()
    {
        $("#complex_radio").attr('checked', 'checked');
    });

    $("#report_date_range_simple").change(function ()
    {
        $("#simple_radio").attr('checked', 'checked');
    });

});


$(document).ready(function () {
    $("#generate_report13").click(function () {
        if ($.trim($("#specific_input_data").val()) == '') {
            alert(notice);
            return false;
        }
        var tam = ($("#employee_label").find("#specific_input_data"));
        if (tam) {
            var employee_id = $("#specific_input_data").val();
        } else
            var employee_id = 0;
        var cost_type = $("#cost_type").val();
        var export_excel = 0;
        if ($("#export_excel_yes").attr('checked'))
        {
            export_excel = 1;
        }

        if ($("#simple_radio").attr('checked'))
        {
            window.location = window.location + '/' + $("#report_date_range_simple option:selected").val() + '/' + employee_id + '/' + cost_type + '/' + export_excel;
        }
        else
        {
            var start_date = $("#start_year").val() + '-' + $("#start_month").val() + '-' + $('#start_day').val() + ' ' + $('#start_hour').val() + ':' + $('#start_minute').val() + ':00';
            var end_date = $("#end_year").val() + '-' + $("#end_month").val() + '-' + $('#end_day').val() + ' ' + $('#end_hour').val() + ':' + $('#end_minute').val() + ':00';

            window.location = window.location + '/' + start_date + '/' + end_date + '/' + employee_id + '/' + cost_type + '/' + export_excel;
        }
    });

    $("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").change(function ()
    {
        $("#complex_radio").attr('checked', 'checked');
    });

    $("#report_date_range_simple").change(function ()
    {
        $("#simple_radio").attr('checked', 'checked');
    });

});
//end Loi
$(document).ready(function () {
    $("#generate_report11").click(function () {
        var sup_id = $("#specific_input_data").val() ? $("#specific_input_data").val() : 0;
        var export_excel = 0;
        if ($("#export_excel_yes").attr('checked')) {
            export_excel = 1;
        }
        if ($("#simple_radio").attr('checked')) {
            window.location = window.location + '/' + $("#report_date_range_simple option:selected").val() + '/' + sup_id + '/' + export_excel;
        } else {
            var start_date = $("#start_year").val() + '-' + $("#start_month").val() + '-' + $('#start_day').val() + ' ' + $('#start_hour').val() + ':' + $('#start_minute').val() + ':00';
            var end_date = $("#end_year").val() + '-' + $("#end_month").val() + '-' + $('#end_day').val() + ' ' + $('#end_hour').val() + ':' + $('#end_minute').val() + ':00';
            window.location = window.location + '/' + start_date + '/' + end_date + '/' + sup_id + '/' + export_excel;
        }
    });

    $("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").change(function () {
        $("#complex_radio").attr('checked', 'checked');
    });

    $("#report_date_range_simple").change(function () {
        $("#simple_radio").attr('checked', 'checked');
    });
});
$(document).ready(function () {
    $("#generate_report9").click(function () {
        var export_excel = 0;
        var cus_id = $('#specific_input_data').val() ? $('#specific_input_data').val() : 0;
        if ($("#export_excel_yes").attr('checked'))
        {
            export_excel = 1;
        }

        if ($("#simple_radio").attr('checked'))
        {
            window.location = window.location + '/' + $("#report_date_range_simple option:selected").val() + '/' + cus_id + '/' + export_excel;
        }
        else
        {
            var start_date = $("#start_year").val() + '-' + $("#start_month").val() + '-' + $('#start_day').val() + ' ' + $('#start_hour').val() + ':' + $('#start_minute').val() + ':00';
            var end_date = $("#end_year").val() + '-' + $("#end_month").val() + '-' + $('#end_day').val() + ' ' + $('#end_hour').val() + ':' + $('#end_minute').val() + ':00';

            window.location = window.location + '/' + start_date + '/' + end_date + '/' + cus_id + '/' + export_excel;
        }
    });

    $("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").change(function ()
    {
        $("#complex_radio").attr('checked', 'checked');
    });

    $("#report_date_range_simple").change(function ()
    {
        $("#simple_radio").attr('checked', 'checked');
    });

});

//dungbv 
$(document).ready(function ()
{
    $("#generate_report14").click(function ()
    {

        var sale_type = $("#sale_type").val();
        //var item_type = $("#item_type").val();
        var export_excel = 0;
        if ($("#export_excel_yes").attr('checked'))
        {
            export_excel = 1;
        }
        //var cost_type = $("#cost_type").val();
        if ($("#simple_radio").attr('checked'))
        {
            window.location = window.location + '/' + $("#report_date_range_simple option:selected").val() + '/' + sale_type + '/' + export_excel;
        }
        else
        {
            var start_date = $("#start_year").val() + '-' + $("#start_month").val() + '-' + $('#start_day').val() + ' ' + $('#start_hour').val() + ':' + $('#start_minute').val() + ':00';
            var end_date = $("#end_year").val() + '-' + $("#end_month").val() + '-' + $('#end_day').val() + ' ' + $('#end_hour').val() + ':' + $('#end_minute').val() + ':00';

            window.location = window.location + '/' + start_date + '/' + end_date + '/' + sale_type + '/' + export_excel;
        }
    });

    $("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").change(function ()
    {
        $("#complex_radio").attr('checked', 'checked');
    });

    $("#report_date_range_simple").change(function ()
    {
        $("#simple_radio").attr('checked', 'checked');
    });

});

//bc xuất kho

$(document).ready(function () {
    $("#generate_report_store").click(function () {

        var export_excel = 0;
        if ($("#export_excel_yes").attr('checked')) {
            export_excel = 1;
        }
        var store = $("#specific_input_data").val();
        if ($("#simple_radio").attr('checked')) {
            window.location = window.location + '/' + $("#report_date_range_simple option:selected").val() + '/' + export_excel + '/' + store;
        } else {
            var start_date = $("#start_year").val() + '-' + $("#start_month").val() + '-' + $('#start_day').val() + ' ' + $('#start_hour').val() + ':' + $('#start_minute').val() + ':00';
            var end_date = $("#end_year").val() + '-' + $("#end_month").val() + '-' + $('#end_day').val() + ' ' + $('#end_hour').val() + ':' + $('#end_minute').val() + ':00';
            window.location = window.location + '/' + start_date + '/' + end_date + '/' + export_excel + '/' + store;
        }
    });
    $("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").change(function () {
        $("#complex_radio").attr('checked', 'checked');
    });
    $("#report_date_range_simple").change(function () {
        $("#simple_radio").attr('checked', 'checked');
    });
});
$(document).ready(function ()
{
    $("#generate_report_sale").click(function ()
    {

        var export_excel = 0;
        if ($("#export_excel_yes").attr('checked'))
        {
            export_excel = 1;
        }
        if ($("#simple_radio").attr('checked'))
        {
            window.location = window.location + '/' + $("#report_date_range_simple option:selected").val() + '/' + export_excel;
        }
        else
        {
            var start_date = $("#start_year").val() + '-' + $("#start_month").val() + '-' + $('#start_day').val() + ' ' + $('#start_hour').val() + ':' + $('#start_minute').val() + ':00';
            var end_date = $("#end_year").val() + '-' + $("#end_month").val() + '-' + $('#end_day').val() + ' ' + $('#end_hour').val() + ':' + $('#end_minute').val() + ':00';

            window.location = window.location + '/' + start_date + '/' + end_date + '/' + export_excel;
        }
    });

    $("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").change(function ()
    {
        $("#complex_radio").attr('checked', 'checked');
    });

    $("#report_date_range_simple").change(function ()
    {
        $("#simple_radio").attr('checked', 'checked');
    });

});
/*end specific_input.php*/
function init_table_sorting()
{
    //Only init if there is more than one row
    if ($('.tablesorter tbody tr').length > 1)
    {
        $("#sortable_table").tablesorter();
    }
}
$(document).ready(function ()
{
    init_table_sorting();
});
/*end script file report*/



/*script interface*/
$(function () {
    $layout = $('.metro-layout');
    $container = $('.metro-layout .content');

    function changeLayoutMode(isHorizontal) {
        $('.items', $layout).removeAttr('style');
        if (isHorizontal) {
            $('.items', $layout).css({
                width: $('.items', $layout).outerWidth()
            }).isotope({
                itemSelector: '.box',
                layoutMode: 'masonryHorizontal',
                animationEngine: 'css'
            });
        } else {
            $('.items', $layout).css({
                width: 'auto'
            }).isotope({
                itemSelector: '.box',
                layoutMode: 'masonry',
                animationEngine: 'css'
            });
        }
    }
    changeLayoutMode($layout.hasClass('horizontal'));
    $('.next', $layout).click(function (ev) {
        ev.preventDefault();
        $container.stop().animate({
            scrollLeft: '+=' + ($('body').innerWidth() / 1.8)
        }, 400);
    });
    $('.prev', $layout).click(function (ev) {
        ev.preventDefault();
        $container.stop().animate({
            scrollLeft: '-=' + ($('body').innerWidth() / 1.8)
        }, 400);
    });
    $('.up', $layout).click(function (ev) {
        ev.preventDefault();
        $container.stop().animate({
            scrollTop: '-=' + ($('body').innerHeight() / 1.8)
        }, 400);
    });
    $('.down', $layout).click(function (ev) {
        ev.preventDefault();
        $container.stop().animate({
            scrollTop: '+=' + ($('body').innerHeight() / 1.8)
        }, 400);
    });
    $('.toggle-view', $layout).click(function (ev) {
        ev.preventDefault();
        $layout.toggleClass('horizontal vertical');
        changeLayoutMode($layout.hasClass('horizontal'));
        toggleSlideControls();
    });

    function toggleSlideControls()
    {
        var hasHScrollbar = $container.get(0).scrollWidth > $container.innerWidth();
        var hasVScrollbar = $container.get(0).scrollHeight > $container.innerHeight();
        if (hasHScrollbar)
            $('.prev,.next', $layout).show();
        else
            $('.prev,.next', $layout).hide();
        if (hasVScrollbar)
            $('.up,.down', $layout).show();
        else
            $('.up,.down', $layout).hide();
    }
    ;
    toggleSlideControls();
    $('.items', $layout).bind('mousewheel', function (ev, delta, deltaX, deltaY) {
        if (delta) {
            ev.preventDefault();
            var isHorizontal = $layout.hasClass('horizontal');
            if (isHorizontal)
                $container.stop().animate({
                    scrollLeft: '-=' + ($('body').innerWidth() / 4 * delta)
                }, 10);
            else
                $container.stop().animate({
                    scrollTop: '-=' + ($('body').innerHeight() / 4 * delta)
                }, 10);
            console.log(delta, deltaX, deltaY);
        }
    });
    var resizeTimer;
    $(window).bind('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(toggleSlideControls, 100);
    });
    $container.dragscrollable({
        dragSelector: '.items'
    });
})

$(document).ready(function () {
    setTimeout(function () {
        $(":input:visible:first", "#approve_form").focus();
    }, 100);
    var submitting = false;
    $('#approve_form').validate({
        submitHandler: function (form) {
            if (submitting)
                return;
            submitting = true;
            $(form).mask(("xin chờ trong giây lát..."));
            $(form).ajaxSubmit({
                success: function (response) {
                    submitting = false;
                    tb_remove();
                    post_receiving_form_submit(response);
                },
                dataType: 'json'
            });
        }
    });
});
/*end script interface*/