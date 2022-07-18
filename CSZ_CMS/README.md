# （CVE-2019-13086）CSZ CMS 1.2.2 sql注入漏洞

## 一、漏洞简介

CSZ CMS是一套基于PHP的开源内容管理系统（CMS）。 CSZ CMS 1.2.2版本（2019-06-20之前）中的core/MY_Security.php文件存在SQL注入漏洞。该漏洞源于基于数据库的应用缺少对外部输入SQL语句的验证。攻击者可利用该漏洞执行非法SQL命令。

## 二、漏洞影响

CSZ CMS 1.2.2版本（2019-06-20之前）

## 三、利用过程

具体见**CVE-2019-13086.py**，利用时替换localhost即可

---



# CSZ CMS 1.2.7  储存型 xss

## 一、漏洞简介

拥有访问私有消息的未授权用户可以向管理面板嵌入Javascript代码。

## **二、漏洞影响**

CSZ CMS 1.2.7

## 三、利用过程

新建一个用户，点击inbox发送私信，选定管理员用户，修改User-Agent为`<script>alert(1)</script>`，管理员登陆后台即可触发xss。
