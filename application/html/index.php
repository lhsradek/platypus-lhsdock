<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
$isWp = @$index->isUrl("https://".$parent.".wordpress.local");
$isWpa = @$index->isUrl("https://wpa.".$parent.".wordpress.local");
$isPma = @$index->isUrl("https://pma.".$parent.".wordpress.local");
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
    <a href="https://hub.docker.com/repository/docker/lhsradek/lhsdock" target="_blank"><img src="docker.png" width="30" height="30"/></a>
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
            <?php if($isWp) { ?><li><?php print("<a href=\"https://".$parent.".wordpress.local".$port."\" target=\"_blank\">".$parent.".wordpress.local")?></a></li><?php } ?>
	    <?php if($isWpa) { ?><li><?php print("<a href=\"https://wpa.".$parent.".wordpress.local\" target=\"_blank\">wpa.".$parent.".wordpress.local")?></a></li><?php } ?>
            <?php if($isPma) { ?><li><?php print("<a href=\"https://pma.".$parent.".wordpress.local".$port."\" target=\"_blank\">pma.".$parent.".wordpress.local")?></a></li><?php } ?>
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
        <p>

        <h2>Apache Tomcat</h2>
        <h5>Webs servlet/JSP container</h5>
        <p>
          <ul>
              <li><?php print("<a href=\"https://".$parent.".tomcat.local".$port."\">".$parent.".tomcat.local")?></a></li>
              <li><a href="https://tomcat.apache.org" target="_blank">tomcat.apache.org</a></li>
          </ul>
        </p>
	<p><img src="tomcat.png" width="63" height="40"/></p>
      </div>

      <div class="content-column-right">
        <h2>Documentation</h2>
        <p>
          <ul>
              <li><a href="https://hub.docker.com/_/adminer" target="_blank">hub.docker.com - Adminer</a></li>
              <li><a href="https://hub.docker.com/_/alpine" target="_blank">hub.docker.com - Alpine Linux</a></li>
              <li><a href="https://hub.docker.com/_/elasticsearch" target="_blank">hub.docker.com - Elasticsearch</a></li>
              <li><a href="https://hub.docker.com/_/kibana" target="_blank">hub.docker.com - Kibana</a></li>
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
              <li><a href="https://docs.docker.com/compose/" target="_blank">docs.docker.com - compose</a></li>
              <li><a href="https://nginx.org/en/docs/" target="_blank">nginx.org - Documentation</a></li>
              <li><a href="https://wiki.alpinelinux.org" target="_blank">alpinelinux.org - Wiki</a></li>
	  </ul>
        </p>
        <p><img src="docker-logo.png" width="53" height="40"/></p>
      </div>

    </div>
  </div>
</body>
</html>
