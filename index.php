<?php
/**
 */
define('IN_DOUCO', true);

// 强制在移动端中显示PC版
if (isset($_REQUEST['mobile'])) {
    setcookie('client', 'pc');
    if ($_COOKIE['client'] != 'pc') $_COOKIE['client'] = 'pc';
}

require (dirname(__FILE__) . '/include/init.php');

// 如果存在搜索词则转入搜索页面
if ($_REQUEST['s']) {
    if ($check->is_search_keyword($keyword = trim($_REQUEST['s']))) {
        require (ROOT_PATH . 'include/search.inc.php');
    } else {
        $dou->dou_msg($_LANG['search_keyword_wrong']);
    }
}

// 获取关于我们信息
$sql = "SELECT * FROM " . $dou->table('page') . " WHERE id = '1'";
$query = $dou->query($sql);
$about = $dou->fetch_array($query);

// 写入到index数组
$index['about_name'] = $about['page_name'];
$index['about_content'] = $about['description'] ? $about['description'] : $dou->dou_substr($about['content'], 300, false); // 这里的300数值不能设置得过大，否则会造成程序卡死
$index['about_link'] = $dou->rewrite_url('page', '1');
$index['cur'] = true;

// 城市获取
$sql1 = "SELECT *FROM".$dou->table('city')."where pid = '100000'";
$query1 = $dou->query($sql1);
while($row = $dou->fetch_array($query1)){
    $city[] = array( 
        'id' =>$row['id'],
        'name'=>$row['name']
       
    );
}
$smarty->assign('city',$city);


// 赋值给模板-meta和title信息
$smarty->assign('page_title', $dou->page_title());
$smarty->assign('keywords', $_CFG['site_keywords']);
$smarty->assign('description', $_CFG['site_description']);

// 赋值给模板-导航栏
$smarty->assign('nav_top_list', $dou->get_nav('top'));
$smarty->assign('nav_middle_list', $dou->get_nav('middle'));
$smarty->assign('nav_bottom_list', $dou->get_nav('bottom'));

// 赋值给模板-数据
$smarty->assign('show_list', $dou->get_show_list());
$smarty->assign('link', get_link_list());
$smarty->assign('index', $index);
$smarty->assign('recommend_product', $dou->get_list('product', 'ALL', $_DISPLAY['home_product'], 'sort DESC'));
$smarty->assign('recommend_article', $dou->get_list('article', 'ALL', $_DISPLAY['home_article'], 'sort DESC'));
$smarty->assign('case_list', $dou->get_list('case', 'ALL', $_DISPLAY['case'], 'sort DESC'));


$smarty->display('index.dwt');

/**
 * +----------------------------------------------------------
 * 获取友情链接
 * +----------------------------------------------------------
 */
function get_link_list() {
    $sql = "SELECT * FROM " . $GLOBALS['dou']->table('link') . " ORDER BY sort ASC, id ASC";
    $query = $GLOBALS['dou']->query($sql);
    while ($row = $GLOBALS['dou']->fetch_array($query)) {
        $link_list[] = array (
                "id" => $row['id'],
                "link_name" => $row['link_name'],
                "link_url" => $row['link_url'],
                "sort" => $row['sort'] 
        );
    }
    
    return $link_list;
}
?>