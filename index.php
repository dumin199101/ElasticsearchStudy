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


/*$params = [
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
showbug($response);*/

/*      相当于sql语句：
       select * from book_list where browse_count>=300
and browse_count<2000  limit 0,5;  */

// 查询高亮
/*$params = [
    'index' => 'songs_ik5',
    'type' => 'playlist',
    'body' => [
        'query' => [
            'match' => [
                'title' => '歌曲榜单'
            ]
        ],
        'highlight'=>[
            'pre_tags' =>[
                '<b style="color:red;">'
            ],
            'post_tags'=>[
                '</b>'
            ],
            'fields'=>[
                'title'=> new \stdClass()
            ]
        ]
    ],
    'size'=>100,
    'from'=>0
];

$response = $client->search($params);
showbug($response);*/

// 排序
/*$params = [
    'index' => 'songs_ik5',
    'type' => 'playlist',
    'body' => [
        'query' => [
            'match' => [
                'title' => '歌曲榜单'
            ]
        ],
        'highlight'=>[
            'pre_tags' =>[
                '<b style="color:red;">'
            ],
            'post_tags'=>[
                '</b>'
            ],
            'fields'=>[
                'title'=> new \stdClass()
            ]
        ],
        'sort'=>[
            'cnt'=>[
                'order'=>'desc'
            ]
        ]
    ],
    'size'=>100,
    'from'=>0
];

$response = $client->search($params);
showbug($response);*/


//筛选：filtered被弃用
/*$params = [
    'index' => 'songs_ik5',
    'type' => 'playlist',
    'body' => [
        'query' => [
            'bool' => [
                'filter'=>[
                    'match'=>['over'=>'N']
                ],
                'must'=>[
                    'match'=>['title'=>'歌曲榜单']
                ]
            ]
        ],
        'highlight'=>[
            'pre_tags' =>[
                '<b style="color:red;">'
            ],
            'post_tags'=>[
                '</b>'
            ],
            'fields'=>[
                'title'=> new \stdClass()
            ]
        ],
        'sort'=>[
            'cnt'=>[
                'order'=>'desc'
            ]
        ]
    ],
    'size'=>100,
    'from'=>0
];

$response = $client->search($params);
showbug($response);*/

//平均值、最值、求和、cardinality 求唯一值聚合统计
/*$params = [
    'index' => 'songs_ik5',
    'type' => 'playlist',
    'body' => [
        'query' => [
            'match' => [
                'title' => '歌曲榜单'
            ]
        ],
        'aggs'=>[
            'avg_cnt'=>[
                "avg"=>[
                    "field"=>"cnt"
                ]
            ],
            'sum_cnt'=>[
                "sum"=>[
                    "field"=>"cnt"
                ]
            ],
            'max_cnt'=>[
                "max"=>[
                    "field"=>"cnt"
                ]
            ],
            'min_cnt'=>[
                "min"=>[
                    "field"=>"cnt"
                ]
            ],
            'create_time_count'=>[
                "cardinality"=>[
                    "field"=>"create_time"
                ]
            ],
            'cnt_stats'=>[
                "stats"=>[
                    "field"=>"cnt"
                ]
            ],
        ]
    ]
];

$response = $client->search($params);
showbug($response);*/


//按照时间分组统计,使用terms聚合：
/*$params = [
    'index' => 'songs_ik5',
    'type' => 'playlist',
    'body' => [
        'query' => [
            'match' => [
                'title' => '歌曲榜单'
            ]
        ],
        'aggs'=>[
            'create_time_group_by'=>[
                'terms'=>[
                    'field'=>'create_time',
                    'size'=>20
                ]
            ]
        ]
    ],
    'size'=>20,
    'from'=>0
];

$response = $client->search($params);
showbug($response);*/

