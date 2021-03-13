<?include __DIR__.'/../template/header.php';?>
      <section class="white-label" id="whitelabel">
        <div class="container">
          <ul class="breadcrumbs white-label__breadcrumbs">
            <li><a href="/">Home</a></li>
            <li>White Label</li>
          </ul>
          <div class="row">
            <div class="col-sm-6 col-md-8">
				<h1 class="white-label__title"><span>White label </span> Decentralized autonomous organization</h1><span class="white-label__subtitle">Running your own blockchain (decentralized) platform with a few clicks of a button.</span>
            </div>
            <div class="col-sm-6 col-md-4">
            <form class="white-label__form wl-form" method = "POST" action="#">
                <input type="hidden" name = "emailTo" value ="localcoin@sent.com">
                <h4 class="wl-form__title">Order now!</h4>
                <p class = "messege"></p>
                <div class="wl-form__input">
                  <label for="input_name">Name*</label>
                  <input id="input_name" type="text" name="name" required>
                </div>
                <div class="wl-form__input">
                  <label for="input_email">Email*</label>
                  <input id="input_email" type="email" name="email" required>
                </div>
                <div class="wl-form__input">
                  <label for="message">Your message:</label>
                  <textarea id="message" name="message"></textarea>
                </div>
                <div class="g-recaptcha" data-sitekey="6LdX_XoUAAAAANzmXQd6CUx0Blgpx-ztSrSVtoTk"></div>
                <input class="wl-form__submit" type="submit" value="Submit">
              </form>
            </div>
          </div>
        </div>
       <div class="white-label__advantages wl-advantages">
          <div class="container">
            <div class="row">
              <div class="col-sm-6 col-md-4">
                <div class="wl-advantages__item wl-advantages__item_01">
                  <h5>High performance</h5>
                  <p>A liquidity-ready Amcc is one of the <a href="https://localcoin.is/#trading">fastest blockchain</a> existed on the market</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="wl-advantages__item wl-advantages__item_02">
                  <h5>Top-notch technology</h5>
                  <p>We made the best of what Lmax Exchange had to offer and built <a href="https://localcoin.is/#advantages">better-designed platform</a>. It can process more that 180k transactions every second which is much more than Visa or MasterCard combined.</p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6 col-md-4">
                <div class="wl-advantages__item wl-advantages__item_03">
                  <h5>Ready-made, customizable UI</h5>
                  <p>Go with the original LocalCoin layouts with improved design. All tailored to your brand identity and regularly updated by our team. You can also provide deeper customization if needed.</p>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="wl-advantages__item wl-advantages__item_04">
                  <h5>Scalability</h5>
                  <p>Increase your revenues by implementing Blockchain Tech  son a one-time payment or revenue-sharing basis.</p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6 col-md-4">
                <div class="wl-advantages__item wl-advantages__item_05">
                  <h5>Professional product team</h5>
                  <p>A team of 21+ blockchain and cryptocurrency experts is working every day to improve the platform. We are constantly rolling out new gateways to let users trade world’s most wanted coins. Rest assured we’ll have you covered from the moment your exchange goes live.</p>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="wl-advantages__item wl-advantages__item_06">
                  <h5>Flexible engagement models</h5>
                  <p>We’ve come up with 3 transparent engagement models, each with a different level of control and risk. You can start small and then switch to a more high-profit model as your business grows.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-md-8">
              <div class="white-label__fees">
                <h3>Fees</h3>
                <p>Amcc DEX relies on NO trading fee structure, there are only fixed small fees applicable, just to cover the broadcasting, simply to push your transaction into the blockchain. See this document to learn more about <a href="https://wallet.commodity.llc/explorer/fees" target="_blank">Amcc's fees.</a></p>
              </div>
              <div class="white-label__tech-req tech-req">
                <h3>Technical requirements</h3>
                <p>Our platform requires no heavy infrastructure investments. All you need to get your exchange up and running is:</p>
                <ul class="tech-req__list">
                  <li class="tech-req__list-item tech-req__list-item_01">Registered domain name</li>
                  <li class="tech-req__list-item tech-req__list-item_02">SSL certificate</li>
                  <li class="tech-req__list-item tech-req__list-item_03">2 servers with the following minimum configuration:</li>
                </ul>
                <div class="tech-req__table">
                  <table>
                    <tr>
                      <td class="t-title">Processor</td>
                      <td>Intel® Xeon® E5-1650 v3 Hexa-Core</td>
                    </tr>
                    <tr>
                      <td class="t-title">RAM</td>
                      <td>32GB DDR4 ECC</td>
                    </tr>
                    <tr>
                      <td class="t-title">Data Storage</td>
                      <td>2×500GB SATA 6Gb/s Enterprise HDD; 7200 rpm (or 2×500GB SSD)</td>
                    </tr>
                    <tr>
                      <td class="t-title">Ethernet</td>
                      <td>1 Gbit/s bandwidth</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

<?include __DIR__.'/../template/footer.php';?>