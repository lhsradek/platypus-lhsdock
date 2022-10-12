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
$printEnv = false;
#  $printEnv = true;

class IndexController {

	public function isSocket(String $serverName, int $port) {
		$ret = false;
		$fp = fsockopen($serverName, $port, $errno, $errstr, 1);
		if ($fp) {
			fclose($fp);
			$ret = true;
		}
		return $ret;
	}

	public function isUrl(String $url) {
		$ret = true;
		stream_context_set_default( [
    			'ssl' => [
        			'verify_peer' => false,
        			'verify_peer_name' => false,
    			],
		]);
		$file_headers = get_headers($url);
		if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
    			$ret = false;
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
			$ret = ":" . $serverPort;
		}
		return $ret;
	}

}

$index = new IndexController();
$port = $index->getPort();
$parent = @$_SERVER['APP_HOST'];;
$net = @$_SERVER['APP_NET'];
$clusterName = @$_SERVER['CLUSTER_NAME'];
$clusterUuid = @$_SERVER['CLUSTER_UUID'];
$serverSoftware = ucfirst(preg_split("/\//", $_SERVER['SERVER_SOFTWARE'])[0]);
$isApm =  @$index->isSocket("lhsdock-apm", 8200);
$isKibana = @$index->isSocket("lhsdock-kibana", 5601);
$isCerebro = @$index->isSocket("lhsdock-cerebro", 9000);
$isEs01 = @$index->isSocket("lhsdock-es01", 9200);
$isEs02 = @$index->isSocket("lhsdock-es02", 9201);
$isEs03 = @$index->isSocket("lhsdock-es03", 9202);
$isFile =  @$index->isSocket("lhsdock-file", 5066);
$isHeart =  @$index->isSocket("lhsdock-heart", 5066);
$isMetric =  @$index->isSocket("lhsdock-metric", 5066);
$isWiki = @$index->isUrl("https://wiki.".$parent.".".$net);
$isWp = @$index->isUrl("https://".$parent.".wordpress.local");
$isWpa = @$index->isUrl("https://wpa.".$parent.".wordpress.local");
$isPma = @$index->isUrl("https://pma.".$parent.".wordpress.local");
$isRc = @$index->isUrl("https://rc.".$parent.".wordpress.local");
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
  <link rel="shortcut icon" href="/favicon.png" th:type="image/png"/>
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
      <h5><span><?php print($clusterName." ".$clusterUuid); ?></span></h5>
