#!/usr/bin/bash

# docker exec -it lhsdock-metricbeat bash
# ~/bin/install.bash               
# exit
# docker stop lhsdock-metricbeat
# docker start lhsdock-metricbeat

rm -f /usr/share/metricbeat/modules.d/beat-xpack.yml
rm -f /usr/share/metricbeat/modules.d/beat-xpack.yml.disabled
cp /root/bin/beat-xpack.yml /usr/share/metricbeat/modules.d/beat-xpack.yml
rm -f /usr/share/metricbeat/modules.d/elasticsearch-xpack.yml
rm -f /usr/share/metricbeat/modules.d/elasticsearch-xpack.yml.disabled
cp /root/bin/elasticsearch-xpack.yml /usr/share/metricbeat/modules.d/elasticsearch-xpack.yml
rm -f /usr/share/metricbeat/modules.d/kibana-xpack.yml
rm -f /usr/share/metricbeat/modules.d/kibana-xpack.yml.disabled
cp /root/bin/kibana-xpack.yml /usr/share/metricbeat/modules.d/kibana-xpack.yml
rm -f /usr/share/metricbeat/modules.d/logstash-xpack.yml
rm -f /usr/share/metricbeat/modules.d/logstash-xpack.yml.disabled
cp /root/bin/logstash-xpack.yml /usr/share/metricbeat/modules.d/logstash-xpack.yml.disabled
rm -f /usr/share/metricbeat/modules.d/nginx.yml
rm -f /usr/share/metricbeat/modules.d/nginx.yml.disabled
cp /root/bin/nginx.yml /usr/share/metricbeat/modules.d/nginx.yml
rm -f /usr/share/metricbeat/modules.d/php_fpm.yml
rm -f /usr/share/metricbeat/modules.d/php_fpm.yml.disabled
cp /root/bin/nginx.yml /usr/share/metricbeat/modules.d/php_fpm.yml
rm -f /usr/share/metricbeat/modules.d/system.yml
rm -f /usr/share/metricbeat/modules.d/system.yml.disabled
cp /root/bin/system.yml /usr/share/metricbeat/modules.d/system.yml.disabled
rm -f /usr/share/metricbeat/modules.d/docker.yml
rm -f /usr/share/metricbeat/modules.d/docker.yml.disabled
cp /root/bin/docker.yml /usr/share/metricbeat/modules.d/docker.yml
chown root.root /usr/share/metricbeat/modules.d/*
