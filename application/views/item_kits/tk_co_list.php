            <option value="">Chọn tài khoản có</option>
            <?php
            foreach ($list_tk_co as $parent1){?>
                <option value="<?=$parent1['id']?>" <?= $tk_co == $parent1['id'] ? 'selected' : '' ?> >
                    <?= $parent1['id'].' - '.$parent1['name'] ?>
                </option>
                <?php
                $parents2 = $this->Tkdu->get_all_tk2_by_tk1($parent1['id'])->result();
                foreach ($parents2 as $parent2){?>
                    <option value="<?=$parent2->id?>" <?= $parent2->id == $tk_co ? 'selected' : '' ?> >
                        <?= '---- '.$parent2->id.' - '.$parent2->name ?>
                    </option>
                    <?php 
                    $parents3 = $this->Tkdu->get_all_tk2_by_tk1($parent2->id)->result();
                    foreach ($parents3 as $parent3){?>
                        <option value="<?=$parent3->id?>" <?= $parent3->id == $tk_co ? 'selected' : '' ?> >
                            <?= '----.---- '.$parent3->id.' - '.$parent3->name ?>
                        </option>
                        <?php
                    }
                }
            }?>
