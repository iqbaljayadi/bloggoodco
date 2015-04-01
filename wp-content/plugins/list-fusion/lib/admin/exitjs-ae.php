<h2 style="padding-bottom:10px; font-weight:bold;">
  <?php if(isset($_GET['id'])) { ?>
  Edit
  <?php } else { ?>
  Add New
  <?php } ?>
  Exit JS PopUp</h2>
  
<div style="padding:5px 0px 10px 0px;"> <a href="<?php echo $this->listfusion_page; ?>">
  <input name="" type="button" class="button button-primary"  value="<< Back To DashBoard" />
  </a> </div>
  
<div style="width:850px; margin:10px 0px 20px 0px; position:relative;">
  <div id="listfusion-nav">
    <ul>
      <li class="current" onclick="__listfusionSelectTab(1)"><a id="listfusionHead-1"><strong>Exit Js PopUp</strong></a></li>
    </ul>
  </div>
  <div class="listfusion-content">
    <div class="listfusion-section">
	
      <!--Start Exit PopUp-->
      <h3 class="listfusion_heading"><span class="listfusion_stepIndicator listfusion_stepActive">1</span>&nbsp;&nbsp;Image preview </h3>
      <img src="<?php echo LIST_FUSION_LIBPATH ?>images/exit-popup/1.png" style="max-width:100%; border:none;" />&nbsp;&nbsp;
      <h3 class="listfusion_heading"><span class="listfusion_stepIndicator listfusion_stepActive">2</span>&nbsp;&nbsp;Template fields</h3>
      <form action="" method="post" name="exitJsPopUp" onsubmit="return __listfusion_JS_chckexitpopup('redirectURL','exitjspopupName'); ">
        <div style="display:block;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;"  id="listfusion_fields_show">
          <table class="<?php echo $this->list_fusion_replaceclassname; ?>">
            <tbody>
              <tr valign="top">
                <th width="20%">Redirect URL: </th>
                <td width="80%"><input id="redirectURL" name="listfusion[exitjspopup_redirectURL]" type="text" value="<?php echo $this->listfusionShow_placement_ejs_redirectURL; ?>" size="35px" class="regular-text" />
                  &nbsp;<span style="color:#FF0000">*</span> </td>
              </tr>
              <tr valign="top">
                <th scope="row">Exit popup message:</th>
                <td><textarea name="listfusion[exitjspopup_msg]" class="large-text code" rows="10" cols="55"><?php echo  ( $_GET['id'] ) ? $this->listfusionShow_placement_msg : '***************************************
 
 W A I T   B E F O R E   Y O U   G O !
 
  CLICK THE *CANCEL* BUTTON RIGHT NOW
     TO STAY ON THE CURRENT PAGE.
 
 I HAVE SOMETHING VERY SPECIAL FOR YOU!
 
***************************************'; ?></textarea>
                  <p><i><strong>WARNING</strong>: Do not include any HTML tags, Enter just plain text</i></p></td>
              </tr>
              <tr valign="top">
                <th width="20%">Exit js popup name:</th>
                <td width="80%"><input id="exitjspopupName" name="listfusion[exitjspopup_name]" type="text" value="<?php echo $this->listfusionShow_placement_name; ?>" size="35px" class="regular-text" style="width:200px;" />
                  <span style="color: #C4C4C4;">(Appears only to you)</span>&nbsp;<span style="color:#FF0000">*</span></td>
              </tr>
            </tbody>
          </table>
        </div>
        <h3 class="listfusion_heading"><span class="listfusion_stepIndicator listfusion_stepActive">3</span>&nbsp;<a onClick="__JS_listfustion_ShowHide('listfusion_exitjs_show', 'listfusion_exitjs_show_img', 2, '<?php echo LIST_FUSION_LIBPATH;?>');" style="cursor:hand;cursor:pointer; text-decoration:none;"> <img src="<?php echo LIST_FUSION_LIBPATH; ?>images/plus-small.gif" id="listfusion_exitjs_show_img" border="0" title="Click to collapse" align="top" />Where to show exit js popup?</a>&nbsp;&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"> <span style="color:#FF0000">Required</span> </h3>
        <div style="display:none;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;" id="listfusion_exitjs_show">
          <!--min-height: 42px; max-height: 250px; overflow: auto; padding: 0 .9em; border: solid 1px #dfdfdf; background-color: #fdfdfd;-->
          <br>
          <span style="color:#CC3300; font-size:12px;">WARNING: Choose different display location for your newly added records.</span>
          <?php 
$this->listfusion_page_list('display_in_all','display_in_front','display_in_home','display_in_post','display_in_archive','display_in_search','display_in_other','showOnPostWithID','dontShowOnPostWithID','display_catIn','display_in_cat','display_in_pageid','listfusion_showlist','display_listfusion_in_all',($this->listfusionShow_in_all?$this->listfusionShow_in_all:($_GET['id']?'':'checked')),$this->listfusionShow_in_home,$this->listfusionShow_in_front,$this->listfusionShow_in_post,$this->listfusionShow_in_arch,$this->listfusionShow_in_search,$this->listfusionShow_in_other,$this->listfusionShow_showOnPostWithID,$this->listfusionShow_dontShowOnPostWithID,$this->listfusionShow_display_in_pageid,$this->listfusionShow_display_catIn,$this->listfusionShow_display_in_cat,''); 
?>
        </div>
        <div style="padding-top:20px;">
          <input type="submit" class="button button-primary" value="Save" name="listfusion[process_exitjspopup_save]" />
        </div>
      </form>
	  
      <!--/Eof Exit Js PopUp-->
    </div>
  </div>
</div>

<div style="clear:both"></div>
<br>
