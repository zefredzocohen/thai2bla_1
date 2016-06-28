<?php
echo form_open('reports/save');
?>
<input type="text" name="noidung" placeholder="Nội dung" required="required" />
<input type="number" name="chiphi" placeholder="Chi phí" required="required" />
<input type="text" name="personid" value="<?php echo $person_id; ?>" />
<input type="submit" />
<?php echo form_close(); ?>