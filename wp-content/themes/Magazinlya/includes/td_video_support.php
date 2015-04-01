<?php

/*  ----------------------------------------------------------------------------
    tagDiv video support
    - downloads the video thumbnail and puts it asa a featured image to the post
 */

class td_video_support{

    /*
     * youtube
     */
    function getYoutubeId($videoUrl) {
        $query_string = array();
        parse_str(parse_url($videoUrl, PHP_URL_QUERY), $query_string);
        if (empty($query_string["v"])) {
            //short link: http://youtu.be/AgFeZr5ptV8
            $yt_short_link_parts = explode('/', $videoUrl);
            if (!empty($yt_short_link_parts[3])) {
                return $yt_short_link_parts[3];
            }
        } else {
            return $query_string["v"];
        }

    }

    /*
     * Vimeo id
     */
    function getVimeoId($videoUrl) {
        sscanf(parse_url($videoUrl, PHP_URL_PATH), '/%d', $video_id);
        return $video_id;
    }

    /*
     * Dailymotion
     */
    function getDailymotionID($videoUrl) {
        $id = strtok(basename($videoUrl), '_');
        if (strpos($id,'#video=') !== false) {
            $videoParts = explode('#video=', $id);
            if (!empty($videoParts[1])) {
                return $videoParts[1];
            }
        } else {
            return $id;
        }

    }

    /*
     * Detect the video service from url
     */
    function detectVideoSearvice($videoUrl) {
        $videoUrl = strtolower($videoUrl);
        if (strpos($videoUrl,'youtube.com') !== false or strpos($videoUrl,'youtu.be') !== false) {
            return 'youtube';
        }
        if (strpos($videoUrl,'dailymotion.com') !== false) {
            return 'dailymotion';
        }
        if (strpos($videoUrl,'vimeo.com') !== false) {
            return 'vimeo';
        }

        return false;
    }


    function is404($url) {
        $headers = get_headers($url);
        if (strpos($headers[0],'404') !== false) {
            return true;
        } else {
            return false;
        }
    }


    //returns the thumb url
    function getThumbUrl($videoUrl) {
        switch ($this->detectVideoSearvice($videoUrl)) {
            case 'youtube':
                if (!$this->is404('http://img.youtube.com/vi/' . $this->getYoutubeId($videoUrl) . '/maxresdefault.jpg')) {
                    return 'http://img.youtube.com/vi/' . $this->getYoutubeId($videoUrl) . '/maxresdefault.jpg';
                } else {
                    return 'http://img.youtube.com/vi/' . $this->getYoutubeId($videoUrl) . '/hqdefault.jpg';
                }

                break;
            case 'dailymotion':

                break;
            case 'vimeo':
                $vimeoApi = @file_get_contents('http://vimeo.com/api/v2/video/' . $this->getVimeoId($videoUrl) . '.php');
                if (!empty($vimeoApi)) {
                    $vimeoApiData = @unserialize($vimeoApi);
                    if (!empty($vimeoApiData[0]['thumbnail_large'])) {
                        return $vimeoApiData[0]['thumbnail_large'];
                    }
                    //print_r($vimeoApiData);
                }

                break;
        }
    }

    function renderVideo($videoUrl) {
        $buffy = '';
        switch ($this->detectVideoSearvice($videoUrl)) {
            case 'youtube':
                $buffy .= '
                <div class="wpb_video_wrapper">
                    <iframe width="600" height="560" src="http://www.youtube.com/embed/' . $this->getYoutubeId($videoUrl) . '?feature=oembed&wmode=opaque" frameborder="0" allowfullscreen=""></iframe>
                </div>
                ';

                break;
            case 'dailymotion':

                break;
            case 'vimeo':
                $buffy = '
                <div class="wpb_video_wrapper">
                    <iframe src="http://player.vimeo.com/video/' . $this->getVimeoId($videoUrl) . '" width="500" height="212" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                </div>
                ';
                break;
        }
        return $buffy;
    }


    function validateVideoUrl($videoUrl) {
        if ($this->detectVideoSearvice($videoUrl) === false) {
            return false;
        }

        if (!preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $videoUrl)) {
            return false;
        }

        return true;
    }
}



function new_attachment($att_id){
// the post this was sideloaded into is the attachments parent!
    $p = get_post($att_id);
    update_post_meta($p->post_parent,'_thumbnail_id',$att_id);
}

add_action( 'save_post', 'td_get_video_thumb' );

function td_get_video_thumb( $post_id ) {
    //verify post is not a revision
    if ( !wp_is_post_revision( $post_id ) ) {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        $td_post_video = get_post_meta($post_id, 'td_post_video', true);


        //load video support
        $td_video_support = new td_video_support();

        //check to see if the url is valid
        if (empty($td_post_video['td_video']) or $td_video_support->validateVideoUrl($td_post_video['td_video']) === false) {
            return;
        }



        if (!empty($td_post_video['td_last_video']) and $td_post_video['td_last_video'] == $td_post_video['td_video']) {
            //we did not update the url
            return;
        }



        //$myFile = "D:/td_video.txt";
        //$fh = fopen($myFile, 'a') or die("can't open file");
        $stringData = $post_id . ' - ' . print_r($td_post_video, true) . "\n";

        //return;


        $videoThumbUrl = $td_video_support->getThumbUrl($td_post_video['td_video']);

        /*
        $stringData .= $post_id . ' - ' . $videoThumbUrl . "\n";
        fwrite($fh, $stringData);
        fclose($fh);

        */

        if (!empty($videoThumbUrl)) {
            // add the function above to catch the attachments creation
            add_action('add_attachment','new_attachment');

            // load the attachment from the URL
            media_sideload_image($videoThumbUrl, $post_id, $post_id);

            // we have the Image now, and the function above will have fired too setting the thumbnail ID in the process, so lets remove the hook so we don't cause any more trouble
            remove_action('add_attachment','new_attachment');
        }

    }
}


//echo $td_video_support->getThumbUrl('http://www.youtube.com/watch?v=irE7miqG_LU&list=FLOBuNbx8x0RyDnCgLpTznHA&index=2');
//echo '<br>';
//echo $td_video_support->getThumbUrl('http://vimeo.com/15274619');

?>