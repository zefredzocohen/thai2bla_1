<link href="<?php echo base_url() ?>css/thai2bala/jquery.fs.selecter.css" rel="stylesheet" />
<link href="<?php echo base_url() ?>css/thai2bala/Store.css" rel="stylesheet" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type='text/javascript' language=javascript charset="UTF-8">
  $(document).ready(function(){
    $("#submit").click(function(){
   
     alert("Gửi liên hệ thành công");
     // jQuey's submit function applied on form.
    });
  });
</script>
<!-- Content not select -->
<?php foreach ($inventories as $key => $inventorie) { 
  if ($key == 1) { ?>
  <div id="offset" style="display:none;" offsetx="<?php echo $inventorie->map_x ?>" offsety="<?php echo $inventorie->map_y ?>" zoom="16" ></div>
<?php }} ?>
  <!-- End not select -->

<div id="contact">
<div class="bgr-extra"></div>
<!-- CONTACT -->
  <div id="contact-call" class="container-fluid">
    <div class="container">
      <div class="contact-list col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <h3 class="text-center text-uppercase">danh bạ</h3>
        <div class="dot-line"></div>

        <div id="find-location" class="nav">
            <ul id="selectAdress" class="nav nav-tabs list-inline">
                <li class="province">

                    <select id="selectProvince" name="Province" url="">
                        <option value="0">Chọn tỉnh/thành phố</option>
                        <?php foreach( $this->Create_invetory->get_all_select()->result() as $inventorie) { ?>
                          <option value="<?php echo $inventorie->id_province ?>"><?php echo $inventorie->name_province ?></option>
                        <?php } ?>
                    </select>
                </li>
                <span class="caret" style="margin-top: 15px;"></span>
            </ul>
        </div>

        <div class="dot-line" style="margin-top: 25px;"></div>
        <div id="myTabContent" class="tab-content">
          <div role="tabpanel" class="tab-pane fade active in" id="dropdown1" style="overflow: auto;max-height: 270px;"> 
            
            
                        <div id="store-list" class="list-content">
                          <div id="va-accordion">
                              <div class="va-wrapper">
                                  <?php
                                    foreach ($this->Create_invetory->get_all()->result() as $inventorie) {
                                  ?>
                                  <div class="va-slice">
                                      <div class="location_item text-left"
                                              offsetx="<?php echo $inventorie->map_x; ?>"
                                              offsety="<?php echo $inventorie->map_y; ?>" 
                                              zoom="16">
                                          <p style="display: none;" class="province" data-province-id="<?php echo $inventorie->id_province ?>"><?php echo $inventorie->name_province ?></p>
                                          <p style="display: none;" class="district" data-district-id="<?php echo $inventorie->id_district ?>">Quận 9</p>
                                          <p><span class="i-map"></span><?php echo $inventorie->name_inventory; ?></p>
                                          <p><span class="i-skype"></span><?php echo $inventorie->description; ?></p>
                                      </div>
                                      <div class="dot-line"></div>
                                  </div>
                                  
                                  <?php } ?>      
                              </div>
                          </div>
                      </div>
          </div> 
        </div>
        <!-- end select adress -->
        <div class="text-center">
          <span class="call-center text-uppercase">hotline: 
                        <?php foreach ($hotline as $key => $hotlines) { 
                            if ($key == 0) {
                                echo $hotlines->phone;
                            }
                        } ?>
            </span>
        </div>

      </div>
      <div class="contact-maps col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <h3 class="text-uppercase">tìm thái2bla trên bản đồ</h3>
        <div class="dot-line"></div>
        <div class="maps" id="store-content-right">
          <!-- iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.3919357874615!2d105.84703031462922!3d21.01699809355623!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab8b84a47dc9%3A0x71139b0acc4589d3!2zQsOgIFRyaeG7h3UsIEjDoCBO4buZaSwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1451378155150" width="577" height="388" frameborder="0" style="border:0;display: inline;"></iframe-->
        

              <div id="content_store" class="stor-content">
                  <div id="bigmap">
                      <div id="map" data-icon="<?php echo base_url() ?>images/thai2bala/gg-location.png"></div>
                  </div>
              </div>

        </div>
        <!-- end -->

        <h3 class="timesheet text-uppercase">Hãy đến thái2bla từ 9h00" đến 23h00" mỗi ngày</h3>
      </div>
    </div>
  </div>
