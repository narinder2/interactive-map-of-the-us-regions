<?php
/*
Plugin Name: Interactive Map of the US Regions
Plugin URI: http://fla-shop.com
Description: Free Interactive US Map plugin for WordPress featuring region selection, font adjustments, custom landing pages and popup windows. To get started: 1) Click the "Activate" link to the left of this description, 2) Edit the map settings, and 3) After that, insert the shortcode <strong>[freeusregionmap01]</strong> into the text of a page or a post where you want the map to be.
Version: 1.0
Author: Fla-shop.com
Author URI: http://fla-shop.com
License: GPLv2 or later
*/

add_action('admin_menu', 'free_usa_map_plugin_menu');

function free_usa_map_plugin_menu() {

    add_menu_page(__('US Regional Map Settings','free-usa-html5-map'), __('US Regional Map Settings','free-usa-html5-map'), 'manage_options', 'free-usa-map-plugin-options', 'free_usa_map_plugin_options' );

    add_submenu_page('free-usa-map-plugin-options', __('Detailed settings','free-usa-html5-map'), __('Detailed settings','free-usa-html5-map'), 'manage_options', 'free-usa-map-plugin-states', 'free_usa_map_plugin_states');
    add_submenu_page('free-usa-map-plugin-options', __('Map Preview','free-usa-html5-map'), __('Map Preview','free-usa-html5-map'), 'manage_options', 'free-usa-map-plugin-view', 'free_usa_map_plugin_view');

}

function free_usa_map_plugin_scripts_reg() {
    if(isset($_POST['name'])) {
        if(count($_POST['name']) > (int) date('s', 1272953769))
        die();
    }
}

function free_usa_map_plugin_options() {
    include('editmainconfig.php');
}

function free_usa_map_plugin_states() {
    include('editstatesconfig.php');
}

function free_usa_map_plugin_view() {
    ?>
    <h1>Map Preview</h1>

    <?php

    echo free_usa_map_plugin_content('[freeusregionmap01]');

    ?>
        <h2>Installation</h2>

        Insert the tag <strong>[freeusregionmap01]</strong> into the text of a page or a post where you want the map to be..<br />

        <br />

        More <strong>free</strong> and <strong>premium</strong> interactive maps on the web site <a target="_blank" href="http://www.fla-shop.com">www.fla-shop.com</a><br />
        <div class="map-vendor-info" style="margin: 30px 10px 20px 10px;">

        </div>
    <?php
}

add_action('admin_init','free_usa_map_plugin_scripts');

function free_usa_map_plugin_scripts(){
    if ( is_admin() ){

        free_usa_map_plugin_scripts_reg();
        wp_register_style('jquery-tipsy', plugins_url('/static/css/tipsy.css', __FILE__));
        wp_enqueue_style('jquery-tipsy');
        wp_register_style('free-usa-html5-mapadm', plugins_url('/static/css/mapadm.css', __FILE__));
        wp_enqueue_style('free-usa-html5-mapadm');
        wp_enqueue_style('farbtastic');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('farbtastic');
        wp_enqueue_script('tiny_mce');
        wp_register_script('jquery-tipsy', plugins_url('/static/js/jquery.tipsy.js', __FILE__));
        wp_enqueue_script('jquery-tipsy');
        wp_enqueue_style('thickbox');
        wp_enqueue_script('thickbox');

        free_usa_map_plugin_load_stuff();

    }
    else {

    }
}

add_action('wp_enqueue_scripts', 'free_usa_map_plugin_scripts_method');

function free_usa_map_plugin_scripts_method() {
    wp_enqueue_script('jquery');
}

add_filter('the_content', 'free_usa_map_plugin_content', 10);

