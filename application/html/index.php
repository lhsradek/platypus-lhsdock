<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
The MIT License (MIT)

Copyright (c) 2022 Radek Kádner

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
--!>
<?php

use Elastic\Apm\ElasticApm;
use Elastic\Apm\TransactionInterface;

$printEnv = false;
# $printEnv = true;

class IndexController {

	public function isSocket(String $serverName, int $port) {
		$ret = false;
		$transaction = ElasticApm::beginCurrentTransaction(
    			'IndexController::isSocket',
    			'php::fsockopen'
		);
		try {
			set_time_limit(1);
			$fp = fsockopen($serverName, $port, $errno, $errstr, 1);
			if ($fp) {
				fclose($fp);
				$ret = true;
			}
		} finally {
		    $transaction->end();
		}
		return $ret;
	}

	public function isUrl(String $url) {
		$ret = true;
		$transaction = ElasticApm::beginCurrentTransaction(
    			'IndexController::isUrl',
    			'php::get_headers'
		);
		try {
			stream_context_set_default([
    				'ssl' => [
       				'verify_peer' => false,
        			'verify_peer_name' => false,
    				],
			]);
			$file_headers = get_headers($url);
			if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found' || $file_headers[0] == 'HTTP/1.1 502 Bad Gateway') {
    				$ret = false;
			}
		} finally {
		    $transaction->end();
		}
		return $ret;
	}


	public function getServerEnv() {
		$ret = getEnv();
		ksort($ret);
		return $ret;
	}

	public function getServerName() {
		$ret = $_SERVER['SERVER_NAME'];
		return $ret;
	}

	public function getServerPort() {
		$ret = 80;
		if (@$_SERVER['HTTP_X_FORWARDED_PORT']) {
			$ret = $_SERVER['HTTP_X_FORWARDED_PORT'];
		}
		return $ret;
	}

	public function getPort() {
		$serverPort = $this->getServerPort();
		if ($serverPort == 80 || $serverPort == 443) {
			$ret = "";
		} else {
			$ret = ":".$serverPort;
		}
		return $ret;
	}

	public function printWiki(String $id) {
		$parent = @$_SERVER['APP_HOST'];
		$net = @$_SERVER['APP_NET'];
                $arr = preg_split("/#/", $id);
		if (count($arr) == 2) {
			$nid = ucfirst($arr[1]);
		} else {
			$nid = ucfirst($arr[0]);
		}
		print("<small><a href=\"https://wiki.".$parent.".".$net."/doku.php?id=".$id."\" target=\"_blank\">".$nid."</a></small><img src=\"dokuwiki.png\" width=\"8\" height=\"8\"></br>");
	}
}

$index = new IndexController();
$port = $index->getPort();
$parent = @$_SERVER['APP_HOST'];
$host = @$_SERVER['HOST_NICK'];
$net = @$_SERVER['APP_NET'];
$clusterName = @$_SERVER['CLUSTER_NAME'];
$clusterUuid = @$_SERVER['CLUSTER_UUID'];
$apmEnv = @$_SERVER['ELASTIC_APM_ENVIRONMENT'];
$apmUrl = @$_SERVER['ELASTIC_APM_SERVER_URL'];
$apmName = @$_SERVER['ELASTIC_APM_SERVICE_NAME'];
$apmNode = @$_SERVER['ELASTIC_APM_SERVICE_NODE_NAME'];

$serverSoftware = ucfirst(preg_split("/\//", $_SERVER['SERVER_SOFTWARE'])[0]);
if ($parent == "docker") {
  $isTraefik = @$index->isUrl("http://web.traefik.local");
} else {
  $isTraefik = @$index->isUrl("https://".$parent.".traefik.local");
}
if ($parent == "www") {
  $isKibana = @$index->isUrl("https://kibana.docker.".$net.":443");
} else {
  $isKibana = @$index->isUrl("http://kibana.".$host.".".$net.":5601");
}
if ($parent == "docker") {
  $isKibanaPlatel = @$index->isUrl("https://kibana.platel");
} else {
  $isKibanaPlatel = @$index->isUrl("http://kibana.platel:5601") || @$index->isUrl("http://kibana.platel");
}
$isCerebro = @$index->isSocket("cerebro.".$parent.".".$net, 9000);
$isEs01 = false; // @$index->isUrl("https://es01.".$host.".".$net.":9200");
$isEs02 = false; // @$index->isUrl("https://es02.".$host.".".$net.":9201");
$isEs03 = false; // @$index->isUrl("https://es03.".$host.".".$net.":9202");
$isWiki = @$index->isUrl("https://wiki.".$parent.".".$net);
$isWp = @$index->isUrl("https://".$parent.".wordpress.local");
$isWpa = @$index->isUrl("https://wpa.".$parent.".wordpress.local");
$isPma = @$index->isUrl("https://pma.".$parent.".wordpress.local");
$isRc =  @$index->isUrl("https://rc.".$parent.".wordpress.local");
$isTomcat = @$index->isUrl("https://".$parent.".tomcat.local/manager/");
$env = "";
if ($printEnv) {
	foreach($index->getServerEnv() as $key => $val) {
    		$env .= @sprintf("<strong>%s</strong>:'%s'\n", $key, $val);
	}
}

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs_CZ.UTF-8" lang="cs_CZ.UTF-8">
<head>
  <title><?php print($index->getServerName())?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="style.css" type="text/css">
  <link rel="shortcut icon" href="/favicon.png" type="image/png"/>
