# English Version:

# URL-Shorter

A modern, safe and simple PHP url shorter.

## Demo:
[http://bbr.buzz/](http://bbr.buzz/)

## Function:
+ Use PDO and it's Bindparam to prevent SQL Inject.
+ Use Ajax to get the short Code
+ Use pure JS to copy the short link
+ No more magnificent functions

## Installation
1. Git clone or Download the code and unzip
2. Add the website in your web server config (Require Apache or Nginx rewrite rules(Similar as Wordpress rewrite rules))
3. Import the url.sql to your db
4. Configure the config.php
5. Finished

## Future:
+ Redis cache
+ Redis control the rate

---

# 中文简介:

# 短链接

一个现代、安全且简洁的PHP短链接 (PHP是世界上最好F#fIO#@($)#U)

## Demo:
[http://bbr.buzz/](http://bbr.buzz/)

## 功能:
+ 使用PDO和Bindparam防注入
+ 使用Ajax获取短链接(免刷新)
+ 使用纯JS复制生成的短链接
+ 没有更多功能了

## 安装方法:
1. git clone或者下载代码到网站根目录
2. 配置好伪静态(Apache直接使用根目录下的.htaccess就可以了，Nginx请自行配置(类似Wordpress的规则)) 
3. 导入url.sql到数据库
4. 配置好配置文件
5. 完成

## 计划中要增加的功能 (计划中，计划中)
+ 使用Redis缓存，更快，抗压能力更强
+ 使用Redis控制访问速率，抗CC
