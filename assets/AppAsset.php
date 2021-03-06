<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace ra\admin\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
    ];

    public $js = [
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\jui\JuiAsset',
        'ra\admin\assets\TagsInputAsset',
        'ra\admin\assets\DropZoneAsset',
        'ra\admin\widgets\adminTheme\AdminThemeAsset',
    ];
}
