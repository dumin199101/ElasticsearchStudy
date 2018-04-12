<?php

#该常量是在PHP5.6版本之后才引出来的
if(!defined('JSON_PRESERVE_ZERO_FRACTION'))
{
    define('JSON_PRESERVE_ZERO_FRACTION', 1024);
}

function showbug($msg){
    echo '<pre>';
    var_dump($msg);
    echo '</pre>';
}

require 'vendor/autoload.php';

use Elasticsearch\ClientBuilder;

# 导入Elasticsearch类库
$hosts = [
    '192.168.226.1:9200',         // IP + Port
    /*'192.168.1.2',              // Just IP
    'mydomain.server.com:9201', // Domain + Port
    'mydomain2.server.com',     // Just Domain
    'https://localhost',        // SSL to localhost
    'https://192.168.1.3:9200'  // SSL to IP + Port*/
];
$client = ClientBuilder::create()           // Instantiate a new ClientBuilder
->setHosts($hosts)      // Set the hosts
->build();              // Build the client object

# 1.创建索引（库）
/*$params = [
    'index' => 'es_book',
    'body' => [
        'settings' => [
            'number_of_shards' => 4,
            'number_of_replicas' => 0
        ]
    ]
];
$response = $client->indices()->create($params);
print_r($response);*/

# 2.删除索引（库）
/*$deleteParams = [
    'index' => 'es_book'
];
$response = $client->indices()->delete($deleteParams);
print_r($response);*/



# 3.索引文档（添加记录）
/*$params = [
    'index' => 'es_book',
    'type' => 'book_list',
    'id' => '7',
    'body' => [
        'bookName' => '红楼梦',
        'price'=>100.00,
        'browse_count'=>400,
        'bookDesc'=>'中国四大名著之一，贾宝玉与林黛玉的悲情故事！'
    ]
];

$response = $client->index($params);
print_r($response);*/


# 4.获取索引文档（get 记录）
/*$params = [
    'index' => 'es_book',
    'type' => 'book_list',
    'id' => '1'
];

$response = $client->get($params);
print_r($response);*/


# 5.搜索文档（search 记录）
/*$params = [
    'index' => 'es_book',
    'type' => 'book_list',
    'body' => [
        'query' => [
            'match' => [
                'bookName' => 'Hello World'
            ]
        ]
    ]
];

$response = $client->search($params);
print_r($response);*/

# 6.删除文档（delete 记录）
/*$params = [
    'index' => 'es_book',
    'type' => 'book_list',
    'id' => '1'
];

$response = $client->delete($params);
print_r($response);*/


# 分页查询
/*$params = [
    'index' => 'es_book',
    'type' => 'book_list',
    'body' => [
        'query' => [
            'match' => [
                'bookDesc' => '中国'
            ]
        ]
    ],
    'size'=>5,
    'from'=>0
];

$response = $client->search($params);
showbug($response);*/



/*相当于sql语句：
select * from book_list where bookDesc='中国'
limit 0,5;*/


# bool查询：并且

/*$params = [
    'index' => 'es_book',
    'type' => 'book_list',
    'body' => [
        'query' => [
            'bool' => [
                'must'=>[
                    ['match'=>['price'=>300]],
                    ['match'=>['bookDesc'=>'四大名著']]
                ]
            ]
        ]
    ],
    'size'=>5,
    'from'=>0
];

$response = $client->search($params);
showbug($response);*/


/*     相当于sql语句：
     select * from book_list where bookDesc='四大名著'
and price = 300 limit 0,5;  */


# bool查询：或者
/*$params = [
    'index' => 'es_book',
    'type' => 'book_list',
    'body' => [
        'query' => [
            'bool' => [
                'should'=>[
                    ['match'=>['price'=>100]],
                    ['match'=>['bookDesc'=>'四大名著']]
                ]
            ]
        ]
    ],
    'size'=>5,
    'from'=>0
];

$response = $client->search($params);
showbug($response);*/


/*  当于sql语句：
  select * from book_list where price=100
or bookDesc = '四大名著' limit 0,5;  */


# bool查询：不含
/*$params = [
    'index' => 'es_book',
    'type' => 'book_list',
    'body' => [
        'query' => [
            'bool' => [
                'must_not'=>[
                    ['match'=>['price'=>100]],
                    ['match'=>['bookDesc'=>'四大名著']]
                ]
            ]
        ]
    ],
    'size'=>5,
    'from'=>0
];

$response = $client->search($params);
showbug($response);*/


/*    相当于sql语句：
     select * from book_list where price!='fcd5d900beca'
and bookDesc != '四大名著' limit 200,10;  */


# 范围查询：
/*$index['index'] = 'log'; //索引名称
$index['type'] = 'ems_run_log'; //类型名称
$index['body']['query']['range'] = array(
    'id' => array('gte' => 20, 'lt' => 30)
);
$index['size'] = 10;
$index['from'] = 200;
$elastic->search($index);*/


$params = [
    'index' => 'es_book',
    'type' => 'book_list',
    'body' => [
        'query' => [
            'range' => [
                'browse_count' => ['gte'=>300,'lt'=>2000]
            ]
        ]
    ],
    'size'=>5,
    'from'=>0
];

$response = $client->search($params);
showbug($response);

/*      相当于sql语句：
       select * from book_list where browse_count>=300
and browse_count<2000  limit 0,5;  */




echo "Completed...";