<?php

defined('ABSPATH') or die("No script kiddies please!");

class InteroChimpSubscribeWidget extends WP_Widget
{
    /**
     * Register widget with WordPress.
     */
    function __construct()
    {
        parent::__construct(
            'intero_mailchimp_widget_subscribe', // Base ID
            __('Mailchimp subscribe widget', 'text_domain'), // Name
            array('description' => __('Subscription form widget', 'text_domain'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {

        $title = apply_filters('widget_title', $instance['title']);
        $isPopup = $instance['is_popup'];
        $listId = $instance['list_id'];
        $thankyou= $instance['thankyou'];

        echo $args['before_widget'];
        ?>
        <div id="interoSubscribe1" class="interochimp-form <?php echo $isPopup ? 'popup' : '' ?>">
            <a href="javascript:void(0)" class="interochimp-form-close">&nbsp;</a>
            <form action="" method="post">
                <h4><?php
                    echo empty($title) ? 'Подпишитесь на рассылку' : $title;
                    ?></h4>
                <fieldset>
                    <div class="form-group input text">
                        <label for="subscribe_email">Имя:</label>
                        <input type="text" id="subscribe_name" name="subscribe_name" placeholder="Ваше имя"/>
                    </div>
                    <div class="form-group input text">
                        <label for="subscribe_email">Email:</label>
                        <input type="email" id="subscribe_email" name="subscribe_email" placeholder="Ваш email"/>
                    </div>
                    <div class="input submit">
                        <button type="submit" class="btn btn-info">Подписаться</button>
                    </div>

                    <div class="emailloader">&nbsp;</div>
                    <p>Никакого спама. Только полезная информация.</p>

                    <input type="hidden" name="subscribe_list_id" value="<?php echo $listId;?>"/>
                    <input type="hidden" name="subscribe_thankyou" value="<?php echo $thankyou;?>"/>
                </fieldset>
            </form>
        </div>
        <?php
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance)
    {

        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('Subscribe to news', 'text_domain');
        }

        $isPopup = $instance['is_popup'] && true;
        $listId = $instance['list_id'];
        $thankYou = $instance['thankyou'];

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('is_popup'); ?>"><?php _e('Is popup:'); ?></label>
            <input type="checkbox" id="<?php echo $this->get_field_id('is_popup'); ?>"
                   name="<?php echo $this->get_field_name('is_popup'); ?>" <?php echo $isPopup ? 'checked="checked"' : ''?>/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('list_id'); ?>"><?php _e('List id:'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id('list_id'); ?>"
                   name="<?php echo $this->get_field_name('list_id'); ?>" value="<?php echo $listId; ?>"/>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('thankyou'); ?>"><?php _e('Thank you page:'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id('thankyou'); ?>"
                   name="<?php echo $this->get_field_name('thankyou'); ?>" value="<?php echo $thankYou; ?>"/>
        </p>
    <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['is_popup'] = $new_instance['is_popup'];
        $instance['list_id'] = $new_instance['list_id'];
        $instance['thankyou'] = $new_instance['thankyou'];
        return $instance;
    }
}