 <?php
                    $item_id = $this->uri->segment(4);
                    unset($_SESSION['cart'][$item_id]);
                    redirect(base_url().'gio-hang.html');
                    