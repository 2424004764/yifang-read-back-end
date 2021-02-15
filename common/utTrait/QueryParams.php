<?php
/**
 * 用来传递查询的结构化参数
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/11/3 0003
 * Time: 10:34
 */

namespace app\common\utTrait;


use yii\db\QueryTrait;

class QueryParams
{
    /** @var QueryTrait 查询用的trait 用来传递结构化参数 简单实用可参考\app\controllers\BookClassController::actionGetClass */
    use QueryTrait;

    /**
     * @var string 要查询的字段
     * 默认查询所有字段
     */
    public string $select = '';

    public function select($select)
    {
        $this->select = $select;
        return $this;
    }

    /**
     * @var int 页码
     */
    public int $page = 0;

    /**
     * @var int 每页数量
     */
    public int $size = 0;

    /**
     * 设置page参数
     * @param $page
     * @return $this
     */
    public function page($page){
        $this->page = $page;
        return $this;
    }

    /**
     * 设置size参数
     * @param $size
     * @return $this
     */
    public function size($size){
        $this->size = $size;
        return $this;
    }

    /**
     * 一次性加载 page、size 参数
     * @param $ps
     * @return $this
     */
    public function loadPageSize($ps)
    {
        if(isset($ps['page'])){
            $this->page = $ps['page'];
        }
        if(isset($ps['size'])){
            $this->size = $ps['size'];
        }

        return $this;
    }
}