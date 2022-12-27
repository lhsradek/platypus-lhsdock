#!/usr/bin/bash

# docker exec -it lhsdock-filebeat bash
# ~/bin/install.bash 
# exit
# docker stop lhsdoc-filebeat
# docker start lhsdock-filebeat

rm -f /usr/share/filebeat/modules.d/elasticsearch.yml
rm -f /usr/share/filebeat/modules.d/elasticsearch.yml.disabled
cp /root/bin/elasticsearch.yml /usr/share/filebeat/modules.d/elasticsearch.yml
rm -f /usr/share/filebeat/modules.d/kibana.yml
rm -f /usr/share/filebeat/modules.d/kibana.yml.disabled
cp /root/bin/kibana.yml /usr/share/filebeat/modules.d/kibana.yml
rm -f /usr/share/filebeat/modules.d/traefik.yml
rm -f /usr/share/filebeat/modules.d/traefik.yml.disabled
cp /root/bin/traefik.yml /usr/share/filebeat/modules.d/traefik.yml.disabled
rm -f /usr/share/filebeat/modules.d/nginx.yml
rm -f /usr/share/filebeat/modules.d/nginx.yml.disabled
cp /root/bin/nginx.yml /usr/share/filebeat/modules.d/nginx.yml
chown root.root /usr/share/filebeat/modules.d/*
