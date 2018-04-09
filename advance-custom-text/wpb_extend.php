<?php
/*
Plugin Name: Advance Custom Text
Plugin URI: https://rahat.me
Description: Advance Custom Text addons for Visual Composer.
Version: 0.1.1
Author: Rahat
Author URI: https://rahat.me
License: GPLv2 or later
*/



// don't load directly
if (!defined('ABSPATH')) die('-1');

class VCExtendAddonClass {
    function __construct() {
        // We safely integrate with VC with this hook
        add_action( 'init', array( $this, 'integrateWithVC' ) );

        // Use this when creating a shortcode addon
        add_shortcode( 'advctext', array( $this, 'renderMyadvctext' ) );

        // Register CSS and JS
        add_action( 'wp_enqueue_scripts', array( $this, 'loadCssAndJs' ) );
    }

    public function integrateWithVC() {
        // Check if WPBakery Page Builder is installed
        if ( ! defined( 'WPB_VC_VERSION' ) ) {
            // Display notice that Extend WPBakery Page Builder is required
            add_action('admin_notices', array( $this, 'showVcVersionNotice' ));
            return;
        }

        /*
        Add your WPBakery Page Builder logic here.
        Lets call vc_map function to "register" our custom shortcode within WPBakery Page Builder interface.

        More info: http://kb.wpbakery.com/index.php?title=Vc_map
        */
        vc_map( array(
            "name" => __("Advance Custom Text", 'vc_extend'),
            "description" => __("Most Advance Custom Text", 'vc_extend'),
            "base" => "advctext",
            "class" => "",
            "controls" => "full",
            "icon" => plugins_url('assets/wpm_act.png', __FILE__), // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
            "category" => __('Content', 'js_composer'),
            //'admin_enqueue_js' => array(plugins_url('assets/vc_extend.js', __FILE__)), // This will load js file in the VC backend editor
            //'admin_enqueue_css' => array(plugins_url('assets/vc_extend_admin.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(
                array(
                  "type" => "textfield",
                  "holder" => "div",
                  "class" => "",
                  "heading" => __("Title", 'vc_extend'),
                  "param_name" => "act_title",
                  "value" => __("Default params value", 'vc_extend'),
                  "description" => __("Custom title here. If you need.", 'vc_extend')
              ),
              array(
                  "type" => "colorpicker",
                  "class" => "",
                  "edit_field_class" => "vc_col-sm-6 vc_column",
                  "heading" => __("Title color", 'vc_extend'),
                  "param_name" => "title_color",
                  "description" => __("Choose text color", 'vc_extend')
              ),
              array(
                  "type" => "dropdown",
                  "heading" => __("Tag Name", "vc_extend") ,
                  "edit_field_class" => "vc_col-sm-6 vc_column",
                  "param_name" => "tag_name",
                  "value" => array(
                     "h1" => "h1",
                      "h2" => "h2",
                      "h3" => "h3",
                      "h4" => "h4",
                      "h5" => "h5",
                      "h6" => "h6"
                  ) ,
                  "description" => __("choose html tag")
              ) ,

              array(
                  "type" => "dropdown",
                  "heading" => __("Title Align", "vc_extend") ,
                  "param_name" => "title_align",
                  "edit_field_class" => "vc_col-sm-3 vc_column",
                  "width" => 150,
                  "value" => array(
                      __('Left', "vc_extend") => "left",
                      __('Right', "vc_extend") => "right",
                      __('Center', "vc_extend") => "center"
                  ) ,
                  "description" => __("", "vc_extend")
              ) ,
              array(
                  "type" => "dropdown",
                  "heading" => __("Font Weight", "vc_extend") ,
                  "edit_field_class" => "vc_col-sm-3 vc_column",
                  "param_name" => "title_font_weight",
                  "value" => array(
                      __('Light', "vc_extend") => "lighter",
                      __('Normal', "vc_extend") => "normal",
                      __('Bold', "vc_extend") => "bold",
                      __('Bolder', "vc_extend") => "bolder",
                      __('Extra Bold', "vc_extend") => "900",
                  ) ,
                  "description" => __("", "vc_extend")
              ) ,
              array(
                  "type" => "dropdown",
                  "heading" => __("Font Style", "vc_extend") ,
                  "edit_field_class" => "vc_col-sm-3 vc_column",
                  "param_name" => "title_font_style",
                  "value" => array(
                      __('Normal', "vc_extend") => "normal",
                      __('Italic', "vc_extend") => "italic",
                  ) ,
                  "description" => __("", "vc_extend")
              ) ,
              array(
                  "type" => "dropdown",
                  "heading" => __("Text Transform", "vc_extend") ,
                  "edit_field_class" => "vc_col-sm-3 vc_column",
                  "param_name" => "title_txt_transform",
                  "value" => array(
                      __('Default', "vc_extend") => "initial",
                      __('None', "vc_extend") => "none",
                      __('Uppercase', "vc_extend") => "uppercase",
                      __('Lowercase', "vc_extend") => "lowercase",
                      __('Capitalize', "vc_extend") => "capitalize"
                  ) ,
                  "description" => __("", "vc_extend")
              ) ,
              array(
                  "type" => "range",
                  "heading" => __("Title Font Size", "vc_extend") ,
                  "param_name" => "title_size",
                  "value" => "14",
                  "min" => "12",
                  "max" => "70",
                  "step" => "1",
                  "unit" => 'px',
                  "description" => __("", "vc_extend")
              ) ,
              array(
                  "type" => "range",
                  "heading" => __("Letter Spacing", "vc_extend") ,
                  "param_name" => "title_letter_spacing",
                  "value" => "0",
                  "min" => "0",
                  "max" => "10",
                  "step" => "1",
                  "unit" => 'px',
                  "description" => __("Space between each character.", "vc_extend")
              ) ,
              array(
                  "type" => "range",
                  "heading" => __("Margin Top", "vc_extend") ,
                  "param_name" => "title_margin_top",
                  "value" => "0",
                  "min" => "0",
                  "max" => "500",
                  "step" => "1",
                  "unit" => 'px',
                  "description" => __("", "vc_extend")
              ) ,
              array(
                  "type" => "range",
                  "heading" => __("Margin Bottom", "vc_extend") ,
                  "param_name" => "title_margin_bottom",
                  "value" => "20",
                  "min" => "0",
                  "max" => "500",
                  "step" => "1",
                  "unit" => 'px',
                  "description" => __("", "vc_extend")
              ) ,
              array(
                  "type" => "textarea_html",
                  "holder" => "div",
                  "class" => "",
                  "heading" => __("Content", 'vc_extend'),
                  "param_name" => "content",
                  "value" => __("<p>I am test text block. Click edit button to change this text.</p>", 'vc_extend'),
                  "description" => __("Enter your content.", 'vc_extend')
              ),
              array(
                  "type" => "colorpicker",
                  "class" => "",
                  "heading" => __("Text color", 'vc_extend'),
                  "edit_field_class" => "vc_col-sm-6 vc_column",
                  "param_name" => "para_color",
                  "description" => __("Choose text color", 'vc_extend')
              ),
              array(
                  "type" => "dropdown",
                  "heading" => __("Text Align", "vc_extend") ,
                  "edit_field_class" => "vc_col-sm-6 vc_column",
                  "param_name" => "para_align",
                  "width" => 150,
                  "value" => array(
                      __('Left', "vc_extend") => "left",
                      __('Right', "vc_extend") => "right",
                      __('Center', "vc_extend") => "center",
                      __('Justify', "vc_extend") => "justify"
                  ) ,
                  "description" => __("", "vc_extend")
              ) ,
              array(
                  "type" => "range",
                  "heading" => __("Text Font Size", "vc_extend") ,
                  "param_name" => "para_size",
                  "value" => "14",
                  "min" => "8",
                  "max" => "30",
                  "step" => "1",
                  "unit" => 'px',
                  "description" => __("", "vc_extend")
              ) ,

              array(
                "type" => "textfield",
                "heading" => __("Extra custom class", 'vc_extend'),
                "param_name" => "ex_cus_class",
                "description" => __("Extra custom class. If you want to add more css on this section", 'vc_extend')
            ),
            )
        ) );
    }


    public function renderMyadvctext( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'foo' => 'something',
        'title_color' => '',
        'act_title' => '',
        'tag_name' => 'h2',
        'title_align' => 'left',
        'title_font_weight' => 'normal',
        'title_font_style' => 'normal',
        'title_txt_transform' => 'uppercase',
        'title_size' => '22',
        'title_letter_spacing' => '0',
        'title_margin_top' => '0',
        'title_margin_bottom' => '20',
        'para_size' => '20',
        'para_align' => '20',
        'para_color' => '20',

      ), $atts ) );

      $content = wpb_js_remove_wpautop($content, true);

      $title_styles = "";

      $title_styles .= 'font-size:'.$title_size.'px;';
      $title_styles .= 'color:'.$title_color.';';
      $title_styles .= 'text-align:'.$title_align.';';
      $title_styles .= 'font-weight:'.$title_font_weight.';';
      $title_styles .= 'font-style:'.$title_font_style.';';
      $title_styles .= 'text-transform:'.$title_txt_transform.';';
      $title_styles .= 'letter-spacing:'.$title_letter_spacing.'px;';
      $title_styles .= 'margin-top:'.$title_margin_top.'px;';
      $title_styles .= 'margin-bottom:'.$title_margin_bottom.'px;';



      $para_styles = "";

      $para_styles .= 'color:'.$para_color.';';
      $para_styles .= 'font-size:'.$para_size.'px;';
      $para_styles .= 'text-align:'.$para_align.';';


