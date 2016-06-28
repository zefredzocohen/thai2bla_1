<ul id="gn-menu-header" class="gn-menu-main-header" style="z-index:11 !important " >
    <li class="gn-trigger-header">
        <a class="gn-icon gn-icon-menu" ></a>
        <nav class="gn-menu-wrapper new-class" style="top: 146px !important; z-index:11">
            <!-- <div class="gn-scroller"> -->
            <ul class="gn-menu">
                <?php
                $i = 0;
                foreach ($allowed_modules_header->result() as $module) {
                    ?>
                    <li>
                        <a href="<?php echo site_url($module->module_id); ?>">
                            <?php echo lang("module_" . $module->module_id) ?>
                        </a> 
                    </li>
                    <?php
                    $i++;
                    if ($i == 16)
                        break;
                }
                ?>                                          
            </ul>
            <!-- </div> /gn-scroller -->
        </nav>
    </li>
    <li></li>
</ul>
<ul id="gn-menu" class="gn-menu-main" style="z-index:10 !important ">
    <li class="gn-trigger">
        <a class="gn-icon gn-icon-menu" ><span>Menu</span></a>
        <nav class="gn-menu-wrapper">
            <!-- <div class="gn-scroller"> -->
            <ul class="gn-menu">
                <?php
                foreach ($allowed_modules->result() as $module) {
                    ?>
                    <li><a href="<?php echo site_url("$module->module_id"); ?>"><?php echo lang("module_" . $module->module_id) ?></a></li>  
                <?php } ?>               
            </ul>
            <!-- </div> /gn-scroller -->
        </nav>
    </li>
    <li></li>
</ul>
