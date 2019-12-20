<?php
$arrayProducts = array();

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
    //?
    xml_set_character_data_handler($parser, "data");
    $file = fopen("C:\\xampp\\htdocs\\xml\\products.xml", "r");
    while ($data = fread($file, 4096)) {
        if (xml_parse($parser, $data, feof($file))) {
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
 * @param $attribs - Tретий аргумент attribs содержит ассоциативный массив с атрибутами элемента (если есть).
 * Индексами этого массива будут имена атрибутов, а значения массива будут соответствовать значениям атрибутов.
 */
function start($parser, $name, $attribs)
{
    //switch
}

function stop($parser, $element_name)
{

}

function data($parser, $data)
{

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

            ?>
        </div>
    </div>
</div>