<?php if ($printEnv) { ?>
      <h2>Environment</h2>
<code>
<?php print($env); ?></code>
<?php
} ?>
    </div>

    <div class="content-columns">
      <div class="content-column-left">

        <h2>Links</h2>
        <p>
          <ul>
	    <li><?php
	print("<a href=\"https://".$parent.".traefik.local".$port."\" target=\"_blank\">".$parent.".traefik.local</a>");
	if($isWiki) {
		print(" <small><a href=\"https://wiki.".$parent.".".$net."/doku.php?id=traefik\" target=\"_blank\">Traefik</a></small><img src=\"dokuwiki.png\" width=\"8\" height=\"8\"></li>");
	} ?></li> <?php
	if($isKibana || $isWiki) { ?><li><?php
		if($isKibana) {
			print("<a href=\"https://kibana.".$parent.".".$net.":5601\" target=\"_blank\">kibana.".$parent.".".$net."</a> ");
		} if($isWiki) {
			print("<small><a href=\"https://wiki.".$parent.".".$net."/doku.php?id=kibana\" target=\"_blank\">Kibana</a></small><img src=\"dokuwiki.png\" width=\"8\" height=\"8\"></li>");
		}
	}
	if($isCerebro|| $isWiki) {
		?><li><?php
		if($isCerebro) {
			print("<a href=\"https://cerebro.".$parent.".".$net.$port."\" target=\"_blank\">cerebro.".$parent.".".$net."</a> ");
		} if($isWiki) {
			print("<small><a href=\"https://wiki.".$parent.".".$net."/doku.php?id=cerebro\" target=\"_blank\">Cerebro</a></small><img src=\"dokuwiki.png\" width=\"8\" height=\"8\"></li>");
		}
	}
	if($isEs01 || $isWiki) { ?><li><?php
		if($isEs01) {
			print("<a href=\"https://es01.".$parent.".".$net.":9200/?pretty\" target=\"_blank\">es01.".$parent.".".$net."</a> ");
		} if($isWiki) {
			print("<small><a href=\"https://wiki.".$parent.".".$net."/doku.php?id=elasticsearch\" target=\"_blank\">Elasticsearch</a></small><img src=\"dokuwiki.png\" width=\"8\" height=\"8\"></li>");
		}
	}
	if($isEs02) {
		print("<li><a href=\"https://es02.".$parent.".".$net.":9201/?pretty\" target=\"_blank\">es02.".$parent.".".$net."</a></li>");
	}
	if($isEs03) {
		print("<li><a href=\"https://es03.".$parent.".".$net.":9202/?pretty\" target=\"_blank\">es03.".$parent.".".$net."</a></li>");
	}
	if($isApm || $isWiki) { ?><li><?php
		if($isApm && $isKibana) {
			print("<a href=\"https://apm.".$net."/?pretty\" target=\"_blank\">apm.".$net."</a> ");
		} if($isWiki) {
			print("<small><a href=\"https://wiki.".$parent.".".$net."/doku.php?id=apm-server\" target=\"_blank\">APM Server</a></small><img src=\"dokuwiki.png\" width=\"8\" height=\"8\"></li>");
		}
	}
	if($isFile || $isWiki) { ?><li><?php
		if($isFile && $isKibana) {
			print("<a href=\"https://file.".$net."?pretty\" target=\"_blank\">file.".$net."</a> ");
		} if($isWiki) {
			print("<small><a href=\"https://wiki.".$parent.".".$net."/doku.php?id=beats#filebeat\" target=\"_blank\">Filebeat</a></small><img src=\"dokuwiki.png\" width=\"8\" height=\"8\"></li>");
		}
	}
	if($isHeart || $isWiki) { ?><li><?php
		if($isHeart && $isKibana) {
			print("<a href=\"https://heart.".$net."?pretty\" target=\"_blank\">heart.".$net."</a> ");
		} if($isWiki) {
			print("<small><a href=\"https://wiki.".$parent.".".$net."/doku.php?id=beats#heartbeat\" target=\"_blank\">Heartbeat</a></small><img src=\"dokuwiki.png\" width=\"8\" height=\"8\"></li>");
		}
	}
	if($isMetric || $isWiki) { ?><li><?php
		if($isMetric && $isKibana) {
			print("<a href=\"https://metric.".$net."?pretty\" target=\"_blank\">metric.".$net."</a> ");
		} if($isWiki) {
			print("<small><a href=\"https://wiki.".$parent.".".$net."/doku.php?id=beats#metricbeat\" target=\"_blank\">Metricbeat</a></small><img src=\"dokuwiki.png\" width=\"8\" height=\"8\"></li>");
		}
	}
	if($isWiki) {
		print("<li><span><a href=\"https://wiki.".$parent.".".$net.$port."\" target=\"_blank\">wiki.".$parent.".".$net."</a><br/><img src=\"dokuwiki.png\" width=\"24\" height=\"24\"></span></li>");
	}
	if($isWp) {
		print("<li><a href=\"https://".$parent.".wordpress.local".$port."\" target=\"_blank\">".$parent.".wordpress.local</a></li>");
	}
	if($isWpa) {
		print("<li><a href=\"https://wpa.".$parent.".wordpress.local\" target=\"_blank\">wpa.".$parent.".wordpress.local</a></li>");
	}
	if($isPma) {
		print("<li><a href=\"https://pma.".$parent.".wordpress.local".$port."\" target=\"_blank\">pma.".$parent.".wordpress.local</a></li>");
	}
	if($isRc) {
		print("<li><a href=\"https://rc.".$parent.".wordpress.local".$port."\" target=\"_blank\">rc.".$parent.".wordpress.local</a></li>");
	} ?>
          </ul>
          </p>

        <h2>Nginx</h2>
        <h5>HTTP and reverse proxy server</h5>
        <p>
          <ul>
            <li><?php print("<a href=\"https://".$parent.".nginx.local".$port."/phpinfo.php\">".$parent.".nginx.local - phpinfo")?></a></li>
            <li><?php print("<a href=\"https://".$parent.".nginx.local".$port."/downloads/\">".$parent.".nginx.local - downloads")?></a></li>
            <li><a href="https://nginx.com" target="_blank">nginx.com</a></li>
          </ul>
        </p>

        <p>
        <h2>Apache Tomcat</h2>
        <h5>Webs servlet/JSP container</h5>
        <p>
          <ul>
              <?php if ($isTomcat) { ?><li><?php print("<a href=\"https://".$parent.".tomcat.local".$port."\" target=\"_blank\">".$parent.".tomcat.local")?></a></li><?php } ?>
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
              <li><a href="https://www.elastic.co/guide/en/elasticsearch/reference/8.4/docker.html" target="_blank">elastic.co</a></li>
              <li><a href="https://nginx.org/en/docs/" target="_blank">nginx.org</a></li>
              <li><a href="https://tomcat.apache.org" target="_blank">tomcat.apache.org</a></li>
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
              <li><a href="https://hub.docker.com/_/kibana" target="_blank">hub.docker.com - Kibana</a></li>
              <li><a href="https://hub.docker.com/_/logstash" target="_blank">hub.docker.com - Logstash</a></li>
              <li><a href="https://hub.docker.com/_/mariadb" target="_blank">hub.docker.com - MariaDB</a></li>
              <li><a href="https://hub.docker.com/_/nginx" target="_blank">hub.docker.com - Nginx</a></li>
              <li><a href="https://hub.docker.com/_/node" target="_blank">hub.docker.com - Node</a></li>
              <li><a href="https://hub.docker.com/_/php" target="_blank">hub.docker.com - PHP</a></li>
              <li><a href="https://hub.docker.com/_/phpmyadmin" target="_blank">hub.docker.com - phpMyAdmin</a></li>
              <li><a href="https://hub.docker.com/_/postgres" target="_blank">hub.docker.com - Postgres</a></li>
              <li><a href="https://hub.docker.com/_/redis" target="_blank">hub.docker.com - Redis</a></li>
              <li><a href="https://hub.docker.com/_/tomcat" target="_blank">hub.docker.com - Tomcat</a></li>
              <li><a href="https://hub.docker.com/_/ubuntu" target="_blank">hub.docker.com - Ubuntu</a></li>
              <li><a href="https://hub.docker.com/_/wordpress" target="_blank">hub.docker.com - Wordpress</a></li>
	  </ul>
        </p>
        <p><img src="docker-logo.png" width="53" height="40"/></p>
      </div>

    </div>
  </div>
</body>
</html>
