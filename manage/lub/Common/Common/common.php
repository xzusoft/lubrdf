<?php
// +----------------------------------------------------------------------
// | LubTMP
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@leubao.com>
// +----------------------------------------------------------------------

/**
 * 系统缓存缓存管理
 * @param mixed $name 缓存名称
 * @param mixed $value 缓存值
 * @param mixed $options 缓存参数
 * @return mixed
 */
function cache($name, $value = '', $options = null) {
    static $cache = '';
    if (empty($cache)) {
        $cache = \Libs\System\Cache::getInstance();
    }
    // 获取缓存
    if ('' === $value) {
        if (false !== strpos($name, '.')) {
            $vars = explode('.', $name);
            $data = $cache->get($vars[0]);
            return is_array($data) ? $data[$vars[1]] : $data;
        } else {
            return $cache->get($name);
        }
    } elseif (is_null($value)) {//删除缓存
        return $cache->remove($name);
    } else {//缓存数据
        if (is_array($options)) {
            $expire = isset($options['expire']) ? $options['expire'] : NULL;
        } else {
            $expire = is_numeric($options) ? $options : NULL;
        }
        return $cache->set($name, $value, $expire);
    }
}

/**
 * 调试，用于保存数组到txt文件 正式生产删除
 * 用法：array2file($info, SITE_PATH.'post.txt');
 * @param type $array
 * @param type $filename
 */
function array2file($array, $filename) {
    if (defined("APP_DEBUG") && APP_DEBUG) {
        //修改文件时间
        file_exists($filename) or touch($filename);
        if (is_array($array)) {
            $str = var_export($array, TRUE);
        } else {
            $str = $array;
        }
        return file_put_contents($filename, $str);
    }
    return false;
}

/**
 * 返回LubTMP对象
 * @return Object
 */
function LubTMP() {
    return \Common\Controller\LubTMP::app();
}

/**
 * 快捷方法取得服务
 * @param type $name 服务类型
 * @param type $params 参数
 * @return type
 */
function service($name, $params = array()) {
    return \Libs\System\Service::getInstance($name, $params);
}

/**
 * 生成上传附件验证
 * @param $args   参数
 */
function upload_key($args) {
    return md5($args . md5(C("AUTHCODE") . $_SERVER['HTTP_USER_AGENT']));
}

/**
 * 检查模块是否已经安装
 * @param type $moduleName 模块名称
 * @return boolean
 */
function isModuleInstall($moduleName) {
    $appCache = cache('Module');
    if (isset($appCache[$moduleName])) {
        return true;
    }
    return false;
}

/**
 * 产生一个指定长度的随机字符串,并返回给用户 
 * @param type $len 产生字符串的长度
 * @param $type int 生成类型
 * @return string 随机字符串
 */
function genRandomString($len = 6,$type = null) {
    if($type == '1'){
        $chars = array("0", "1", "2","3", "4", "5", "6", "7", "8", "9");
    }else{
        $chars = array(
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
            "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
            "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
            "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
            "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",
            "3", "4", "5", "6", "7", "8", "9"
        );
    }  
    $charsLen = count($chars) - 1;
    // 将数组打乱 
    shuffle($chars);
    $output = "";
    for ($i = 0; $i < $len; $i++) {
        $output .= $chars[mt_rand(0, $charsLen)];
    }
    return $output;
}

/**
 * 获取模型数据
 * @param type $modelid 模型ID
 * @param type $field 返回的字段，默认返回全部，数组
 * @return boolean
 */
function getModel($modelid, $field = '') {
    if (empty($modelid)) {
        return false;
    }
    $key = 'getModel_' . $modelid;
    $cache = S($key);
    if ($cache === 'false') {
        return false;
    }
    if (empty($cache)) {
        //读取数据
        $cache = M('Model')->where(array('modelid' => $modelid))->find();
        if (empty($cache)) {
            S($key, 'false', 60);
            return false;
        } else {
            S($key, $cache, 3600);
        }
    }
    if ($field) {
        return $cache[$field];
    } else {
        return $cache;
    }
}

