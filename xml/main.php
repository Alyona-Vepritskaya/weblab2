<?php
$path = "../images/";
$products = array();
$items = array();
$item = array();
$item_p = array();
function parseData()
{
    /**
     * xml_parser_create() создает новый XML-анализатор
     */
    $parser = xml_parser_create();
    /**
     * xml_set_element_handler — Установка обработчика начального и конечного элементов
     * start_element_handler и end_element_handler - строки, содержащие имена функций,
     * которые должны быть определены на момент вызова функции xml_parse() из анализатора parser.
     */
    xml_set_element_handler($parser, "start", "stop");
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_set_character_data_handler($parser, "data");
    $file = fopen("products.xml", "r");
    while ($data = fread($file, 4000)) {
        if (!xml_parse($parser, $data, feof($file))) {
            //die — Эквивалент функции exit  - exit ([ string $status ] ) : void
            //xml_error_string — Получение строки ошибки XML-анализатора
            //xml_get_error_code — Получает код ошибки XML-анализатора
            //xml_get_current_line_number — Получает от XML-анализатора номер текущей строки
            die ("Error: " . xml_error_string(xml_get_error_code($parser)) . "\n Line :" . xml_get_current_line_number($parser));
        }
    }
    xml_parser_free($parser);
}

/**
 * @param $parser
 * @param $name - Второй аргумент name содержит имя элемента(тега), для которого этот обработчик вызывается
 * @param $attribs - Третий аргумент attribs содержит ассоциативный массив с атрибутами элемента (если есть).
 * Индексами этого массива будут имена атрибутов, а значения массива будут соответствовать значениям атрибутов.
 */
function start($parser, $name, $attribs)
{
    global $item, $itemsType, $items,$item_p;
    switch ($name) {
        case "ITEM":
            $item = array();
            break;
        case "ITEMS":
            $items = array();
            $item['params'] = array();
            $itemsType = $attribs["TYPE"];
            break;
        case "SOME_PARAM":
            $item['params'][] = Array("name" => $attribs["NAME"], "value" => $attribs["VALUE"]);
            break;
        default:
            break;
    }
}

function stop($parser, $element_name)
{

    global $item, $items, $currentData, $itemsType, $products,$item_p;
    if ($element_name != "ITEM" && $element_name != "SOME_PARAM" && $element_name != "PRODUCTS" && $element_name != "ITEMS") {
        $item[$element_name] = $currentData;
    }
    if ($element_name == "ITEM") {
        $items[] = $item;
    }
    if ($element_name == "ITEMS") {
        $products[$itemsType] = $items;
    }
}

/**
 * @param $parser
 * @param $data - string in tag
 */
function data($parser, $data)
{
    global $currentData;
    $currentData = $data;
}

?>
<div class="right-col">
    <div class="news-info">
        <a href="">
            <div class="news">
                Товары
            </div>
        </a>
        <div class="date">
            30 февраля 1313
        </div>
    </div>
    <div class="text-content  clearfix">
        <div class="products">
            <?php
            parseData();
            foreach ($products as $itemsType => $items)
            { ?>
                <div class="item-name"><?=strtoupper($itemsType[0]).substr($itemsType, 1)?></div>
                <?php
                foreach ($items as $key => $item)
                { ?>
                    <div class="product">
                        <div class="item-name"><?=$item['NAME']?></div>
                        <img src="<?=$path.$item['IMAGE']?>" alt="img">
                        <div>Serial number: <?=$item['ID']?></div>
                        <div>Price: <?=$item['PRICE']?></div>
                        <div>Production date: <?=$item['PROD_YEAR']?></div>
                        <div>Production country: <?=$item['PROD_COUNTRY']?></div>
                        <?php
                        foreach ($item['params'] as $k => $v){
                            echo "<div>".$v['name'].": ".$v['value']."<br>"."</div>";
                        }
                        ?>
                        <input class="buy-item" type="submit" value="Buy now">
                    </div>
                <?php
                }
            }
            ?>
        </div>
    </div>
</div>
