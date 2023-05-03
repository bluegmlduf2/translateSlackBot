## Required
- Docker

## Installation
```bash
cd php
docker build --no-cache -t php/sample:20210109 .
cd web
docker build --no-cache -t nginx/sample:20210109 .
docker network create --driver bridge sample_nw
```

## RUN
```bash
docker run --net=sample_nw --name php-sample php/sample:20210109
docker run -p 80:80 --net=sample_nw --name nginx-sample nginx/sample:20210109
```
OEPN LINK [http://localhost:80](http://localhost:80)