/**
 * 检测一个数据长度是否超过最小值
 * @param type $value 数据
 * @param type $length 最小长度
 * @return type 
 */
function isMin($value, $length) {
    return mb_strlen($value, 'utf-8') >= (int) $length ? true : false;
}

/**
 * 检测一个数据长度是否超过最大值
 * @param type $value 数据
 * @param type $length 最大长度
 * @return type 
 */
function isMax($value, $length) {
    return mb_strlen($value, 'utf-8') <= (int) $length ? true : false;
}

/**
 * 取得文件扩展
 * @param type $filename 文件名
 * @return type 后缀
 */
function fileext($filename) {
    $pathinfo = pathinfo($filename);
    return $pathinfo['extension'];
}

/**
 * 对 javascript escape 解码
 * @param type $str 
 * @return type
 */
function unescape($str) {
    $ret = '';
    $len = strlen($str);
    for ($i = 0; $i < $len; $i++) {
        if ($str[$i] == '%' && $str[$i + 1] == 'u') {
            $val = hexdec(substr($str, $i + 2, 4));
            if ($val < 0x7f)
                $ret .= chr($val);
            else
            if ($val < 0x800)
                $ret .= chr(0xc0 | ($val >> 6)) . chr(0x80 | ($val & 0x3f));
            else
                $ret .= chr(0xe0 | ($val >> 12)) . chr(0x80 | (($val >> 6) & 0x3f)) . chr(0x80 | ($val & 0x3f));
            $i += 5;
        } else
        if ($str[$i] == '%') {
            $ret .= urldecode(substr($str, $i, 3));
            $i += 2;
        } else
            $ret .= $str[$i];
    }
    return $ret;
}

/**
 * 字符截取
 * @param $string 需要截取的字符串
 * @param $length 长度
 * @param $dot
 */
function str_cut($sourcestr, $length, $dot = '...') {
    $returnstr = '';
    $i = 0;
    $n = 0;
    $str_length = strlen($sourcestr); //字符串的字节数 
    while (($n < $length) && ($i <= $str_length)) {
        $temp_str = substr($sourcestr, $i, 1);
        $ascnum = Ord($temp_str); //得到字符串中第$i位字符的ascii码 
        if ($ascnum >= 224) {//如果ASCII位高与224，
            $returnstr = $returnstr . substr($sourcestr, $i, 3); //根据UTF-8编码规范，将3个连续的字符计为单个字符         
            $i = $i + 3; //实际Byte计为3
            $n++; //字串长度计1
        } elseif ($ascnum >= 192) { //如果ASCII位高与192，
            $returnstr = $returnstr . substr($sourcestr, $i, 2); //根据UTF-8编码规范，将2个连续的字符计为单个字符 
            $i = $i + 2; //实际Byte计为2
            $n++; //字串长度计1
        } elseif ($ascnum >= 65 && $ascnum <= 90) { //如果是大写字母，
            $returnstr = $returnstr . substr($sourcestr, $i, 1);
            $i = $i + 1; //实际的Byte数仍计1个
            $n++; //但考虑整体美观，大写字母计成一个高位字符
        } else {//其他情况下，包括小写字母和半角标点符号，
            $returnstr = $returnstr . substr($sourcestr, $i, 1);
            $i = $i + 1;            //实际的Byte数计1个
            $n = $n + 0.5;        //小写字母和半角标点等与半个高位字符宽...
        }
    }
    if ($str_length > strlen($returnstr)) {
        $returnstr = $returnstr . $dot; //超过长度时在尾处加上省略号
    }
    return $returnstr;
}
/**
 * flash上传初始化
 * 初始化swfupload上传中需要的参数
 * @param $module 模块名称
 * @param $catid 栏目id
 * @param $args 传递参数
 * @param $userid 用户id
 * @param $groupid 用户组id 默认游客
 * @param $isadmin 是否为管理员模式
 */
