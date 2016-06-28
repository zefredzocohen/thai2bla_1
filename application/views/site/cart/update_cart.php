<?php
  foreach($_POST['number'] as $key=>$value)
    {
        $_SESSION['cart'][$key]['soluong'] = $value;
    }
   redirect(base_url().'gio-hang.html');