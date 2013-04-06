<?php
/**
 * File CAdvancedClientScriptBehavior.
 *
 * @category  Mobipark
 * @package   Estensions/Behaviors/ClientScript
 * @author    Marco Garofalo <garofalo@olomedia.it>
 * @copyright 2012 Olomedia
 * @license   www.olomedia.it Licenza
 * @link      www.olomedia.it
 */

/**
 * Classe CAdvancedClientScriptBehavior.
 *
 * @category  Application
 * @package   Estensions/Behaviors/ClientScript
 * @author    Marco Garofalo <garofalo@olomedia.it>
 * @copyright 2012 Olomedia
 * @license   www.olomedia.it Licenza
 * @link      www.olomedia.it
 */
class CAdvancedClientScriptBehavior extends CBehavior
{
    protected $activeScriptId;
    protected $activeScriptPosition;

    /**
     * Start buffering.
     *
     * @param string $id  script id
     * @param int    $pos script position
     *
     * @return void;
     */
    public function beginScript($id, $pos = CClientScript::POS_READY)
    {
        $this->activeScriptId = $id;
        $this->activeScriptPosition = $pos;
        ob_start();
        ob_implicit_flush(false);
    }

    /**
     * Closing the buffer.
     *
     * @return void
     */
    public function endScript()
    {
        $script = ob_get_clean();
        // removing script tag
        $script = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "$1", $script);
        Yii::app()->clientScript->registerScript($this->activeScriptId, $script, $this->activeScriptPosition);

    }
}
