<?php

namespace LBYT;

class SettingsPage extends WpSubPage
{

    public function render_settings_page()
    {
        $option_name = $this->settings_page_properties['option_name'];
        $option_group = $this->settings_page_properties['option_group'];
        $settings_data = $this->get_settings_data();

        if (isset($_REQUEST["settings-updated"])) {
            echo "
                    <div 
                        style='color: green; 
                        font-weight: bold; 
                        font-size: 16px; 
                        background-color: honeydew; 
                        padding: 5px'>
                            <span class='dashicons dashicons-saved'></span>
                            <span>Saved successfully!</span>
                    </div>
                    ";
        }
        ?>

        <div class="wrap">
            <h2>LB Youtube Plugin</h2>
            <p>Please type the API Key and Channel ID.</p>
            <form method="post" action="options.php">
                <?php
                settings_fields($option_group);
                ?>
                <table class="form-table">
                    <tr>
                        <th><label for="api_key">API Key:</label></th>
                        <td>
                            <input type="text"
                                   id="api_key"
                                   size="50"
                                   name="<?php echo esc_attr($option_name . "[api_key]"); ?>"
                                   value="<?php echo esc_attr($settings_data['api_key']); ?>"
                            />
                        </td>
                    </tr>
                    <tr>
                        <th><label for="channel_id">Channel ID:</label></th>
                        <td>
                            <input type="text"
                                   id="channel_id"
                                   size="50"
                                   name="<?php echo esc_attr($option_name . "[channel_id]"); ?>"
                                   value="<?php echo esc_attr($settings_data['channel_id']); ?>"
                            />
                        </td>
                    </tr>
                    <tr>
                        <th><label>Shortcode:</label></th>
                        <td>
                            <p>lbyt_shortcode</p>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <span class="dashicons dashicons-editor-help"></span>
                            <label>Need Help?</label>
                        </th>
                        <td>
                            <p>Post your question at the Support Forum.</p>
                        </td>
                    </tr>
                </table>
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Options">
            </form>
        </div>
        <?php
    }

    public function get_default_settings_data()
    {
        $defaults = array();
        $defaults['api_key'] = "";
        $defaults['channel_id'] = "";

        return $defaults;
    }
}