function initupload($module, $catid, $args, $userid, $groupid = 8, $isadmin = false) {
    if (empty($module)) {
        return false;
    }
    //网站配置
    $config = cache('Config');
    //检查用户是否有上传权限
    if ($isadmin) {
        //后台用户
        //上传大小
        $file_size_limit = intval($config['uploadmaxsize']);
        //上传处理地址
        $upload_url = U('Attachment/Manage/swfupload');
    } else {
        //前台用户
        $Member_group = cache("Member_group");
        if ((int) $Member_group[$groupid]['allowattachment'] < 1 || empty($Member_group)) {
            return false;
        }
        //上传大小
        $file_size_limit = intval($config['qtuploadmaxsize']);
        //上传处理地址
        $upload_url = U('Attachment/Upload/swfupload');
    }
    //当前时间戳
    $sess_id = time();
    //生成验证md5
    $swf_auth_key = md5(C("AUTHCODE") . $sess_id . ($isadmin ? 1 : 0));
    //同时允许的上传个数, 允许上传的文件类型, 是否允许从已上传中选择, 图片高度, 图片宽度,是否添加水印1是
    if (!is_array($args)) {
        //如果不是数组传递，进行分割
        $args = explode(',', $args);
    }
    //参数补充完整
    if (empty($args[1])) {
        //如果允许上传的文件类型为空，启用网站配置的 uploadallowext
        if ($isadmin) {
            $args[1] = $config['uploadallowext'];
        } else {
            $args[1] = $config['qtuploadallowext'];
        }
    }
    //允许上传后缀处理
    $arr_allowext = explode('|', $args[1]);
    foreach ($arr_allowext as $k => $v) {
        $v = '*.' . $v;
        $array[$k] = $v;
    }
    $upload_allowext = implode(';', $array);

    //上传个数
    $file_upload_limit = (int) $args[0] ? (int) $args[0] : 8;
    //swfupload flash 地址
    $flash_url = CONFIG_SITEURL_MODEL . 'statics/js/swfupload/swfupload.swf';

    $init = 'var swfu_' . $module . ' = \'\';
    $(document).ready(function(){
        Wind.use("swfupload",GV.DIMAUB+"statics/js/swfupload/handlers.js",function(){
            swfu_' . $module . ' = new SWFUpload({
                flash_url:"' . $flash_url . '?"+Math.random(),
                upload_url:"' . $upload_url . '",
                file_post_name : "Filedata",
                post_params:{
                    "sessid":"' . $sess_id . '",
                    "module":"' . $module . '",
                    "catid":"' . $catid . '",
                    "uid":"' . $userid . '",
                    "isadmin":"' . $isadmin . '",
                    "groupid":"' . $groupid . '",
                    "watermark_enable":"' . intval($args[5]) . '",
                    "thumb_width":"' . intval($args[3]) . '",
                    "thumb_height":"' . intval($args[4]) . '",
                    "filetype_post":"' . $args[1] . '",
                    "swf_auth_key":"' . $swf_auth_key . '"
                  },
               file_size_limit:"' . $file_size_limit . 'KB",
               file_types:"' . $upload_allowext . '",
               file_types_description:"All Files",
               file_upload_limit:"' . $file_upload_limit . '",
               custom_settings : {progressTarget : "fsUploadProgress",cancelButtonId : "btnCancel"},
               button_image_url: "",
               button_width: 75,
               button_height: 28,
               button_placeholder_id: "buttonPlaceHolder",
               button_text_style: "",
               button_text_top_padding: 3,
               button_text_left_padding: 12,
               button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
               button_cursor: SWFUpload.CURSOR.HAND,
               file_dialog_start_handler : fileDialogStart,
               file_queued_handler : fileQueued,
               file_queue_error_handler:fileQueueError,
               file_dialog_complete_handler:fileDialogComplete,
               upload_progress_handler:uploadProgress,
               upload_error_handler:uploadError,
               upload_success_handler:uploadSuccess,
               upload_complete_handler:uploadComplete
        });
    });
})
';
    return $init;
}

