<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

namespace app\common\captcha;

use Closure;
use Exception;
use GdImage;
use think\Response;

class Captcha
{
    private ?GdImage $image = null; // 验证码图片实例
    private int $color = 0; // 验证码字体颜色
    // 验证码字符集合
    protected string $codeSet = '2345678abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY';
    // 使用背景图片
    protected bool $useImgBg = false;
    // 是否画混淆曲线
    protected bool $useCurve = true;
    // 是否添加杂点
    protected bool $useNoise = true;
    // 验证码图片高度
    protected int $imageH = 0;
    // 验证码图片宽度
    protected int $imageW = 0;
    // 验证码位数
    protected int $length = 5;
    // 验证码字体大小(px)
    protected int $fontSize = 25;
    // 验证码字体，不设置随机获取
    protected string $fontttf = '';
    // 背景颜色
    protected array $bg = [243, 251, 254];
    //从 0 到 127。0 表示完全不透明，127 表示完全透明。
    protected int $alpha = 0;
    // 使用API模式生成
    protected bool $api = false;
    // 验证码干扰项及处理方法
    protected array $interfere = [
        'useImgBg' => 'background',
        'useCurve' => 'writeCurve',
        'useNoise' => 'writeNoise',
    ];


    public function setApi($enable = false)
    {
        $this->api = $enable;
    }

    /**
     * 创建验证码
     * @return string
     * @throws Exception
     */
    public function getCode(): string
    {
        $bag = '';
        $characters = str_split($this->codeSet);
        for ($i = 0; $i < $this->length; $i++) {
            $bag .= $characters[random_int(0, count($characters) - 1)];
        }
        return strtolower($bag);

    }

    /**
     * 输出验证码图片或者JSON 数组
     * @access public
     * @return Response|array
     * @throws Exception
     */
    public function create($code)
    {
        $this->imageW || $this->imageW = (int)($this->length * $this->fontSize * 1.5 + $this->length * $this->fontSize / 2);
        $this->imageH || $this->imageH = (int)($this->fontSize * 2.5);
        $this->imageW = (int)$this->imageW;
        $this->imageH = (int)$this->imageH;
        // 建立一幅 $this->imageW x $this->imageH 的图像
        $this->image = imagecreate($this->imageW, $this->imageH);
        // 设置背景
        imagecolorallocatealpha($this->image, $this->bg[0], $this->bg[1], $this->bg[2], $this->alpha);
        // 验证码字体随机颜色
        $this->color = imagecolorallocate($this->image, mt_rand(1, 150), mt_rand(1, 150), mt_rand(1, 150));
        // 验证码使用随机字体
        $ttfPath = __DIR__ . '/assets/ttfs/';
        if (empty($this->fontttf)) {
            $dir = dir($ttfPath);
            $ttfs = [];
            while (false !== ($file = $dir->read())) {
                if (str_ends_with($file, '.ttf') || str_ends_with($file, '.otf')) {
                    $ttfs[] = $file;
                }
            }
            $dir->close();
            $this->fontttf = $ttfs[array_rand($ttfs)];
        }
        $fontttf = $ttfPath . $this->fontttf;
        // 添加干扰项
        foreach ($this->interfere as $type => $method) {
            if ($method instanceof Closure) {
                $method($this->image, $this->imageW, $this->imageH, $this->fontSize, $this->color);
            } elseif ($this->$type) {
                $this->$method();
            }
        }
        // 绘验证码
        $text = str_split($code); // 验证码
        foreach ($text as $index => $char) {
            $x = $this->fontSize * ($index + 1) * 1.5;
            $y = $this->fontSize + mt_rand(10, 20);
            $angle = mt_rand(-40, 40);
            imagettftext($this->image, $this->fontSize, $angle, (int)$x, $y, $this->color, $fontttf, $char);
        }
        ob_start();
        // 输出图像
        imagepng($this->image);
        $content = ob_get_clean();
        imagedestroy($this->image);

        // API调用模式
        if ($this->api) {
            return [
                'code' => implode('', $text),
                'img' => 'data:image/gif;base64,' . base64_encode($content),
            ];
        }
        // 输出验证码图片
        return  response($content, 200, ['Content-Length' => strlen($content)])->contentType('image/gif');
    }

