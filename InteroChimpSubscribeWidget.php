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

        echo $args['before_widget'];
        ?>
        <form action="" method="post" class="interochimp-form">
            <?php
            if (!empty($title)):
                ?>
                <h3><?php echo $args['before_title'] . $title . $args['after_title'];?></h3>
            <?php
            endif;
            ?>
            <div class="input text">
                <label for="subscribe_email">Имя:</label>
                <input type="text" id="subscribe_name" name="subscribe_name" placeholder="Ваше имя"/>
            </div>
            <div class="input text">
                <label for="subscribe_email">Email:</label>
                <input type="email" id="subscribe_email" name="subscribe_email" placeholder="Ваш email"/>
            </div>
            <div class="input submit">
                <button type="submit" >Отправить</button>
            </div>
        </form>
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
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>">
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

        return $instance;
    }
}