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

    public function getServerParent() {
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
  $parent = $index->getServerParent();
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
  <h1><strong><?php print($index->getServerName())?></strong><!--  <img src="poweredby.png"/>--></h1>
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
            <li><a href="https://<?php print($parent)?>.traefik.local" target="_blank"><?php print($parent)?>.traefik.local</a></li>
            <ul>
	      <li><a href="https://<?php print($parent)?>.nginx.local"><?php print($parent)?>.nginx.local</a></li>
	      <li><a href="https://<?php print($parent)?>.nginx.local/downloads/readme.txt"><?php print($parent)?>.nginx.local - readme</a></li>
              <li><a href="https://<?php print($parent)?>.wordpress.local" target="_blank"><?php print($parent)?>.wordpress.local</a></li>
              <li><a href="https://pma.<?php print($parent)?>.wordpress.local" target="_blank">pma.<?php print($parent)?>.wordpress.local</a></li>
            </ul>
          </ul>
        </p>

        <h2>Apache Tomcat</h2>
        <h5>Webs servlet/JSP container</h5>
        <p>
          <ul>
              <li><a href="https://<?php print($parent)?>.tomcat.local" target="_blank"><?php print($parent)?>.tomcat.local</a></li>
              <li><a href="https://<?php print($parent)?>.tomcat.local/tombola" target="_blank"><?php print($parent)?>.tomcat.local - tombola</a></li>
          </ul>
        </p>
        <p><img src="tomcat.png"/></p>
        <h2>nginx</h2>
        <h5>HTTP and reverse proxy server</h5>
        <p>
          <ul>
              <li><a href="https://nginx.com" target="_blank">nginx.com</a></li>
          </ul>
        <p>
        <p><img src="nginx-logo.png"/></p>
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
        <p><img src="docker.png"/></p>
      </div>

    </div>
  </div>
</body>
</html>