    /**
     * 画一条由两条连在一起构成的随机正弦函数曲线作干扰线(你可以改成更帅的曲线函数)
     *
     *      高中的数学公式咋都忘了涅，写出来
     *        正弦型函数解析式：y=Asin(ωx+φ)+b
     *      各常数值对函数图像的影响：
     *        A：决定峰值（即纵向拉伸压缩的倍数）
     *        b：表示波形在Y轴的位置关系或纵向移动距离（上加下减）
     *        φ：决定波形与X轴位置关系或横向移动距离（左加右减）
     *        ω：决定周期（最小正周期T=2π/∣ω∣）
     *
     */
    protected function writeCurve(): void
    {
        $py = 0;
        // 曲线前部分
        $A = mt_rand(1, (int)($this->imageH / 2)); // 振幅
        $b = mt_rand((int)(-$this->imageH / 4), (int)($this->imageH / 4)); // Y轴方向偏移量
        $f = mt_rand((int)(-$this->imageH / 4), (int)($this->imageH / 4)); // X轴方向偏移量
        $T = mt_rand($this->imageH, $this->imageW * 2); // 周期
        $w = (2 * M_PI) / $T;

        $px1 = 0; // 曲线横坐标起始位置
        $px2 = mt_rand((int)($this->imageW / 2), (int)($this->imageW * 0.8)); // 曲线横坐标结束位置

        for ($px = $px1; $px <= $px2; $px = $px + 1) {
            if (0 != $w) {
                $py = $A * sin($w * $px + $f) + $b + $this->imageH / 2; // y = Asin(ωx+φ) + b
                $i = (int)($this->fontSize / 5);
                while ($i > 0) {
                    imagesetpixel($this->image, (int)($px + $i), (int)($py + $i), $this->color); // 这里(while)循环画像素点比imagettftext和imagestring用字体大小一次画出（不用这while循环）性能要好很多
                    $i--;
                }
            }
        }

        // 曲线后部分
        $A = mt_rand(1, (int)($this->imageH / 2)); // 振幅
        $f = mt_rand((int)(-$this->imageH / 4), (int)($this->imageH / 4)); // X轴方向偏移量
        $T = mt_rand($this->imageH, $this->imageW * 2); // 周期
        $w = (2 * M_PI) / $T;
        $b = $py - $A * sin($w * $px + $f) - $this->imageH / 2;
        $px1 = $px2;
        $px2 = $this->imageW;

        for ($px = $px1; $px <= $px2; $px = $px + 1) {
            if (0 != $w) {
                $py = $A * sin($w * $px + $f) + $b + $this->imageH / 2; // y = Asin(ωx+φ) + b
                $i = (int)($this->fontSize / 5);
                while ($i > 0) {
                    imagesetpixel($this->image, (int)($px + $i), (int)($py + $i), $this->color);
                    $i--;
                }
            }
        }
    }

    /**
     * 画杂点
     * 往图片上写不同颜色的字母或数字
     */
    protected function writeNoise(): void
    {
        $codeSet = '2345678abcdefhijkmnpqrstuvwxyz';
        for ($i = 0; $i < 10; $i++) {
            //杂点颜色
            $noiseColor = imagecolorallocate($this->image, mt_rand(150, 225), mt_rand(150, 225), mt_rand(150, 225));
            for ($j = 0; $j < 5; $j++) {
                // 绘杂点
                imagestring($this->image, 5, mt_rand(-10, $this->imageW), mt_rand(-10, $this->imageH), $codeSet[mt_rand(0, 29)], $noiseColor);
            }
        }
    }

    /**
     * 绘制背景图片
     * 注：如果验证码输出图片比较大，将占用比较多的系统资源
     */
    protected function background(): void
    {
        $path = __DIR__ . '/assets/bgs/';
        $dir = dir($path);

        $bgs = [];
        while (false !== ($file = $dir->read())) {
            if ('.' != $file[0] && str_ends_with($file, '.jpg')) {
                $bgs[] = $path . $file;
            }
        }
        $dir->close();

        $gb = $bgs[array_rand($bgs)];

        [$width, $height] = @getimagesize($gb);
        // Resample
        $bgImage = @imagecreatefromjpeg($gb);
        @imagecopyresampled($this->image, $bgImage, 0, 0, 0, 0, $this->imageW, $this->imageH, $width, $height);
        @imagedestroy($bgImage);
    }
}