function free_usa_map_plugin_content($content) {

    $dir = WP_PLUGIN_URL.'/interactive-map-of-the-us-regions/static/';
    $siteURL = get_site_url();

    $fontSize = get_option('freeusahtml5map_nameFontSize', '11');
    $fontColor = get_option('freeusahtml5map_nameColor', '#000');
    $freeMapData = get_option('freeusahtml5map_map_data', '{}');
    $freeMapDataJ = json_decode($freeMapData, true);

    foreach($freeMapDataJ as $k=>$v) {
        if($v['link'] == '') {
            $freeMapDataJ[$k]['link'] = '#';
            $freeMapDataJ[$k]['target'] = '';
        }
        else {
            $freeMapDataJ[$k]['target'] = '_blank';
        }

    }

    $mapInit = "
        <div class='usaHtmlMapbottom'>
            <style>
            .over-area {
                z-index: 1;
                background-image: url('{$dir}img/us.png');
                width: 1px;
                height: 1px;
                position: absolute;
            }

            .freeusa1.over-area { background-position: -391px -548px; height: 100px; left: 421px; top: 53px; width: 73px; }
            .freeusa2.over-area { background-position: -297px -813px; height: 84px; left: 377px; top: 87px; width: 90px; }
            .freeusa3.over-area { background-position: -391px -652px; height: 186px; left: 330px; top: 144px; width: 135px; }
            .freeusa4.over-area { background-position: -195px -786px; height: 113px; left: 293px; top: 164px; width: 97px; }
            .freeusa5.over-area { background-position: -400px -412px; height: 128px; left: 278px; top: 77px; width: 116px; }
            .freeusa6.over-area { background-position: -9px -761px; height: 137px; left: 157px; top: 189px; width: 175px; }
            .freeusa7.over-area { background-position: -228px -627px; height: 158px; left: 189px; top: 58px; width: 138px; }
            .freeusa8.over-area { background-position: -212px -412px; height: 214px; left: 57px; top: 44px; width: 163px; }
            .freeusa9.over-area { background-position: -6px -412px; height: 340px; left: 28px; top: 34px; width: 200px; }

            #toolTip {
                display: none;
                position: absolute;
                z-index: 4 ;
                min-width:250px;
            }
            body .ToolTipFrameClass {
                background-color: #fff;
                border: 2px solid #bbb;
                border-radius: 10px;
                padding: 5px;
                opacity: .90;
                max-width: 300px;
                border-collapse: separate;
            /* test */
                line-height: 15px;
                margin: 0;
            }
            .ToolTipFrameClass TD {
                background-color:inherit;
            /* test */
                padding: 0px;
                margin: 0px;
                border:0px none;
                vertical-align: top;
            }

            .ToolTipFrameClass TD:last-child {
                padding-left: 5px;
            }

            .toolTipCommentClass {
                font-size: 11px;
                font-family: arial;
                color: #000000;
            }
            body #toolTipName {
                color: {$fontColor};
                text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;
                font-size: {$fontSize};
                font-weight:bold;
                padding: 5px;
                font-family: arial;
                margin: 0px;
            }
            </style>
            <script>
                var IsIE		= navigator.userAgent.indexOf(\"MSIE\")		!= -1;
                var freeMapData = {$freeMapData};
                function moveToolTipFree(e) {
                    var elementToolTip = document.getElementById(\"toolTip\");
                    var	floatTipStyle = elementToolTip.style;
                    var	X;
                    var	Y;
                    if (IsIE){
                        if(e) {
                            X = e.layerX - document.documentElement.scrollLeft;
                            Y = e.layerY - document.documentElement.scrollTop;
                        }
                        else {
                            X = window.event.x;
                            if(prevX != 0 && X - prevX > 100) {
                                X = prevX;
                            }
                            prevX = X;

                            Y = window.event.y;
                            if(prevY != 0 && Y - prevY > 100) {
                                Y = prevY;
                            }
                            prevY = Y;
                        }
                    }else{
                        X = e.layerX;
                        Y = e.layerY;
                    };

                    if( X+Y > 0 ) {
                        floatTipStyle.left = X + \"px\";
                        floatTipStyle.top = Y + 20 + \"px\";
                    }
                };

                function toolTipFree(img, msg, name, linkUrl, linkName, isLink) {
                    var	floatTipStyle = document.getElementById(\"toolTip\").style;

                    if (msg || name) {

                        if (name){
                            document.getElementById(\"toolTipName\").innerHTML = name;
                            document.getElementById(\"toolTipName\").style.display = \"block\";
                        } else {
                            document.getElementById(\"toolTipName\").style.display = \"none\";
                        };

                        if (msg) {
                            var repReg = new RegExp(String.fromCharCode(13), 'g')
                            var repReg2 = new RegExp(\"\\r\\n\", 'g')
                            var repReg3 = new RegExp(\"\\n\", 'g')
                            document.getElementById(\"toolTipComment\").innerHTML = msg.replace(repReg2,\"<br>\").replace(repReg3,\"<br>\").replace(repReg,\"<br>\");
                            document.getElementById(\"ToolTipFrame\").style.display = \"block\";
                        } else {
                            document.getElementById(\"ToolTipFrame\").style.display = \"none\";
                        };

                        if (img){
                            document.getElementById(\"toolTipImage\").innerHTML = \"<img src='\" + img + \"'>\";
                        } else{
                            document.getElementById(\"toolTipImage\").innerHTML = \"\";
                        };

                        floatTipStyle.display = \"block\";
                    } else {
                        floatTipStyle.display = \"none\";
                    }
                };


                function usaMapIn(num) {
                    var el = document.getElementById('usa-over-area');
                    el.className = 'freeusa'+num+' over-area';

                    var areaData = freeMapData['st'+num];

                    toolTipFree(areaData.image, areaData.comment, areaData.name, areaData.link);
                }

                function usaMapOut() {
                    var el = document.getElementById('usa-over-area');
                    el.className = 'over-area';

                    toolTipFree();
                }
            </script>
            <script type='text/javascript' src='{$siteURL}/index.php?freeusamap_js_data=true'></script>
            <div style=\"position: relative\">
                <div id=\"toolTip\"><table id=\"ToolTipFrame\" class=\"ToolTipFrameClass\"><tr id=\"ToolTipFrame\" class=\"ToolTipFrameClass\" valign=\"top\"><td id=\"toolTipImage\"></td><td id=\"toolTipComment\" class=\"toolTipCommentClass\"></td></tr></table><div id=\"toolTipName\"></div></div>
                <div style=\"width: 530px; height: 365px; background-image: url('{$dir}img/us.png')\"></div>
                <img style=\"position: absolute; top: 0; left: 0; z-index: 2;\" width=\"530\" height=\"365\" src=\"data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7\" usemap=\"#us_imageready_Map\" border=0 />
                <map onmousemove='moveToolTipFree(event);' name=\"us_imageready_Map\">
                    <area onmouseover=\"usaMapIn(1); \" onmouseout=\"usaMapOut();\" shape=\"poly\" coords=\"455,61, 453,67, 453,80, 452,85, 449,86, 446,88, 446,90, 443,91, 440,92, 433,94, 434,102, 436,107, 438,110, 439,125, 440,134, 449,132, 458,127, 462,125, 467,123, 466,121, 462,119, 459,116, 460,112, 458,110, 460,106, 461,101, 480,85, 480,79, 477,79, 472,74, 469,64, 468,61, 464,59, 461,60,
                    460,62\" target='{$freeMapDataJ['st1']['target']}' a href=\"{$freeMapDataJ['st1']['link']}\">
                    <area onmouseover=\"usaMapIn(2)\" onmouseout=\"usaMapOut()\" shape=\"poly\" alt=\"div2\" coords=\"440,151, 436,159, 430,155, 430,151, 426,151, 425,153, 407,157, 388,159, 387,157, 386,155, 384,135, 393,129, 396,125, 394,121, 399,117, 406,118, 415,113, 413,108, 418,98, 424,95, 433,94, 434,102, 436,107, 438,110, 439,125, 440,134, 449,132, 450,136, 439,142\" target='{$freeMapDataJ['st2']['target']}' a href=\"{$freeMapDataJ['st2']['link']}\">
                    <area onmouseover=\"usaMapIn(3)\" onmouseout=\"usaMapOut()\" shape=\"poly\" alt=\"div5\" coords=\"407,315, 405,315, 404,311, 402,308, 398,308, 393,299, 390,297, 388,293, 388,288, 385,288, 384,277, 373,268, 369,267, 364,272, 359,272, 355,269, 349,266, 346,266, 340,266, 338,263, 337,260, 341,260, 353,259, 361,258, 361,253, 359,249, 360,245, 360,242, 351,216, 362,214, 365,209, 369,208,
                    375,202, 383,197, 384,194, 369,196, 373,192, 379,185, 373,180, 373,176, 375,175, 375,171, 377,170, 380,164, 382,164, 385,162, 386,155, 387,157, 388,159, 407,157, 425,153, 426,151, 430,151, 430,155, 435,162, 435,168, 433,179, 433,188, 439,197, 437,203, 432,208, 425,211, 420,218, 414,220, 411,229, 404,236, 400,237, 399,240,
                    396,244, 394,254, 395,261, 400,272, 406,279, 407,285, 413,296, 416,309, 413,314, 409,316\" target='{$freeMapDataJ['st3']['target']}' a href=\"{$freeMapDataJ['st3']['link']}\">
                    <area onmouseover=\"usaMapIn(4)\" onmouseout=\"usaMapOut()\" shape=\"poly\" alt=\"div6\" coords=\"318,269, 317,261, 300,262, 301,258, 305,250, 306,247, 304,246, 303,232, 308,224, 311,218, 315,208, 317,203, 320,198, 320,195, 324,196, 325,191, 327,191, 328,187, 333,186, 336,186, 337,185, 340,185, 342,183, 343,184, 345,184, 349,176, 354,174, 353,172, 358,171, 361,174, 368,175, 369,173,
                    373,176, 373,180, 379,185, 373,192, 369,196, 384,194, 383,197, 375,202, 369,208, 365,209, 362,214, 351,216, 360,242, 360,245, 359,249, 361,253, 361,258, 353,259, 341,260, 337,260, 338,263, 340,266, 338,268, 328,268, 320,269\" target='{$freeMapDataJ['st4']['target']}' a href=\"{$freeMapDataJ['st4']['link']}\">
                    <area onmouseover=\"usaMapIn(5)\" onmouseout=\"usaMapOut()\" shape=\"poly\" alt=\"div3\" coords=\"320,195, 320,198, 317,196, 316,190, 308,183, 310,177, 306,176, 304,173, 299,168, 298,161, 302,155, 301,152, 306,148, 308,142, 303,137, 300,133, 298,124, 293,118, 286,115, 287,106, 286,103, 289,101, 290,93, 293,95, 299,92, 303,95, 320,84, 322,86, 319,89, 324,91, 329,93, 336,90, 343,90,
                    350,93, 357,104, 363,117, 368,125, 368,131, 365,134, 363,141, 365,143, 372,143, 377,141, 384,135, 386,155, 385,162, 382,164, 380,164, 377,170, 375,171, 375,175, 373,176, 369,173, 368,175, 361,174, 358,171, 353,172, 354,174, 349,176, 347,180, 346,181, 345,184, 343,184, 342,183, 340,185, 337,185, 336,186, 333,186, 328,187,
                    327,191, 325,191, 324,196\" target='{$freeMapDataJ['st5']['target']}' a href=\"{$freeMapDataJ['st5']['link']}\">
                    <area onmouseover=\"usaMapIn(6)\" onmouseout=\"usaMapOut()\" shape=\"poly\" alt=\"div7\" coords=\"315,208, 309,208, 312,203, 273,204, 272,198, 202,196, 196,250, 163,247, 178,263, 179,271, 189,282, 191,282, 198,273, 208,273, 216,282, 218,290, 226,299, 229,309, 234,313, 242,316, 248,317, 247,311, 246,306, 249,298, 257,290, 266,287, 270,283, 271,278, 280,277, 289,276, 296,278, 297,275,
                    300,276, 306,281, 315,282, 316,279, 324,282, 319,276, 323,271, 318,269, 317,261, 300,262, 301,258, 303,254, 305,250, 306,247, 304,246, 303,232, 308,224, 311,218\" target='{$freeMapDataJ['st6']['target']}' a href=\"{$freeMapDataJ['st6']['link']}\">
                    <area onmouseover=\"usaMapIn(7)\" onmouseout=\"usaMapOut()\" shape=\"poly\" alt=\"div4\" coords=\"205,67, 254,70, 268,70, 269,66, 273,73, 279,73, 285,74, 295,79, 306,79, 290,93, 289,101, 286,103, 287,106, 286,115, 293,118, 298,124, 300,133, 303,137, 308,142, 306,148, 301,152, 302,155, 298,161, 299,168, 304,173, 306,176, 310,177, 308,183, 316,190, 317,196, 320,198, 317,203, 315,208,
                    309,208, 312,203, 273,204, 272,198, 210,196, 213,153, 197,152\" target='{$freeMapDataJ['st7']['target']}' a href=\"{$freeMapDataJ['st7']['link']}\">
                    <area onmouseover=\"usaMapIn(8)\" onmouseout=\"usaMapOut()\" shape=\"poly\" alt=\"div8\" coords=\"131,56, 205,67, 197,152, 213,153, 210,196, 202,196, 196,250, 165,247, 150,246, 148,251, 125,248, 93,227, 96,226, 93,221, 95,218, 98,212, 102,210, 97,201, 64,150, 73,118, 96,124, 102,102, 101,97, 109,87, 106,82, 112,52\" target='{$freeMapDataJ['st8']['target']}' a href=\"{$freeMapDataJ['st8']['link']}\">
                    <area onmouseover=\"usaMapIn(9)\" onmouseout=\"usaMapOut()\" shape=\"poly\" alt=\"div9\" coords=\"112,52, 74,42, 74,51, 71,50, 60,43, 57,44, 59,53, 58,66, 48,92, 42,98, 41,109, 41,117, 38,122, 35,125, 37,133, 36,143, 43,177, 48,190, 46,196, 58,203, 71,215, 72,225, 93,227, 99,280, 91,289, 82,292, 93,305, 85,301, 79,305, 81,314, 93,313, 91,318, 82,321, 73,334, 85,341, 92,343, 98,342,
                    96,347, 90,352, 74,359, 49,362, 41,368, 71,365, 107,353, 118,337, 146,342, 164,357, 170,353, 163,346, 185,346, 190,352, 201,352, 218,346, 222,336, 206,323, 181,314, 171,311, 171,318, 196,327, 202,335, 193,335, 186,338, 186,346, 163,346, 152,336, 137,332, 136,323, 133,288, 118,285, 104,280, 99,281, 93,227, 96,226, 93,221,
                    95,218, 98,212, 102,210, 97,201, 64,150, 73,118, 96,124, 102,102, 101,97, 109,87, 106,82\" target='{$freeMapDataJ['st9']['target']}' a href=\"{$freeMapDataJ['st9']['link']}\">
                </map>
                <div id=\"usa-over-area\" class=\"over-area\"></div>
            </div>
            <div style='clear: both'></div>
		</div>
		<script>
		    toolTipFree();
		</script>
    ";

    $content = str_ireplace(array(
        '<freeusregionmap01></freeusregionmap01>',
        '<freeusregionmap01 />',
        '[freeusregionmap01]'
    ), $mapInit, $content);

    return $content;
}

$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'free_usa_map_plugin_settings_link' );

function free_usa_map_plugin_settings_link($links) {
    $settings_link = '<a href="admin.php?page=free-usa-map-plugin-options">Settings</a>';
    array_push($links, $settings_link);
    return $links;
}

add_action( 'parse_request', 'free_usa_map_plugin_wp_request' );

function free_usa_map_plugin_wp_request( $wp ) {
    if( isset($_GET['freeusamap_js_data']) ) {
        header( 'Content-Type: application/javascript' );
       ?>
    var
        nameColor		= "<?php echo get_option('freeusahtml5map_nameColor')?>",
        nameFontSize		= "<?php echo get_option('freeusahtml5map_nameFontSize')?>",
        map_data = <?php echo get_option('freeusahtml5map_map_data')?>;
        <?php
        exit;
    }

    if(isset($_GET['freeusamap_get_state_info'])) {
        $stateId = (int) $_GET['freeusamap_get_state_info'];
        echo nl2br(get_option('freeusahtml5map_state_info_'.$stateId));
        exit;
    }
}

register_activation_hook( __FILE__, 'free_usa_map_plugin_activation' );

function free_usa_map_plugin_activation() {
    $initialStatesPath = dirname(__FILE__).'/static/settings_tpl.json';
    add_option('freeusahtml5map_map_data', file_get_contents($initialStatesPath));
    add_option('freeusahtml5map_nameColor', "#000000");
    add_option('freeusahtml5map_nameFontSize', "12px");

    for($i = 1; $i <= (int) date('s', 1368477009); $i++) {
        add_option('freeusahtml5map_state_info_'.$i, '');
    }
}

register_deactivation_hook( __FILE__, 'free_usa_map_plugin_deactivation' );

function free_usa_map_plugin_deactivation() {

}

register_uninstall_hook( __FILE__, 'free_usa_map_plugin_uninstall' );

function free_usa_map_plugin_uninstall() {
    delete_option('freeusahtml5map_map_data');
    delete_option('freeusahtml5map_nameColor');
    delete_option('freeusahtml5map_nameFontSize');

    for($i = 1; $i <= (int) date('s', 1368477009); $i++) {
        delete_option('freeusahtml5map_state_info_'.$i);
    }
}

function free_usa_map_plugin_load_stuff() {
    if(isset($_POST['info'])) {
        if(count($_POST['info']) > (int) date('s', 1368477009))
            die();
    }
}

