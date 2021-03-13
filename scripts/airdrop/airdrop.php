<?
/*Simple script for mass-payment throught cli-wallet*/

/* Config */
$CSVname = 'airdrop-users.csv'; //user list for payments

// username => public key. you should import private key into cli-wallet application before using this script
$arWitnessess = [
    'username' => 'LLC7qwEQtfjGZgUqRX5CmjZwxo7Qr5CboaqqmowjWWEVHx7Vb8Xmo'
];
$walletPass = 'testpass'; // password to unlock cli-wallet
$start = microtime(true);


//Sends data to cli-wallet
function sendCurl(string $method, $arParams = [''], $ignoreErr = true) {

    $curl = curl_init("http://localhost:8091/"); // run cli-wallet at port 8091

    $data = [
        "jsonrpc" => "2.0", 
        "id" => 1, 
        "method" => $method,
        "params" => $arParams
    ];


    $data_json = json_encode($data); //paste data into json

    //PR($data_json);
    
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type'=>'application/json'));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

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

//gets account id by his name
function get_account_id($account_name){
    $arResult = sendCurl('get_account_id', [$account_name]);
    return $arResult;
}

//starts payments
function startAirdrop() {

    global $CSVname, $walletPass, $arWitnessess;

    //Get userlist from file, amount and memo
    if (isset($_SERVER['DOCUMENT_ROOT']) and !empty($_SERVER['DOCUMENT_ROOT'])){
        $dataCsv = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/airdrop//' . $CSVname);
    } else {
        $_SERVER['DOCUMENT_ROOT'] = getenv('MY_DOCUMENT_ROOT');
        $dataCsv = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/airdrop//' .$CSVname);
    }
    
    $arDataCsv = str_getcsv($dataCsv, "\n");
    foreach($arDataCsv as &$Row) $Row = str_getcsv($Row, ",");
    //foreach($arDataCsv as $value) $arUser[$value[0]] = $value[1];
    //PR($arUser);

    if (sendCurl('is_locked') == '1') { // Unlocks wallet
        sendCurl('unlock', [$walletPass]);
    }

    $arPrivkeys = sendCurl('dump_private_keys'); // Check private keys in your cli-wallet
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
    $i = 1;
    foreach($arDataCsv as $value) {
        $curl_data = [
            'localcoin-bounty',
            $value[0],
            $value[1],
            '1.3.0',
            $value[2],
            'false'
        ];
        sendCurl('transfer', $curl_data);
        usleep(50000); // timeout for each operation, if disable cli-wallet could crash
        PR($curl_data);
        echo $i++;
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

function logFile($textLog) {
    $file = '/logFile.txt';
    $text = '=======================\n';
    $text .= print_r($textLog);//Выводим переданную переменную
    $text .= '\n'. date('Y-m-d H:i:s') .'\n'; //Добавим актуальную дату после текста или дампа массива
    $fOpen = fopen($file,'a');
    fwrite($fOpen, $text);
    fclose($fOpen);
    }

echo 'Script was working: '.round(microtime(true) - $start, 4).' sec.';
?>