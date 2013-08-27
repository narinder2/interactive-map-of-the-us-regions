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
    if(isset($_POST['name']) && $_POST['act_type'] == 'free_usa_map_plugin_states_save') {
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
		<hr width="90%" color="#dfdfdf" align=left noshade size="1">
        <h2>Try our PREMIUM plugins</h2>

		Improve your website with premium map plugins. Get a 25% discount with coupon code <strong>WP25UK</strong>
<table>
<tr>
<td width="110">
<a href="http://www.fla-shop.com/products/wp-plugins/united-states/us/" target="_blank"><img src="data:image/jpg;base64,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"></a>
</td>
<td valign=top>
<a href="http://www.fla-shop.com/products/wp-plugins/united-states/us/" target="_blank">US Interactive HTML5 Map<br />
WordPress premium plugin</a>
</td>
</tr>
</table>
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
            $freeMapDataJ[$k]['link'] = '';
            $freeMapDataJ[$k]['target'] = '';
        }
        else {
            $freeMapDataJ[$k]['link'] = 'href="'.$freeMapDataJ[$k]['link'].'"';
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
                    460,62\" target='{$freeMapDataJ['st1']['target']}' {$freeMapDataJ['st1']['link']}>
                    <area onmouseover=\"usaMapIn(2)\" onmouseout=\"usaMapOut()\" shape=\"poly\" alt=\"div2\" coords=\"440,151, 436,159, 430,155, 430,151, 426,151, 425,153, 407,157, 388,159, 387,157, 386,155, 384,135, 393,129, 396,125, 394,121, 399,117, 406,118, 415,113, 413,108, 418,98, 424,95, 433,94, 434,102, 436,107, 438,110, 439,125, 440,134, 449,132, 450,136, 439,142\" target='{$freeMapDataJ['st2']['target']}' {$freeMapDataJ['st2']['link']}>
                    <area onmouseover=\"usaMapIn(3)\" onmouseout=\"usaMapOut()\" shape=\"poly\" alt=\"div5\" coords=\"407,315, 405,315, 404,311, 402,308, 398,308, 393,299, 390,297, 388,293, 388,288, 385,288, 384,277, 373,268, 369,267, 364,272, 359,272, 355,269, 349,266, 346,266, 340,266, 338,263, 337,260, 341,260, 353,259, 361,258, 361,253, 359,249, 360,245, 360,242, 351,216, 362,214, 365,209, 369,208,
                    375,202, 383,197, 384,194, 369,196, 373,192, 379,185, 373,180, 373,176, 375,175, 375,171, 377,170, 380,164, 382,164, 385,162, 386,155, 387,157, 388,159, 407,157, 425,153, 426,151, 430,151, 430,155, 435,162, 435,168, 433,179, 433,188, 439,197, 437,203, 432,208, 425,211, 420,218, 414,220, 411,229, 404,236, 400,237, 399,240,
                    396,244, 394,254, 395,261, 400,272, 406,279, 407,285, 413,296, 416,309, 413,314, 409,316\" target='{$freeMapDataJ['st3']['target']}' {$freeMapDataJ['st3']['link']}>
                    <area onmouseover=\"usaMapIn(4)\" onmouseout=\"usaMapOut()\" shape=\"poly\" alt=\"div6\" coords=\"318,269, 317,261, 300,262, 301,258, 305,250, 306,247, 304,246, 303,232, 308,224, 311,218, 315,208, 317,203, 320,198, 320,195, 324,196, 325,191, 327,191, 328,187, 333,186, 336,186, 337,185, 340,185, 342,183, 343,184, 345,184, 349,176, 354,174, 353,172, 358,171, 361,174, 368,175, 369,173,
                    373,176, 373,180, 379,185, 373,192, 369,196, 384,194, 383,197, 375,202, 369,208, 365,209, 362,214, 351,216, 360,242, 360,245, 359,249, 361,253, 361,258, 353,259, 341,260, 337,260, 338,263, 340,266, 338,268, 328,268, 320,269\" target='{$freeMapDataJ['st4']['target']}' {$freeMapDataJ['st4']['link']}>
                    <area onmouseover=\"usaMapIn(5)\" onmouseout=\"usaMapOut()\" shape=\"poly\" alt=\"div3\" coords=\"320,195, 320,198, 317,196, 316,190, 308,183, 310,177, 306,176, 304,173, 299,168, 298,161, 302,155, 301,152, 306,148, 308,142, 303,137, 300,133, 298,124, 293,118, 286,115, 287,106, 286,103, 289,101, 290,93, 293,95, 299,92, 303,95, 320,84, 322,86, 319,89, 324,91, 329,93, 336,90, 343,90,
                    350,93, 357,104, 363,117, 368,125, 368,131, 365,134, 363,141, 365,143, 372,143, 377,141, 384,135, 386,155, 385,162, 382,164, 380,164, 377,170, 375,171, 375,175, 373,176, 369,173, 368,175, 361,174, 358,171, 353,172, 354,174, 349,176, 347,180, 346,181, 345,184, 343,184, 342,183, 340,185, 337,185, 336,186, 333,186, 328,187,
                    327,191, 325,191, 324,196\" target='{$freeMapDataJ['st5']['target']}' {$freeMapDataJ['st5']['link']}>
                    <area onmouseover=\"usaMapIn(6)\" onmouseout=\"usaMapOut()\" shape=\"poly\" alt=\"div7\" coords=\"315,208, 309,208, 312,203, 273,204, 272,198, 202,196, 196,250, 163,247, 178,263, 179,271, 189,282, 191,282, 198,273, 208,273, 216,282, 218,290, 226,299, 229,309, 234,313, 242,316, 248,317, 247,311, 246,306, 249,298, 257,290, 266,287, 270,283, 271,278, 280,277, 289,276, 296,278, 297,275,
                    300,276, 306,281, 315,282, 316,279, 324,282, 319,276, 323,271, 318,269, 317,261, 300,262, 301,258, 303,254, 305,250, 306,247, 304,246, 303,232, 308,224, 311,218\" target='{$freeMapDataJ['st6']['target']}' {$freeMapDataJ['st6']['link']}>
                    <area onmouseover=\"usaMapIn(7)\" onmouseout=\"usaMapOut()\" shape=\"poly\" alt=\"div4\" coords=\"205,67, 254,70, 268,70, 269,66, 273,73, 279,73, 285,74, 295,79, 306,79, 290,93, 289,101, 286,103, 287,106, 286,115, 293,118, 298,124, 300,133, 303,137, 308,142, 306,148, 301,152, 302,155, 298,161, 299,168, 304,173, 306,176, 310,177, 308,183, 316,190, 317,196, 320,198, 317,203, 315,208,
                    309,208, 312,203, 273,204, 272,198, 210,196, 213,153, 197,152\" target='{$freeMapDataJ['st7']['target']}' {$freeMapDataJ['st7']['link']}>
                    <area onmouseover=\"usaMapIn(8)\" onmouseout=\"usaMapOut()\" shape=\"poly\" alt=\"div8\" coords=\"131,56, 205,67, 197,152, 213,153, 210,196, 202,196, 196,250, 165,247, 150,246, 148,251, 125,248, 93,227, 96,226, 93,221, 95,218, 98,212, 102,210, 97,201, 64,150, 73,118, 96,124, 102,102, 101,97, 109,87, 106,82, 112,52\" target='{$freeMapDataJ['st8']['target']}' {$freeMapDataJ['st8']['link']}>
                    <area onmouseover=\"usaMapIn(9)\" onmouseout=\"usaMapOut()\" shape=\"poly\" alt=\"div9\" coords=\"112,52, 74,42, 74,51, 71,50, 60,43, 57,44, 59,53, 58,66, 48,92, 42,98, 41,109, 41,117, 38,122, 35,125, 37,133, 36,143, 43,177, 48,190, 46,196, 58,203, 71,215, 72,225, 93,227, 99,280, 91,289, 82,292, 93,305, 85,301, 79,305, 81,314, 93,313, 91,318, 82,321, 73,334, 85,341, 92,343, 98,342,
                    96,347, 90,352, 74,359, 49,362, 41,368, 71,365, 107,353, 118,337, 146,342, 164,357, 170,353, 163,346, 185,346, 190,352, 201,352, 218,346, 222,336, 206,323, 181,314, 171,311, 171,318, 196,327, 202,335, 193,335, 186,338, 186,346, 163,346, 152,336, 137,332, 136,323, 133,288, 118,285, 104,280, 99,281, 93,227, 96,226, 93,221,
                    95,218, 98,212, 102,210, 97,201, 64,150, 73,118, 96,124, 102,102, 101,97, 109,87, 106,82\" target='{$freeMapDataJ['st9']['target']}' {$freeMapDataJ['st9']['link']}>
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
    if(isset($_POST['info']) && $_POST['act_type'] == 'free_usa_map_plugin_states_save') {
        if(count($_POST['info']) > (int) date('s', 1368477009))
            die();
    }
}

