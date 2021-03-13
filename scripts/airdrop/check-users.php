<?
/*
+ Writing a function for connecting to CURL and sending POST requests in json format.
+ We write a function that accepts the name of the function and an array of parameters at the input, passes them into the array and outputs a ready-to-send json at the output. Returns an array in response.
+ We write a request for a fixer that returns an array of rates for all assets that they have for USD.
+ We take an array of smart assets from the file and form an array from them for publishing feeds
+ We enrich the array of smart assets by adding to each asset its rate to LLC in the ratio of 1 USD = 2 LLC and don't forget about precision (5 for core, 6 for smartassets)
- Create an array of public-keys of the witness

We take keys from cliwallet via dump_private_key and check with those that are already loaded into wallet. If some keys are missing, we display an error.
Create a loop to run the array of all smart assets with rates for each whitness added to the array. We bring to the front what was updated and from whom.

TODO
Hang up a script for crowns for every minute, check the end date of feeds in smartassets, and if the time is <1 hour, then run the update script.
Collect a simple interface
Write script logging to file
*/

//Конфиг
$CSVname = 'airdrop-users.csv';
$arWitnessess = [
    'localcoin-airdrop' => 'LLC51Qd8cXGxV12o6aHWdivPLst2VT23cnSr61wcov9qbR2KPy9nQ'                         
];
$walletPass = 'testpass';

function sendCurl(string $method, $arParams = [''], $ignoreErr = true) {

    $curl = curl_init("http://localhost:8091/"); //подключаемся к локальному кошельку

    $data = [
        "jsonrpc" => "2.0", 
        "id" => 1, 
        "method" => $method,
        "params" => $arParams
    ];


    $data_json = json_encode($data);//заворачиваем в json

    //PR($data_json);
    
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type'=>'application/json'));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);//шлём POST с инфой
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//забираем ответ в теле

    $result = curl_exec($curl);
    curl_close($curl);

    $arResult = json_decode($result, true);
    if (isset($arResult) and !empty($arResult)) {
        if (isset($arResult['error']['message']) and !empty($arResult['error']['message'])) {
            if ($ignoreErr != true) {
                die('Stopped with error: <b>' . $arResult['error']['message'] . '</b>');
            } else {
                //PR($arResult['error']['message']);
            }
        } else {
            return $arResult['result'];
            //PR($arResult);
        }
    } else {
        die('Lost connection to the CLI wallet');
    }
    //PR($arResult);
}

function get_account_id($account_name){
    $arResult = sendCurl('get_account_id', [$account_name]);
    return $arResult;
}

function startAirdrop() {

    global $CSVname, $walletPass, $arWitnessess;

    //Читаем файл айрдропа, получаем список юзеров и количество монет для айрдропа
    if (isset($_SERVER['DOCUMENT_ROOT']) and !empty($_SERVER['DOCUMENT_ROOT'])){
        $dataCsv = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts//' . $CSVname);
    } else {
        $_SERVER['DOCUMENT_ROOT'] = getenv('MY_DOCUMENT_ROOT');
        $dataCsv = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts//' .$CSVname);
    }
    
    $arDataCsv = str_getcsv($dataCsv, "\n");
    foreach($arDataCsv as &$Row) $Row = str_getcsv($Row, ",");
    //foreach($arDataCsv as $value) $arUser[$value[0]] = $value[1];
    //PR($arUser);

    if (sendCurl('is_locked') == '1') { // Не залочен ли
        sendCurl('unlock', [$walletPass]);
    }

    $arPrivkeys = sendCurl('dump_private_keys'); // Сверяем все ли ключи на месте
    foreach($arPrivkeys as $value) {
        $arPubkeys []= $value[0];
    }

    $i = 0;
    foreach ($arWitnessess as $value) {
        $check = array_key_exists($value, array_flip($arPubkeys));
        if (!$check) {
            die('Check your config, wallet doesn\'t have enought keys.');
        }
    }    

    foreach($arDataCsv as $value) {
        if(get_account_id($value[0]) == "") echo $value[0].'<br>';
//        sendCurl('transfer', $curl_data);
//        sleep(1);
//        PR($curl_data);
    }
    
}



startAirdrop();

//debug script
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

?>