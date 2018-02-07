<?php

namespace common\models\base;
/*
基础模型
*/

use yii\db\ActiveRecord;

class BaseModel extends ActiveRecord
{
	//创建完之后去修改其它model——AdminModel/UserModel等

    //获取分页数据的公共类
    /**
     * @param $query
     * @param int $curPage
     * @param int $pageSize
     * @param null $search
     * @return array
     */
    public function getPages($query, $curPage = 1, $pageSize = 10, $search = null)
    {
        if ($search){
            $query = $query -> andFilerWhere($search);
        }
        $data['count'] = $query ->count();
        if (!$data['count']){
            return['count'=>0,'curPage' => $curPage,'pageSize' => $pageSize,'start' =>0,'end' =>0,'data' =>[]
            ];
        }
        //选择页码不合法时，即超过当前页数时，不取curPage为当前页
        $curPage =  (ceil($data['count']/$pageSize) < $curPage)
                    ?ceil($data['count']/$pageSize):$curPage;

        //当前页
        $data['curPage'] = $curPage;
        //每页显示条数
        $data['pageSize'] = $pageSize;
        //起始页
        $data['start'] = ($curPage-1)*$pageSize + 1;
        //末页
        $data['end'] = (ceil($data['count']/$pageSize) == $curPage)?$data['count']:($curPage-1)*$pageSize +$pageSize;
        //返回数据
        $data['data'] = $query  -> offset(($curPage-1)*$pageSize)
                                    -> limit($pageSize)
                                    -> asArray()
                                    -> all();

        return $data;

    }

}