<?php

namespace vessel\login\includes;

class ImageCaptcha
{   
    //验证码的session的下标  
    public $key = 'xenice_captcha';   //验证码关键字
    //验证码中使用的字符，01IO容易混淆，不用  
    public $codeSet = '3456789ABCDEFGHJKLMNPQRTUVWXY';   
    public $fontSize = 16;     // 验证码字体大小(px)   
    public $useCurve = true;   // 是否画混淆曲线   
    public $useNoise = true;   // 是否添加杂点    
    public $imageH = 32.8;        // 验证码图片宽   
    public $imageL = 130;        // 验证码图片长   
    public $length = 4;        // 验证码位数   
    public $bg = array(243, 251, 254);  // 背景   
       
    protected $_image = null;     // 验证码图片实例   
    protected $_color = null;     // 验证码字体颜色   

    
    public function set($key)
    {
        $this->key = $key;
        return $this;
    }
    
    public function show()
    {
        $this->generate();
        header('Pragma: no-cache');        
        header("content-type: image/JPEG");   
        imageJPEG($this->_image);    
        imagedestroy($this->_image);   
    }
    
    
    /**  
     * 输出验证码并把验证码的值保存的session中  
     */  
    private function generate()
    {   
        // 图片宽(px)   
        $this->imageL || $this->imageL = $this->length * $this->fontSize * 1.5 + $this->fontSize*1.5;    
        // 图片高(px)   
        $this->imageH || $this->imageH = $this->fontSize * 2;   
        // 建立一幅 $this->imageL x $this->imageH 的图像   
        $this->_image = imagecreate($this->imageL, $this->imageH);    
        // 设置背景         
        imagecolorallocate($this->_image, $this->bg[0], $this->bg[1], $this->bg[2]);    
        // 验证码字体随机颜色   
        $this->_color = imagecolorallocate($this->_image, mt_rand(1,120), mt_rand(1,120), mt_rand(1,120));   
        // 验证码使用随机字体，保证目录下有这些字体集   
        $ttf = dirname(__FILE__) . '/ttfs/t' . mt_rand(1, 9) . '.ttf';     
  
        if ($this->useNoise) {   
            // 绘杂点   
            $this->writeNoise();   
        }    
        if ($this->useCurve) {   
            // 绘干扰线   
            $this->writeCurve();   
        }   
           
        // 绘验证码   
        $code = array(); // 验证码   
        $codeNX = 0; // 验证码第N个字符的左边距   
        for ($i = 0; $i<$this->length; $i++) {   
            $code[$i] = $this->codeSet[mt_rand(0, 28)];   
            $codeNX += mt_rand($this->fontSize*1.2, $this->fontSize*1.6);   
            // 写一个验证码字符   
            imagettftext($this->_image, $this->fontSize, mt_rand(-40, 70), $codeNX, $this->fontSize*1.5, $this->_color, $ttf, $code[$i]);   
        }   
           
        // 保存验证码   
        isset($_SESSION) || session_start();   
        $_SESSION[$this->key]['code'] = join('', $code); // 把验证码保存到session, 验证时注意是大写  
        $_SESSION[$this->key]['time'] = time();  // 验证码创建时间   
    }   
       
    /**   
     * 画一条由两条连在一起构成的随机正弦函数曲线作干扰线(你可以改成更帅的曲线函数)   
     *      正弦型函数解析式：y=Asin(ωx+φ)+b  
     *      各常数值对函数图像的影响：  
     *        A：决定峰值（即纵向拉伸压缩的倍数）  
     *        b：表示波形在Y轴的位置关系或纵向移动距离（上加下减）  
     *        φ：决定波形与X轴位置关系或横向移动距离（左加右减）  
     *        ω：决定周期（最小正周期T=2π/∣ω∣）  
     */  
    private function writeCurve()
    {   
        $A = mt_rand(1, $this->imageH/2);                  // 振幅   
        $b = mt_rand(-$this->imageH/4, $this->imageH/4);   // Y轴方向偏移量   
        $f = mt_rand(-$this->imageH/4, $this->imageH/4);   // X轴方向偏移量   
        $T = mt_rand($this->imageH*1.5, $this->imageL*2);  // 周期   
        $w = (2* M_PI)/$T;   
                           
        $px1 = 0;  // 曲线横坐标起始位置   
        $px2 = mt_rand($this->imageL/2, $this->imageL * 0.667);  // 曲线横坐标结束位置              
        for ($px=$px1; $px<=$px2; $px=$px+ 0.9) {   
            if ($w!=0) {   
                $py = $A * sin($w*$px + $f)+ $b + $this->imageH/2;  // y = Asin(ωx+φ) + b   
                $i = (int) (($this->fontSize - 6)/4);   
                while ($i > 0) {    
                    imagesetpixel($this->_image, $px + $i, $py + $i, $this->_color);  
					//这里画像素点比imagettftext和imagestring性能要好很多                     
                    $i--;   
                }   
            }   
        }   
           
        $A = mt_rand(1, $this->imageH/2);                  // 振幅           
        $f = mt_rand(-$this->imageH/4, $this->imageH/4);   // X轴方向偏移量   
        $T = mt_rand($this->imageH*1.5, $this->imageL*2);  // 周期   
        $w = (2* M_PI)/$T;         
        $b = $py - $A * sin($w*$px + $f) - $this->imageH/2;   
        $px1 = $px2;   
        $px2 = $this->imageL;   
        for ($px=$px1; $px<=$px2; $px=$px+ 0.9) {   
            if ($w!=0) {   
                $py = $A * sin($w*$px + $f)+ $b + $this->imageH/2;  // y = Asin(ωx+φ) + b   
                $i = (int) (($this->fontSize - 8)/4);   
                while ($i > 0) {            
                    imagesetpixel($this->_image, $px + $i, $py + $i, $this->_color); 
					//这里(while)循环画像素点比imagettftext和imagestring用字体大小一次画出
					//的（不用while循环）性能要好很多       
                    $i--;   
                }   
            }   
        }   
    }   
       
    /**  
     * 画杂点  
     * 往图片上写不同颜色的字母或数字  
     */  
    private function writeNoise() {   
        for($i = 0; $i < 10; $i++){   
            //杂点颜色   
            $noiseColor = imagecolorallocate(   
                              $this->_image,    
                              mt_rand(150,225),    
                              mt_rand(150,225),    
                              mt_rand(150,225)   
                          );   
            for($j = 0; $j < 5; $j++) {   
                // 绘杂点   
                imagestring(   
                    $this->_image,   
                    5,    
                    mt_rand(-10, $this->imageL),    
                    mt_rand(-10, $this->imageH),    
                    $this->codeSet[mt_rand(0, 28)], // 杂点文本为随机的字母或数字   
                    $noiseColor  
                );   
            }   
        }   
    }   
}   