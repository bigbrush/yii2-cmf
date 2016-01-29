<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\widgets;

use Yii;
use yii\web\JsExpression;
use bigbrush\big\widgets\editor\Editor as BigEditor;

/**
 * Editor provides an editor that is setup specifically for Big Cms. An extra menu item is added
 * in the "Insert" submenu which can be used to insert block include statement.
 *
 * Big Cms will automatically detect any include statements and insert block content. This
 * is done in the plugin [[bigbrush\cms\plugins\system\blockinclude\Plugin]].
 */
class Editor extends BigEditor
{
    /**
     * @var string defines the skin to use.
     * @see http://www.tinymce.com/wiki.php/Configuration:skin
     */
    public $skin = 'light';
    /**
     * @var string defines the skin_url to use.
     * If this property is not set the asset bundle [[EditorSkinAsset]] is used as skin url.
     * @see http://www.tinymce.com/wiki.php/Configuration:skin_url
     */
    public $skinUrl;


    /**
     * Initializes this widget.
     */
    public function init()
    {
        parent::init();
        // register css for the block button icon
        $this->getView()->registerCss('
            #block-button .mce-i-insertblock:before {
                content: "\f0c8";
                font-family: FontAwesome;
                font-size: 18px;
            }
        ');
        $this->clientOptions = array_merge($this->clientOptions(), $this->clientOptions);
    }
    
    /**
     * Returns a default configuration array for the editor.
     * This includes an extra menu item under "Insert" that inserts a block include statement. You should call [[process()]]
     * when displaying content created with this editor.
     *
     * @return array default editor configuration.
     */
    public function clientOptions()
    {
        if ($this->skinUrl === null) {
            $bundle = EditorSkinAsset::register($this->getView());
            $this->skinUrl = $bundle->baseUrl;
        }
    	return [
            'skin_url' => $this->skinUrl . '/' . $this->skin,
            'skin' => $this->skin,
            'plugins' => 'contextmenu advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table contextmenu paste',
            'toolbar' => 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            'setup' => new JsExpression('function(editor) {
                editor.addMenuItem("insertblock", {
                    text: "' . Yii::t('cms', 'Block') . '",
                    icon: "insertblock",
                    id: "block-button",
                    context: "insert",
                    prependToContext: true,
                    onclick: function() {
                        editor.insertContent("<div>{block ' . Yii::t('cms', 'INSERT_BLOCK_TITLE') . '}</div><p>&nbsp;</p>");
                    }
                });
            }')
        ];
    }
}
