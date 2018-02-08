<table>
    <?php
    foreach($map as $folder_key=>$folder_val)
    { ?>
    <tr>
        <td><?php echo $folder_key; ?></td>
                <td>
                     <!--Second Level-->
                    <ul>
                            <?php foreach($folder_val as $mvc_key=>$mvc_val) { ?>
                       
                            <li>
                                <?php echo (is_array($mvc_val))?$mvc_key:$mvc_val; ?>
                                 <!--Third Level Start-->
                                <ul style="margin-left:50px;">
                                    <?php foreach($mvc_val as $page_key=>$page_val){ ?>
                                    <li>
                                        <?php echo (is_array($page_val))?$page_key:$page_val; ?>
                                        <?php if(is_array($page_val) && count($page_val) > 0){ ?>
                                                <!--Fourth Level Start-->
                                                <ul style="margin-left:50px;">
                                                         <?php foreach($page_val as $page_level_key => $page_level_val) { ?>  
                                                                <li><?php echo (is_array($page_level_val))?$page_level_key:$page_level_val; ?></li>
                                                         <?php } ?>
                                                </ul>
                                                <!--Fourth Level End-->
                                        <?php } ?>
                                    </li>
                                    
                                    <?php } ?>
                                </ul>
                                 <!--Third Level End-->
                            </li>     
                           
                            <?php } ?>
                   </ul>
                      <!--Second Level end-->
                    <hr/>
                </td>
                
    </tr>
    
<?php } ?>
</table>