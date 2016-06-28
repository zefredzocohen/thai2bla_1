<?php
if ($num_rows > 0) {
    foreach ($sms_history as $sh) {
        echo "<tr>";
            echo "<td style='text-align: center;'>" . $sh['id'] . "</td>";
            echo "<td style='text-align: center;'>" . date("d-m-Y H:i:s",strtotime($sh['date_send'])) . "</td>";
            echo "<td style='text-align: center;'>" . $sh['mobile'] . "</td>";
            echo "<td>".$sh['content_message']."</td>";
            echo "<td>";
                if($sh['equals'] > 0){
                    echo "Gửi thành công";
                }elseif($sh['equals'] == -1){
                    echo "Tên đăng nhập hoặc mật khẩu không hợp lệ";
                }elseif($sh['equals'] == -2){
                    echo "NOT_ENOUGHCREDITS";
                }elseif($sh['equals'] == -3){
                    echo "Mạng điện thoại không được hỗ trợ";
                }elseif($sh['equals'] == -4){
                    echo "Địa chỉ IP của khách hàng không được cho phép";
                }elseif($sh['equals'] == -7){
                    echo "Độ dài của tin nhắn không quá 459 kí tự";
                }elseif($sh['equals'] == -8){
                    echo "Hai tin nhắn trong 1 ngày (dest_addr+message)";
                }elseif($sh['equals'] == -9){
                    echo "Brandname chưa đăng ký";
                }elseif($sh['equals'] == -10){
                    echo "Số điện thoại trong danh sách đen của chủ sở hữu hoặc Công ty viễn thông";
                }elseif($sh['equals'] == -13){
                    echo "Số điện thoại sai định dạng";
                }elseif($sh['equals'] == -16){
                    echo "Mẫu tin nhắn chưa được đăng ký";
                }elseif($sh['equals'] == -17){
                    echo "Ký tự không được hỗ trợ trong nội dung tin nhắn";
                }elseif($sh['equals'] == -18){
                    echo "Không đủ tin nhắn";
                }elseif($sh['equals'] == -19){
                    echo "Không đủ tiền";
                }elseif($sh['equals'] == -99){
                    echo "Ngoại lệ";
                }else{
                    echo "No more";
                }
            echo "</td>";
        echo "</tr>";
    }   
}
if ($num_rows == $resultsPerPage) {
    $loadpage = $paged + 1;
    echo "<tr class='loadbutton6'><td colspan = '5'><div class='loadmore7' data-page='" . $loadpage . "'>Xem thêm</div></td></tr>";
}
?>
