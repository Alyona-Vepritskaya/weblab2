<?php
$path = "http://k503labs.ukrdomen.com/535a/Veprytskaya/images/";
$products = array();
$items = array();
$item = array();
$item_params = array();
function parseData()
{
    $parser = xml_parser_create();
    xml_set_element_handler($parser, "start", "stop");
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_set_character_data_handler($parser, "data");
    $file = fopen("products.xml", "r");
    while ($data = fread($file, 4000)) {
        if (!xml_parse($parser, $data, feof($file))) {
            die ("Error: " . xml_error_string(xml_get_error_code($parser)) . "\n Line :" . xml_get_current_line_number($parser));
        }
    }
    xml_parser_free($parser);
}

function start($parser, $name, $attribs)
{
    global $item, $itemsType, $items,$item_params, $single_param;;
    switch ($name) {
        case "ITEM":
            $item = array();
            $item['ID'] = $attribs["S_NUM"];
            break;
        case "ITEMS":
            $items = array();
            $itemsType = $attribs["TYPE"];
            break;
        case "PARAMS":
            $item_params = array();
            break;
        case "PARAM":
            $single_param = array();
            break;
        default:
            break;
    }
}

function stop($parser, $element_name)
{
    global $item, $items, $currentData, $itemsType, $products,$item_params,$single_param;
    if ($element_name != "ITEM"  && $element_name != "PRODUCTS" && $element_name != "ITEMS" && $element_name !="PARAMS"
        && $element_name !="PARAM" && $element_name !="PARAM_NAME" && $element_name !="PARAM_VALUE") {
        $item[$element_name] = $currentData;
    }
    if ($element_name == "ITEM") {
        $items[] = $item;
    }
    if ($element_name == "ITEMS") {
        $products[$itemsType] = $items;
    }
    if($element_name == "PARAMS"){
        $item['PARAMS'] = $item_params;
    }
    if($element_name == "PARAM"){
        $item_params[] = $single_param;
    }
    if($element_name == "PARAM_NAME"){
        $single_param['name'] = $currentData;
    }
    if($element_name == "PARAM_VALUE"){
        $single_param['value'] = $currentData;
    }
}

function data($parser, $data)
{
    global $currentData;
    $currentData = $data;
}