<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/10/24 0024
 * Time: 21:38
 */

namespace app\common\repository;
use app\common\BaseAR;
use app\common\train\error\ErrorCode;
use app\common\train\error\ErrorTrain;

class BaseRepository
{
    use ErrorTrain;

    /**
     * repository 统一的向entity中添加的方法
     * @param BaseAR $entity
     * @return BaseAR
     * @throws \Exception
     */
    public function add(BaseAR $entity)
    {
        try {
            return BaseAR::add($entity);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}