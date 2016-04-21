## 我的yii2项目，目前集成了如下模块
* redis
* mysql
* aws s3云存储(里面的账号不可用,替换成你的账号吧)
 
## 说明
控制器未采用rest控制器，建议做为内部管理后台使用。

## 准备工作
* redis : 需要提前安装好，windows下面的编译好的二进制包，注意版本，要求是3.0以上的版本。然后启动redis
* mysql:在windows环境下是wamp，linx下面集成 wamp就好了
* 强烈建议使用phpmyadmin

## 搭建步骤
### 复制本项目
```
git clone https://github.com/njkfei/yii2-basic
```
### 更新vendor
  vendor是本项目的依赖项目，需要下载到本地，运行下面的命令即可。注意，时间有点长，需要耐心。
```
composer update
```

## 测试
### 启动服务
```
php yii serve --port=8888
```

### 浏览
```
http://localhost:8888
```
```
http://localhost:8888/index.php?r=site/db
```

```
http://localhost:8888/index.php?r=site/themes
```

```
http://localhost:8888/index.php?r=site/db
```