/**
 * 取得URL地址中域名部分
 * @param type $url 
 * @return \url 返回域名
 */
function urlDomain($url) {
    if ($url) {
        $pathinfo = parse_url($url);
        return $pathinfo['scheme'] . "://" . $pathinfo['host'] . "/";
    }
    return false;
}

/**
 * 获取当前页面完整URL地址
 * @return type 地址
 */
function get_url() {
    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self . (isset($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : $path_info);
    return $sys_protocal . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '') . $relate_url;
}

/**
 * 返回附件类型图标
 * @param $file 附件名称
 * @param $type png为大图标，gif为小图标
 */
function file_icon($file, $type = 'png') {
    $ext_arr = array('doc', 'docx', 'ppt', 'xls', 'txt', 'pdf', 'mdb', 'jpg', 'gif', 'png', 'bmp', 'jpeg', 'rar', 'zip', 'swf', 'flv');
    $ext = fileext($file);
    if ($type == 'png') {
        if ($ext == 'zip' || $ext == 'rar')
            $ext = 'rar';
        elseif ($ext == 'doc' || $ext == 'docx')
            $ext = 'doc';
        elseif ($ext == 'xls' || $ext == 'xlsx')
            $ext = 'xls';
        elseif ($ext == 'ppt' || $ext == 'pptx')
            $ext = 'ppt';
        elseif ($ext == 'flv' || $ext == 'swf' || $ext == 'rm' || $ext == 'rmvb')
            $ext = 'flv';
        else
            $ext = 'do';
    }
    $config = cache('Config');
    if (in_array($ext, $ext_arr)) {
        return $config['siteurl'] . 'statics/images/ext/' . $ext . '.' . $type;
    } else {
        return $config['siteurl'] . 'statics/images/ext/blank.' . $type;
    }
}

/**
 * 根据文件扩展名来判断是否为图片类型
 * @param type $file 文件名
 * @return type 是图片类型返回 true，否则返回 false
 */
function isImage($file) {
    $ext_arr = array('jpg', 'gif', 'png', 'bmp', 'jpeg', 'tiff');
    //取得扩展名
    $ext = fileext($file);
    return in_array($ext, $ext_arr) ? true : false;
}

/**
 * 对URL中有中文的部分进行编码处理
 * @param type $url 地址 http://www.chengde360.com/s?wd=博客
 * @return type ur;编码后的地址 http://www.chengde360.com/s?wd=%E5%8D%9A%20%E5%AE%A2
 */
function cn_urlencode($url) {
    $pregstr = "/[\x{4e00}-\x{9fa5}]+/u"; //UTF-8中文正则
    if (preg_match_all($pregstr, $url, $matchArray)) {//匹配中文，返回数组
        foreach ($matchArray[0] as $key => $val) {
            $url = str_replace($val, urlencode($val), $url); //将转译替换中文
        }
        if (strpos($url, ' ')) {//若存在空格
            $url = str_replace(' ', '%20', $url);
        }
    }
    return $url;
}

/**
 * 获取模版文件 格式 主题://模块/控制器/方法
 * @param type $templateFile
 * @return boolean|string 
 */
