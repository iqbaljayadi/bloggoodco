<div class="my_meta_control td-not-portfolio td-not-home">
	
        <p class="td_help_section "> 
            <span class="td_custom_label">Custom sidebar:</span>
            <?php $mb->the_field('td_sidebar'); ?>
            <select name="<?php $mb->the_name(); ?>">
                    <option value="">Default sidebar</option>
                    <?php 
                    $currentSidebars = td_get_option('sidebars'); //read the sidebars


                    foreach ($currentSidebars as $sidebar) {
                        ?>
                            <option value="<?php echo $sidebar?>"<?php $mb->the_select_state($sidebar); ?>><?php echo $sidebar?></option>
                        <?php
                    }
                    ?>
            </select>
            
             - <a href="admin.php?page=td_theme_sidebars">manage sidebars</a>
             
        </p>


        <p class="td_help_section ">
            <span class="td_custom_label">Primary category:</span>
            <?php $mb->the_field('td_primary_cat'); ?>
            <select name="<?php $mb->the_name(); ?>">
                <option value="">Auto select a category</option>
                <?php
                $td_current_categories = td_get_category2id_array(false);

                //print_r($td_current_categories);
                //die;
                foreach ($td_current_categories as $td_category => $td_category_id) {
                    ?>
                    <option value="<?php echo $td_category_id?>"<?php $mb->the_select_state($td_category_id); ?>><?php echo $td_category?></option>
                <?php
                }
                ?>
            </select>

            <span class="td_info_inline"> - If the posts has multiple categories, the one selected here will show up in blocks.</span>

        </p>


        
        <p class="td_help_section"> 
            <?php $mb->the_field('td_source'); ?>
            <span class="td_custom_label">Source name:</span>
            <input style="width: 200px;" type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
            <span class="td_info_inline"> - name of the source</span> 
        </p>
        
        <p class="td_help_section"> 
            <?php $mb->the_field('td_source_url'); ?>
            <span class="td_custom_label">Source url:</span>
            <input style="width: 200px;" type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
            <span class="td_info_inline"> - url to the source</span> 
        </p>
        
        <p class="td_help_section"> 
            <?php $mb->the_field('td_via'); ?>
            <span class="td_custom_label">Via name:</span>
            <input style="width: 200px;" type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
          
        </p>
        
        
        <p class="td_help_section"> 
            <?php $mb->the_field('td_via_url'); ?>
            <span class="td_custom_label">Via url:</span>
            <input style="width: 200px;" type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
        </p>

</div>


