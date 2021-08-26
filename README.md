# IIR新生訓練laravel_HW
## 建置 laravel - docker
* Dockerfile ：
```
FROM php:7.4-fpm
RUN curl -sS http://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
RUN mkdir /app
WORKDIR /app
COPY . /app/
```
* docker-compose.yaml ：
```
version: '3'

services:
    web:
        build: .
        command: php artisan serve --host=0.0.0.0
        ports:
            - 8080:8000
        volumes:
            - ./web:/app

```

## docker使用流程
### 1. 於終端機輸入
```
git clone https://github.com/Chei-YuanChi/laravel_HW.git
cd laravel_hw
docker-compose up -d --build
```
### 2. 連線至 ( http://localhost:8080 )
### 3. remove container
```
docker-compose down
```
### 4. model weight 儲存於 movie_recommender.h5

## 網頁使用說明
### 1. 主頁( Home ) ：
#### * 顯示各分頁可以做的事
![](https://i.imgur.com/zGI0PRw.png)

#### * 上方點擊可進入各分頁
![](https://i.imgur.com/1lDVANY.png)

#### *Home ： 回到主頁面
### 2. Get ： 輸入欲 insert 至資料庫之資料數量 並 output 所有在資料庫中的資料(若欲輸入之資料已在資料庫中則跳過)
### 3. Delete ： 輸入 userId 以及 movieId 若在資料庫中則刪除
### 4. Watched ： 輸入指定 userId 並 output 其在資料庫中看過的電影
### 5. Modify ： 輸入 userId, movieId, rating 若 userId 及 movieId 在資料庫中則修改其對應的 rating 為輸入之 rating 值
### 6. Recommend ： 輸入指定 userId 並為其推薦 2 部電影
