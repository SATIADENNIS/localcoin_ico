<?
if ($_SERVER['REQUEST_URI'] == "/") {
    define('ISMAIN', true );
}

function PR($o, $show = false) {
    global $USER;
        $bt = debug_backtrace();
        $bt = $bt[0];
        $dRoot = $_SERVER["DOCUMENT_ROOT"];
        $dRoot = str_replace("/", "\\", $dRoot);
        $bt["file"] = str_replace($dRoot, "", $bt["file"]);
        $dRoot = str_replace("\\", "/", $dRoot);
        $bt["file"] = str_replace($dRoot, "", $bt["file"]);
        ?>
        <div style='font-size: 12px;font-family: monospace;width: 100%;color: #181819;background: #EDEEF8;border: 1px solid #006AC5;'>
            <div style='padding: 5px 10px;font-size: 10px;font-family: monospace;background: #006AC5;font-weight:bold;color: #fff;'>File: <?= $bt["file"] ?> [<?= $bt["line"] ?>]</div>
            <pre style='padding:10px;'><? print_r($o) ?></pre>
        </div>
        <?
}

//PR($_SERVER);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-133419070-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-133419070-3');
</script>      
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="LocalCoin is the true democratic decentralized ecosystem where everyone is free to do what
they want and how they want. LocalCoin is not a company or a person, it is a community of
people who shares the same libertarian values and freedom.">
    <title>AMCC is the true democratic decentralized trading ecosystem.</title>
    <!-- CSS-->
    <link href="/css/style.css" rel="stylesheet" media="screen">
  </head>
  <body>
    <div class="wrapper">
      <header class="header <?=($_SERVER['REQUEST_URI'] != "/")?'header_inner':''?>" id="header">
        <div class="container">
          <div class="hamburger hamburger--squeeze">
            <div class="hamburger-box">
              <div class="hamburger-inner"></div>
            </div>
          </div><a class="header__logo" href="/"><img src="/img/logo.png" srcset="/img/logo-2x.png 2x" alt="Localcoin"></a>
          <div class="header__nav" style="display:none">
            <ul>
              <li><a href="#advantages">Why</a></li>
              <li><a href="#trading">Trading</a></li>
              <li><a href="#tokeninfo">Token info</a></li>
              <li><a href="#roadmap">Road map</a></li>
              <li><a href="#download">Download</a></li>
            </ul>
          </div>
          <div class="header__right-menu">
            <ul>
              <li><a class="btn-blue btn-blue_small" onclick="gtag('event', 'buy', {'event_category': 'header'});" id="buy_coin_header" href="#">Buy LLC</a></li>
              <li><a class="btn-blue btn-blue_small sign-in" id="signIn" href="#download">Register</a></li>
              <li><a class="whitepaper" href="https://localcoin.is/downloads/LocalCoinBlockchain.pdf" target="_blank">WP</a></li>
              <li><a class="whitelabel" href="/whitelabel">WL</a></li>
              <li>
                <!-- <div class="header__lang select select-lang">
                  <input class="select_hidden" type="hidden" value="1">
                  <div class="select_in select-lang_in"><span class="select_title select-lang_title"><img src="img/eng.png" srcset="img/eng-2x.png 2x" alt="eng"></span><i class="select_arrow select-lang_arrow"></i></div>
                  <ul class="select_list select-lang_list">
                    <li class="is-active" data-value="1"><img src="img/eng.png" srcset="img/eng-2x.png 2x" alt="eng"></li>
                    <li data-value="2"><img src="img/svg/rus.svg" alt="rus"></li>
                  </ul>
                </div> -->
              </li>
            </ul>
          </div>
        </div>
      </header>
