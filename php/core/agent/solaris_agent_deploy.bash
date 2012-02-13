#/bin/bash

  curl https://envlog01.idc1.level3.com:7860/agent/asc.zip > /var/tmp/asc.zip
  unzip /var/tmp/asc.zip -d /app/asc/node/docroot/test/`hostname`
