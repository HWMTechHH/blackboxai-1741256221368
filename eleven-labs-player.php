<?php
/**
 * Plugin Name: Eleven Labs Player
 * Description: A WordPress plugin that adds a player to read articles aloud using Eleven Labs API.
 * Version: 1.0
 * Author: Stormarn.Tech
 */

define('ELEVEN_LABS_API_KEY', 'sk_3fa3380ea4ed7b14e47c6501c7da877376db46d8c96dbfed');

// Enqueue styles and scripts
function eleven_labs_enqueue_scripts() {
    wp_enqueue_style('eleven-labs-style', plugin_dir_url(__FILE__) . 'style.css');
    wp_enqueue_script('eleven-labs-script', plugin_dir_url(__FILE__) . 'script.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'eleven_labs_enqueue_scripts');

// Add player to each post
function eleven_labs_add_player($content) {
    $player_html = '
    <div class="col-lg-12" style="margin-bottom: 1.5rem;">
        <div class="bt-player bordered" style="background: rgb(255, 255, 255);">
            <div class="bt-player__cta">Diesen Artikel vorlesen lassen</div>
            <div class="bt-playbtn">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 26 26" xml:space="preserve" width="48" height="48">
                    <polygon class="bt-playbtn-play" points="9.3,6.7 9.3,19.4 19.3,13" fill="#ca0019"></polygon>
                    <g>
                        <path d="M13,1c6.6,0,12,5.4,12,12s-5.4,12-12,12S1,19.6,1,13S6.4,1,13,1 M13,0C5.8,0,0,5.8,0,13s5.8,13,13,13s13-5.8,13-13 S20.2,0,13,0L13,0z" fill="#ca0019"></path>
                    </g>
                    <g class="bt-playbtn-pause">
                        <rect x="10" y="7.7" width="2" height="10.7" fill="#ca0019"></rect>
                        <rect x="14" y="7.7" width="2" height="10.7" fill="#ca0019"></rect>
                    </g>
                </svg>
            </div>
            <div class="bt-player__wave">
                <div style="position: relative; width: 100%; height: 100%; cursor: pointer;">
                    <canvas width="649" height="30" style="width: 649px; height: 30px;"></canvas>
                    <div style="position: absolute; z-index: 2; left: 0px; top: 0px; bottom: 0px; overflow: hidden; height: 30px; width: 0px; display: block; transition: width 10ms ease-in-out; box-sizing: border-box;">
                        <canvas width="649" height="30" style="width: 649px; height: 30px;"></canvas>
                    </div>
                </div>
            </div>
            <div class="bt-player__time-volume-container">
                <button type="button" class="bt-player__volume-mute">
                    <svg width="12" height="12" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0 5.10001V10.4H3.6L8 14.9V0.700012L3.6 5.10001H0Z" fill="#ca0019"></path>
                        <path d="M10 1.8V0C13.5 0.8 16.2 4 16.2 7.8C16.2 11.6 13.6 14.8 10 15.6V13.8C12.5 13 14.4 10.6 14.4 7.8C14.4 4.9 12.6 2.6 10 1.8Z" fill="#ca0019"></path>
                        <path d="M10 4.2C11.3 4.9 12.2 6.2 12.2 7.8C12.2 9.4 11.3 10.7 10 11.3V4.2Z" fill="#ca0019"></path>
                        <path d="M15.7 6.20002L14.4 4.90002L12.8 6.50002L11.2 4.90002L9.90002 6.20002L11.5 7.80002L9.90002 9.40002L11.2 10.7L12.8 9.10002L14.4 10.7L15.7 9.40002L14.1 7.80002L15.7 6.20002Z" fill="transparent"></path>
                    </svg>
                </button>
                <div class="bt-player__time"><span><span>00</span>:<span>00</span></span> / <span><span>00</span>:<span>05</span></span></div>
                <div class="bt-player__volume-slider">
                    <div class="bt-player__volume-slider__value" style="width: 50%; background-color: rgb(202, 1, 25);"></div>
                </div>
                <div class="bt-player__speed"><span class="bt-player__speed-option">1X</span></div>
                <a href="https://stormarn.tech" target="_blank" rel="noopener" class="bt-player__bottalk"><span>Stormarn.Tech</span></a>
                <audio preload="metadata" title="" src=""></audio>
                <div id="bt-ad-container"></div>
            </div>
        </div>
    </div>';
    
    if (is_single() && 'post' === get_post_type()) {
        return $player_html . $content;
    }
    return $content;
}
add_filter('the_content', 'eleven_labs_add_player');
?>
