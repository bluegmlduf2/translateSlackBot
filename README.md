# Required

-   Docker
-   [SLACK API](https://api.slack.com/)
-   [PAPAGO TRANSLATE API](https://developers.naver.com/docs/papago/papago-nmt-overview.md)

# DOCKER

### Installation

```bash
cd php
docker build --no-cache -t php/sample:20210109 .
cd web
docker build --no-cache -t nginx/sample:20210109 .
docker network create --driver bridge sample_nw
```

### RUN

```bash
cd php/src
docker run --net=sample_nw --name php-sample -v $(pwd):/usr/share/nginx/html php/sample:20210109
docker run -p 80:80 --net=sample_nw --name nginx-sample nginx/sample:20210109
```

OEPN LINK [http://localhost:80](http://localhost:80)

# SLACK

1. Create an app by referring to this [site](https://api.slack.com/)
2. Create a new Shortcuts from the Features > Interactivity & Shortcuts menu

# PAPAGO TRANSLATE API

1. Refer to this [site](https://developers.naver.com/docs/papago/papago-nmt-overview.md) and get a key issued
2. Input the issued key in config.php
