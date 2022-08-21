<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
$printEnv = false;
#  $printEnv = true;

class IndexController {

	public function isSocket(String $serverName, int $port) {
		$ret = false;
		$fp = fsockopen($serverName, $port, $errno, $errstr, 0.1);
		if ($fp) {
			fclose($fp);
			$ret = true;
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
		$ret = $_SERVER['HTTP_X_FORWARDED_PORT'];
		return $ret;
	}

	public function getPort() {
		$serverPort = $this->getServerPort();
		if ($serverPort == 443) {
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
  <h1><strong><?php print($index->getServerName())?></strong> <a href="https://github.com/lhsradek/platypus-lhsdock" target="_blank"><img src="github.png"/></a> <a href="https://hub.docker.com/repository/docker/lhsradek/lhsdock" target="_blank"><img src="docker.png"/></a> <a href="https://www.facebook.com/radek.kadner/" target="_blank"><img src="facebook.png"/></a> <a href="https://www.linkedin.com/in/radekkadner/" target="_blank"><img src="in.png"/></a> <a href="mailto:radek.kadner@gmail.com"><img src="mail.png"/></a></h1>
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
            <li><?php print("<a href=\"https://".$parent.".wordpress.local".$port."\" target=\"_blank\">".$parent.".wordpress.local")?></a></li>
            <!-- <li><?php print("<a href=\"https://".$parent.".wordpress.local".$port."/phpinfo.php\" target=\"_blank\">".$parent.".wordpress.local - phpinfo")?></a></li> -->
            <li><?php print("<a href=\"https://pma.".$parent.".wordpress.local".$port."\" target=\"_blank\">pma.".$parent.".wordpress.local")?></a></li>
            <!-- <li><?php print("<a href=\"https://pma.".$parent.".wordpress.local".$port."/phpinfo.php\" target=\"_blank\">pma.".$parent.".wordpress.local - phpinfo")?></a></li> -->
            <!-- <li><a href="https://wp.dantoaphoto.local" target="_blank">wp.dantoaphoto.local</a></li>
            <li><a href="https://phpmyadmin.dantoaphoto.local" target="_blank">phpmyadmin.dantoaphoto.local</a></li> -->
          </ul>
        </p>

        <h2>Nginx</h2>
        <h5>HTTP and reverse proxy server</h5>
        <p>
          <ul>
            <li><?php print("<a href=\"https://".$parent.".nginx.local".$port."\" target=\"_blank\">".$parent.".nginx.local")?></a></li>
            <li><?php print("<a href=\"https://".$parent.".nginx.local".$port."/phpinfo.php\" target=\"_blank\">".$parent.".nginx.local - phpinfo")?></a></li>
            <li><?php print("<a href=\"https://".$parent.".nginx.local".$port."/downloads/\">".$parent.".nginx.local - downloads")?></a></li>
            <li><a href="https://nginx.com" target="_blank">nginx.com</a></li>
          </ul>
        <p>

        <h2>Apache Tomcat</h2>
        <h5>Webs servlet/JSP container</h5>
        <p>
          <ul>
              <li><?php print("<a href=\"https://".$parent.".tomcat.local".$port."\" target=\"_blank\">".$parent.".tomcat.local")?></a></li>
              <li><a href="https://tomcat.apache.org" target="_blank">tomcat.apache.org</a></li>
          </ul>
        </p>
        <p><img src="tomcat.png"/></p>
      </div>

      <div class="content-column-right">
        <h2>Documentation</h2>
        <p>
          <ul>
              <li><a href="https://hub.docker.com/_/alpine" target="_blank">hub.docker.com - Official build of Alpine Linux</a></li>
              <li><a href="https://hub.docker.com/_/mariadb" target="_blank">hub.docker.com - Official build of MariaDB</a></li>
              <li><a href="https://hub.docker.com/_/nginx" target="_blank">hub.docker.com - Official build of Nginx</a></li>
              <li><a href="https://hub.docker.com/_/php" target="_blank">hub.docker.com - Official build of PHP</a></li>
              <li><a href="https://hub.docker.com/_/phpmyadmin" target="_blank">hub.docker.com - Official build of phpMyAdmin</a></li>
              <li><a href="https://hub.docker.com/_/postgres" target="_blank">hub.docker.com - Official build of Postgres</a></li>
              <li><a href="https://hub.docker.com/_/redis" target="_blank">hub.docker.com - Official build of Redis</a></li>
              <li><a href="https://hub.docker.com/_/tomcat" target="_blank">hub.docker.com - Official build of Tomcat</a></li>
              <li><a href="https://hub.docker.com/_/ubuntu" target="_blank">hub.docker.com - Official build of Ubuntu</a></li>
              <li><a href="https://hub.docker.com/_/wordpress" target="_blank">hub.docker.com - Official build of Wordpress</a></li>
              <li><a href="https://docs.docker.com" target="_blank">docs.docker.com</a></li>
              <li><a href="https://docs.docker.com/compose/" target="_blank">docs.docker.com - compose</a></li>
              <li><a href="https://nginx.org/en/docs/" target="_blank">nginx.org - Documentation</a></li>
              <li><a href="https://wiki.alpinelinux.org" target="_blank">alpinelinux.org - Wiki</a></li>
	  </ul>
        </p>
        <p><img src="docker-logo.png"/></p>
      </div>

    </div>
  </div>
</body>
</html>
