# 项目安装

## 安装扩展包
```
composer install
```

## 设置 .env 文件
```
cp .env.example .env
```

### 配置 key
```
php artisan key:generate
```

### 安装 passport
#### 步骤一
```
php artisan passport:install
```
#### 步骤二
```
设置 .env 文件
PASSWORD_CLIENT_ID=
PASSWORD_CLIENT_SECRET=
```

### 设置上传目录
#### 步骤一
```
新建 /storage/app/public/uploads 文件夹
新建 /public/uploads 软链接(ln -s ../storage/app/public/uploads uploads)
```

### 设置 web hook