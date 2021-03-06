<?php
header("Content-type: text/html; charset=utf-8");
include("includes/functions/meta_boxes.php");
include("includes/functions/face.php");
include("includes/functions/admin.php");



remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
remove_action('wp_head', 'print_emoji_detection_script', 7 );
remove_action('admin_print_scripts', 'print_emoji_detection_script' );
remove_action('wp_print_styles', 'print_emoji_styles' );
remove_action('admin_print_styles', 'print_emoji_styles' );





// logo change
function custom_login_logo(){
  echo "<link rel='stylesheet' id='colors-fresh-css'  href='".get_bloginfo("template_url")."/css/admin_style.css' type='text/css' media='all' />";
  if(stripslashes(get_option('login_logo'))){
    echo "<style>.login h1 a{background:url(".stripslashes(get_option('login_logo')).") center bottom no-repeat;}</style>";
  }
  echo "<style>body.login{background:url(".stripslashes(get_option('login_bgpic')).") ".stripslashes(get_option('login_bgcolor'))." center no-repeat;}</style>";
  echo '<script type="text/javascript" src="'.get_bloginfo("template_url").'/js/public/jquery-1.11.2.min.js"></script><script type="text/javascript">$(document).ready(function() {$("#login h1 a").attr("href", "http://www.shejiwo.net/").attr("target", "_blank");});</script>';
}
add_action('login_head', 'custom_login_logo');


function forHtml($str){
	$returnstr=htmlspecialchars($str);
	$returnstr=str_replace(' ',' ',$returnstr);
	$returnstr=str_replace(chr(10),'<br/>',$returnstr);
	return($returnstr);
}




function my_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);
?>
    <li <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
    
    <!-- comment_loop -->
    <div id="div-comment-<?php comment_ID() ?>" class="comment_loop clearfix">
      
      <div class="comment_face"><?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, 64 ); ?></div>
      <!-- comment_right -->
      <div class="comment_right">
        <div class="comment_author"><?php printf(__('%s'), get_comment_author_link()); ?></div>
        <div class="comment_text"><?php comment_text(); ?></div>
        <?php if ($comment->comment_approved == '0') : ?>
        <div class="awaiting"><?php _e('Your comment is awaiting moderation.') ?></div>
        <?php endif; ?>
        <div class="comment_bottom clearfix">

          <div class="comment_time f_l"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php echo timeago( get_gmt_from_date(get_comment_time('Y-m-d G:i:s')) );?></a><?php edit_comment_link(__('(Edit)'),'  ','' ); ?></div>
          <div class="comment_reply f_r"><?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>

        </div>
        

      </div>
      <!-- /comment_right -->

    </div>
    <!-- /comment_loop -->
<?php
}



// Time
function timeago( $ptime ) {
    $ptime = strtotime($ptime);
    $etime = time() - $ptime;
    if ($etime < 1) return '1 sec ago';     
    $interval = array (         
        12 * 30 * 24 * 60 * 60  =>  'years ago ('.date('Y-m-d', $ptime).')',
        30 * 24 * 60 * 60       =>  'month ago ('.date('m-d', $ptime).')',
        7 * 24 * 60 * 60        =>  'weeks ago ('.date('m-d', $ptime).')',
        24 * 60 * 60            =>  'days ago',
        60 * 60                 =>  'hours ago',
        60                      =>  'min ago',
        1                       =>  'second ago'
    );
    foreach ($interval as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . $str;
        }
    };
}
 


function get_ssl_avatar($avatar) {
   $avatar = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)&.*/','<img src="https://secure.gravatar.com/avatar/$1?s=$2" class="avatar avatar-$2" height="$2" width="$2">',$avatar);
   return $avatar;
}
add_filter('get_avatar', 'get_ssl_avatar');



register_nav_menus(
	array(
    'header-menu' => __( 'Header Menu' ),
    'mobile-header-menu' => __( 'Mobil Header Menu' )
	)
);



//image
function post_thumbnail(){
    if(has_post_thumbnail()){
        the_post_thumbnail(array(250,250));
    } else {
        global $post, $posts;
        $post_img = '';
        ob_start();
        ob_end_clean();
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
        $post_img_src = $matches [1][0];
        $post_img = '<img src="'.$post_img_src.'" alt="" />';    //
        if(empty($post_img_src)){
            $post_img = '<img src="'.get_bloginfo("template_url").'/images/nopic.gif" alt="" />';
        }
        echo $post_img;
    }
}

function post_thumbnail_src(){
    global $post;
  if( $values = get_post_custom_values("thumb") ) {
    $values = get_post_custom_values("thumb");
    $post_thumbnail_src = $values [0];
  } elseif( has_post_thumbnail() ){
        $thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
    $post_thumbnail_src = $thumbnail_src [0];
    } else {
    $post_thumbnail_src = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    $post_thumbnail_src = $matches [1] [0];   //get the image src
    if(empty($post_thumbnail_src)){ //ramdom picture
      $random = mt_rand(1, 10);
      echo get_bloginfo('template_url');
      echo '/images/pic/'.$random.'.jpg';
    }
  };
  echo $post_thumbnail_src;
}



if(stripslashes(get_option('thumbcolumn_grey'))==1){

if ( !function_exists('fb_AddThumbColumn') && function_exists('add_theme_support') ) {

add_theme_support('post-thumbnails', array( 'post' ) );
function fb_AddThumbColumn($cols) {
  $cols['thumbnail'] = __('Thumbnail');
  return $cols;
}
function fb_AddThumbValue($column_name, $post_id) {
  $width = (int) 160;
  $height = (int) 160;
  if ( 'thumbnail' == $column_name ) {
    
    $thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
    // image from gallery
    $attachments = get_children( array('post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image') );
    if ($thumbnail_id)
      $thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
    elseif ($attachments) {
      foreach ( $attachments as $attachment_id => $attachment ) {
        $thumb = wp_get_attachment_image( $attachment_id, array($width, $height), true );
      }
    }
    if ( isset($thumb) && $thumb ) {
      echo $thumb;
    } else {
      echo __('None');
    }
  }
}
// for posts
add_filter( 'manage_posts_columns', 'fb_AddThumbColumn' );
add_action( 'manage_posts_custom_column', 'fb_AddThumbValue', 10, 2 );
// for pages
add_filter( 'manage_pages_columns', 'fb_AddThumbColumn' );
add_action( 'manage_pages_custom_column', 'fb_AddThumbValue', 10, 2 );
}
}




// rename filename auto
if(stripslashes(get_option('rename_filename'))){

function rename_filename($filename) {
  $info = pathinfo($filename);
  $ext = empty($info['extension']) ? '' : '.' . $info['extension'];
  $name = basename($filename, $ext);
  return substr(md5($name), 0, 20) . $ext;
}
add_filter('sanitize_file_name', 'rename_filename', 10);

}



// grey style
function grey_style(){
  if(stripslashes(get_option('filter_grey'))==1){
?>
<style>
html{overflow-y:scroll;filter:progid:DXImageTransform.Microsoft.BasicImage(grayscale=1);-webkit-filter: grayscale(100%);}
</style>
<?php
  }
}
add_action('wp_head', 'grey_style');






add_theme_support( 'post-thumbnails' );




if ( ! function_exists( 'catchbox_setup' ) ) :

function myblog_setup(){
	//Redirect to Theme Options Page on Activation
	global $pagenow;
	if ( is_admin() && isset($_GET['activated'] ) && $pagenow =="themes.php" ) {
		
		
		wp_redirect( 'admin.php?page=themes-settings' );
	}
}

endif;
add_action( 'after_setup_theme', 'myblog_setup' );


?>