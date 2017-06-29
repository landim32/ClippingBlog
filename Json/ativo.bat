[
  {
    "url": "http://www.phpit.com.br",
    "url_artigo": "#^http://www.phpit.com.br/artigos/([a-z,A-Z,\\-,_]+)\\.phpit$#i",
    "titulo": "#<h1 class=\"headline\">(.*?)</h1>#i",
    "texto": "#<div class=\"article\">.*?<span class=\"divider-small\"></span>(.*?)<div class=\"sharedaddy sd-sharing-enabled\">#s",
    "autor_padrao": "Rafael Jaques",
    "data": "#<meta property=\"article:published_time\" content=\"(\\d{4}-\\d{2}-\\d{2})T.*\"/>#i",
    "test_file": "phpit.html"
  },
  {
    "url": "https://www.tiagogouvea.com.br",
    "url_artigo": "#^https://www.tiagogouvea.com.br/([a-z,A-Z,\\-,_]+)$#i",
    "titulo": "#<meta property=\"og:title\" content=\"(.*?)\" />#i",
    "texto": "#<div style=\"margin: 10px 0 40px 0;\">.*?</center>.*?</div>(.*?)<div class=\"tt-share clearfix\">#s",
    "autor_padrao": "Tiago Gouvêa",
    "data": "#<meta property=\"article:published_time\" content=\"(\\d{4}-\\d{2}-\\d{2})T.*\" />#i",
    "test_file": "tiagogouvea.html"
  },
  {
    "url": "http://www.marcofolio.net",
    "url_artigo": "#^http://www.marcofolio.net/([a-z,A-Z,0-9,\\-,_]+)/([a-z,A-Z,0-9,\\-,_]+).html$#i",
    "titulo": "#<td class=\"contentheading\" width=\"100%\">(.*?)</td>#s",
    "texto": "#<table class=\"contentpaneopen\">.*?<td valign=\"top\" colspan=\"2\">(.*?)<br />Tags:#s",
    "autor_padrao": "Marco Folio",
    "test_file": "marcofolio-exemplo.html"
  },
  {
    "url": "http://www.phpblog.com.br",
    "url_artigo": "#^http://www.phpblog.com.br/([a-z,A-Z,\\-]+)/$#i",
    "titulo": "#<h1 class=\"entry-title\">(.*?)</h1>#i",
    "data": "#<time class=\"entry-date\" datetime=\"(\\d{4}-\\d{2}-\\d{2})T.*\">.*</time>#i",
    "texto": "#<div class=\"entry-content\">(.*?)</div><!-- .entry-content -->#s",
    "autor": "#<p>Autor: <a href=\".*\" target=\"_blank\">([a-z,A-Z,\\ ]+)</a>#i",
    "url_fonte": "#Fonte: <a href=\"(.*?)\" target=\"_blank\">.*</a>#i",
    "test_file": "phpblog-exemplo.html"
  }
]