//区间聚合统计（把一个字段分区间统计）
/*$params = [
    'index' => 'songs_ik5',
    'type' => 'playlist',
    'body' => [
        'query' => [
            'match' => [
                'title' => '歌曲榜单'
            ]
        ],
        'aggs'=>[
            'cnt_range'=>[
                'range'=>[
                    'field'=>'cnt',
                    'ranges'=>[
                        ["to"=>10000],
                        ["from"=>10000,"to"=>100000],
                        ["from"=>100000,"to"=>300000],
                        ["from"=>300000,"to"=>500000],
                        ["from"=>500000]
                    ]
                ]
            ]
        ]
    ]
];

$response = $client->search($params);
showbug($response);*/


//日期范围聚合(过去10个月)
/*$params = [
    'index' => 'songs_ik5',
    'type' => 'playlist',
    'body' => [
        'aggs'=>[
            'range'=>[
                'date_range'=>[
                    'field'=>'create_time',
                    'format'=>"yyyy-MM-dd",
                    'ranges'=>[
                        ["to"=>"now-10M/M"],
                        ["from"=>"now-10M/M"]
                    ]
                ]
            ]
        ]
    ]
];

$response = $client->search($params);
showbug($response);*/


/*$params = [
    'index' => 'songs_ik5',
    'type' => 'playlist',
    'body' => [
        'aggs'=>[
            'create_time'=>[
                'date_histogram'=>[
                    'field'=>'create_time',
                    'format'=>"yyyy-MM-dd HH:mm:ss",
                    'interval'=>'minute'
                ]
            ]
        ]
    ]
];

$response = $client->search($params);
showbug($response);*/

// analyzer分词处理的match跟match_phrase,multi_match的区别
/**
 * match查询匹配就会进行分词:分为歌曲跟榜单所有包含这两个词中的一个或多个的文档就会被搜索出来
 * match_phrase查询：精确匹配所有同时包含两个词，经测试两个词必须是紧邻的短语，但有个可调节因子slop，相隔多远的意思是为了让查询和文档匹配你需要移动词条多少次
 * multi_match查询：如果我们希望两个字段进行匹配，其中一个字段有这个文档就满足
 */
/*$params = [
    'index' => 'songs_ik5',
    'type' => 'playlist',
    'body' => [
        'query' => [
            'match' => [
                'title' => '时空歌曲作者'
//                'title' => '冬日温暖'
            ]
        ],
        'highlight'=>[
            'pre_tags' =>[
                '<b style="color:red;">'
            ],
            'post_tags'=>[
                '</b>'
            ],
            'fields'=>[
                'title'=> new \stdClass()
            ]
        ]
    ],
    'size'=>100,
    'from'=>0
];

$response = $client->search($params);
showbug($response);*/

/*$params = [
    'index' => 'songs_ik5',
    'type' => 'playlist',
    'body' => [
        'query' => [
            'match_phrase' => [
                'title' => [
                    'query'=>'电影原声带',
                    'slop'=>3
                ]
            ]
        ],
        'highlight'=>[
            'pre_tags' =>[
                '<b style="color:red;">'
            ],
            'post_tags'=>[
                '</b>'
            ],
            'fields'=>[
                'title'=> new \stdClass()
            ]
        ]
    ],
    'size'=>100,
    'from'=>0
];

$response = $client->search($params);
showbug($response);*/

/*$params = [
    'index' => 'songs_ik5',
    'type' => 'playlist',
    'body' => [
        'query' => [
            'multi_match' => [
                'query'=>'曲风',
                'fields'=>[
                    'title','dsc'
                ]
            ]
        ],
        'highlight'=>[
            'pre_tags' =>[
                '<b style="color:red;">'
            ],
            'post_tags'=>[
                '</b>'
            ],
            'fields'=>[
                'title'=> new \stdClass(),
                'dsc'=>new \stdClass()
            ]
        ]
    ],
    'size'=>100,
    'from'=>0
];

$response = $client->search($params);
showbug($response);*/



