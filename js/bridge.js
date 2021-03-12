// #bridgeForm
// #bridgeAmountFrom
// #bridgeCurrency
// #bridgeCurrenciesList
// #bridgeAmountTo
// #bridgeSubmit
const MIN_LLC_VAL = 5;
const MAX_CNT_IN_DROP_DOWN = 12;

// setTimeout(function() {
//     $("#buy_coin_header").click();
//     setTimeout(function() { $("#bridgeCurrenciesLabel").click(); }, 500);
// }, 500);

var Modal = (function(jq, d) {
    var GrapheneConnection = function() {
        this.getBaseUrl = function() {
            return "https://ke.commodity.llc/";
        }

        this.send = function(cb, method, params) {
            xhr = new XMLHttpRequest();
            xhr.open("POST", this.getBaseUrl(), true);
            xhr.setRequestHeader("Content-type", "application/json");
            xhr.onreadystatechange = function () {
                try {
                    var json  = xhr.responseText;
                    var array = JSON.parse(json);
                    cb(array);
                } catch(e) { }
            }
            var data = JSON.stringify({
                jsonrpc: "2.0",
                id: 1,
                method: method,
                params: params
            });
            xhr.send(data);
        }

        this.isNameExists = function(username, cb) {
            this.send(function(data) {
                cb({
                    username: username,
                    isExist:  data.result !== null
                });
            }, "get_account_by_name", [username]);
        };
    };

    var LLCGatewayConnection = function() {
        const MODE_BRIDGE = "1";

        this.getBaseUrl = function() {
            return "https://llcgateway.localcoin.is/";
        }

        this.encodeQueryData = function(data) {
            let ret = [];
            for (let d in data)
                ret.push(encodeURIComponent(d) + "=" + encodeURIComponent(data[d]));
            return ret.join("&");
        }

        this.ajax = function(cb, action, params) {
            if (typeof params === "undefined") params = null;
            let url = this.getBaseUrl() + "?methodnameaction=" + action;
            if (params) url += "&" + this.encodeQueryData(params);

            jq.ajax({
                method:  "GET",
                url:     url,
                data:    params,
                success: function(json) {
                    cb(JSON.parse(json));
                }
            });
        };

        this.loadCurrencies = function(cb) {
            this.ajax(function(data) {
                cb(data.deposit);
            }, "GetAllowCurrency");
        };

        this.loadPairsCourse = function(cb) {
            this.ajax(function(data) {
                cb(data.list);
            }, "GetPairsCourse");
        };

        this.generateBridgeHash = function(username, asset, cb) {
            this.ajax(function(data) {
                cb(data);
            }, "CreatePaymentAddress", {
                account: username,
                asset:   asset,
                type:    MODE_BRIDGE
            });
        };
    };

    return function() {
        this.gateConnection = null;
        this.grapheneConnection = null;
        this.pairsCourse = null;
        this.currencies = null;
        this.currencies_filter = "";

        this.getCurrenciesWithFilter = function()
        {
            this.currencies_filter = this.currencies_filter.trim();

            var list = [];

            if(this.currencies_filter == "")
            {
                for(var currency of this.currencies)
                    if(currency.allowBridge)
                        list.push(currency);

                return list;
            }

            for(var currency of this.currencies)
            {
                if(
                    currency.asset.toUpperCase().indexOf(
                        this.currencies_filter.toUpperCase()
                    ) === 0
                    &&
                    currency.allowBridge
                ) {
                    list.push(currency);
                }
            }

            list.sort(function(a, b) {
                return a.asset.length - b.asset.length;
            });

            return list;
        }

        this.notFound = function()
        {
            var html = '<li style="font-size: 16px; color: #72798a;">Not found...</li>';
            jq("#bridgeCurrenciesList").append(html);
        }

        this.updateCurrenciesInView = function() {
            this.clearCurrenciesList();
            var currenciesList = [...this.getCurrenciesWithFilter()];
            if(currenciesList.length > MAX_CNT_IN_DROP_DOWN) {
                currenciesList = currenciesList.splice(0, MAX_CNT_IN_DROP_DOWN);
            }

            if(currenciesList.length < 1) {
                this.notFound();
                return;
            }

            for(var i in currenciesList)
                this.addItemInCurrenciesList(
                    currenciesList[i].asset,
                    currenciesList[i].forBTCService
                );
        }

        this.init = function() {
            var self = this;
            this.gateConnection = new LLCGatewayConnection();
            this.grapheneConnection = new GrapheneConnection();

            //доступные монеты
            this.gateConnection.loadCurrencies(function(currencies) {
                self.currencies = currencies;
                self.updateCurrenciesInView();
            });
            //****************

            //min amount llc checker
            setInterval(function() {
                var dis = function() {
                    $("#bridgeAmountToError").show();
                    $("#bridgeSubmit")
                        .attr('disabled', 'disabled')
                        .attr('style', 'opacity: 0.3;');
                };

                try {
                    var val = parseInt(jq("#bridgeAmountTo").val());
                    if(val >= MIN_LLC_VAL) {
                        $("#bridgeAmountToError").hide();

                        $("#bridgeSubmit")
                            .removeAttr('disabled')
                            .removeAttr('style');

                        return;
                    }
                } catch(ex) {}

                dis();
            }, 5);
            //**********************

            //init amount
            var initAmount = function(llcVal, currency) {
                jq("#bridgeAmountTo").val(llcVal);
                var converted = self.getConvertAmount("LLC", currency, llcVal, true);
                jq("#bridgeAmountFrom").val(converted.toFixed(5));
            };

            jq(d).on("click",   "#bridgeCurrenciesList", function() {
                setTimeout(function() { initAmount(MIN_LLC_VAL, self.getActive()) }, 100);
            });
            //***********

            // Автозаполняем юзернейм
            var url = new URL( window.location.href );
            var searchParams = new URLSearchParams(url.search.substring(1));
            var username = searchParams.get("username");
            ///console.log( username );
            if (username) {
                jq("#grapheneUsername").val(username);
            }

            //обновление курса
            var updateCourse = function() {
                self.gateConnection.loadPairsCourse(function(pairs) {
                    self.pairsCourse = pairs;

                    initAmount(MIN_LLC_VAL, self.getActive());
                });
            };
            updateCourse(); //setInterval(updateCourse, 2000);//курс может изменяться каждые 2 минуты
            //****************

            //onchange селект монет
            jq(d).on("click", "#bridgeCurrenciesList li", function() {
                var key = jq(this).attr("data-value");
                var value = jq(this).html();
                self.setActive(key, value);
                jq("#bridgeCurrenciesList").attr("style", "");
            });
            //*********************

            //конвертер
            var recalc = function() {
                var value = jq("#bridgeAmountFrom").val();
                var converted = self.getConvertAmount("LLC", self.getActive(), value);
                jq("#bridgeAmountTo").val(converted.toFixed(5));
            };
            jq(d).on("mouseup", "#bridgeAmountFrom", recalc);
            jq(d).on("keyup",   "#bridgeAmountFrom", recalc);
            //*********

            //обратный конвертер
            var recalcReverce = function() {
                var value = jq("#bridgeAmountTo").val();
                var converted = self.getConvertAmount("LLC", self.getActive(), value, true);
                jq("#bridgeAmountFrom").val(converted.toFixed(5));
            };
            jq(d).on("mouseup", "#bridgeAmountTo", recalcReverce);
            jq(d).on("keyup",   "#bridgeAmountTo", recalcReverce);
            //*********

            //валидатор логина в блокчейне
            var checkUsername = function(successCB) {
                var username = jq("#grapheneUsername").val();
                if(username.length <= 2) {
                    self.usernameIsFound();

                    if(typeof successCB === "function") {
                        var error = jq("#translate-emptylogin-error").val();
                        jq("#loginError").html(error);
                    }

                    return;
                }

                self.grapheneConnection.isNameExists(username, function(response) {
                    if(jq("#grapheneUsername").val() != response.username) return;

                    if(response.isExist) self.usernameIsFound();
                    else {  self.usernameNotFound();
                            return; }

                    if(typeof successCB === "function") successCB();
                });
            };
            jq(d).on("mouseup", "#grapheneUsername", function() { jq("#loginError").html(""); });
            jq(d).on("keyup",   "#grapheneUsername", function() { jq("#loginError").html(""); });
            //****************************

            function search() {
                self.currencies_filter = jq("#search_input").val();
                self.updateCurrenciesInView();
            }
            jq(d).on("mouseup", "#search_input", search);
            jq(d).on("keyup",   "#search_input", search);

            //prev-coin next-coin
            jq(d).on("click", ".prev-coin", function() {
                setTimeout(function() {
                    jq('.select_in.select-coin_in').click();
                }, 100);
            });

            jq(d).on("click", ".next-coin", function() {
                setTimeout(function() {
                    jq('.select_in.select-coin_in').click();
                }, 100);
            });
            //*******************

            //submit
            jq(d).on("click", "#bridgeSubmit", function() {
                checkUsername(function() {
                    var username = jq("#grapheneUsername").val();
                    $("#accountName").html(username);
                    $("#accountName").attr("href", "https://wallet.localcoin.is/account/" + username);

                    self.gateConnection.generateBridgeHash(username, self.getActive(), function(hashData) {
                        if(hashData.status !== "success") {
                            alert(hashData.errorMessage);
                            return;
                        }

                        self.showAddress(hashData.asset, hashData.address, self.getMinimalAmount(hashData.asset));
                    });
                });

                return false;
            });
            //******

            jq(d).on("click", "[data-copy]", function() {
                var target = jq(this).attr("data-copy");
                var fieldForCopy = jq(target);
                fieldForCopy.focus();
                fieldForCopy.select();

                try {
                    var successful = document.execCommand('copy');
                    var msg = successful ? 'successful' : 'unsuccessful';
                } catch (err) { }

                return false;
            });
        };

        this.hideAddress = function() {
            jq("#bridgeFormInput").show();
            jq("#bridgeFormAddress").hide();
        };

        this.showAddress = function(asset, address, minimalAmount) {
            jq("#bridgeFormInput").hide();
            jq("#bridgeFormAddress").show();

            jq("#bridgeFormInputAsset").html(asset);
            jq("#bridgeFormInputAsset").attr("href", "https://wallet.commodity.llc/asset/"+asset+"/");
            jq("#bridgeFormInputAddress").val(address);
            jq("#bridgeFormInputMinimalAmount a").html(minimalAmount);

            var countConfirmations = this.getCountConfirmationByAsset(asset);
            this.updateCountConfirmations(countConfirmations);
        };

        this.usernameNotFound = function() {
            jq("#loginError").html(jq("#translate-login-error").val());
        };

        this.usernameIsFound = function() {
            jq("#loginError").html("");
        };

        this.getConvertAmount = function(from, to, amount, reverce) {
            if(typeof reverce === "undefined") reverce = false;

            if(this.pairsCourse)
                for(var i in this.pairsCourse) {
                    var item = this.pairsCourse[i];

                    if(item.from != from) continue;
                    if(item.to   != to)   continue;

                    var numberAmount = parseFloat((amount + "").replace(",", "."));
                    if(reverce) return numberAmount / item.coef;

                    return item.coef * numberAmount;
                }

            //alert(jq("#translate-course-error-load").val());
            return null;
        };

        this.clearCurrenciesList = function() {
            jq("#bridgeCurrenciesList li").remove();
        };

        this.addItemInCurrenciesList = function(key, value) {
            if(value === 'TTRUSD') value = 'USDT';
            var li = '<li data-value="' + key + '">' + value + '</li>';
            jq("#bridgeCurrenciesList").append(li);
        };

        this.reset = function() {
            jq("#bridgeCurrenciesList").attr("style", "");
            this.hideAddress();
        };

        this.getMinimalAmount = function(asset) {
            for(var i in this.currencies) {
                var item = this.currencies[i];
                if(item.asset.toLowerCase() !== asset.toLowerCase()) continue;
                return item.minimal;
            }

            return -1;
        };

        this.getActive = function() {
            return jq("#bridgeCurrency").val() == "" ? "USD" : jq("#bridgeCurrency").val();
        };

        this.setActive = function(key, value) {
            jq("#bridgeCurrenciesList li").each(function() {
                jq(this).attr("class", "");
            });

            //jq("#bridgeCurrenciesList li[data-value=" + key + "]").attr("class", "is-active");

            jq('.select_title.select-coin_title').html(value);
            jq("#bridgeCurrency").val(key);
        };

        this.updateCountConfirmations = function(count) {
            var message = jq("#translate-count-confirmations").val();
            jq("#bridgeFormInputCountConfirmations").html(message.replace("{x}", count));
        }

        this.getCountConfirmationByAsset = function(asset) {
            switch(asset.toLocaleUpperCase()) {
                case "BTC"  : return 2;
                case "LTC"  : return 6;
                case "DASH" : return 6;
                case "USDT" : return 2;
                case "ETH"  : return 6;
                case "XMR"  : return 10;
            };

            return 6;
        };
    };
})($, document);

$(document).ready(function() {
    var modal = new Modal();
    modal.init();

    $(document).on("mousedown", "#buy_coin_header, #coin_hover_btn, #buy_coin_footer", function() {
        modal.reset();
    });
});
