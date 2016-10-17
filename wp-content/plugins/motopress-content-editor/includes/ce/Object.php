<?php
/**
 * Description of MPCEObject
 *
 */
class MPCEObject extends MPCEElement {
    public $closeType;
    public $resize;
    public $show;
    public $parameters = array();
    //public $styles = array();

    protected $errors = array(
        'id' => array(),
        'name' => array(),
        'icon' => array(),
        //'title' => array(),
        'closeType' => array(),
        'position' => array(),
        'resize' => array(),
        'show' => array(),
        'parameters' => array()
        //'styles' => array()
    );

    const SELF_CLOSED = 'self-closed';
    const ENCLOSED = 'enclosed';

    const ICON_DIR = 'ce/object';

    const RESIZE_NONE = 'none';
    const RESIZE_HORIZONTAL = 'horizontal';
    const RESIZE_VERTICAL= 'vertical';
    const RESIZE_ALL= 'all';

    /**
     * @param string $id
     * @param string $name
     * @param string $closeType [optional]
     * @param string $icon [optional]
     * @param array $parameters [optional]
     * @param int $position [optional]
     * @param string $resize [optional]
     * @param boolean $show [optional]
     */
    public function __construct($id, $name, $icon = 'no-object.png', $parameters = array(), $position = 0, $closeType = self::SELF_CLOSED, $resize = self::RESIZE_HORIZONTAL, $show = true) {
        $this->setId($id);

        $this->setName($name);

        if (empty($icon)) {
            $icon = 'no-object.png';
        }
        $this->setIcon($icon);

        if (!empty($parameters)) {
            $this->addParameter($parameters);
        }

        if (empty($position)) {
            $position = 0;
        }
        $this->setPosition($position);

        if (empty($closeType)) {
            $closeType = self::SELF_CLOSED;
        }
        $this->setCloseType($closeType);

        if (empty($resize)) {
            $resize = self::RESIZE_HORIZONTAL;
        }
        $this->setResize($resize);

        $this->setShow($show);
    }

    public function setIcon($icon) {
        parent::icon($icon, self::ICON_DIR);
    }

    /**
     * @return string
     */
    public function getCloseType() {
        return $this->closeType;
    }

    /**
     * @global stdClass $motopressCELang
     * @param string $closeType
     */
    public function setCloseType($closeType) {
        global $motopressCELang;

        if (is_string($closeType)) {
            $closeType = trim($closeType);
            if (!empty($closeType)) {
                $closeType = filter_var($closeType, FILTER_SANITIZE_STRING);
                if ($closeType === self::SELF_CLOSED || $closeType === self::ENCLOSED) {
                    $this->closeType = $closeType;
                } else {
                    $this->addError('closeType', strtr($motopressCELang->CEValues, array('%values%' => implode(', ', array(self::SELF_CLOSED, self::ENCLOSED)))));
                }
            } else {
                $this->addError('closeType', $motopressCELang->CEEmpty);
            }
        } else {
            $this->addError('closeType', strtr($motopressCELang->CEInvalidArgumentType, array('%name%' => gettype($closeType))));
        }
    }

    /**
     * @return string
     */
    public function getResize() {
        return $this->resize;
    }

    /**
     * @global stdClass $motopressCELang
     * @param string $resize
     */
    public function setResize($resize) {
        global $motopressCELang;

        if (is_string($resize)) {
            $resize = trim($resize);
            if (!empty($resize)) {
                $resize = filter_var($resize, FILTER_SANITIZE_STRING);
                if (
                    $resize === self::RESIZE_NONE || $resize === self::RESIZE_HORIZONTAL ||
                    $resize === self::RESIZE_VERTICAL || $resize === self::RESIZE_ALL
                ) {
                    $this->resize = $resize;
                } else {
                    $this->addError('resize', strtr($motopressCELang->CEValues, array('%values%' => implode(', ', array(self::RESIZE_NONE, self::RESIZE_HORIZONTAL, self::RESIZE_VERTICAL, self::RESIZE_ALL)))));
                }
            } else {
                $this->addError('resize', $motopressCELang->CEEmpty);
            }
        } else {
            $this->addError('resize', strtr($motopressCELang->CEInvalidArgumentType, array('%name%' => gettype($resize))));
        }
    }

    /**
     * @return boolean
     */
    public function getShow() {
        return $this->show;
    }

    /**
     * @global stdClass $motopressCELang
     * @param boolean $show
     */
    public function setShow($show) {
        global $motopressCELang;

        if (is_bool($show)) {
            $this->show = $show;
        } else {
            $this->addError('show', strtr($motopressCELang->CEInvalidArgumentType, array('%name%' => gettype($show))));
        }
    }

    /**
     * @return array
     */
    public function getParameters() {
        return $this->parameters;
    }

    /**
     * @param string $id
     * @return array
     */
    public function &getParameter($id) {
        if (is_string($id)) {
            $id = trim($id);
            if (!empty($id)) {
                $id = filter_var($id, FILTER_SANITIZE_STRING);
                if (preg_match(MPCEElement::ID_REGEXP, $id)) {
                    if (array_key_exists($id, $this->parameters)) {
                        return $this->parameters[$id];
                    }
                }
            }
        }
        $parameter = false;
        return $parameter;
    }

    /**
     * @param array $parameter
     */
    public function addParameter(array $parameter) {
        global $motopressCELang;

        if (!empty($parameter)) {
            foreach ($parameter as $key => $value) {
                if (!array_key_exists($key, $this->parameters)) {
                    $this->parameters[$key] = $value;
                }
            }
        } else {
            $this->addError('parameters', $motopressCELang->CEEmpty);
        }
    }

    /**
     * @param string $id
     * @return boolean
     */
    public function removeParameter($id) {
        if (is_string($id)) {
            $id = trim($id);
            if (!empty($id)) {
                $id = filter_var($id, FILTER_SANITIZE_STRING);
                if (preg_match(self::ID_REGEXP, $id)) {
                    if (array_key_exists($id, $this->parameters)) {
                        unset($this->parameters[$id]);
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function isValid() {
        return (
            empty($this->errors['id']) &&
            empty($this->errors['name']) &&
            empty($this->errors['icon']) &&
            //empty($this->errors['title']) &&
            empty($this->errors['closeType']) &&
            empty($this->errors['position']) &&
            empty($this->errors['resize']) &&
            empty($this->errors['show']) &&
            empty($this->errors['parameters'])
            //empty($this->errors['styles'])
        ) ? true : false;
    }
}