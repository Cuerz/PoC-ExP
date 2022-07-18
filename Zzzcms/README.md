# FOFA语法：app="Zzzcms"



# **Zzzcms 1.75** **后台地址泄露**

## **一、漏洞影响**

Zzzcms 1.75

## **二、复现过程**

存在一个比较奇葩的文件直接将一些属于不可访问的zzz_config.php的内容直接给回显了，该信息泄露文件位于plugins/webuploader/js/webconfig.php，可以直接获取到管理后台的管理路径名称，再也不用去爆破admin加3位数字了

通过访问[http://xxxx/plugins/webuploader/js/webconfig.php]()即可获取后台路径

![image-20220718120157582](https://0-bit.oss-cn-beijing.aliyuncs.com/cuer/image-20220718120157582.png)

