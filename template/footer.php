<section class="getfree" id="getfree">
        <div class="container">
          <div class="getfree__logo"><img src="./../img/d-logo.png" srcset="./../img/d-logo-2x.png 2x" alt="logo"></div>
          <h2 class="wow fadeInUp">Get <span>LLC </span>ASSET NOW<span>!!!</span></h2>
          <p class="wow fadeInUp">The first 100 000 users receive 1+ LLC asset</p><a class="getfree__btn btn-yellow" href="https://t.me/LocalCoinIS">Get LLC NOW!</a>
        </div>
      </section>
      <footer class="footer" id="footer">
        <div class="container">
          <ul class="footer__social f-social">
            <li><a class="f-social__item f-social__item_vk" href="https://vk.com/localcoin" target="_blank"></a></li>
            <li><a class="f-social__item f-social__item_fb" href="#" target="_blank"></a></li>
            <li><a class="f-social__item f-social__item_tm" href="https://t.me/LocalCoinIS" target="_blank"></a></li>
            <li><a class="f-social__item f-social__item_04" href="https://discord.gg/vzxSzYN" target="_blank"></a></li>
            <li><a class="f-social__item f-social__item_06" href="https://golos.io/@localcoin" target="_blank"></a></li>
            <li><a class="f-social__item f-social__item_07" href="https://www.reddit.com/r/LocalCoinIs" target="_blank"></a></li>
            <li><a class="f-social__item f-social__item_08" href="https://steemit.com/@localcoin" target="_blank"></a></li>
            <li><a class="f-social__item f-social__item_ch" href="https://www.chainnode.com/post/336108" target="_blank"></a></li>
            <li><a class="f-social__item f-social__item_bt" href="https://bitcointalk.org/index.php?topic=5125670" target="_blank"></a></li>
            <li><a class="f-social__item f-social__item_tw" href="https://twitter.com/LocalCoinIS" target="_blank"></a></li>
            <li><a class="f-social__item f-social__item_yt" href="https://www.youtube.com/localcoinis?sub_confirmation=1" target="_blank"></a></li>
            <li><a class="f-social__item f-social__item_in" href="#" target="_blank"></a></li>
            <li><a class="f-social__item f-social__item_cm" href="https://coinmarketcap.com/exchanges/localcoin/" target="_blank"></a></li>
          </ul>
          <ul class="footer__links">
            <li><a class="footer__wl" href="/whitelabel">White Label</a></li>
            <li><a class="footer__wp" href="https://localcoin.is/downloads/LocalCoinBlockchain.pdf" target="_blank">White Paper</a></li>
            <li><a class="btn-blue" onclick="gtag('event', 'buy', {'event_category': 'footer'});"  id="buy_coin_footer" href="#">Buy LLC token</a></li>
          </ul>
          <ul class="footer__nav wow fadeInUp">
            <li><a href="#main">Home</a></li>
            <li><a href="#advantages">Why</a></li>
            <li><a href="#trading">Trading</a></li>
            <li><a href="#tokeninfo">Token info</a></li>
            <li><a href="#roadmap">Road map</a></li>
            <li><a href="#download">Download</a></li>
            <li><a href="https://dev.localcoin.is" target="_blank">Documentation</a></li>
            <li><a href="https://how.localcoin.is" target="_blank">User guide</a></li>
            <li><a href="#airDrop">Reward</a></li>
          </ul>
          <div class="footer__desc wow fadeInUp">AMCC is THE true democracy decentralized ecosystem where everyone is free to do what they want and say what they want. AMCC is a community of people who shares the same libertarian values and freedoms.</div>
        </div>
      </footer>
      <div class="popup-modal">
        <div class="p-modal">
          <div class="p-modal__close"></div>
          <div class="p-modal__form" id="bridgeFormInput">
            <form class="ps-form" action="#" id="bridgeForm">
              <div class="ps-form__input ps-form__input_num input-coin">
                <input type="number" min="0.0001" step="0.0001" name="btc" value="0" id="bridgeAmountFrom">
                <div class="ps-form__select select select-coin">
                  <input class="select_hidden" type="hidden" value="BTC" id="bridgeCurrency">
                  <div class="select_in select-coin_in">
                    <span class="select_title select-coin_title" id="bridgeCurrenciesLabel">BTC</span>
                    <i class="select_arrow select-coin_arrow"></i>
                  </div>
                  <div class="select_list select-coin_list" id="bridgeCurrenciesList">
                    <div class="search_container">
                      <input type="text" id="search_input" placeholder="Search..">
                    </div>
                  </div>
                </div>
                <div class="prev-coin"></div>
                <div class="next-coin"></div>
              </div>
              <div class="ps-form__arr"></div>
              <div class="ps-form__input ps-form__input_num input-llc">
                <input type="number" name="llc" value="0" id="bridgeAmountTo" style="background-color: #fff;">
                <label id="bridgeAmountToError" style="display: none; display: block; position: relative; float: left; top: 50px; color: #ffde25; font-size: 16px;">min to buy is 5 LLC</label>
              </div>
              <div class="ps-form__input ps-form__input_text" style="margin-top: 30px;">
                <input type="text" id="grapheneUsername" placeholder="Your LocalCoin Account name">
                <span id="loginError" class="ps-form__reg" style="color: #faa; display: inherit; margin-top: 10px;"></span>
                <span class="ps-form__reg">Not a member yet? <a href="https://localcoin.is/#download" target="_blank">Register now</a></span>
              </div>
              <input class="ps-form__btn btn-yellow" type="submit" value="Buy LLC coin" id="bridgeSubmit">
            </form>
          </div>
          <div class="p-modal__form" id="bridgeFormAddress" style="display: none;">
            <span class="ps-form__reg" style="display: inherit; margin-top: 20px;">Deposit to account: <a id="accountName" target="_blank" href=""></a></span>
            <span class="ps-form__reg" style="display: inherit; margin-top: 20px;">Address for deposit <a id="bridgeFormInputAsset" target="_blank" href=""></a>: </span>
            <span class="ps-form__reg" style="display: inherit; font-size: 20px;">
            <textarea rows="3" id="bridgeFormInputAddress" style="margin-top: 10px; width: 450px; border: 0; background: none; color: #fff; text-align: center; font-size: 19px;"></textarea>
            </span>
            <span class="ps-form__reg">
              <a data-copy="#bridgeFormInputAddress" style="font-size: 25px; cursor: pointer;">copy address</a>
            </span>
            <span id="bridgeFormInputCountConfirmations" class="ps-form__reg" style="display: inherit; margin-top: 10px;"></span>
            <span id="loginError" class="ps-form__reg" style="color: #faa; display: inherit; margin-top: 10px; padding-left: 25px; padding-right: 25px; margin-top: 10px;">
              IMPORTANT: Send only  to this deposit address. Sending less than or any other currency to this address may result in the loss of your deposit.
            </span>
          </div>
        </div>
      </div>
    </div>

    <input type="hidden" id="translate-count-confirmations" value="Wait for {x} confirmations for balance funding"      />
    <input type="hidden" id="translate-course-error-load"   value="Exchange rate update failed, please reload the page" />
    <input type="hidden" id="translate-login-error"         value="The account name could not be found"                 />
    <input type="hidden" id="translate-emptylogin-error"    value="Please enter real account name"                      />

    <!-- jQuery-->
    <script src="/js/jquery-3.3.1.min.js"></script>
    <!-- Plugins for airDrop chart-->
    <script src="/js/TweenMax.min.js"></script>
    <script src="/js/Draggable.min.js"></script>
    <script src="/js/ThrowPropsPlugin.min.js"></script>
    <script src="/js/DrawSVGPlugin.min.js"></script>
    <script src="/js/AnticipateEase.min.js"></script>
    <script src="/js/MorphSVGPlugin.min.js"></script>
    <!-- Plugins-->
    <script src="/js/wow.min.js"></script>
    <script src="/js/slick.min.js"></script>
    <script src="/js/fancybox.min.js"></script>
    <script src="/js/mCustomScrollbar.min.js"></script>
    <script src="/js/Chart.min.js"></script>
    <script src="/js/chartjs-plugin-style.min.js"></script>
    <script src="/js/Sticky-kit.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- JavaScripts-->
    <script src="/js/scripts.js"></script>
    <script src="/js/bridge.js"></script>
  </body>
</html>
