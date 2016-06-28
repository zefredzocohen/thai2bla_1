<?php $this->load->view('site/template/left'); ?>
<STYLE type="text/css">

    label.error{
    color:red;
}
</style>
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
    
 <?php
include_once 'template/LanguageHelper.php';
$object = new LanguageHelper();
$lang = $object->checkLang();
include_once($lang);
if(isset($_GET['lang'])){
    if($_GET['lang'] == 'vi'){
?>
    <div class="products-list">
        <div class="row">
              <form class="form-horizontal" role="form" method="post" action="<?php echo base_url()?>site/agent/check_login"> 
                        <div class="col-md-6 col-sm-6">
                          <div class="run-customer">
                            <h5>
                             Đăng nhập hệ thống
                            </h5>
                            <form>
                              <div class="form-row">
                                <label class="lebel-abs">
                                  Email 
                                  <strong class="red">
                                    *
                                  </strong>
                                </label>
                                <input type="text" class="input namefild" name="email">
                              </div>
                              <div class="form-row">
                                <label class="lebel-abs">
                                  Mật khẩu
                                  <strong class="red">
                                    *
                                  </strong>
                                </label>
                                  <input type="password" class="input namefild" name="password">
                              </div>
                              <p class="forgoten">
                                <a href="#">
                                  Chưa có tài khoản hãy đăng ký?
                                </a>
                              </p>
                              <button type="submit">
                                Đăng nhập
                              </button>
                          </div>
                        </div>
                       </form>
                      </div>
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
                        <img src="<?php echo base_url()?>images/envato.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/themeforest.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/photodune.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/activeden.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/envato.png" alt="">
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
                        <img src="<?php echo base_url()?>images/envato.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/themeforest.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/photodune.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/activeden.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/envato.png" alt="">
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
    <?php }elseif($_GET['lang'] == 'en'){?>
<div class="products-list">
        <div class="row">
              <form class="form-horizontal" role="form" method="post" action="<?php echo base_url()?>site/agent/check_login"> 
                        <div class="col-md-6 col-sm-6">
                          <div class="run-customer">
                            <h5>
                             Login System
                            </h5>
                            <form>
                              <div class="form-row">
                                <label class="lebel-abs">
                                  Email 
                                  <strong class="red">
                                    *
                                  </strong>
                                </label>
                                <input type="text" class="input namefild" name="email">
                              </div>
                              <div class="form-row">
                                <label class="lebel-abs">
                                  Password
                                  <strong class="red">
                                    *
                                  </strong>
                                </label>
                                  <input type="password" class="input namefild" name="password">
                              </div>
                              <p class="forgoten">
                                <a href="#">
                                  Register?
                                </a>
                              </p>
                              <button type="submit">
                                Login
                              </button>
                          </div>
                        </div>
                       </form>
                      </div>
    </div>
    
</div>
<div class="clearfix">
          </div>
          <div class="our-brand">
            <h3 class="title">
              <strong>
                VENDOR 
              </strong>
              
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
                        <img src="<?php echo base_url()?>images/envato.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/themeforest.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/photodune.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/activeden.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/envato.png" alt="">
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
                        <img src="<?php echo base_url()?>images/envato.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/themeforest.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/photodune.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/activeden.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/envato.png" alt="">
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
    <?php }?>
<?php }else{?>
<div class="products-list">
        <div class="row">
              <form class="form-horizontal" role="form" method="post" action="<?php echo base_url()?>site/agent/check_login"> 
                        <div class="col-md-6 col-sm-6">
                          <div class="run-customer">
                            <h5>
                             Đăng nhập hệ thống
                            </h5>
                            <form>
                              <div class="form-row">
                                <label class="lebel-abs">
                                  Email 
                                  <strong class="red">
                                    *
                                  </strong>
                                </label>
                                <input type="text" class="input namefild" name="email">
                              </div>
                              <div class="form-row">
                                <label class="lebel-abs">
                                  Mật khẩu
                                  <strong class="red">
                                    *
                                  </strong>
                                </label>
                                  <input type="password" class="input namefild" name="password">
                              </div>
                              <p class="forgoten">
                                <a href="#">
                                  Chưa có tài khoản hãy đăng ký?
                                </a>
                              </p>
                              <button type="submit">
                                Đăng nhập
                              </button>
                          </div>
                        </div>
                       </form>
                      </div>
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
                        <img src="<?php echo base_url()?>images/envato.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/themeforest.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/photodune.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/activeden.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/envato.png" alt="">
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
                        <img src="<?php echo base_url()?>images/envato.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/themeforest.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/photodune.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/activeden.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/envato.png" alt="">
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
<?php }?>
<script>
$(document).ready(function(){
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
                minlength: 6, 
            },
            
          
            
        }, 
        messages: { 
            email: { 
                required: "Email cần nhập", 
                email:"Địa chỉ email không hợp lệ"
            },
            password: { 
                required: "Mật khẩu cần nhập", 
                minlength:"Mật khẩu ít nhất là 6 ký tự"
            },
            
           
        }
    }); 
})
</script>  