function parseTemplateFile($templateFile = '') {
    static $TemplateFileCache = array();
    //模板路径
    $TemplatePath = TEMPLATE_PATH;
    //模板主题
    $Theme = empty(\Common\Controller\LubTMP::$Cache["Config"]['theme']) ? 'Default' : \Common\Controller\LubTMP::$Cache["Config"]['theme'];
    //如果有指定 GROUP_MODULE 则模块名直接是GROUP_MODULE，否则使用 MODULE_NAME，这样做的目的是防止其他模块需要生成
    $group = defined('GROUP_MODULE') ? GROUP_MODULE : MODULE_NAME;
    //兼容 Add:ss 这种写法
    if (!empty($templateFile) && strpos($templateFile, ':') && false === strpos($templateFile, C('TMPL_TEMPLATE_SUFFIX'))) {
        if (strpos($templateFile, '://')) {
            $temp = explode('://', $templateFile);
            $fxg = str_replace(':', '/', $temp[1]);
            $templateFile = $temp[0] . $fxg;
        } else {
            $templateFile = str_replace(':', '/', $templateFile);
        }
    }
    if ($templateFile != '' && strpos($templateFile, '://')) {
        $exp = explode('://', $templateFile);
        $Theme = $exp[0];
        $templateFile = $exp[1];
    }
    // 分析模板文件规则
    $depr = C('TMPL_FILE_DEPR');
    //模板标识
    if ('' == $templateFile) {
        $templateFile = $TemplatePath . $Theme . '/' . $group . '/' . CONTROLLER_NAME . '/' . ACTION_NAME . C('TMPL_TEMPLATE_SUFFIX');
    }
    $key = md5($templateFile);
    if (isset($TemplateFileCache[$key])) {
        return $TemplateFileCache[$key];
    }
    if (false === strpos($templateFile, '/') && false === strpos($templateFile, C('TMPL_TEMPLATE_SUFFIX'))) {
        $templateFile = $TemplatePath . $Theme . '/' . $group . '/' . CONTROLLER_NAME . '/' . $templateFile . C('TMPL_TEMPLATE_SUFFIX');
    } else if (false === strpos($templateFile, C('TMPL_TEMPLATE_SUFFIX'))) {
        $path = explode('/', $templateFile);
        $action = array_pop($path);
        $controller = !empty($path) ? array_pop($path) : CONTROLLER_NAME;
        if (!empty($path)) {
            $group = array_pop($path)? : $group;
        }
        $depr = defined('MODULE_NAME') ? C('TMPL_FILE_DEPR') : '/';
        $templateFile = $TemplatePath . $Theme . '/' . $group . '/' . $controller . $depr . $action . C('TMPL_TEMPLATE_SUFFIX');
    }
    //区分大小写的文件判断，如果不存在，尝试一次使用默认主题
    if (!file_exists_case($templateFile)) {
        $log = '模板:[' . $templateFile . '] 不存在！';
        \Think\Log::record($log);
        //启用默认主题模板
        $templateFile = str_replace($TemplatePath . $Theme, $TemplatePath . 'Default', $templateFile);
        //判断默认主题是否存在，不存在直接报错提示
        if (!file_exists_case($templateFile)) {
            if (defined('APP_DEBUG') && APP_DEBUG) {
                E($log);
            }
            $TemplateFileCache[$key] = false;
            return false;
        }
    }
    $TemplateFileCache[$key] = $templateFile;
    return $TemplateFileCache[$key];
}

/**
 * 生成缩略图
 * @param type $imgurl 图片地址
 * @param type $width 缩略图宽度
 * @param type $height 缩略图高度
 * @param type $thumbType 缩略图生成方式 1 按设置大小截取 0 按原图等比例缩略
 * @param type $smallpic 图片不存在时显示默认图片
 * @return type
 */