$act_styles .= '.wpm_act_paragraph p {color:' .$para_color.'}';

// Mk_Static_Files::addCSS($act_styles);




      $output = "<div id='wpm_act_sec' class='{$ex_cus_class}'>
      <{$tag_name} id='wpm_act_title' style='{$title_styles}'>{$act_title}</{$tag_name}>

      <div class='wpm_act_paragraph' style='{$para_styles}'>

      {$content}
      </div>

      </div>";
      return $output;
    }

    /*
    Load plugin css and javascript files which you may need on front end of your site
    */
    public function loadCssAndJs() {
      wp_register_style( 'vc_extend_style', plugins_url('assets/vc_extend.css', __FILE__) );
      wp_enqueue_style( 'vc_extend_style' );


      // If you need any javascript files on front end, here is how you can load them.
      //wp_enqueue_script( 'vc_extend_js', plugins_url('assets/vc_extend.js', __FILE__), array('jquery') );
    }

    /*
    Show notice if your plugin is activated but Visual Composer is not
    */
    public function showVcVersionNotice() {
        $plugin_data = get_plugin_data(__FILE__);
        echo '
        <div class="updated">
          <p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'vc_extend'), $plugin_data['Name']).'</p>
        </div>';
    }
}
// Finally initialize code
new VCExtendAddonClass();
