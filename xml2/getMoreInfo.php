<?php
function filter_input_($name, $default)
{
    $result = $default;
    if (isset($_POST[$name])) {
        $result = $_POST[$name];
    }
    if (isset($_GET[$name])) {
        $result = $_GET[$name];
    }
    return $result;
}

$q = filter_input_("item",'');
$flag = false;
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
    global $q, $flag;
    switch ($name) {
        case "ITEM":
            $flag = ($q == $attribs["S_NUM"]) ? true : false;
            break;
        default:
            break;
    }
}

function stop($parser, $element_name)
{
    global  $items, $currentData, $item_params, $single_param, $flag;
    if ($element_name == "ITEM") {
        $items = $item_params;
    }
    if ($element_name == "PARAM") {
        if ($flag)
            $item_params[] = $single_param;
    }
    if ($element_name == "PARAM_NAME") {
        if ($flag)
            $single_param['name'] = $currentData;
    }
    if ($element_name == "PARAM_VALUE") {
        if ($flag)
            $single_param['value'] = $currentData;
    }
}

function data($parser, $data)
{
    global $currentData;
    $currentData = $data;
}
parseData();
$myJSON = json_encode($items);
echo $myJSON;