//analyzer不分词处理的term、terms查询过滤
/**
 * 使用term要确定的是这个字段是否“被分析”(analyzed)，默认的字符串是被分析的
 * 经过ik分词器分词处理后，再对比关键词（一个整体：输入多个词的场景）发现关键词未在分词中的话就找不到。
 * 经过测试不建议使用term，使用match_phrase代替
 * terms可用于指定多个值进行过滤:类似于match中输入多个值自动分词
 */
/*$params = [
    'index' => 'songs_ik5',
    'type' => 'playlist',
    'body' => [
        'query' => [
            'term' => [
                'title' => '时空'
            ]
        ],
        'highlight'=>[
            'pre_tags' =>[
                '<b style="color:red;">'
            ],
            'post_tags'=>[
                '</b>'
            ],
            'fields'=>[
                'title'=> new \stdClass()
            ]
        ]
    ],
    'size'=>100,
    'from'=>0
];

$response = $client->search($params);
showbug($response);*/


/*$params = [
    'index' => 'songs_ik5',
    'type' => 'playlist',
    'body' => [
        'query' => [
            'terms' => [
                'title' => ['时空','歌曲','作者']
            ]
        ],
        'highlight'=>[
            'pre_tags' =>[
                '<b style="color:red;">'
            ],
            'post_tags'=>[
                '</b>'
            ],
            'fields'=>[
                'title'=> new \stdClass()
            ]
        ]
    ],
    'size'=>100,
    'from'=>0
];

$response = $client->search($params);
showbug($response);*/

//fuzzy模糊查询、前缀查询、通配符及正则表达式查询
/**
 * 模糊查询一般作为模糊建议使用
 * 经测试前缀、通配符、正则对中文无效
 */
/*$params = [
    'index' => 'songs_ik5',
    'type' => 'playlist',
    'body' => [
        'query' => [
            'fuzzy' => [
                'title'=>[
                    'value' => '时间',
                    'fuzziness'=>1, //编辑距离
                    'max_expansions'=>5, //返回最大的模糊数量
//                    'prefix_length'=>3 //不能被模糊的初识字符数
                ]
            ]
        ],
        'highlight'=>[
            'pre_tags' =>[
                '<b style="color:red;">'
            ],
            'post_tags'=>[
                '</b>'
            ],
            'fields'=>[
                'title'=> new \stdClass()
            ]
        ]
    ],
    'size'=>100,
    'from'=>0
];

$response = $client->search($params);
showbug($response);*/

/*$params = [
    'index' => 'songs_ik5',
    'type' => 'playlist',
    'body' => [
        'query' => [
            'regexp' => [
                 'title'=>'电影.*声带'
            ]
        ],
        'highlight'=>[
            'pre_tags' =>[
                '<b style="color:red;">'
            ],
            'post_tags'=>[
                '</b>'
            ],
            'fields'=>[
                'title'=> new \stdClass()
            ]
        ]
    ],
    'size'=>100,
    'from'=>0
];

$response = $client->search($params);
showbug($response);*/

/*$params = [
    'index' => 'songs_ik5',
    'type' => 'playlist',
    'body' => [
        'query' => [
            'wildcard' => [
                'title'=>'电影?声*'
            ]
        ],
        'highlight'=>[
            'pre_tags' =>[
                '<b style="color:red;">'
            ],
            'post_tags'=>[
                '</b>'
            ],
            'fields'=>[
                'title'=> new \stdClass()
            ]
        ]
    ],
    'size'=>100,
    'from'=>0
];

$response = $client->search($params);
showbug($response);*/

/*$params = [
    'index' => 'songs_ik5',
    'type' => 'playlist',
    'body' => [
        'query' => [
            'prefix' => [
                'title'=>'电影'
            ]
        ],
        'highlight'=>[
            'pre_tags' =>[
                '<b style="color:red;">'
            ],
            'post_tags'=>[
                '</b>'
            ],
            'fields'=>[
                'title'=> new \stdClass()
            ]
        ]
    ],
    'size'=>100,
    'from'=>0
];

$response = $client->search($params);
showbug($response);*/

echo "Completed...";
