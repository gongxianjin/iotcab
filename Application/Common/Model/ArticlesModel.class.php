<?php
namespace Common\Model;
use Think\Model;

/**
 * 咨询列表model操作
 * @author  victor
 */
class ArticlesModel extends Model {
    private $_db = '';

    public function __construct() {
        $this->_db = M('article');
    }
    public function select($data = array(), $limit = 100) {

        $conditions = $data;
        $list = $this->_db->where($conditions)->order('id desc')->limit($limit)->select();
        return $list;
    }
    public function insert($data = array()) {
        if(!is_array($data) || !$data) {
            return 0;
        }

        $data['create_time']  = time();
        $data['username'] =  getLoginUsername();
        return $this->_db->add($data);
    }
    public function getArticles($data,$page,$pageSize=10) {
        $conditions = $data;
        if(isset($data['title']) && $data['title']) {
            $conditions['title'] = array('like','%'.$data['title'].'%');
        }
        if(isset($data['catid']) && $data['catid'])  {
            $conditions['catid'] = intval($data['catid']);
        }
        $conditions['status'] = array('neq',-1);

        $offset = ($page - 1) * $pageSize;
        $list = $this->_db->where($conditions)
            ->order('listorder desc ,news_id desc')
            ->limit($offset,$pageSize)
            ->select();

        return $list;

    }


    public function getArticlesCount($data = array()){
        $conditions = $data;
        if(isset($data['title']) && $data['title']) {
            $conditions['title'] = array('like','%'.$data['title'].'%');
        }
        if(isset($data['catid']) && $data['catid'])  {
            $conditions['catid'] = intval($data['catid']);
        }
        $conditions['status'] = array('neq',-1);

        return $this->_db->where($conditions)->count();
    }

    public function find($id) {
        $data = $this->_db->where('id='.$id)->find();
        return $data;
    }

    public function updateById($id, $data) {
        if(!$id || !is_numeric($id) ) {
            throw_exception("ID不合法");
        }
        if(!$data || !is_array($data)) {
            throw_exception('更新数据不合法');
        }

        return $this->_db->where('id='.$id)->save($data);
    }

    public function updateStatusById($id, $status) {
        if(!is_numeric($status)) {
            throw_exception('status不能为非数字');
        }
        if(!$id || !is_numeric($id)) {
            throw_exception('id不合法');
        }
        $data['status'] = $status;

        return $this->_db->where('id='.$id)->save($data);
    }

    public function updateNewsListorderById($id, $listorder) {
        if(!$id || !is_numeric($id)) {
            throw_exception('ID不合法');
        }
        $data = array('listorder'=>intval($listorder));
        return $this->_db->where('id='.$id)->save($data);
    }
    public function getArticlesByArticlesIdIn($Ids) {
        if(!is_array($Ids)) {
            throw_exception("参数不合法");
        }

        $data = array(

            'id' => array('in',implode(',', $Ids)),
        );

        return $this->_db->where($data)->select();
    }

    /**
     * 获取排行的数据
     * @param array $data
     * @param int $limit
     * @return array
     */
    public function getRank($data = array(), $limit = 100) {
        $list = $this->_db->where($data)->order('count desc,id desc ')->limit($limit)->select();
        return $list;
    }

    public function updateCount($id, $count) {
        if(!$id || !is_numeric($id)) {
            throw_exception("ID 不合法");

        }
        if(!is_numeric($count)) {
            throw_exception("count不能为非数字");
        }

        $data['count'] = $count;
        return $this->_db->where('id='.$id)->save($data);

    }

    public function maxcount() {
        $data = array(
            'status' => 1,
        );
        return $this->_db->where($data)->order('count desc')->limit(1)->find();
    }


}