</head>

<body>
  <h1><span><strong><?php print($index->getServerName())?></strong>
    <a href="https://github.com/lhsradek/platypus-lhsdock" target="_blank"><img src="github.png" width="30" height="30"/></a>
    <a href="https://hub.docker.com/repository/docker/lhsradek/lhsdock" target="_blank"><img src="docker.png" width="41" height="30"/></a>
    <a href="https://github.com/lhsradek/platypus-wordpress-mysql" target="_blank"><img src="github-wordpress.png" width="65" height="30"/></a>
    <a href="https://www.facebook.com/radek.kadner/" target="_blank"><img src="facebook.png" width="14" height="30"/></a>
    <a href="https://www.linkedin.com/in/radekkadner/" target="_blank"><img src="in.png" width="30" height="30"/></a>
    <a href="mailto:radek.kadner@gmail.com"><img src="mail.png"/></a></span></h1>
  <div class="content">
    <div class="content-middle">
      <p>
<small><?php print("cluster name: <b>".$clusterName."</b> uuid: ".$clusterUuid); ?></small>
      </p><?php if ($printEnv) { ?>
      <h2>Environment</h2>
<code><?php print($env); ?></code>
<?php
} ?></div>

    <div class="content-columns">
      <div class="content-column-left">

        <h2>Links</h2>
        <p>
          <ul>
	    <?php
        if($isTraefik || $isWiki) { ?><li><?php
		if($isTraefik) {
                  if ($parent == "docker") { ?>
<a href="https://web.traefik.local<?php print($port); ?>" target="_blank">web.traefik.local</a>
                <?php } else { ?>
<a href="https://<?php print($parent); ?>.traefik.local<?php print($port); ?>" target="_blank"><?php print($parent); ?>.traefik.local</a>
                  <?php
                  }
                }
		if($isWiki) {
			$index->printWiki("traefik");
		} ?></li><?php
	}
	if($isKibana || $isWiki) { ?><li><?php
		if($isKibana) { ?>
<a href="https://kibana.<?php print($host.".".$net.$port); ?>" target="_blank">kibana.<?php print($host.".".$net); ?></a> <?php
		} if($isWiki) {
			$index->printWiki("kibana");
		} ?></li><?php
	}
	if($isKibanaPlatel) { ?><li>
<a href="https://kibana.platel" target="_blank">kibana.platel</a> <?php
	}
	if($isCerebro|| $isWiki) { ?><li><?php
		if($isCerebro) { ?>
<a href="https://cerebro.<?php print($parent.".".$net.$port); ?>" target="_blank">cerebro.<?php print($parent.".".$net); ?></a> <?php
		} if($isWiki) {
			$index->printWiki("cerebro");
		} ?></li><?php
	}
	if($isEs01 || $isWiki) { ?><li><?php
		if($isEs01) { ?>
<a href="https://es01.<?php print($host.".".$net.$port); ?>:9200/?pretty" target="_blank">es01.<?php print($host.".".$net); ?></a> <?php
		} if($isWiki) {
			$index->printWiki("elasticsearch");
		} ?></li><?php
	}
	if($isEs02) { ?>
<li><a href="https://es02.<?php print($host.".".$net.$port); ?>:9201/?pretty" target="_blank">es02.<?php print($host.".".$net); ?></a></li> <?php
	}
	if($isEs03) { ?>
<li><a href="https://es03.<?php print($host.".".$net.$port); ?>:9202/?pretty" target="_blank">es03.<?php print($host.".".$net); ?></a></li> <?php
	}
	if($isWiki) { ?>
<li><a href="https://wiki.<?php print($parent.".".$net.$port); ?>" target="_blank">wiki.<?php print($parent.".".$net); ?></a><img src="dokuwiki.png" width="12" height="12"></li><?php
	}
	if($isWp) { ?>
<li><a href="https://<?php print($parent); ?>.wordpress.local" target="_blank"><?php print($parent); ?>.wordpress.local</a></li><?php
	}
	if($isWpa) { ?>
<li><a href="https://wpa.<?php print($parent); ?>.wordpress.local" target="_blank">pwa.<?php print($parent); ?>.wordpress.local</a></li><?php
	}
	if($isPma) { ?>
<li><a href="https://pma.<?php print($parent); ?>.wordpress.local" target="_blank">pma.<?php print($parent); ?>.wordpress.local</a></li><?php
	}
	if($isRc) { ?>
<li><a href="https://rc.<?php print($parent); ?>.wordpress.local" target="_blank">rc.<?php print($parent); ?>.wordpress.local</a></li><?php
	} ?>
