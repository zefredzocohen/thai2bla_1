<select name="employees_id" style="width: 150px" class="employees_id"  onchange="getEmployees();" >
    <?php foreach ($employees_info AS $key => $values){ ?>
        <option value="<?php echo $values->person_id ; ?>"><?php echo $values->first_name ?></option>
    <?php } ?>
</select>