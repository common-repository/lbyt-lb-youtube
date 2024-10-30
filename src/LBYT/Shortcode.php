<?php

namespace LBYT;

class Shortcode
{
    protected $settings_page_properties;

    public function __construct($settings_page_properties)
    {
        $this->settings_page_properties = $settings_page_properties;
        $this->run();
    }

    public function run()
    {
        add_shortcode('lbyt_shortcode', array($this, 'lbyt_shortcode'));
    }

    public function get_settings_data()
    {
        return get_option($this->settings_page_properties['option_name'], $this->get_default_settings_data());
    }

    public function get_default_settings_data()
    {
        $defaults = array();

        return $defaults;
    }

    function lbyt_shortcode()
    {
        $settings_data = $this->get_settings_data();
        $api_key = urlencode(esc_attr($settings_data['api_key']));
        $channel_id = urlencode(esc_attr($settings_data['channel_id']));
        $request_url = "https://www.googleapis.com/youtube/v3/search?part=snippet&channelId="
            . $channel_id . "&maxResults=10&order=date&type=video&key=" . $api_key;

        $options = array("http" => array("user_agent" => $_SERVER['HTTP_USER_AGENT']));
        $context = stream_context_create($options);
        $response = wp_remote_get($request_url, false, $context);
        $http_code = wp_remote_retrieve_response_code($response);

        if ($http_code == 200) {
            $data = json_decode($response["body"]);
            $videoId = esc_attr($data->items[0]->id->videoId);
            return do_shortcode(
                '<iframe
                src="https://www.youtube.com/embed/' . $videoId . '"
                allowfullscreen
                style="width:400px;height:225px;">
            </iframe>'
            );
        }
        return "Some error occured, please check API Key and Channel ID.";
    }
}
