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
 * Editor provides an editor that is setup specifically for Big Cms. Two extra menu items are added
 * in the "Insert" submenu which can be used to insert block include statement and a page break.
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
     * @var bool $useReadMore if true the "insert" menu will contain an button to insert a "Read more"
     * tag in the editor.
     */
    public $useReadMore = true;


    /**
     * Initializes this widget.
     */
    public function init()
    {
        parent::init();
        // register css for the block button icon
        $this->getView()->registerCss('
            .mce-i-insertblock:before {
                content: "\f0c8";
                font-family: FontAwesome;
                font-size: 18px;
            }
            .mce-i-map-pin:before {
                content: "\f276";
                font-family: FontAwesome;
                font-size: 16px;
            }
        ');
        $this->clientOptions = array_merge($this->clientOptions(), $this->clientOptions);
    }
    
    /**
     * Returns a default configuration array for the editor.
     * This includes two extra menu items under "Insert". One that inserts a block include statement
     * and one that inserts a "Read more" link. A custom css file is also registered by using the
     * TinyMCE property "content_css". Finally two extra image format options are included in the "Format"
     * menu: "Image left" and "Image right" which aligns an image right or left properly.
     *
     * @return array default editor configuration.
     */
    public function clientOptions()
    {
        $contentCss = '';
        if ($this->skinUrl === null) {
            $bundle = EditorSkinAsset::register($this->getView());
            $this->skinUrl = $bundle->baseUrl;
            if (is_file($bundle->basePath . '/' . $this->skin . '/bigcms_styles.css')) {
                $contentCss = $this->skinUrl . '/' . $this->skin . '/bigcms_styles.css';
            }
        }

        $setup = '';
        if ($this->useReadMore) {
            $setup .= 'editor.addMenuItem("bigcmsreadmore", {
                text: "' . Yii::t('cms', 'Read more') . '",
                icon: "map-pin",
                context: "insert",
                prependToContext: true,
                onclick: function() {
                    if (editor.getContent().match(/<hr\s+id=("|\\\')system-readmore("|\\\')\s*\/*>/i))
                    {
                        alert("' . Yii::t('cms', "There is already one 'Read more' link in the editor. Only one is allowed.") . '");
                        return false;
                    } else {
                        editor.insertContent("<hr id=\"system-readmore\" /> ");
                    }
                }
            });';
        }
        $setup .= 'editor.addMenuItem("bigcmsinsertblock", {
            text: "' . Yii::t('cms', 'Block') . '",
            icon: "insertblock",
            id: "block-button",
            context: "insert",
            prependToContext: true,
            onclick: function() {
                editor.insertContent("<div>{block ' . Yii::t('cms', 'INSERT_BLOCK_TITLE') . '}</div><p>&nbsp;</p>");
            }
        });';

    	return [
            'skin_url' => $this->skinUrl . '/' . $this->skin,
            'skin' => $this->skin,
            'content_css' => $contentCss,
            'style_formats_merge' => true,
            'style_formats' => [
                [
                    'title' => Yii::t('cms', 'Image Left'),
                    'selector' => 'img',
                    'styles' => [
                        'float' => 'left',
                        'margin' => '0 10px 10px 0',
                    ]
                ],
                [
                    'title' => Yii::t('cms', 'Image right'),
                    'selector' => 'img',
                    'styles' => [
                        'float' => 'right',
                        'margin' => '0 0 10px 10px',
                    ]
                ],
            ],
            'plugins' => 'contextmenu advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table contextmenu paste',
            'toolbar' => 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image readmorebtn',
            'setup' => new JsExpression('function(editor) {
                ' . $setup . '
            }'),
        ];
    }
}
