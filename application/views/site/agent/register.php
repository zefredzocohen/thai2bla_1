<?php $this->load->view('site/template/left'); ?>
<STYLE type="text/css">

    label.error{
        color:red;
    }
</style>
<?php
include_once 'LanguageHelper.php';
$object = new LanguageHelper();
$lang = $object->checkLang();
include_once($lang);

if (isset($_GET['lang'])) {
    if ($_GET['lang'] == "vi") {
        ?>
        <div class="col-md-9">
            <div class="banner">
                <div class="bannerslide" id="bannerslide">
                    <ul class="slides">
                        <li>
                            <a href="#">
                                <img src="<?php echo base_url() ?>images/banner-01.jpg" alt=""/>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="<?php echo base_url() ?>images/banner-02.jpg" alt=""/>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="clearfix">
            </div>

            <div class="portlet-body">
                <form class="form-horizontal" role="form" method="post" action="<?php echo base_url() ?>site/agent/register" enctype="multipart/form-data">
                    <div class="form-row">
                        <label class="lebel-abs">
                            Họ tên đệm 
                            <strong class="red">
                                *
                            </strong>
                        </label>
                        <input type="text" class="input namefild" name="first_name" id="first_name" >
                    </div>
                    <div class="form-row">
                        <label class="lebel-abs">
                            Tên 
                            <strong class="red">
                                *
                            </strong>
                        </label>
                        <input type="text" class="input namefild" name="last_name" id="last_name">
                    </div>
                    <div class="sort-by">
                        Giới tính 
                        <select name="sex" >
                            <option value="1">
                                Nam
                            </option>
                            <option value="2">
                                Nữ
                            </option>
                        </select>
                    </div>
                    <div class="sort-by">
                        Nhóm đại lý 
                        <select name="cus_type" >
                            <?php
                            foreach ($cus_type as $cus) {
                                ?>
                                <option value="<?php echo $cus['customer_type_id']; ?>"><?php echo $cus['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-row">
                        <label class="lebel-abs">
                            Đại lý giới thiệu
                            <strong class="red">
                                *
                            </strong>
                        </label>
                        <input type="text" class="input namefild" name="agent_input" id="agent_input">
                        <table id="row_selected">
                        </table>
                    </div>
                    <div class="form-row">
                        <label class="lebel-abs">
                            Email
                            <strong class="red">
                                *
                            </strong>
                        </label>
                        <input type="text" class="input namefild" name="email" id="email" placeholder="">
                    </div>
                    <div class="form-row">
                        <label class="lebel-abs">
                            Mật khẩu
                            <strong class="red">
                                *
                            </strong>
                        </label>
                        <input type="password" class="input namefild" name="password" id="password" placeholder="">
                    </div>
                    <div class="form-row">
                        <label class="lebel-abs">
                            Số điện thoại
                            <strong class="red">
                                *
                            </strong>
                        </label>
                        <input type="text" class="input namefild" name="phone" id="phone" placeholder="">
                    </div>
                    <div class="form-row">
                        <label class="lebel-abs">
                            Địa chỉ
                            <strong class="red">
                                *
                            </strong>
                        </label>
                        <input type="text" class="input namefild" name="address" id="address" placeholder="">
                    </div>
                    <div class="form-row">
                        <label class="lebel-abs">
                            Tên đại lý
                            <strong class="red">
                                *
                            </strong>
                        </label>
                        <input type="text" class="input namefild" name="company" id="company" placeholder="">
                    </div>
                    <div class="form-row">
                        <label class="lebel-abs">
                            Người đại diện
                            <strong class="red">
                                *
                            </strong>
                        </label>
                        <input type="text" class="input namefild" name="manage_name" id="manage_name" placeholder="">
                    </div>
                    <div class="form-row">
                        <label class="lebel-abs">
                            Tài khoản
                            <strong class="red">
                                *
                            </strong>
                        </label>
                        <input type="text" class="input namefild" name="account_number" id="" placeholder="">
                    </div>
                    <div class="form-row">
                        <label class="lebel-abs">
                            Mã số thuế
                            <strong class="red">
                                *
                            </strong>
                        </label>
                        <input type="text" class="input namefild" name="code_tax" id="" placeholder="">
                    </div>
                    <div class="form-row">
                        <label class="lebel-abs">
                            Ghi chú
                            <strong class="red">
                                *
                            </strong>
                        </label>
                        <input type="text" class="input namefild" name="comment" id="" placeholder="">
                    </div>
                    <div class="button_group">
                        <button class="button add-cart" type="submit">Đăng ký</button>
                        <button class="button add-cart" type="reset">Hủy bỏ</button>
                    </div>

                </form>
            </div>

        </div>
        <div class="clearfix">
        </div>
        <div class="our-brand">
            <h3 class="title">
                <strong>
                    Đối 
                </strong>
                tác
            </h3>
            <div class="control">
                <a id="prev_brand" class="prev" href="#">
                    &lt;
                </a>
                <a id="next_brand" class="next" href="#">
                    &gt;
                </a>
            </div>
            <ul id="braldLogo">
                <li>
                    <ul class="brand_item">
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/envato.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/themeforest.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/photodune.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/activeden.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/envato.png" alt="">
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <ul class="brand_item">
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/envato.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/themeforest.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/photodune.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/activeden.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/envato.png" alt="">
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        </div>
        </div>
        </div>
        <?php
    } elseif ($_GET['lang'] == 'en') {
        ?>
        <div class="col-md-9">
            <div class="banner">
                <div class="bannerslide" id="bannerslide">
                    <ul class="slides">
                        <li>
                            <a href="#">
                                <img src="<?php echo base_url() ?>images/banner-01.jpg" alt=""/>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="<?php echo base_url() ?>images/banner-02.jpg" alt=""/>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="clearfix">
            </div>

            <div class="portlet-body">
                <form class="form-horizontal" role="form" method="post" action="<?php echo base_url() ?>site/agent/register" enctype="multipart/form-data">
                    <div class="form-row">
                        <label class="lebel-abs">
                            First name 
                            <strong class="red">
                                *
                            </strong>
                        </label>
                        <input type="text" class="input namefild" name="first_name" id="first_name" >
                    </div>
                    <div class="form-row">
                        <label class="lebel-abs">
                            Last name
                            <strong class="red">
                                *
                            </strong>
                        </label>
                        <input type="text" class="input namefild" name="last_name" id="last_name">
                    </div>
                    <div class="sort-by">
                        Sex 
                        <select name="sex" >
                            <option value="1">
                                Male
                            </option>
                            <option value="2">
                                Female
                            </option>
                        </select>
                    </div>
                    <div class="sort-by">
                        Group Resellers 
                        <select name="cus_type" >
                            <?php
                            foreach ($cus_type as $cus) {
                                ?>
                                <option value="<?php echo $cus['customer_type_id']; ?>"><?php echo $cus['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-row">
                        <label class="lebel-abs">
                            Introduction Resellers
                            <strong class="red">
                                *
                            </strong>
                        </label>
                        <input type="text" class="input namefild" name="agent_input" id="agent_input">
                        <table id="row_selected">
                        </table>
                    </div>
                    <div class="form-row">
                        <label class="lebel-abs">
                            Email
                            <strong class="red">
                                *
                            </strong>
                        </label>
                        <input type="text" class="input namefild" name="email" id="email" placeholder="">
                    </div>
                    <div class="form-row">
                        <label class="lebel-abs">
                            Password
                            <strong class="red">
                                *
                            </strong>
                        </label>
                        <input type="password" class="input namefild" name="password" id="password" placeholder="">
                    </div>
                    <div class="form-row">
                        <label class="lebel-abs">
                            Phone
                            <strong class="red">
                                *
                            </strong>
                        </label>
                        <input type="text" class="input namefild" name="phone" id="phone" placeholder="">
                    </div>
                    <div class="form-row">
                        <label class="lebel-abs">
                            Address
                            <strong class="red">
                                *
                            </strong>
                        </label>
                        <input type="text" class="input namefild" name="address" id="address" placeholder="">
                    </div>
                    <div class="form-row">
                        <label class="lebel-abs">
                            Resellers name
                            <strong class="red">
                                *
                            </strong>
                        </label>
                        <input type="text" class="input namefild" name="company" id="company" placeholder="">
                    </div>
                    <div class="form-row">
                        <label class="lebel-abs">
                            Manage name
                            <strong class="red">
                                *
                            </strong>
                        </label>
                        <input type="text" class="input namefild" name="manage_name" id="manage_name" placeholder="">
                    </div>
                    <div class="form-row">
                        <label class="lebel-abs">
                            Account number
                            <strong class="red">
                                *
                            </strong>
                        </label>
                        <input type="text" class="input namefild" name="account_number" id="" placeholder="">
                    </div>
                    <div class="form-row">
                        <label class="lebel-abs">
                            Code taxes
                            <strong class="red">
                                *
                            </strong>
                        </label>
                        <input type="text" class="input namefild" name="code_tax" id="" placeholder="">
                    </div>
                    <div class="form-row">
                        <label class="lebel-abs">
                            Comment
                            <strong class="red">
                                *
                            </strong>
                        </label>
                        <input type="text" class="input namefild" name="comment" id="" placeholder="">
                    </div>
                    <div class="button_group">
                        <button class="button add-cart" type="submit">Register</button>
                        <button class="button add-cart" type="reset">Cancle</button>
                    </div>

                </form>
            </div>

        </div>
        <div class="clearfix">
        </div>
        <div class="our-brand">
            <h3 class="title">
                <strong>
                    Đối 
                </strong>
                tác
            </h3>
            <div class="control">
                <a id="prev_brand" class="prev" href="#">
                    &lt;
                </a>
                <a id="next_brand" class="next" href="#">
                    &gt;
                </a>
            </div>
            <ul id="braldLogo">
                <li>
                    <ul class="brand_item">
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/envato.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/themeforest.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/photodune.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/activeden.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/envato.png" alt="">
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <ul class="brand_item">
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/envato.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/themeforest.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/photodune.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/activeden.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/envato.png" alt="">
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        </div>
        </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <div class="col-md-9">
        <div class="banner">
            <div class="bannerslide" id="bannerslide">
                <ul class="slides">
                    <li>
                        <a href="#">
                            <img src="<?php echo base_url() ?>images/banner-01.jpg" alt=""/>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?php echo base_url() ?>images/banner-02.jpg" alt=""/>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="clearfix">
        </div>

        <div class="portlet-body">
            <form class="form-horizontal" role="form" method="post" action="<?php echo base_url() ?>site/agent/register" enctype="multipart/form-data">
                <div class="form-row">
                    <label class="lebel-abs">
                        Họ tên đệm 
                        <strong class="red">
                            *
                        </strong>
                    </label>
                    <input type="text" class="input namefild" name="first_name" id="first_name" >
                </div>
                <div class="form-row">
                    <label class="lebel-abs">
                        Tên 
                        <strong class="red">
                            *
                        </strong>
                    </label>
                    <input type="text" class="input namefild" name="last_name" id="last_name">
                </div>
                <div class="sort-by">
                    Giới tính 
                    <select name="sex" >
                        <option value="1">
                            Nam
                        </option>
                        <option value="2">
                            Nữ
                        </option>
                    </select>
                </div>
                <div class="sort-by">
                    Nhóm đại lý 
                    <select name="cus_type" >
                       <?php
                            foreach ($cus_type as $cus) {
                                ?>
                                <option value="<?php echo $cus['customer_type_id']; ?>"><?php echo $cus['name']; ?></option>
                            <?php } ?>
                    </select>
                </div>
                <div class="form-row">
                    <label class="lebel-abs">
                        Đại lý giới thiệu
                        <strong class="red">
                            *
                        </strong>
                    </label>
                    <input type="text" class="input namefild" name="agent_input" id="agent_input">
                    <table id="row_selected">
                    </table>
                </div>
                <div class="form-row">
                    <label class="lebel-abs">
                        Email
                        <strong class="red">
                            *
                        </strong>
                    </label>
                    <input type="text" class="input namefild" name="email" id="email" placeholder="">
                </div>
                <div class="form-row">
                    <label class="lebel-abs">
                        Mật khẩu
                        <strong class="red">
                            *
                        </strong>
                    </label>
                    <input type="password" class="input namefild" name="password" id="password" placeholder="">
                </div>
                <div class="form-row">
                    <label class="lebel-abs">
                        Số điện thoại
                        <strong class="red">
                            *
                        </strong>
                    </label>
                    <input type="text" class="input namefild" name="phone" id="phone" placeholder="">
                </div>
                <div class="form-row">
                    <label class="lebel-abs">
                        Địa chỉ
                        <strong class="red">
                            *
                        </strong>
                    </label>
                    <input type="text" class="input namefild" name="address" id="address" placeholder="">
                </div>
                <div class="form-row">
                    <label class="lebel-abs">
                        Tên đại lý
                        <strong class="red">
                            *
                        </strong>
                    </label>
                    <input type="text" class="input namefild" name="company" id="company" placeholder="">
                </div>
                <div class="form-row">
                    <label class="lebel-abs">
                        Người đại diện
                        <strong class="red">
                            *
                        </strong>
                    </label>
                    <input type="text" class="input namefild" name="manage_name" id="manage_name" placeholder="">
                </div>
                <div class="form-row">
                    <label class="lebel-abs">
                        Tài khoản
                        <strong class="red">
                            *
                        </strong>
                    </label>
                    <input type="text" class="input namefild" name="account_number" id="" placeholder="">
                </div>
                <div class="form-row">
                    <label class="lebel-abs">
                        Mã số thuế
                        <strong class="red">
                            *
                        </strong>
                    </label>
                    <input type="text" class="input namefild" name="code_tax" id="" placeholder="">
                </div>
                <div class="form-row">
                    <label class="lebel-abs">
                        Ghi chú
                        <strong class="red">
                            *
                        </strong>
                    </label>
                    <input type="text" class="input namefild" name="comment" id="" placeholder="">
                </div>
                <div class="button_group">
                    <button class="button add-cart" type="submit">Đăng ký</button>
                    <button class="button add-cart" type="reset">Hủy bỏ</button>
                </div>

            </form>
        </div>

    </div>
    <div class="clearfix">
    </div>
    <div class="our-brand">
        <h3 class="title">
            <strong>
                Đối 
            </strong>
            tác
        </h3>
        <div class="control">
            <a id="prev_brand" class="prev" href="#">
                &lt;
            </a>
            <a id="next_brand" class="next" href="#">
                &gt;
            </a>
        </div>
        <ul id="braldLogo">
            <li>
                <ul class="brand_item">
                    <li>
                        <a href="#">
                            <div class="brand-logo">
                                <img src="<?php echo base_url() ?>images/envato.png" alt="">
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="brand-logo">
                                <img src="<?php echo base_url() ?>images/themeforest.png" alt="">
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="brand-logo">
                                <img src="<?php echo base_url() ?>images/photodune.png" alt="">
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="brand-logo">
                                <img src="<?php echo base_url() ?>images/activeden.png" alt="">
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="brand-logo">
                                <img src="<?php echo base_url() ?>images/envato.png" alt="">
                            </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <ul class="brand_item">
                    <li>
                        <a href="#">
                            <div class="brand-logo">
                                <img src="<?php echo base_url() ?>images/envato.png" alt="">
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="brand-logo">
                                <img src="<?php echo base_url() ?>images/themeforest.png" alt="">
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="brand-logo">
                                <img src="<?php echo base_url() ?>images/photodune.png" alt="">
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="brand-logo">
                                <img src="<?php echo base_url() ?>images/activeden.png" alt="">
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="brand-logo">
                                <img src="<?php echo base_url() ?>images/envato.png" alt="">
                            </div>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    </div>
    </div>
    </div>
<?php } ?>
<script type="text/javascript">
    $(document).ready(function () {
        var validator = $(".form-horizontal").validate({
            rules: {
                first_name: "required",
                last_name: "required",
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 8,
                },
                address: "required",
                company: "required",
                manage_name: "required",
                phone: {
                    required: true,
                    number: true
                },
            },
            messages: {
                first_name: "Họ tên đệm cần nhập",
                last_name: "Tên cần nhập",
                email: {
                    required: "Email cần nhập",
                    email: "Địa chỉ email không hợp lệ"
                },
                address: "Địa chỉ cần nhập",
                company: "Tên đại lý cần nhập",
                manage_name: "Người đại diện cần nhập",
                password: {
                    required: "Mật khẩu cần nhập",
                    minlength: "Mật khẩu ít nhất là 8 ký tự"
                },
                phone: {
                    required: "Số điện thoại cần nhập",
                    number: "Số điện thoại phải là số"
                },
            }
        });
    })
</script>  
<style type="text/css">
    .disable_input_cost {
        display: none;
    }
</style>
<script type="text/javascript" language="javascript">

    $("#agent_input").autocomplete({
        source: '<?php echo site_url("site/agent/suggest_code"); ?>',
        delay: 10,
        autoFocus: false,
        minLength: 0,
        select: function (event, ui) {
            $("#agent_input").val("");
            if ($("#row_selected" + ui.item.value).length == 1) {
                $("#row_selected" + ui.item.value).val(parseFloat($("#row_selected" + ui.item.value).val()) + 1);
            } else {
                $("#agent_input").addClass("disable_input_cost");
                $("#row_selected").append("<tr><td width='300px'>" + ui.item.label + "</td><td><a href='#' style='text-decoration: underline;margin-left:-130px;color:blue' onclick='return deleteRow(this);'>Xóa</a></td><td><input type='hidden' size='3' id='agent' name='agent' value='" + ui.item.value + "'/></td></tr>");
                $.post('<?php echo base_url("site/agent/set_agent"); ?>', {agent: $('#agent').val()});
            }

            return false;
        }
    });

    function deleteRow(link) {
        $("#agent_input").removeClass("disable_input_cost");
        $(link).parent().parent().remove();
        return false;
    }
</script>