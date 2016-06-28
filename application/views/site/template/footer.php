<!-- Footer -->
<script type="text/javascript" src="https://secure.skypeassets.com/i/scom/js/skype-uri.js"></script>
    <div id="footer" class="container-fluid">
        <div class="container">
            <div class="adress-info col-xs-12" id="mAdress">
                <p><img src="<?php echo base_url() ?>images/thai2bala/map.png"><span class="text-uppercase"><strong>Tìm chúng tôi ở đâu ?</strong></span></p>
                <span><strong>140/106 Ladphrao 108, wang thong lang, bangkok, thai lan</strong></span><br>
                   
                     <?php  foreach ($this->Create_invetory->get_all()->result() as $row) { ?>
                <span> <?php  echo $row->name_inventory; ?>  |</span>
     <?php   }?>
               
                       <!-- 
                <span>154 Ô Chợ Dừa - Đống Đa - Hà Nội</span> | <span>33 Cầu Giấy</span> | <span>34B Trần Nhân Tông</span>
                       -->
            </div>
            <div class="text-center col-lg-12 col-md-12 col-sm-12 col-xs-12">   
                <ul class="list-inline text-uppercase">
                    <li><a href="<?php echo base_url();?>"><span>Trang chủ</span></a></li>
                    <li class="icon-bullet"></li>
                    <li><a href="<?php echo base_url();?>thuc-don.html"><span>Thực đơn</span></a></li>
                    <li class="icon-bullet"></li>
                    <li><a href="<?php echo base_url();?>tin-tuc.html"><span>tin tức - sự kiện</span></a></li>
                    <li class="icon-bullet"></li>
                    <li><a href="<?php echo base_url();?>gioi-thieu.html"><span>về chúng tôi</span></a></li>
                </ul>       
            </div>
           
            <hr class="link-footer">
            <div class="bottom-footer col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="logo-footer col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                    <img src="<?php echo base_url() ?>images/thai2bala/logo-footer.png">
                    <span class="copyright"style="color: #6e1f60;" >Copyright © 2015 Thai2bla.com.<span style="color: #1CB7EB;">Designed by<span><a href="http://lifetek.com.vn" style="color: #1CB7EB;     font-family: arial;     font-size: 12px;"> LifeTek</a> </span>
                </div>
                <div class="adress-info col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <p><img src="<?php echo base_url() ?>images/thai2bala/map.png"><span class="text-uppercase"><strong>Tìm chúng tôi ở đâu ?</strong></span></p>
                    <span><strong>140/106 Ladphrao 108, wang thong lang, bangkok, thai lan</strong></span><br>
                       <?php  foreach ($this->Create_invetory->get_all()->result() as $row) { ?>
                <span> <?php  echo $row->name_inventory; ?>  |</span>
     <?php   }?>
               
                     <!--<span>154 Ô Chợ Dừa - Đống Đa - Hà Nội</span> | <span>33 Cầu Giấy</span> | <span>34B Trần Nhân Tông</span>
                   -->
                </div>
            </div>
        </div>
        <div class="pull-right footer-right col-lg-4 col-md-5 hidden-sm hidden-xs">
            <div class="text-right chon-mon-img"><a href="#"><img src="<?php echo base_url() ?>images/upload/chon-mon.png"  class="img-responsive"></a></div>
            <div class="text-right social" style="position:relative; top:70px;">
              <?php foreach ($socials as $social):  ?>
                 <a href="<?php echo $social->url; ?>"><span class="<?php echo $social->name; ?>"></span></a> 
              <?php endforeach; ?>
                    <div id="SkypeButton_Call_nhungthuy_1" class="text-right social" style="position:relative; left:50px;">
                     <script type="text/javascript">
                     Skype.ui({
                     "name": "call",
                     "element": "SkypeButton_Call_nhungthuy_1",
                     "participants": ["nhungthuy"],
                     "imageSize": 32
                     });
                     </script>
                    </div>
            </div>
        </div>
    </div>
    <div id="mFooter" class="container-fluid">
        <div class="container">
            <div class="adress-info text-center col-xs-12" id="mAdress">
                <p><img src="<?php echo base_url() ?>images/thai2bala/map.png"><span class="text-uppercase"><strong>Tìm chúng tôi ở đâu ?</strong></span></p>
                <span><strong>140/106 Ladphrao 108, wang thong lang, bangkok, thai lan</strong></span>
                <?php  foreach ($this->Create_invetory->get_all()->result() as $row) { ?>
                <span> <?php  echo $row->name_inventory; ?>  |</span>
     <?php   }?>
               
<!-- <span>154 Ô Chợ Dừa - Đống Đa - Hà Nội</span><span>33 Cầu Giấy</span><span>34B Trần Nhân Tông</span> -->
            </div>
            <div class="logo-footer text-left">
                <a href="<?php echo base_url() ?>"><img src="<?php echo base_url() ?>images/thai2bala/logo-footer.png" class="img-responsive"></a>
            </div>
            <div class="text-center col-lg-12 col-md-12 col-sm-12 col-xs-12">   
                <ul class="list-inline text-uppercase col-xs-12">
                    <li class="col-xs-12">
                        <a href="<?php echo base_url() ?>" class="col-xs-5"><span>Trang chủ</span></a>
                        <span class="icon-bullet col-xs-2"></span>
                        <a href="<?php echo base_url() ?>thuc-don.html" class="col-xs-5"><span>Thực đơn</span></a>
                    </li>
                    <li class="col-xs-12">
                        <a href="<?php echo base_url() ?>tin-tuc.html" class="col-xs-5"><span>tin tức - sự kiện</span></a>
                        <span class="icon-bullet col-xs-2"></span>
                        <a href="<?php echo base_url() ?>gioi-thieu.html" class="col-xs-5"><span>về chúng tôi</span></a>
                    </li>
                </ul>       
            </div>
            <hr class="link-footer">
            <div class="logo-footer col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center">
                <span class="copyright" style="color: #6e1f60;">Copyright © 2015 Thai2bla.com.<span style="color: #1CB7EB;">Designed by<span> <a href="http://lifetek.com.vn" style="color: #1CB7EB;     font-family: arial;     font-size: 12px;"> LifeTek</a></span>
                
                
            </div>
        </div>
        <div class="pull-right footer-right col-lg-4 col-md-5 col-sm-5 col-xs-5 ">
            <div class="text-right chon-mon-img"><a href="#"><img src="<?php echo base_url() ?>images/upload/chon-mon.png" class="img-responsive"></a></div>
            <div class="text-right social">
                  <?php foreach ($socials as $social):  ?>
                     <a href="<?php echo $social->url; ?>"><span class="<?php echo $social->name; ?>"></span></a> 
                  <?php endforeach; ?>
            </div>
        </div>
    </div>       
</body>
</html>