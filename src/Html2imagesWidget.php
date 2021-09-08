<?php
// +----------------------------------------------------------------------
// | Html2imagesWidget.php
// +----------------------------------------------------------------------
// | User: Lengnuan <25314666@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021年08月27日
// +----------------------------------------------------------------------

namespace lengnuan\html2images;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;

class Html2imagesWidget extends Widget
{
    public $id;

    public $html;

    public $name;

    public $class = 'content-html';

    public $icon = 'fa fa-download';

    public $alert = '数据开始下载中，请稍后...';

    public $backgroundColor = '#f4f6f9';

    public $removeClass;

    public function run()
    {
        $this->id   = $this->id ? : $this->getId();
        $this->name = $this->name ? : date('YmdHis');
        echo $this->html ? :Html::tag('div', Html::tag('div', '<i class="' . $this->icon . ' f15 text-white"></i>', ['class' => 'download']), ['id' => $this->id, 'class' => 'html2images cursor']);
        $this->registerClientScript();
    }

    public function registerClientScript()
    {
        $view = $this->getView();

        Html2imagesAsset::register($view);

        $view->registerJs("
            const exportBtn = document.querySelector('#$this->id');
            const { jsPDF } = jspdf;
            exportBtn.addEventListener('click', () => {
                alert('$this->alert');
                $('body').removeClass('$this->removeClass')
                setTimeout(function () {
                    let offsetLeft = $('.$this->class').offset().left;
                    const _articleHtml = document.querySelector('.$this->class');
                    let _w = _articleHtml.clientWidth + 20;
                    let _h = _articleHtml.clientHeight + 20;
                    const scale = 3;
                    if (_w > _h) {
                        _h = _w;
                    }
                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d');
                    canvas.width = _w * scale;
                    canvas.height = _h * scale;
                    context.fillStyle = '#008800';
                    context.fillRect(0, 0, canvas.offsetWidth, canvas.offsetHeight);
                    context.scale(scale, scale);
                    let opts = {
                        scale: 1,
                        width: _w,
                        height: _h,
                        canvas: canvas,
                        useCORS: true,
                        scrollY: 0,
                        scrollX: 10,
                        backgroundColor: '$this->backgroundColor',
                    }
                    html2canvas(_articleHtml, opts).then(canvas => {
                        const contentWidth = canvas.width / scale;
                        const contentHeight = canvas.height / scale;
                        const pdf = new jsPDF('', 'pt', [contentWidth, contentHeight]);
                        const pageData = canvas.toDataURL('image/jpeg', 1.0);
                        pdf.addImage(pageData, 'JPEG', 0, 0, contentWidth, contentHeight);
                        pdf.save(`$this->name.pdf`);
                    })
                    $('body').addClass('$this->removeClass')
                }, 1000)
            })
        ");
    }
}
