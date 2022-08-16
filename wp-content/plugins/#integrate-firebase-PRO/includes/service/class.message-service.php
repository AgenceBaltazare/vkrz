<?php

/**
 * Add Firebase setting menu
 * @var [type]
 */

class IFP_Message {
    private $_message;
    private $_type;

    function __construct($message, $type) {
        $this->_message = $message;
        $this->type = $type;

        add_action('admin_notices', array($this, 'render'));
    }

    function render() {
        global $pagenow;
        if ('index.php' === $pagenow || (isset($_GET['page']) && $_GET['page'] === 'firebase-setting')) {
            printf('
                <div class="notice notice-%s is-dismissible">
                    <p><strong>Integrate Firebase PRO<strong></p>
                    <p>%s</p>
                </div>
            ', 'error', $this->_message);
        }
    }
}