function thumb($imgurl, $width = 100, $height = 100, $thumbType = 0, $smallpic = 'nopic.gif') {
    static $_thumb_cache = array();
    if (empty($imgurl)) {
        return $smallpic;
    }
    //区分
    $key = md5($imgurl . $width . $height . $thumbType . $smallpic);
    if (isset($_thumb_cache[$key])) {
        return $_thumb_cache[$key];
    }
    if (!$width || !$height) {
        return $smallpic;
    }
    //当获取不到DOCUMENT_ROOT值时的操作！
    if (empty($_SERVER['DOCUMENT_ROOT']) && !empty($_SERVER['SCRIPT_FILENAME'])) {
        $_SERVER['DOCUMENT_ROOT'] = str_replace('\\', '/', substr($_SERVER['SCRIPT_FILENAME'], 0, 0 - strlen($_SERVER['PHP_SELF'])));
    }
    if (empty($_SERVER['DOCUMENT_ROOT']) && !empty($_SERVER['PATH_TRANSLATED'])) {
        $_SERVER['DOCUMENT_ROOT'] = str_replace('\\', '/', substr(str_replace('\\\\', '\\', $_SERVER['PATH_TRANSLATED']), 0, 0 - strlen($_SERVER['PHP_SELF'])));
    }
    // 解析URLsitefileurl
    $imgParse = parse_url($imgurl);
    //图片路径
    $imgPath = $_SERVER['DOCUMENT_ROOT'] . $imgParse['path'];
    //取得文件名
    $basename = basename($imgurl);
    //取得文件存放目录
    $imgPathDir = str_replace($basename, '', $imgPath);
    //生成的缩略图文件名
    $newFileName = "thumb_{$width}_{$height}_" . $basename;
    //检查生成的缩略图是否已经生成过
    if (file_exists($imgPathDir . $newFileName)) {
        return str_replace($basename, $newFileName, $imgurl);
    }
    //检查文件是否存在，如果是开启远程附件的，估计就通过不了，以后在考虑完善！
    if (!file_exists($imgPath)) {
        return $imgurl;
    }
    //取得图片相关信息
    list($width_t, $height_t, $type, $attr) = getimagesize($imgPath);
    //判断生成的缩略图大小是否正常
    if ($width >= $width_t || $height >= $height_t) {
        return $imgurl;
    }
    //生成缩略图
    if (1 == $thumbType) {
        \Image::thumb2($imgPath, $imgPathDir . $newFileName, '', $width, $height, true);
    } else {
        \Image::thumb($imgPath, $imgPathDir . $newFileName, '', $width, $height, true);
    }
    $_thumb_cache[$key] = str_replace($basename, $newFileName, $imgurl);
    return $_thumb_cache[$key];
}

/**
 * 邮件发送
 * @param type $address 接收人 单个直接邮箱地址，多个可以使用数组
 * @param type $title 邮件标题
 * @param type $message 邮件内容
 */
function SendMail($address, $title, $message) {
    $config = cache('Config');
    import('PHPMailer');
    try {
        $mail = new \PHPMailer();
        $mail->IsSMTP();
        // 设置邮件的字符编码，若不指定，则为'UTF-8'
        $mail->CharSet = C("DEFAULT_CHARSET");
        $mail->IsHTML(true);
        // 添加收件人地址，可以多次使用来添加多个收件人
        if (is_array($address)) {
            foreach ($address as $k => $v) {
                if (is_array($v)) {
                    $mail->AddAddress($v[0], $v[1]);
                } else {
                    $mail->AddAddress($v);
                }
            }
        } else {
            $mail->AddAddress($address);
        }
        // 设置邮件正文
        $mail->Body = $message;
        // 设置邮件头的From字段。
        $mail->From = $config['mail_from'];
        // 设置发件人名字
        $mail->FromName = $config['mail_fname'];
        // 设置邮件标题
        $mail->Subject = $title;
        // 设置SMTP服务器。
        $mail->Host = $config['mail_server'];
        // 设置为“需要验证”
        if ($config['mail_auth']) {
            $mail->SMTPAuth = true;
        } else {
            $mail->SMTPAuth = false;
        }
        // 设置用户名和密码。
        $mail->Username = $config['mail_user'];
        $mail->Password = $config['mail_password'];
        return $mail->Send();
    } catch (phpmailerException $e) {
        return $e->errorMessage();
    } 
}
// +----------------------------------------------------------------------
// | LubTMP 汉字转拼音
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.leubao.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhoujing <admin@chengde360.com>
// +----------------------------------------------------------------------
define('CODETABLEDIR', COMMON_PATH . 'Data/');

/**
 * gbk转拼音
 * @param $txt
 */
