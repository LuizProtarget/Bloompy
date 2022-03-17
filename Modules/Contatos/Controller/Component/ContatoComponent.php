<?php

class ContatoComponent extends Component {

    /**
     * Controller reference
     *
     * @var Controller
     */
    protected $_controller = null;

    /**
     * Constructor
     *
     * @param ComponentCollection $collection A ComponentCollection this component can use to lazy load its components
     * @param array $settings Array of configuration settings.
     */
    public function initialize(Controller $Controller) {
        $this->_controller = $Controller;
    }
}