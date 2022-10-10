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

	public function getParent() {
		switch ($this->getServerName()) {
		case "docker.nginx.local":
			$ret = "docker";
			break;
		case "docker5.nginx.local":
			$ret = "docker5";
			break;
		default:
			$ret = "www";
		}
		return $ret;
	}
}

$index = new IndexController();
$parent = $index->getParent();
$port = $index->getPort();
$serverSoftware = ucfirst(preg_split("/\//", $_SERVER['SERVER_SOFTWARE'])[0]);
$isKibana = @$index->isUrl("https://kibana.".$parent.".nginx.local:5601");
$isCerebro = @$index->isSocket("cerebro.".$parent.".nginx.local", 9000);
$isEs01 = @$index->isSocket("es01.".$parent.".nginx.local", 9200);
$isEs02 = @$index->isSocket("es02.".$parent.".nginx.local", 9201);
$isEs03 = false; // @$index->isSocket("es03.".$parent.".nginx.local", 9202);
$isApm =  @$index->isSocket("apm.nginx.local", 8200);
$isFile =  @$index->isSocket("file.nginx.local", 5066);
$isHeart =  @$index->isSocket("heart.nginx.local", 5066);
$isMetric =  @$index->isSocket("metric.nginx.local", 5066);
$isFleet =  @$index->isSocket("fleet.nginx.local", 8220);
$isWiki = @$index->isUrl("https://wiki.".$parent.".nginx.local");
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
<?php if ($printEnv) { ?>
    <div class="content-middle">
      <h2>Environment</h2>
<code>
<?php print($env); ?></code>
    </div>
<?php
} ?>

    <div class="content-columns">
      <div class="content-column-left">

        <h2>Links</h2>
        <p>
          <ul>
            <li><?php print("<a href=\"https://".$parent.".traefik.local".$port."\" target=\"_blank\">".$parent.".traefik.local")?></a></li>
	    <?php if($isKibana || $isWiki) { ?><li><?php if($isKibana) { print("<a href=\"https://kibana.".$parent.".nginx.local:5601\" target=\"_blank\">kibana.".$parent.".nginx.local</a> "); } if($isWiki) { ?><small><a href="https://wiki.docker.nginx.local/doku.php?id=kibana" target="_blank">Kibana</a></small><img src="dokuwiki.png" width="10" height="10"></li><?php } } ?>
            <?php if($isCerebro|| $isWiki) { ?><li><?php if($isCerebro) { print("<a href=\"https://cerebro.".$parent.".nginx.local".$port."\" target=\"_blank\">cerebro.".$parent.".nginx.local</a> "); } if($isWiki) { ?><small><a href="https://wiki.docker.nginx.local/doku.php?id=cerebro" target="_blank">Cerebro</a></small><img src="dokuwiki.png" width="10" height="10"></li><?php } } ?>
            <?php if($isEs01 || $isWiki) { ?><li><?php if($isEs01) { print("<a href=\"https://es01.".$parent.".nginx.local:9200/?pretty\" target=\"_blank\">es01.".$parent.".nginx.local</a> "); } if($isWiki) { ?><small><a href="https://wiki.docker.nginx.local/doku.php?id=elasticsearch" target="_blank">Elasticsearch</a></small><img src="dokuwiki.png" width="10" height="10"></li><?php } } ?>
            <?php if($isEs02) { print("<li><a href=\"https://es02.".$parent.".nginx.local:9201/?pretty\" target=\"_blank\">es02.".$parent.".nginx.local"); ?></a></li><?php } ?>
            <?php if($isEs03) { print("<li><a href=\"https://es03.".$parent.".nginx.local:9202/?pretty\" target=\"_blank\">es03.".$parent.".nginx.local"); ?></a></li><?php } ?>
            <?php if($isMetric || $isWiki) { ?><li><?php if($isMetric) { print("<a href=\"https://metric.nginx.local?pretty\" target=\"_blank\">metric.nginx.local</a> "); } if($isWiki) { ?><small><a href="https://wiki.docker.nginx.local/doku.php?id=beats#metricbeat" target="_blank">Metricbeat</a></small><img src="dokuwiki.png" width="10" height="10"></li><?php } } ?>
            <?php if($isFile || $isWiki) { ?><li><?php if($isFile) { print("<a href=\"https://file.nginx.local?pretty\" target=\"_blank\">file.nginx.local</a> "); } if($isWiki) { ?><small><a href="https://wiki.docker.nginx.local/doku.php?id=beats#filebeat" target="_blank">Filebeat</a></small><img src="dokuwiki.png" width="10" height="10"></li><?php } } ?>
            <?php if($isHeart || $isWiki) { ?><li><?php if($isHeart) { print("<a href=\"https://heart.nginx.local?pretty\" target=\"_blank\">heart.nginx.local</a> "); } if($isWiki) { ?><small><a href="https://wiki.docker.nginx.local/doku.php?id=beats#heartbeat" target="_blank">Heartbeat</a></small><img src="dokuwiki.png" width="10" height="10"></li><?php } } ?>
            <?php if($isApm || $isWiki) { ?><li><?php if($isApm) { print("<a href=\"https://apm.nginx.local/?pretty\" target=\"_blank\">apm.nginx.local</a> "); } if($isWiki) { ?><small><a href="https://wiki.docker.nginx.local/doku.php?id=apm-server" target="_blank">APM Server</a></small><img src="dokuwiki.png" width="10" height="10"></li><?php } } ?>
            <?php if($isFleet || $isWiki) { ?><li><?php if($isFleet) { print("fleet.nginx.local "); } if($isWiki) { ?><small><a href="https://wiki.docker.nginx.local/doku.php?id=fleet-server" target="_blank">Fleet Server</a></small><img src="dokuwiki.png" width="10" height="10"></li><?php } } ?>
            <?php if($isWiki) { print("<li><a href=\"https://wiki.".$parent.".nginx.local".$port."\" target=\"_blank\">wiki.".$parent.".nginx.local</a><img src=\"dokuwiki.png\" width=\"10\" height=\"10\"></li>"); } ?>
            <?php if($isWp) { print("<li><a href=\"https://".$parent.".wordpress.local".$port."\" target=\"_blank\">".$parent.".wordpress.local</a></li>"); } ?>
	    <?php if($isWpa) { print("<li><a href=\"https://wpa.".$parent.".wordpress.local\" target=\"_blank\">wpa.".$parent.".wordpress.local</a></li>"); } ?>
            <?php if($isPma) { print("<li><a href=\"https://pma.".$parent.".wordpress.local".$port."\" target=\"_blank\">pma.".$parent.".wordpress.local</a></li>"); } ?>
            <?php if($isRc) { print("<li><a href=\"https://rc.".$parent.".wordpress.local".$port."\" target=\"_blank\">rc.".$parent.".wordpress.local</a></li>"); } ?>
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