<!-- FORM CONTACT -->
  <div id="form-contact" class="container-fluid" style="min-height:300px;height:100%;background-color:#fff;"> 
    <div class="container"> 
      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="dot-line"></div>
        <h3 class="text-uppercase">Chúng tôi có làm bạn hài lòng ?</h3>
        <p class="text-right">
          Hãy chia sẻ với THÁI2BLA những
          điều bạn chưa vừa ý về chất lượng
          dịch vụ cũng như phục vụ của chúng tôi.
          <strong>THÁI2BLA luôn sẵn sàng lắng nghe
          và sẵn sàng thay đổi để làm vừa lòng
          Qúy khách</strong>. Sử dụng form bên cạnh để
          chia sẻ cùng THÁI2BLA.
        </p>
      </div>
      <?php echo form_open('site/default_home/save_abc',array('id'=>'feedback','class'=>'col-lg-8 col-md-8')); ?>
        <div class="col-lg-12 col-md-12 input-padding">
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
              <?php echo form_input(array('id' => 'dfullname', 'name' => 'dfullname','placeholder'=>'Họ tên (*)','class'=>'form-control')); ?>
            </div>
            <div class="form-group">
              <?php echo form_input(array('id' => 'dtitle', 'name' => 'dtitle','placeholder'=>'Tiêu đề (*)','class'=>'form-control')); ?>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
              <?php echo form_input(array('id' => 'dtel','type'=>'number', 'name' => 'dtel','placeholder'=>'Số điện thoại (*)','class'=>'form-control')); ?>
            </div>
            <div class="form-group">
              <?php echo form_input(array('id' => 'demail', 'name' => 'demail','placeholder'=>'Email (*)','class'=>'form-control')); ?>
            </div>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 input-padding">
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group text-left">
              <label class="control-label">Mã bảo mật</label> 
              <input type="pass" class="form-control" id="">
            </div>
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
              <img src="<?php echo base_url(); ?>images/thai2bala/capcha.png" class="img-responsive capcha-img">
            </div>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 input-padding">
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
              <textarea class="form-control" placeholder="Nội dung liên hệ......" name="dcontent" rows="5"></textarea>
            </div>
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group pull-left">
              <button type="submit" name="submit" id="submit" class="btn btn-default btn-contact text-uppercase add-cart">Gửi câu hỏi</button>
            </div>
          </div>
        </div>
      <?php echo form_close(); ?>
    </div>
  </div>
<!-- METHOD AROUND -->
  <div id="around" class="container-fluid">
    <div class="container">
      <div class="m-content col-lg-10 col-lg-offset-1">
        <div class="items-list col-lg-3 col-md-3 col-sm-12 col-xs-12">
          <span class="payment pull-left"></span>
          <h4 class="text-uppercase around-before">Thanh toán</h4>
          <span class="pull-left around-after">khi nhận hàng</span>
        </div>
        <div class="items-list col-lg-3 col-md-3 col-sm-12 col-xs-12">
          <span class="return-order pull-left"></span>
          <h4 class="text-uppercase around-before">Đổi trả</h4>
          <span class="pull-left around-after">trong 3 ngày</span>
        </div>
        <div class="items-list col-lg-3 col-md-3 col-sm-12 col-xs-12">
          <span class="to-shipping pull-left"></span>
          <h4 class="text-uppercase around-before">Vận chuyển</h4>
          <span class="pull-left around-after">toàn quốc</span>
        </div>
        <div class="items-list col-lg-3 col-md-3 col-sm-12 col-xs-12">
          <span class="cam-ket pull-left"></span>
          <h4 class="text-uppercase around-before">Cam kết</h4>
          <span class="pull-left around-after">hàng chính hãng</span>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    //Search
      document.onclick = function(event){
        var hasParent = false;
          for(var node = event.target; node != document.body; node = node.parentNode)
          {
            if(node.id == 'mSearch'){
              hasParent = true;
              break;
            }
          }
        if(hasParent){
          $(".mSearchbox").css("opacity", 1); 
        $("#mSearch .glyphicon").addClass('a_hover'); 
        // else
        //   $(".mSearchbox").css("opacity", 0); 
          $("body").click(function(e) {
              if (e.target.id == "mSearchboxs" || $(e.target).parents("#mSearchboxs").size()) { 
                  //alert("Inside div");
              } else { 
                 $(".mSearchbox").css("opacity", 0);               
              }
          })
        }
        else{$("#mSearch .glyphicon").removeClass('a_hover');}
          
      } 
  </script>
</div>
<SCRIPT src="<?php echo base_url(); ?>js/jquery.validate.min.js" type="text/javascript"></SCRIPT>
<script type="text/javascript">
    $(document).ready(function () {
      var validator = $("#feedback").validate({
            rules: {
                dfullname: "required",
                dtitle: "required",
                dtel: "required",
                demail: {
                    required: true,
                    demail: true
                },              
            },
            messages: {
                dfullname: "Cần nhập họ tên",
                dtitle: "Cần nhập tiêu đề",
                dtel : "Cần nhập số điện thoại",
                demail: {
                    required: "Cần nhập Email",
                    demail: "Địa chỉ email không hợp lệ"
                },                
            }
        });
    })
</script> 

<script type="text/javascript">
  var isBigOrder=false;
</script>  
<!-- script src="<?php echo base_url() ?>js/thai2bala/mapjs.js" type="text/javascript"></script -->
<script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false&libraries=places'></script>
<script src="<?php echo base_url() ?>js/thai2bala/jquery.vaccordion.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>js/thai2bala/LoadingLocationForSearch.js" type="text/javascript"></script>    
<script src="<?php echo base_url() ?>js/thai2bala/jquery.fs.selecter.js"></script>

<style type="text/css">
  input[type=number]::-webkit-inner-spin-button, 
  input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none; 
    margin: 0; 
  }
</style>