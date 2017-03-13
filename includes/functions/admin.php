<?php 

add_action('admin_menu', 'simple_theme_page'); 
function simple_theme_page (){ 
$action=$_POST['action'];


if ( count($_POST) > 0 && isset($_POST['settings_action']) ){

	foreach($_POST as $key=>$value){
		
		$Keys = array ($key); 
		foreach ( $Keys as $Key ){
			delete_option ($Key, $_POST[$key]);
			add_option($Key, $_POST[$key]);
		}
	}
	if($_POST['settings_action']=='save'){
		header("location:".'admin.php?page=themes-settings');
	}else{		
		header("location:".'admin.php?page=themes-settings&action='.$_POST['settings_action'].'');
	}
}

add_menu_page(__('Setting Page'), __('Setting Page'), 'edit_themes','themes-settings', 'simple_settings'); 
} 

// simple_settings
function simple_settings(){ 
?>
<link rel="stylesheet" href="<?php echo get_bloginfo("template_url");?>/css/public/reset.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo get_bloginfo("template_url");?>/css/public/bootstrap.min.css" type="text/css" media="screen" />
<!-- <link rel="stylesheet" href="<?php echo get_bloginfo("template_url");?>/css/public/bootstrap-theme.min.css" type="text/css" media="screen" /> -->
<link rel="stylesheet" href="<?php echo get_bloginfo("template_url");?>/css/public/font-awesome.min.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo get_bloginfo("template_url");?>/css/theme-option.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo get_bloginfo("template_url");?>/js/public/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="<?php echo get_bloginfo("template_url");?>/js/public/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo get_bloginfo("template_url");?>/js/public/laydate/laydate.js"></script>
<!-- <script type="text/javascript" src="<?php echo get_bloginfo("template_url");?>/js/public/jquery.scrollTo.js"></script> -->
<script type="text/javascript" src="<?php echo get_bloginfo("template_url");?>/js/theme-option.js"></script>


<!-- Wrap_bg -->
<div class="Wrap_bg">
<div id="Wrap">

<div id="AdminHead" class="clearfix">
  <h2 class="AdminHead_h2">Setting Page</h2>
</div>


<!--AdminTabs-->
<div id="AdminTabs" class="clearfix">
 <?php
$action=$_GET['action'];
$gamenum=$_GET['gamenum'];
?>
 <!--TabMenu-->
 <div id="TabMenu">
  <ul>
   <li <?php if($action==''){?> class="in"<?php } ?>><a href="admin.php?page=themes-settings"><span><i class="icon-cogs"></i>  Logo</span></a></li>
   <!-- <li <?php if($action=='home'){?> class="in"<?php } ?>><a href="admin.php?page=themes-settings&action=home"><span><i class="icon-home"></i>  </span></a></li> -->
   <li <?php if($action=='seo'){?> class="in"<?php } ?>><a href="admin.php?page=themes-settings&action=seo"><span><i class="icon-search"></i>  SEO TKD</span></a></li>
   <li <?php if($action=='code'){?> class="in"<?php } ?>><a href="admin.php?page=themes-settings&action=code"><span><i class="icon-list-alt"></i>  General</span></a></li>
   <li <?php if($action=='other'){?> class="in"<?php } ?>><a href="admin.php?page=themes-settings&action=other"><span><i class="icon-desktop"></i>  Others</span></a></li>
   <!-- <li <?php if($action=='share'){?> class="in"<?php } ?>><a href="admin.php?page=themes-settings&action=share"><span><i class="icon-share"></i> </span></a></li> -->
  </ul>
 </div>
 <!--/TabMenu-->
 
 <!--TabContent-->
 <div id="TabContent">
  <div id="Settings">
   <form method="post" action="">
    






    <?php //=================================[ Logo ]=================================//  ?>
    <?php if($action==''){?>
    <div class="form_box">
     <table width="100%" border="0" cellspacing="0" cellpadding="2" class="form_table">
      <tr>
       <td class="fb_tdL">&nbsp;</td>
       <td class="fb_tdR"><h2>Logo <small>click <kbd>Upload</kbd></small></h2></td>
      </tr>
      <tr>
       <td class="fb_tdL">Logo：</td>
       <td class="fb_tdR">
         <div class="uploads_image">
           <div class="uploads_image_input clearfix">
             <input name="logo" id="logo" type="text" value="<?php echo stripslashes(get_option('logo')); ?>" size="20" class="form-control w300 f_l" >
             <a class="btn btn-success uploads_button f_l">upload</a>
             <a class="btn btn-danger uploads_del f_l">Delete</a>
           </div>
           <div class="uploads_image_show<?php if(!stripslashes(get_option('logo'))){ echo ' none';}; ?>"><img src="<?php echo stripslashes(get_option('logo')); ?>" class="w200"></div>
         </div>         
       </td>
      </tr>
      <tr>
       <td class="fb_tdL">Favicon：</td>
       <td class="fb_tdR">
         <div class="uploads_image">
           <div class="uploads_image_input clearfix">
             <input name="favicon" id="favicon" type="text" value="<?php echo stripslashes(get_option('favicon')); ?>" size="20" class="form-control w300 f_l" >
             <a class="btn btn-success uploads_button f_l">Upload</a>
             <a class="btn btn-danger uploads_del f_l">Delete</a>
           </div>
           <div class="uploads_image_show<?php if(!stripslashes(get_option('favicon'))){ echo ' none';}; ?>"><img src="<?php echo stripslashes(get_option('favicon')); ?>" class="w200"></div>
         </div>         
       </td>
      </tr>
      <tr>
       <td class="fb_tdL">Login Logo：</td>
       <td class="fb_tdR">
         <div class="uploads_image">
           <div class="uploads_image_input clearfix">
             <input name="login_logo" id="login_logo" type="text" value="<?php if(stripslashes(get_option('login_logo'))){echo stripslashes(get_option('login_logo'));}else{echo get_bloginfo("template_url").'/images/login-logo.png';} ?>" size="20" class="form-control w300 f_l" >
             <a class="btn btn-success uploads_button f_l">Upload</a>
             <a class="btn btn-danger uploads_del f_l">Delete</a>
           </div>
           <div class="uploads_image_show"><img src="<?php if(stripslashes(get_option('login_logo'))){echo stripslashes(get_option('login_logo'));}else{echo get_bloginfo("template_url").'/images/login-logo.png';} ?>" class="w200"></div>
         </div>         
       </td>
      </tr>





     </table>
    </div>

    <button type="submit" name="Submit" class="settings_submit"><i class="icon-repeat"></i> Save</button>
    <input type="hidden" name="settings_action" value="save" style="display:none;" />


    
    
    <div style="width:0px; display:none;">
    <?php wp_editor(stripslashes(get_option('1111111111111')), 1111111111111, $settings = array(
    quicktags=>1,
    tinymce=>1,
    media_buttons=>1,
    textarea_rows=>6,
    editor_class=>"textareastyle"
    ) ); ?>
    </div>
    <br class="clearBoth" />
    <?php } ?>
   

   


    <?php //=================================[ SEO ]=================================//  ?>
    <?php if($action=='seo'){?>
    <div class="form_box">
     <table width="100%" border="0" cellspacing="0" cellpadding="2" class="form_table">
      <tr>
       <td class="fb_tdL">&nbsp;</td>
      </tr>
      <tr>
       <td class="fb_tdL">Title：</td>
       <td class="fb_tdR"><input name="blogname" type="text" id="blogname" value="<?php echo stripslashes(get_option('blogname')); ?>" class="form-control wb70"></td>
      </tr>
      <tr>
       <td class="fb_tdL">Subtitle：</td>
       <td class="fb_tdR">
          <input name="blogdescription" type="text" id="blogdescription" value="<?php echo stripslashes(get_option('blogdescription')); ?>" class="form-control wb70">
       </td>
      </tr>
      <tr>
       <td class="fb_tdL">Keyword：</td>
       <td class="fb_tdR"><textarea name="S_Keyword" class="form-control wb70" id="S_Keyword"><?php echo stripslashes(get_option('S_Keyword')); ?></textarea>
       </td>
      </tr>
      <tr>
       <td class="fb_tdL">Description：</td>
       <td class="fb_tdR"><textarea name="S_Description" class="form-control wb70" id="S_Description"><?php echo stripslashes(get_option('S_Description')); ?></textarea></td>
      </tr>
      <tr>
       <td class="fb_tdL">Copy：</td>
       <td class="fb_tdR"><textarea name="S_Copy" class="form-control wb70" id="S_Copy"><?php echo stripslashes(get_option('S_Copy')); ?></textarea>
       </td>
      </tr>
     </table>
    </div>

    <button type="submit" name="Submit" class="settings_submit"><i class="icon-repeat"></i> Save</button>
    <input type="hidden" name="settings_action" value="seo" style="display:none;" />

    <br class="clearBoth" />
    <?php } ?>


    <?php //=================================[ other ]=================================//  ?>
    <?php if($action=='other'){?>
    <div class="form_box">
     <table width="100%" border="0" cellspacing="0" cellpadding="2" class="form_table">
      <tr>
       <td class="fb_tdL">&nbsp;</td>
       <td class="fb_tdR"><h2>Others <small></small></h2></td>
      </tr>

      <tr>
       <td class="fb_tdL">Share：<br/><small style="color:#999;"></small></td>
       <td class="fb_tdR">
          <div class="radio">
            <label><input type="radio" name="share_grey" id="share_grey" value="1"<?php if(stripslashes(get_option('share_grey'))==1){ echo '  checked="checked"';}; ?>> On</label>
            <label><input type="radio" name="share_grey" id="share_grey" value="0"<?php if(stripslashes(get_option('share_grey'))!=1){ echo '  checked="checked"';}; ?>> Off</label>
          </div>
       </td>
      </tr>

      <tr>
       <td class="fb_tdL">Grey-Style：<br/><small style="color:#999;"></small></td>
       <td class="fb_tdR">
          <div class="radio">
            <label><input type="radio" name="filter_grey" id="filter_grey" value="1"<?php if(stripslashes(get_option('filter_grey'))==1){ echo '  checked="checked"';}; ?>> On</label>
            <label><input type="radio" name="filter_grey" id="filter_grey" value="0"<?php if(stripslashes(get_option('filter_grey'))!=1){ echo '  checked="checked"';}; ?>> Off</label>
          </div>
       </td>
      </tr>

     </table>
    </div>

    <button type="submit" name="Submit" class="settings_submit"><i class="icon-repeat"></i> Save</button>
    <input type="hidden" name="settings_action" value="other" style="display:none;" />

    <br class="clearBoth" />
    <?php } ?>
   </form>
  </div>
 </div>

</div>
</div>
</div>
<!-- /Wrap_bg -->
<?php } //simple_settings ?>