<li><a href="https://kibana.eliasondrej.com" target="_blank">kibana.eliasondrej.com</a></li>
          </ul>
        </p>

        <h2>Nginx</h2>
        <h5>HTTP and reverse proxy server</h5>
        <p>
          <ul>
            <li><a href="https://<?php print($parent); ?>.nginx.local<?php print($port); ?>/phpinfo.php" target="_blank"><?php print($parent); ?>.nginx.local - phpinfo</a></li>
            <li><a href="https://<?php print($parent); ?>.nginx.local<?php print($port); ?>/downloads/" target="_blank"><?php print($parent); ?>.nginx.local - downloads</a></li>
          </ul>
        </p>

        <p>
        <h2>WildFly</h2>
        <h5>Application server (JBoss)</h5>
        <p>
          <ul>
              <li><a href="https://www.wildfly.org/" target="_blank">wildfly.org</a></li>
          </ul>
        </p>

        <p>
        <h2>Apache Tomcat</h2>
        <h5>Webs servlet/JSP container</h5>
        <p>
          <ul>
              <?php if ($isTomcat) { ?><li><?php print("<a href=\"https://".$parent.".tomcat.local".$port."\" target=\"_blank\">".$parent.".tomcat.local")?></a></li><?php } ?>
              <li><a href="https://tomcat.apache.org" target="_blank">tomcat.apache.org</a></li>
          </ul>
        </p>
	<p><img src="tomcat.png" width="63" height="40"/></p>
	</div>

      <div class="content-column-right">
        <h2>Documentation</h2>
        <p>
          <ul>
              <li><a href="https://wiki.alpinelinux.org" target="_blank">alpinelinux.org</a></li>
              <li><a href="https://docs.docker.com/compose/" target="_blank">docker.com</a></li>
              <li><a href="https://www.elastic.co/guide/en/elasticsearch/reference/current/docker.html" target="_blank">elastic.co</a></li>
              <li><a href="https://nginx.org/en/docs/" target="_blank">nginx.org - docs</a></li>
	  </ul>
        </p>
        <h2>Docker Hub</h2>
        <p>
          <ul>
              <li><a href="https://hub.docker.com/_/adminer" target="_blank">hub.docker.com - Adminer</a></li>
              <li><a href="https://hub.docker.com/_/alpine" target="_blank">hub.docker.com - Alpine Linux</a></li>
              <li><a href="https://hub.docker.com/r/lmenezes/cerebro" target="_blank">hub.docker.com - Cerebro</a></li>
              <li><a href="https://hub.docker.com/r/linuxserver/dokuwiki" target="_blank">hub.docker.com - Dokuwiki</a></li>
              <li><a href="https://hub.docker.com/_/elasticsearch" target="_blank">hub.docker.com - Elasticsearch</a></li>
              <li><a href="https://hub.docker.com/_/debian" target="_blank">hub.docker.com - Debian</a></li>
              <li><a href="https://hub.docker.com/r/grafana/grafana" target="_blank">hub.docker.com - Grafana</a></li>
              <li><a href="https://hub.docker.com/_/kibana" target="_blank">hub.docker.com - Kibana</a></li>
              <li><a href="https://hub.docker.com/_/logstash" target="_blank">hub.docker.com - Logstash</a></li>
              <li><a href="https://hub.docker.com/_/mariadb" target="_blank">hub.docker.com - MariaDB</a></li>
              <li><a href="https://hub.docker.com/_/nginx" target="_blank">hub.docker.com - Nginx</a></li>
              <li><a href="https://hub.docker.com/_/node" target="_blank">hub.docker.com - Node</a></li>
              <li><a href="https://hub.docker.com/_/php" target="_blank">hub.docker.com - PHP</a></li>
              <li><a href="https://hub.docker.com/_/phpmyadmin" target="_blank">hub.docker.com - phpMyAdmin</a></li>
              <li><a href="https://hub.docker.com/_/postgres" target="_blank">hub.docker.com - Postgres</a></li>
              <li><a href="https://hub.docker.com/r/bitnami/prometheus" target="_blank">hub.docker.com - Prometheus</a></li>
              <li><a href="https://hub.docker.com/_/redis" target="_blank">hub.docker.com - Redis</a></li>
              <li><a href="https://hub.docker.com/_/tomcat" target="_blank">hub.docker.com - Tomcat</a></li>
              <li><a href="https://hub.docker.com/_/traefik" target="_blank">hub.docker.com - Traefik</a></li>
              <li><a href="https://hub.docker.com/_/ubuntu" target="_blank">hub.docker.com - Ubuntu</a></li>
              <li><a href="https://hub.docker.com/r/bitnami/wildfly" target="_blank">hub.docker.com - WildFly</a></li>
              <li><a href="https://hub.docker.com/_/wordpress" target="_blank">hub.docker.com - Wordpress</a></li>
	  </ul>
        </p>
        <p><img src="docker-logo.png" width="53" height="40"/></p>
      </div>

    </div>
  </div>
</body>
</html>
