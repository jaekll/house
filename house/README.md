==机器人训练==

copy .env_example to .env

job run command : php think queue:listen --queue='default' --delay==3 --tries=3 --timeout=180