<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
  $printEnv = false;
#  $printEnv = true;

  class IndexController {

    public function isSocket(String $serverName, int $port) {
      $ret = false;
      $fp = fsockopen($serverName, $port, $errno, $errstr, 0.1);
      if($fp) {
        fclose($fp);
        $ret = true;
      }
      return $ret;
    }

    public function getEnv() {
      $ret = getEnv();
      ksort($ret);
      return $ret;
    }

  }

  $index = new IndexController();
  $serverName = $_SERVER['SERVER_NAME'];
  $host = explode(".", $serverName)[0];
  switch ($host) {
    case "lhs01":
        $parent = "docker";
        break;
    case "lhs02":
        $parent = "docker5";
        break;
    case "lhs03":
        $parent = "www";
        break;
  }
  $serverSoftware = ucfirst(preg_split("/\//", $_SERVER['SERVER_SOFTWARE'])[0]);
  $env = "";
  if ($printEnv) {
    foreach($index->getEnv() as $key => $val) {
      $env .= @sprintf("<strong>%s</strong>:'%s'\n", $key, $val);
    }
  }

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs_CZ.UTF-8" lang="cs_CZ.UTF-8">
<head>
  <title><?php print($serverName)?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="style.css" type="text/css">
  <link rel="shortcut icon" href="/favicon.png" th:type="image/png"/>
</head>

<body>
  <h1><strong><?php print($serverName)?></strong></h1>
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
            <li><a href="https://<?php print($parent)?>.traefik.local"><?php print($parent)?>.traefik.local</a></li>
            <ul>
	      <li><a href="https://<?php print($parent)?>.nginx.local"><?php print($parent)?>.nginx.local</a></li>
              <li><a href="https://<?php print($parent)?>.phpmyadmin.local"><?php print($parent)?>.phpmyadmin.local</a></li>
              <li><a href="https://<?php print($parent)?>.wordpress.local"><?php print($parent)?>.wordpress.local</a></li>
            </ul>
          </ul>
        </p>

        <h2>Documentation</h2>
        <p>
          <ul>
              <li><a href="https://hub.docker.com/_/alpine">hub.docker.com - Official build of Alpine Linux</a></li>
              <li><a href="https://hub.docker.com/_/mariadb">hub.docker.com - Official build of MariaDB</a></li>
              <li><a href="https://hub.docker.com/_/nginx">hub.docker.com - Official build of Nginx</a></li>
              <li><a href="https://hub.docker.com/_/php">hub.docker.com - Official build of PHP</a></li>
              <li><a href="https://hub.docker.com/_/phpmyadmin">hub.docker.com - Official build of phpMyAdmin</a></li>
              <li><a href="https://hub.docker.com/_/postgres">hub.docker.com - Official build of Postgres</a></li>
              <li><a href="https://hub.docker.com/_/redis">hub.docker.com - Official build of Redis</a></li>
              <li><a href="https://hub.docker.com/_/tomcat">hub.docker.com - Official build of Tomcat</a></li>
              <li><a href="https://hub.docker.com/_/wordpress">hub.docker.com - Official build of Wordpress</a></li>
              <li><a href="https://docs.docker.com">docs.docker.com</a></li>
              <li><a href="https://nginx.org/en/docs/">nginx.org - Documentation</a></li>
              <li><a href="https://wiki.alpinelinux.org">alpinelinux.org - Wiki</a></li>
          </ul>
        </p>

      </div>

      <div class="content-column-right">

        <h2>nginx</h2>
        <h5>HTTP and reverse proxy server</h5>
        <p>
          <ul>
              <li><a href="https://nginx.com">nginx.com</a></li>
          </ul>
        <p>
        <p><img src="nginx-logo.png"/></p>

        <h2>Apache Tomcat</h2>
        <h5>Webs servlet/JSP container</h5>
        <p>
          <ul>
              <li><a href="https://<?php print($parent)?>.tomcat.local"><?php print($parent)?>.tomcat.local</a></li>
          </ul>
        </p>
        <p><img src="tomcat.png"/></p>

      </div>
    </div>
  </div>
</body>
</html>