function gbk_to_pinyin($txt) {
    $l = strlen($txt);
    $i = 0;
    $pyarr = array();
    $py = array();
    $filename = CODETABLEDIR . 'gb-pinyin.table';
    $fp = fopen($filename, 'r');
    while (!feof($fp)) {
        $p = explode("-", fgets($fp, 32));
        $pyarr[intval($p[1])] = trim($p[0]);
    }
    fclose($fp);
    ksort($pyarr);
    while ($i < $l) {
        $tmp = ord($txt[$i]);
        if ($tmp >= 128) {
            $asc = abs($tmp * 256 + ord($txt[$i + 1]) - 65536);
            $i = $i + 1;
        } else
            $asc = $tmp;
        $py[] = asc_to_pinyin($asc, $pyarr);
        $i++;
    }
    return $py;
}

/**
 * Ascii转拼音
 * @param $asc
 * @param $pyarr
 */
function asc_to_pinyin($asc, &$pyarr) {
    if ($asc < 128)
        return chr($asc);
    elseif (isset($pyarr[$asc]))
        return $pyarr[$asc];
    else {
        foreach ($pyarr as $id => $p) {
            if ($id >= $asc)
                return $p;
        }
    }
}
/**
 * 二位数组转一维数组
 */
if (!function_exists('array_column')) {
    function array_column($input, $columnKey, $indexKey = null) {
        $columnKeyIsNumber = (is_numeric($columnKey)) ? true : false;
        $indexKeyIsNull = (is_null($indexKey)) ? true : false;
        $indexKeyIsNumber = (is_numeric($indexKey)) ? true : false;
        $result = array();
        foreach ((array) $input as $key => $row) {
            if ($columnKeyIsNumber) {
                $tmp = array_slice($row, $columnKey, 1);
                $tmp = (is_array($tmp) && !empty($tmp)) ? current($tmp) : null;
            } else {
                $tmp = isset($row[$columnKey]) ? $row[$columnKey] : null;
            }
            if (!$indexKeyIsNull) {
                if ($indexKeyIsNumber) {
                    $key = array_slice($row, $indexKey, 1);
                    $key = (is_array($key) && !empty($key)) ? current($key) : null;
                    $key = is_null($key) ? 0 : $key;
                } else {
                    $key = isset($row[$indexKey]) ? $row[$indexKey] : 0;
                }
            }
            $result[$key] = $tmp;
        }
        return $result;
    }
 }
 /*计算时间差并返回差多少天、时、分、秒 
  * @param int $begin_time
  * @param int $end_time
  * @return string
  */
function timediff($begin_time,$end_time) { 
      if($begin_time < $end_time){ 
         $starttime = $begin_time; 
         $endtime = $end_time; 
      } 
      else{ 
         $starttime = $end_time; 
         $endtime = $begin_time; 
      } 
      $timediff = $endtime-$starttime; 
      $days = intval($timediff/86400); 
      $remain = $timediff%86400; 
      $hours = intval($remain/3600); 
      $remain = $remain%3600; 
      $mins = intval($remain/60); 
      $secs = $remain%60; 
      $res = array("day" => $days,"hour" => $hours,"min" => $mins,"sec" => $secs); 
      return $res; 
}
/*二维数组转字符串
* @param array $arr 待处理的数组
* @param string $field 字段
* @param string $seg 字符串分隔符,默认','分割
*/
function arr2string($arr,$field,$seg = ','){
    $array = array_column($arr,$field);
    $return = implode($seg,$array);
    return $return;
}
/*身份证号码校验
*@param $idcard 身份证号码验证
*/
function checkIdCard($idcard){
    // 只能是18位
    if(strlen($idcard)!=18){
        return false;
    }
    // 取出本体码
    $idcard_base = substr($idcard, 0, 17);
    // 取出校验码
    $verify_code = substr($idcard, 17, 1);
    // 加权因子
    $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
    // 校验码对应值
    $verify_code_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
    // 根据前17位计算校验码
    $total = 0;
    for($i=0; $i<17; $i++){
        $total += substr($idcard_base, $i, 1)*$factor[$i];
    }
    // 取模
    $mod = $total % 11;
    // 比较校验码
    if($verify_code == $verify_code_list[$mod]){
        return true;
    }else{
        return false;
    }
}
/*返回去除敏感信息的客户信息
*@param $uinfo 包含敏感信息的
*/
function senuInfo($uinfo){
    $unset = array(
        'id'=>'',
        'username'=>'',
        'password'=>'',
        'last_login_time'=>'',
        'last_login_ip'=>'',
        'verify'=>'',
        'email'=>'', 
        'remark'=>'',
        'create_time'=>'',
        'update_time'=>'',
        'status'=>'',
        'is_scene'=>'',
        'role_id'=>'',
        'info'=>'',
        'rpassword'=>'',
        );
    $return = array_diff_key($uinfo,$unset);
    return $return;
} 
/**
 * 格式化金额
 *
 * @param int $money
 * @param int $len
 * @param string $sign
 * @return string
 */
