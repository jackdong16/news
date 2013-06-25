<?php
/*
Plugin Name: Nice Map Tags
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Nice map tags on Google Maps with any number of address
Version: 1.0
Author: Jack Dong
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/
?>
<?php
/*  Copyright 2013  JACK DONG  (email : donghuan16@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>
<?php 

if (!class_exists("NiceMapWidget"))
{
  global $updown_db_version;
  $updown_db_version = "1.1"; //???
    
  class NiceMapWidget
  {
    function __construct()
    {
      add_action( 'init', array( &$this, 'init_plugin' ));
      add_action( 'wp_ajax_get_nice_map_data', array( &$this, 'ajax_get_nice_map_data' ));
      add_action( 'wp_ajax_nopriv_get_nice_map_data', array( &$this, 'ajax_get_nice_map_data' ));
      add_action( 'save_post', array( &$this, 'save_post_and_code_address' ));
    
      //add_action( 'wp_ajax_register_vote', array( &$this, 'ajax_register_vote' ));
      //add_action( 'wp_ajax_nopriv_register_vote', array( &$this, 'ajax_register_vote' ));
      add_action( 'wp_head', array( &$this, 'add_ajax_url' ));
      add_action( 'admin_menu', 'nice_map_plugin_menu' );
    }
    
    public function setup_plugin() {

    }
    
    public function init_plugin()
    {
      $this->load_nice_map_resources();
    }
    
    public function load_nice_map_resources()
    {
      if ( !is_admin() )
      {
        wp_register_style ( 'nice_map_widget_css_default', plugins_url ( '/css/default.css', __FILE__));

        wp_enqueue_style ( 'nice_map_widget_css_default' );

        wp_register_script ( 'nice_map_widget_jquery', 'http://code.jquery.com/jquery-1.9.1.min.js');
        wp_register_script ( 'nice_map_widget_jqueryui', 'http://code.jquery.com/ui/1.10.0/jquery-ui.js');
        wp_register_script ( 'nice_map_widget_google_map', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true');
        wp_register_script ( 'nice_map_widget_richmarker', 'http://google-maps-utility-library-v3.googlecode.com/svn/trunk/richmarker/src/richmarker.js');
        wp_register_script ( 'nice_map_widget_js_default', plugins_url ( '/js/default.js', __FILE__));

        wp_enqueue_script('nice_map_widget_jquery');
        wp_enqueue_script('nice_map_widget_jqueryui');
        wp_enqueue_script('nice_map_widget_google_map');
        wp_enqueue_script('nice_map_widget_richmarker');
        wp_enqueue_script('nice_map_widget_js_default');
      }     
    }

    public function add_ajax_url()
    { 
      echo '<script type="text/javascript">var NiceMapWidget = { ajaxurl: "'.admin_url ('admin-ajax.php').'" };</script>';
    }

    function guest_allowed()
    {
      return get_option ("updown_guest_allowed") == "allowed";
    }
    
    public function get_user_id()
    {
      if (is_user_logged_in())
        return get_current_user_id();
      
      // guests user-id = md5 hash of it's IP
      if ($this->guest_allowed())
        return md5 ($_SERVER['REMOTE_ADDR']);
      
      return 0;
    }
    
    public function get_post_votes_total ( $post_id )
    {
      global $wpdb;

      if ( !$post_id )
        return false;

      $result_query = $wpdb->get_results($wpdb->prepare("
                              SELECT vote_count_up, vote_count_down 
                              FROM ".$wpdb->base_prefix."up_down_post_vote_totals 
                              WHERE post_id = %d", $post_id));

      return ( count($result_query) == 1 ? array( "up" => $result_query[0]->vote_count_up, "down" => $result_query[0]->vote_count_down ) : array( "up" => 0, "down" => 0 ));
    }

    public function get_comment_votes_total( $comment_id ) {
      global $wpdb;

      if ( !$comment_id )
        return false;

      $result_query = $wpdb->get_results($wpdb->prepare("
                              SELECT vote_count_up, vote_count_down 
                              FROM ".$wpdb->base_prefix."up_down_comment_vote_totals 
                              WHERE comment_id = %d", $comment_id));

      return ( count($result_query) == 1 ? array( "up" => $result_query[0]->vote_count_up, "down" => $result_query[0]->vote_count_down ) : array( "up" => 0, "down" => 0 ));
    }

    public function get_post_user_vote( $user_id, $post_id ) {
      global $wpdb;
      return $wpdb->get_var($wpdb->prepare("
                          SELECT vote_value 
                          FROM ".$wpdb->base_prefix."up_down_post_vote
                          WHERE voter_id =  %s
                          AND post_id = %d", $user_id, $post_id));
    }

    public function get_comment_user_vote( $user_id, $comment_id ) {
      global $wpdb;
      return $wpdb->get_var($wpdb->prepare("
                          SELECT vote_value 
                          FROM ".$wpdb->base_prefix."up_down_comment_vote
                          WHERE voter_id =  %s
                          AND comment_id = %d", $user_id, $comment_id));
    }

    public function render_vote_badge( $vote_up_count = 0, $vote_down_count = 0, $votable = true, $existing_vote = 0 ) { 
      
      $img_up_status = '';
      $img_down_status = '';
      $vote_label = '';
      $up_classnames = '';
      $down_classnames = '';
      $down_classnames = '';

      $votable = (is_user_logged_in() || $this->guest_allowed()) && $votable;
      
      if ( $existing_vote > 0 )
        $img_up_status = '-on';
      elseif ( $existing_vote < 0 )
        $img_down_status = '-on';

      $up_img_src = plugins_url( '/images/arrow-up'.$img_up_status.'.png', __FILE__);
      $down_img_src = plugins_url( '/images/arrow-down'.$img_down_status.'.png', __FILE__);

      $vote_total_count = $vote_up_count - $vote_down_count;
      $vote_total_count_num = $vote_up_count + $vote_down_count;
      
      if ( $vote_down_count > 0 )
      {
        $vote_down_count *= -1;
        $down_classnames = ' updown-active';
      }
      
      if ( $vote_up_count > 0 ) {
        $vote_up_count = "+" . $vote_up_count;
        $up_classnames = ' updown-active';
      }

      if (!get_option ("updown_counter_sign") || get_option ("updown_counter_sign") == "yes")
        $updown_classnames .= ' updown-count-sign';
      else
        $updown_classnames .= ' updown-count-unsign';
      
      if ($vote_total_count > 0)
      {
        if (!get_option ("updown_counter_sign") || get_option ("updown_counter_sign") == "yes")
          $vote_total_count = "+" . $vote_total_count;
        $updown_classnames .= ' updown-pos-count';
        //        $updown_style = 'style="color:#5ebc40" ';
      }
      else if ($vote_total_count < 0)
      {
        if (get_option ("updown_counter_sign") == "no")
          $vote_total_count = substr ($vote_total_count, 1);
        $updown_classnames .= ' updown-neg-count';
        //        $updown_style = 'style="color:#bb5853" ';
      }
      
      if ( $vote_up_count == 0 && $vote_down_count == 0 && $votable )
      {
        $vote_up_count = '';
        $vote_down_count = '';
        $vote_total_count = '';
      }
      
      if ($votable)
        $vote_label = get_option ('updown_vote_text');
      else
        $vote_label .= get_option ('updown_votes_text');
        
      if ($votable)
        echo '<div><div class="updown-button updown-up-button icon-large icon-thumbs-up" vote-direction="1"></div></div>';
      //  echo '<div><img class="updown-button updown-up-button" vote-direction="1" src="'.$up_img_src.'"></div>';

      if (get_option ("updown_counter_type") == "total")
      {
        echo '<div class="updown-total-count'.$updown_classnames.'" title="'.$vote_total_count_num.' vote'.($vote_total_count_num != 1 ? 's' : '').' so far">'.$vote_total_count.'</div>';
      }
      else
      {
        echo '<div class="updown-up-count'.$up_classnames.'">'.$vote_up_count.'</div>';
        echo '<div class="updown-down-count'.$down_classnames.'">'.$vote_down_count.'</div>';
      }

      if ($votable)
        echo '<div><div class="updown-button updown-down-button" icon-large icon-thumbs-down vote-direction="-1"></div></div>';
      //  echo '<div><img class="updown-button updown-down-button" vote-direction="-1" src="'.$down_img_src.'"></div>';

      echo '<div class="updown-label">'.$vote_label.'</div>';
      
    }

    //Move the codeAddress and save to DB upon saving any posts
    function save_post_and_code_address( $post_id ) {

  

      update_post_meta($post_id, 'address', "test");
      
    }

    //********************************************************************
    //Ajax handlers

    public function ajax_get_nice_map_data() {
      global $wpdb;
      
      //GET THE RESULTS OF POST CONTAININING MAP INFORMATION
      $result = array( 'status' => '-1', 
                        'message' => '', 
                        'response' => ''
                      );

      // if (!is_user_logged_in() && !$this->guest_allowed())
      // {
      //   $result['message'] = 'You must be logged in to vote.';
      //   die(json_encode($result));
      // }
      
      //Validate expected params
      if ( ($_POST['sort_type'] == null) || ($_POST['items'] == null))
        die(json_encode($result));

      $cat_id = $_POST['cat_id'];
      $type = $_POST['sort_type'];
      $items = $_POST['items'];

      if ($cat_id){
        if ($type = 'recent'){

          $posts = $wpdb->get_results(
            "
            SELECT  post_title, id, post_content, meta_value
            FROM    $wpdb->posts
            JOIN $wpdb->postmeta
            ON $wpdb->posts.id = $wpdb->postmeta.post_id
            WHERE post_type = 'post' AND post_status = 'publish' AND meta_key = 'address' AND ID IN 
            (Select object_id FROM $wpdb->term_relationships, $wpdb->terms WHERE $wpdb->term_relationships.term_taxonomy_id =".$cat.") ORDER BY post_date DESC
            "
          );


        }
        if ($type = 'popular'){
          $posts = $wpdb->get_results(
            "
            SELECT  post_title, id, post_content, meta_value
            FROM    $wpdb->posts
            JOIN $wpdb->postmeta
            ON $wpdb->posts.id = $wpdb->postmeta.post_id
            WHERE $wpdb->postmeta.meta_key = 'address'
            "
          );
        }
        else {} //Nothing
      }
      else{ //No cat id
        if ($type = 'recent'){

          $posts = $wpdb->get_results(
            "
            SELECT  post_title, id, post_content, meta_value
            FROM    $wpdb->posts
            JOIN $wpdb->postmeta
            ON $wpdb->posts.id = $wpdb->postmeta.post_id
            WHERE $wpdb->postmeta.meta_key = 'address'
            "
          );

        }
        if ($type = 'popular'){
          $posts = $wpdb->get_results(
            "
            SELECT  post_title, id, post_content, meta_value
            FROM    $wpdb->posts
            JOIN $wpdb->postmeta
            ON $wpdb->posts.id = $wpdb->postmeta.post_id
            WHERE $wpdb->postmeta.meta_key = 'address'
            "
          );
        }
      }






    //  $posts = $wpdb->get_results("SELECT post_id, vote_count_up - vote_count_down AS difference FROM ".$wpdb->base_prefix."up_down_post_vote_totals ORDER BY difference");
    // $posts = $wpdb->get_results("SELECT comment_count, ID, post_title, post_content, post_date FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' AND category = ".$cat_id." ORDER BY comment_count DESC LIMIT 0 , ".$items);
    
      //Update user vote
      // if ($existing_vote != null) {
      //   $wpdb->query($wpdb->prepare("
      //     UPDATE ".$wpdb->base_prefix."up_down_".$element_name."_vote
      //     SET vote_value = %d
      //     WHERE voter_id = %s
      //       AND ".$element_name."_id = %d", $vote_value, $user_id, $element_id));
      // } else {
      //   $wpdb->query($wpdb->prepare("
      //     INSERT INTO ".$wpdb->base_prefix."up_down_".$element_name."_vote
      //     ( vote_value, ".$element_name."_id, voter_id )
      //     VALUES
      //     ( %d, %d, %s )", $vote_value, $element_id, $user_id ));
      //   $existing_vote = 0;
      // }

      // //Update total
      // if ($wpdb->query($wpdb->prepare("
      //     UPDATE ".$wpdb->base_prefix."up_down_".$element_name."_vote_totals
      //     SET vote_count_up = (vote_count_up + %d),
      //       vote_count_down = (vote_count_down + %d)
      //     WHERE ".$element_name."_id = %d", $up_vote_delta, $down_vote_delta, $element_id)) == 0)
      //   $wpdb->query($wpdb->prepare("
      //   INSERT INTO ".$wpdb->base_prefix."up_down_".$element_name."_vote_totals
      //     ( vote_count_up, vote_count_down, ".$element_name."_id )
      //     VALUES
      //     ( %d, %d, %d )", $up_vote_delta, $down_vote_delta, $element_id));

      //Return success
      $result["status"] = 1;
      $result["message"] = "Getting map data from the most ".$sort_type." from category ".$cat_id.".";
      $result["response"] = $posts;
      // $result["vote_totals"] = $wpdb->get_row($wpdb->prepare("
      //                           SELECT vote_count_up as up, vote_count_down as down
      //   FROM ".$wpdb->base_prefix."up_down_".$element_name."_vote_totals
      //                           WHERE ".$element_name."_id = %d", $element_id));

      die(json_encode($result));
    }
  } //class:UpDownPostCommentVotes
  
  //Create instance of plugin
  $up_down_plugin = new NiceMapWidget();

  //Handle plugin activation and update
  register_activation_hook( __FILE__, array( &$up_down_plugin, 'setup_plugin' ));
  if (function_exists ("register_update_hook"))
    register_update_hook ( __FILE__, array( &$up_down_plugin, 'setup_plugin' ));
  else
    add_action('init', array( &$up_down_plugin, 'setup_plugin' ), 1);


  //SHORTCODE
  function nice_map_widg($items = 10, $cat_id, $sort_type) 
  {
    $return_html = '<div id="map_canvas" cat_id="'.$cat_id.'" sort_type="'.$sort_type.'" items="'.$items.'"></div>';

    return $return_html;
  }


  function nice_map_widget_func($atts) {
    
    //extract short code attr
    extract(shortcode_atts(array(
      'cat_id' => '',
      'sort_type' => 'popular',
      'items' => 10,
    ), $atts));

    $return_html = nice_map_widg($items, $cat_id, $sort_type);
    
    return $return_html;
  }
  add_shortcode('nice_map_widget', 'nice_map_widget_func');

  //********************************************************************
  //Custom template tags

  // function up_down_post_votes( $post_id, $allow_votes = true ) {
  //   global $up_down_plugin;

  //   if ( !$post_id )
  //     return false;
      
  //   $vote_counts = $up_down_plugin->get_post_votes_total( $post_id );
  //   $existing_vote = $up_down_plugin->get_post_user_vote( $up_down_plugin->get_user_id(), $post_id );

  //   echo '<div class="updown-vote-box updown-post" id="updown-post-'.$post_id.'" post-id="'.$post_id.'">';
  //   $up_down_plugin->render_vote_badge( $vote_counts["up"], $vote_counts["down"], $allow_votes, $existing_vote );
  //   echo '</div>';
  // }

  // function up_down_comment_votes( $comment_id, $allow_votes = true ) {
  //   global $up_down_plugin;

  //   if ( !$comment_id )
  //     return false;
      
  //   $vote_counts = $up_down_plugin->get_comment_votes_total( $comment_id );
  //   $existing_vote = $up_down_plugin->get_comment_user_vote( $up_down_plugin->get_user_id(), $comment_id );
    
  //   echo '<div class="updown-vote-box updown-comments" id="updown-comment-'.$comment_id.'" comment-id="'.$comment_id.'">';
  //   $up_down_plugin->render_vote_badge( $vote_counts["up"], $vote_counts["down"], $allow_votes, $existing_vote );
  //   echo '</div>';
  // }

  // function up_down_post_vote_count($post_id){
  //   global $up_down_plugin;

  //   if ( !$post_id )
  //     return false;

  //   return $up_down_plugin->get_post_votes_total( $post_id );
  // }

  
  //********************************************************************
  // Admin page
  
  function nice_map_plugin_menu()
  {
    add_options_page('UpDown Options', 'NiceMapWidget', 'manage_options', 'updown_plugin_menu_id', 'nice_map_options');
  } 

  function nice_map_options()
  {
    global $up_down_plugin;
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    
    if (isset ($_POST['Submit']))
    {
      // guest allowed
      if (isset ($_POST['guest_allowed']) && $_POST['guest_allowed'] == "on")
      {
        update_option ("updown_guest_allowed", "allowed");
      }
      else
        update_option ("updown_guest_allowed", "not allowed");
      
      // style
      update_option ("updown_css", trim (strip_tags ($_POST['style'])));
      
      // counter type
      update_option ("updown_counter_type", trim (strip_tags ($_POST['counter'])));
      if ($_POST['counter-sign'] == "yes")
        update_option ("updown_counter_sign", "yes");
      else
        update_option ("updown_counter_sign", "no");
      
      // text
      update_option ("updown_vote_text", trim ($_POST['votetext']));
      update_option ("updown_votes_text", trim ($_POST['votestext']));
    }
    
    echo '<div class="wrap"><h2>Nice Map Widget Settings</h2><form name="form1" method="post" action=""><table width="100%" cellpadding="5" class="form-table"><tbody>';
    
    // permissions
    $allow_guests = get_option ("updown_guest_allowed") == "allowed" ? "checked " : "";
    echo '<tr valign="top"><th>Allow guests to vote:</th><td><input type="checkbox" name="guest_allowed" '.$allow_guests.'/> <span class="description">Allow guest visitors to vote without login? (Votes tracked by ip address)</span></td></tr>';
    
    //style
    $selected = "";
    echo '<tr valign="top"><th>Badge style:</th><td><select name="style">';
    if (get_option ("updown_css") == "default") $selected = "selected ";
    else $selected = "";
    echo '<option value="default"'.$selected.'>default</option>';
    if (get_option ("updown_css") == "simple") $selected = "selected ";
    else $selected = "";
    echo '<option value="simple"'.$selected.'>simple</option>';
    echo '</select> <span class="description">Choose basic badge style. You can also override CSS in your theme.</span></td></tr>';
    
    // counter type
    echo '<tr valign="top"><th>Counter type:</th><td>';
    if (!get_option ("updown_counter_type") || get_option ("updown_counter_type") == "plusminus")
      $selected = "checked ";
    else
      $selected = "";
    echo '<input type="radio" name="counter" value="plusminus" '.$selected.'/> Plus/Minus ';
    if (get_option ("updown_counter_type") == "total")
      $selected = "checked ";
    else
      $selected = "";
    echo '<input type="radio" name="counter" value="total" '.$selected.'/> Total ';
    echo ' <span class="description">Do you want to see the positive and negative counts, or only a total score?</td></tr>';
    
    // sign?
    echo '<tr valign="top"><th>Sign total counter:</th><td>';
    if (!get_option ("updown_counter_sign") || get_option ("updown_counter_sign") == "yes")
      $selected = "checked ";
    else
      $selected = "";
    echo '<input type="radio" name="counter-sign" value="yes" '.$selected.'/> sign ';
    if (get_option ("updown_counter_sign") == "no")
      $selected = "checked ";
    else
      $selected = "";
    echo '<input type="radio" name="counter-sign" value="no" '.$selected.'/> don\'t sign ';
    echo ' <span class="description">Should the total score contain a +/- in front of it?</span></td></tr>';
    
    //text
    echo '<tr valign="top"><th>Vote label if voteable:</th><td><input type="text" name="votetext" value="'.get_option('updown_vote_text').'"/> <span class="description">Text on the bottom of the buttons if the visitor is allowed to vote (HTML allowed)</span></td></tr>';
    echo '<tr valign="top"><th>Vote label if not voteable:</th><td><input type="text" name="votestext" value="'.get_option('updown_votes_text').'"/> <span class="description">Text on the bottom of the buttons if the visitor is <strong>not</strong> allowed to vote (HTML allowed)</span></td></tr>';
    
    echo '</tbody></table>';
    
    //save
    echo '<p class="submit"><input type="submit" name="Submit" class="button-primary" value="'.esc_attr('Save Changes').'" /></p>';
    echo '</form></div>';
  }
} 
?>