<div style="float:left; width: 100%">

    <fieldset id="item_basic_info">
        <legend><h4 style="color:red;">Thông tin cá nhân</h4></legend>
        <div id="fist_info" style="margin-top: 10px;float: left">
            <p><label class="required" style="width: 115px;">Mã nhân viên : </label>
                <?php echo form_input(array(
                    'name'=>'id_employees',
                    'id'=>'id_employees',
                    'value'=>$person_info->emp_code
                ));
                ?>
            </p>
            <p>
                <label class="required" style="width: 115px;">Họ nhân viên : </label>
                <?php echo form_input(array(
                    'name'=>'first_name',
                    'id'=>'first_name',
                    'value'=>$person_info->first_name
                ));?>
            </p>    
            <p>
                <label class="required" style="width: 115px;">Tên nhân viên : </label>
                <?php echo form_input(array(
                    'name'=>'last_name',
                    'id'=>'last_name',
                    'value'=>$person_info->last_name
                ));?>
            </p>
            
            <p>
                <label class="field">Ngày sinh : </label>
                <?php
                echo form_input(array(
                        'name'=>'birth_date',
                        'id'=>'birth_date',
                        'value'=>$person_info->birth_date != '1950-01-01' ? date(get_date_format(),strtotime($person_info->birth_date != '' ? $person_info->birth_date: date('d-m-Y'))):''
                    )
                )
                ;?>
            </p>
            <p><label class="field">Email : </label>
                <?php
                    echo form_input(array(
                    'name'=>'email',
                    'id'=>'email',
                    'value'=>$person_info->email
                ));?>
            </p>
            <p><label class="field">Số CMTND : </label>
                <?php echo form_input(array(
                    'name'=>'identity_card',
                    'id'=>'identity_card',
                    'value'=>$person_info->identity_card))
                ;?>
            </p>
        </div>

        <div id="second_info" style="margin: 10px 0 0 30px ;float: left">
            <p>
                <label class="field" >Ngày cấp :</label>
                <?php
                echo form_input(array(
                        'name'=>'date_identity_card',
                        'id'=>'date_identity_card',
                        'value'=>$person_info->date_identity_card != '1950-01-01'?date(get_date_format(),strtotime($person_info->em_ngaycapcmt != ''?$person_info->em_ngaycapcmt: date('d-m-Y'))):''
                    )
                )
                ;?>
            </p>
            <p><label class="field">Địa chỉ : </label>
                <?php echo form_input(array(
                    'name'=>'address_1',
                    'id'=>'address_1',
                    'value'=>$person_info->address_1));?>
            </p>
            <p><label class="field">Thành phố : </label>

                <select name="city">
                    <?php $this->load->model('City');
                    $city = $this->City->get_all1();
                    if($city != null){
                        foreach($city as $citys){ ?>
                            <?php if($person_info->city == $citys['id_city']){ ?>
                                <option value="<?php echo $citys['id_city']; ?>" selected="selected"><?php echo $citys['name']; ?></option>
                            <?php }else{ ?>
                                <option value="<?php echo $citys['id_city']; ?>"><?php echo $citys['name']; ?></option>
                            <?php }}} ?>
                </select>
            </p>
            <p><label class="field" >Điện thoại : </label>
                <?php echo form_input(array(
                    'name'=>'phone_number',
                    'id'=>'phone_number',
                    'value'=>$person_info->phone_number));?>
            </p>
            <p><label class="field">Dân tộc : </label>
                <?php echo form_input(array(
                    'name'=>'name_nation',
                    'id'=>'name_nation',
                    'value'=>$person_info->name_nation
                ));?>
            </p>

        </div>
        <div id="thirt_info" style="margin-top: 10px;float: left">
            <p><label class="field">Học vấn : </label>
                <select name="id_education">
                    <?php
                    if($hocvan != null){
                        foreach($hocvan as $educations){ ?>
                            <?php if($person_info->id_education == $educations['id']){ ?>
                                <option value="<?php echo $educations['id']; ?>" selected="selected"><?php echo $educations['name_education']; ?></option>
                            <?php }else{ ?>
                                <option value="<?php echo $educations['id']; ?>"><?php echo $educations['name_education']; ?></option>
                            <?php
                            }
                        }
                    } ?>
                </select>
            </p>
            <p><label class="field">Bằng cấp : </label>
                <select  name="id_diplomas">
                    <?php
                    if($bangcap != null){
                        foreach($bangcap as $bangcaps){ ?>
                            <?php if($person_info->id_diplomas == $bangcaps['id_bangcap']){ ?>
                                <option value="<?php echo $bangcaps['id_bangcap']; ?>" selected="selected"><?php echo $bangcaps['nam_bangcap']; ?></option>
                            <?php }else{ ?>
                                <option value="<?php echo $bangcaps['id_bangcap']; ?>"><?php echo $bangcaps['nam_bangcap']; ?></option>
                            <?php
                            }
                        }
                    } ?>

                </select>
            </p>
            <p><label class="field">Ngoại ngữ : </label>
                <select name="id_language">
                    <?php
                    if($language != null){
                        foreach($language as $languages){ ?>
                            <?php if($person_info->id_language == $languages['id_language']){ ?>
                                <option value="<?php echo $languages['id_language']; ?>" selected="selected"><?php echo $languages['name_language']; ?></option>
                            <?php }else{ ?>
                                <option value="<?php echo $languages['id_language']; ?>"><?php echo $languages['name_language']; ?></option>
                            <?php }}} ?>

                </select>
            </p>
            <p><label class="field">Tin học : </label>
                <select  name="id_informatics">
                    <?php
                    if($tinhoc != null){
                        foreach($tinhoc as $tinhocs){ ?>
                            <?php if($person_info->id_informatics == $tinhocs['id_tinhoc']){ ?>
                                <option value="<?php echo $tinhocs['id_tinhoc']; ?>" selected="selected"><?php echo $tinhocs['chungchi_tinhoc']; ?></option>
                            <?php }else{ ?>
                                <option value="<?php echo $tinhocs['id_tinhoc']; ?>"><?php echo $tinhocs['chungchi_tinhoc']; ?></option>
                            <?php }}} ?>
                </select>
            </p>
            <p><label class="field">Quốc tịch : </label>
                <select  name="id_visa">
                    <?php
                    if($quoctich != null){
                        foreach($quoctich as $visas){ ?>
                            <?php if($person_info->id_visa == $visas['id_visa']){ ?>
                                <option value="<?php echo $visas['id_visa']; ?>" selected="selected"><?php echo $visas['name_visa']; ?></option>
                            <?php }else{ ?>
                                <option value="<?php echo $visas['id_visa']; ?>"><?php echo $visas['name_visa']; ?></option>
                            <?php
                            }
                        }
                    } ?>
                </select>
            </p>
            <input type="hidden" name="certify" id="certify" value="1">
        </div>
    </fieldset></div>