function format_money($money, $len=2, $sign='￥'){
    $negative = $money >= 0 ? '' : '-';
    $int_money = intval(abs($money));
    $len = intval(abs($len));
    $decimal = '';//小数
    if ($len > 0) {
        $decimal = '.'.substr(sprintf('%01.'.$len.'f', $money),-$len);
    }
    $tmp_money = strrev($int_money);
    $strlen = strlen($tmp_money);
    for ($i = 3; $i < $strlen; $i += 3) {
        $format_money .= substr($tmp_money,0,3).',';
        $tmp_money = substr($tmp_money,3);
    }
    $format_money .= $tmp_money;
    $format_money = strrev($format_money);
    return $sign.$negative.$format_money.$decimal;
}
/*判断终端访问类型*/
function is_mobile() { 
    $user_agent = $_SERVER['HTTP_USER_AGENT']; 
    $mobile_agents = array("240x320","acer","acoon","acs-","abacho","ahong","airness","alcatel","amoi", 
    "android","anywhereyougo.com","applewebkit/525","applewebkit/532","asus","audio", 
    "au-mic","avantogo","becker","benq","bilbo","bird","blackberry","blazer","bleu", 
    "cdm-","compal","coolpad","danger","dbtel","dopod","elaine","eric","etouch","fly ", 
    "fly_","fly-","go.web","goodaccess","gradiente","grundig","haier","hedy","hitachi", 
    "htc","huawei","hutchison","inno","ipad","ipaq","iphone","ipod","jbrowser","kddi", 
    "kgt","kwc","lenovo","lg ","lg2","lg3","lg4","lg5","lg7","lg8","lg9","lg-","lge-","lge9","longcos","maemo", 
    "mercator","meridian","micromax","midp","mini","mitsu","mmm","mmp","mobi","mot-", 
    "moto","nec-","netfront","newgen","nexian","nf-browser","nintendo","nitro","nokia", 
    "nook","novarra","obigo","palm","panasonic","pantech","philips","phone","pg-", 
    "playstation","pocket","pt-","qc-","qtek","rover","sagem","sama","samu","sanyo", 
    "samsung","sch-","scooter","sec-","sendo","sgh-","sharp","siemens","sie-","softbank", 
    "sony","spice","sprint","spv","symbian","tablet","talkabout","tcl-","teleca","telit", 
    "tianyu","tim-","toshiba","tsm","up.browser","utec","utstar","verykool","virgin", 
    "vk-","voda","voxtel","vx","wap","wellco","wig browser","wii","windows ce", 
    "wireless","xda","xde","zte"); 
    $is_mobile = false; 
    foreach ($mobile_agents as $device) { 
        if (stristr($user_agent, $device)) { 
            $is_mobile = true; 
            break; 
        } 
    } 
    return $is_mobile; 
}