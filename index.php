<?php
// Добавояем новые теги в выгрузку фидов
//<outlets>
//<outlet id="1" instock="1"/>
//</outlets>

if (file_exists('export_goods.xml')) {
    $xml = simplexml_load_file('export_goods.xml');
    
//  print_r($xml->shop->offers->offer[0]->param);

    foreach ($xml->shop->offers->offer as $offer) {
        foreach($offer->param as $param){
            if ((string)$param->attributes() == "stock"){
                $offer->addChild('outlets', '');
                $offer->outlets->addChild('outlet', '');
                $offer->outlets->outlet->addAttribute('id', '1');
                $offer->outlets->outlet->addAttribute('instock', $param);
            }
        }
    }

    $new = fopen("export_goods_new.xml", "w"); // open new file
    fwrite($new, $xml->asXML()); //write XML to new file using asXML method
    fclose($new); // close the new file
    //echo $xml->asXML();
} else {
    exit('Не удалось открыть файл export_goods.xml');
}