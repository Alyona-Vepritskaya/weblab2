<?php
$products = array();
$items = array();
$item = array('ID'=>123456, 'NAME'=>'Xiaomi Mi 8 Pro','IMAGE'=>'../images/iphpro.jpg','PRICE'=>'67.89 $','PROD_YEAR'=>1977,'PROD_COUNTRY'=>'China');
$item['params'][] = Array("name" => 'Ram', "value" => 8);
$item['params'][] = Array("name" => 'Rom', "value" => 16);
$item['params'][] = Array("name" => 'Color', "value" => 'Blue');
$items[] = $item;
$products['computers']=$items;
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
            foreach ($products as $itemsType => $items)
            { ?>
              <!--  <div class="item-name"><?/*=strtoupper($itemsType[0]).substr($itemsType, 1)*/?></div>-->
                <?php
                foreach ($items as $key => $item)
                { ?>
                    <div class="product">
                        <img src="<?=$item['IMAGE']?>" alt="img">
                        <div class="description">
                            <div class="item-name"><?=$item['NAME']?></div>
                            <div>Serial number: <?=$item['ID']?></div>
                            <div class="price"><?=$item['PRICE']?></div>
                            <div>Production date: <?=$item['PROD_YEAR']?></div>
                            <div>Production country: <?=$item['PROD_COUNTRY']?></div>
                            <?php
                            foreach ($item['params'] as $k => $v){
                                echo "<div>".$v['name'].": ".$v['value']."<br>"."</div>";
                            }
                            ?>
                            <input class="buy-item" type="submit" value="ADD TO CART">
                        </div>
                    </div>
                <?php
                }
            }
            ?>
        </div>
    </div>
</div>
