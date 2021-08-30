<?php
// +----------------------------------------------------------------------
// | Html2imagesAsset
// +----------------------------------------------------------------------
// | User: Lengnuan <25314666@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021年08月27日
// +----------------------------------------------------------------------

namespace lengnuan\html2images;

use yii\web\AssetBundle;

class Html2imagesAsset extends AssetBundle
{
    public $sourcePath = '@vendor/lengnuan-v/yii2-html2images/src/assets';

    /**
     * @var array
     */
    public $css = [
        'css/html2images.css',
    ];

    /**
     * @var array
     */
    public $js = [
        'js/jspdf.umd.min.js',
        'js/html2canvas.min.js',
    ];
}