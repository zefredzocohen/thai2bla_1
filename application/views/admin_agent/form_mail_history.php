<style>
    table tr td{
        border-bottom: 1px solid #000000;
        padding: 5px 0px;
    }
    table tr:last-child td{
        border: none;
    }
</style>
<form action="" method="post" id="form_mail_history">
    <table>
        <tr>
            <td style="width: 15%;"><b>Tiêu đề:</b></td>
            <td><b><?php echo $mail_history['title']?></b></td>
        </tr>
        <tr>
            <td style="width: 15%;"><b>Nội dung:</b></td>
            <td><?php echo $mail_history['content']?></td>
        </tr>
        <?php
        if($mail_history['file']!=""){
        ?>
            <tr>
                <td style="width: 15%;"><b>File đính kèm:</b></td>              
                <td>
                    <a href="<?php echo site_url().'/sales/download_matarial?file='.$mail_history['file'];?>"><?php echo $mail_history['file']?></a>
                </td>
            </tr>
        <?php
        }
        ?>        
    </table>
</form>
<?php $this->load->view("partial/abouts"); ?>