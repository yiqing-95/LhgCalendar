<?php
/**
 *
 * User: yiqing
 * Date: 13-9-27
 * Time: 下午7:25
 * To change this template use File | Settings | File Templates.
 * -------------------------------------------------------
 *
 * -------------------------------------------------------
 */

class LhgCalendar extends CInputWidget
{

    /**
     *
     * @var bool
     */
    public $debug = YII_DEBUG;
    /**
     * @var string
     *
     */
    public $inputId;

    /**
     * @var array
     */
    public $options = array();

    /**
     * @var array
     */
    protected $defaultOptions = array();

    /**
     *
     */
    public function init()
    {
        $assets = self::getAssetsPath();

        parent::init();

        $this->defaultOptions = array();
    }

    /**
     * @static
     * @return string
     */
    public static function getAssetsPath()
    {
        $baseDir = dirname(__FILE__);
        return Yii::app()->getAssetManager()->publish($baseDir . DIRECTORY_SEPARATOR . 'assets',false,-1,YII_DEBUG);
    }

    /**
     * @return $this
     */
    public function publishAssets()
    {
        $assets = self::getAssetsPath();

        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery')

            ->registerScriptFile($assets . '/lhgcalendar.min.js', CClientScript::POS_HEAD);

        return $this;
    }

    /**
     *
     */
    public function  run()
    {
        $this->publishAssets();

        /**
         * you can use it just for giving a inputId for the existing textArea input
         */
        if (!isset($this->inputId)) {
            if ($this->hasModel()) {
                echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
                // list($name, $id) = $this->resolveNameID();
                $this->inputId = CHtml::activeId($this->model, $this->attribute);

            } else {
                echo CHtml::textField($this->name, $this->value, $this->htmlOptions);
                $this->inputId = CHtml::getIdByName($this->name);
            }
            if (isset($this->htmlOptions['id'])) {
                $this->inputId = $this->htmlOptions['id'];
            }
        }


        $options = CJavaScript::encode(CMap::mergeArray($this->defaultOptions, $this->options));

        $script = <<<EOP
    $(function() {
       	$('#{$this->inputId}').calendar({$options});
	});

EOP;

        Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $this->inputId, $script, CClientScript::POS_HEAD);
    }


    public function __set($name, $value)
    {
        try {
            //shouldn't swallow the parent ' __set operation
            parent::__set($name, $value);
        } catch (Exception $e) {
            $this->options[$name] = $value;
        }
    }

}