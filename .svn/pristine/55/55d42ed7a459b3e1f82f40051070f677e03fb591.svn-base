<?php
if (!defined('IS_INITPHP')) exit('Access Denied!');   
/**
 * 生成树状结构
 */
class treeInit {
    public $arr = array();
    public $icon = array('┇&nbsp;','├&nbsp;','└&nbsp;');
    private $result_array = '';
    //计算树状结构的最深层，默认不允许超过5层结构，有效防止数据结构混乱造成无限循环
    private $deep = 1;
 
    /**
    * 注意，array的索引要和索引值id值相同
    * 例子：
    * array(
    *      1 => array('id'=>'1','parentid'=>0,'name'=>'一级栏目A'),
    *      2 => array('id'=>'2','parentid'=>0,'name'=>'一级栏目B'),
    *      3 => array('id'=>'3','parentid'=>1,'name'=>'二级栏目A'),
    *      4 => array('id'=>'4','parentid'=>1,'name'=>'二级栏目B'),
    *      5 => array('id'=>'5','parentid'=>2,'name'=>'二级栏目C'),
    *      6 => array('id'=>'6','parentid'=>3,'name'=>'三级栏目A'),
    *      7 => array('id'=>'7','parentid'=>3,'name'=>'三级栏目B')
    *      )
    */
    public function init($arr) {
		$this->arr = $arr;
		$this->result_array = '';
    }
 
    /**
    * 得到父级数组
    * @param int
    * @return array
    */
    public function get_parent($k_id) {
        $arrays = array();
        if(!isset($this->arr[$k_id])) return FALSE;
        $parentid = $this->arr[$k_id]['parentid'];
        $parentid = $this->arr[$parentid]['parentid'];
        if(is_array($this->arr)) {
            foreach($this->arr as $id => $a) {
                if($a['parentid'] == $parentid) $arrays[$id] = $a;
            }
        }
        return $arrays;
    }
 
    /**
    * 得到子级数组
    * @param int
    * @return array
    */
    public function get_child($k_id) {
        $arrays = array();
        if(is_array($this->arr)) {
            foreach($this->arr as $id => $a) {
                if($a['parentid'] == $k_id) $arrays[$id] = $a;
            }
        }
        $this->deep++;
        return $arrays ? $arrays : FALSE;
    }

    /**
    * 得到树型结构
    * @param int ID，表示获得这个ID下的所有子级
    * @param string 生成树型结构的基本代码，例如："<option value=\$id \$selected>\$spacer\$name</option>"
    * @param int 被选中的ID，比如在做树型下拉框的时候需要用到
    * @return string
    */
    public function create($k_id,$str,$sid=0,$adds='') {
        if($this->deep>5) {
            echo ('array structure error');
            exit;
        }
        $number=1;
        $child = $this->get_child($k_id);
        if(is_array($child)) {
        $total = count($child);
        foreach($child as $id=>$a) {
            $j = $k = '';
            if($number==$total){
                $j .= $this->icon[2];
            } else {
                $j .= $this->icon[1];
                $k = $adds ? $this->icon[0] : '';
            }
            $spacer = $adds ? $adds.$j : '';
            $selected = $id==$sid ? "selected" : '';
            @extract($a);
            eval("\$nstr = \"$str\";");
            $this->result_array .= $nstr;
            $this->create($id,$str,$sid,$adds.$k.'&nbsp;');
            $number++;
        }
        }
        $this->deep = 1;
        return $this->result_array;
    }
     /**
    * @param integer $myid 要查询的ID
    * @param string $str   第一种HTML代码方式
    * @param string $str2  第二种HTML代码方式
    * @param integer $sid  默认选中
    * @param integer $adds 前缀
    */
    public function get_tree_category($myid, $str, $str2, $sid = 0, $adds = ''){
        $number=1;
        $child = $this->get_child($myid);
        if(is_array($child)){
            $total = count($child);
            foreach($child as $id=>$a){
                $j=$k='';
                if($number==$total){
                    $j .= $this->icon[2];
                }else{
                    $j .= $this->icon[1];
                    $k = $adds ? $this->icon[0] : '';
                }
                $spacer = $adds ? $adds.$j : '';
                
                $selected = $this->have($sid,$id) ? 'selected' : '';
                @extract($a);
                if (empty($html_disabled)) {
                    eval("\$nstr = \"$str\";");
                } else {
                    eval("\$nstr = \"$str2\";");
                }
                $this->ret .= $nstr;
                $this->get_tree_category($id, $str, $str2, $sid, $adds.$k.'&nbsp;');
                $number++;
            }
        }
        return $this->ret;
    }
    /**
     * [get_treeview description]
     * @param  [type]  $catid        [description]
     * @param  string  $treeid       [description]
     * @param  string  $str          [description]
     * @param  string  $str2         [description]
     * @param  integer $showlevel    [description]
     * @param  integer $currentlevel [description]
     * @param  boolean $have_child   [description]
     * @return [type]                [description]
     */
    public function get_treeview($catid, $treeid = 'tree', $str = "<li><a href='javascript:w(\$catid);' onclick='o_p(\$catid,this)' class='i-t'>\$catname</a></li>", $str2 = "<li><a href='javascript:w(\$catid);' onclick='o_p(\$catid,this)' class='i-t'>\$catname</a>", $showlevel = 0, $currentlevel = 1, $have_child = FALSE) {
        $_child = $this->get_child($catid);


        if (!defined('EFFECTED_INIT')) {
            $effected = ' id="' . $treeid . '"';
            define('EFFECTED_INIT', 1);
        }
        else {
            $effected = '';
        }

        if (!$have_child) $this->str .= '<ul' . $effected . '>';

        foreach ($_child as $id => $a) {
            @extract($a);
            $this->str .= $have_child ? '<ul><li>' : '';
            $have_child = FALSE;

            if ($this->get_child($id)) {
                eval("\$nstr = \"$str2\";");
                $this->str .= $nstr;
                if ($showlevel == 0 || ($showlevel > 0 && $showlevel > $currentlevel)) {
                    $this->get_treeview($id, '', $str, $str2, $showlevel, $currentlevel + 1, TRUE);
                }
            }
            else {
                eval("\$nstr = \"$str\";");
                $this->str .= $nstr;
            }


            $this->str .= $have_child ? '</li></ul>' : '</li>';
        }

        if (!$have_child) $this->str .= '</ul>';
        return $this->str;
    }
/**
 * [have description]
 * @param  [type] $list [description]
 * @param  [type] $item [description]
 * @return [type]       [description]
 */
    private function have($list,$item){
        return(strpos(',,'.$list.',',','.$item.','));
    }
}
?>