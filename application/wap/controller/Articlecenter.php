<?php
/**
 * Helpcenter.php
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2015-2025 山西牛酷信息科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: https://www.51jiyan.com/
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用。
 * 任何企业和个人不允许对程序代码以任何形式任何目的再发布。
 * =========================================================
 * @author : niuteam
 * @date : 2015.1.17
 * @version : v1.0.0.0
 */
namespace app\wap\controller;

use data\service\Article;
use data\service\Config;

/**
 * 帮助中心
 * 创建人：李志伟
 * 创建时间：2017年2月17日20:12:50
 */
class Articlecenter extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 首页
     */
    public function index()
    {
        $document_id = request()->post('id', '');
        $article = new Article();
        $platform_help_class = $article->getArticleClassQuery();
        $this->assign('platform_help_class', $platform_help_class["data"]); // 文章一级分类列表
        $this->assign("title_before","文章中心");
        return view($this->style . 'Articlecenter/index');
    }

    /**
     * 获取分类下文章列表
     */
    public function getArticleList()
    {
        $class_id = request()->post('class_id', '0');
        $page = request()->post("page",1);
        $condition = array();
        if($class_id != 0){
            $condition['nca.class_id'] = $class_id;
        }
        $article = new Article();
        $article_list = $article->getArticleList($page, PAGESIZE, $condition, 'nca.sort desc');
        return $article_list;
    }

    /**
     * 文章内容
     */
    public function articleContent()
    {
        $article_id = request()->get('article_id', '');
        $article = new Article();
        $article_info = $article->getArticleDetail($article_id);
        if (empty($article_info)) {
            $this->error("未获取到文章信息");
        }
        if (!request()->isMobile()) {
            $redirect = __URL(__URL__ . "/cms/articleclassinfo?article_id=".$article_id."&class_id=1");
            $this->redirect($redirect);
            exit();
        }
        
        $article -> updateArticleClickNum($article_id);
        
        $this->assign("title_before",$article_info['title']);
        $this->assign('article_info', $article_info);
  
        // 上一篇
        $prev_info = $article->getArticleList(1, 1, [
            "article_id" => array(
                "<",
                $article_id
            ),
            "nca.class_id" => $article_info["class_id"],
            "status" => 2
        ], "article_id desc");
        $this->assign("prev_info", $prev_info['data'][0]);

        // 下一篇
        $next_info = $article->getArticleList(1, 1, [
            "article_id" => array(
                ">",
                $article_id
            ),
            "nca.class_id" => $article_info["class_id"],
            "status" => 2
        ], "article_id asc");
        $this->assign("next_info", $next_info['data'][0]);
        
        $ticket = $this->getShareTicket();
        $this->assign("signPackage", $ticket);
        $Config = new Config();
        $seoconfig = $Config->getSeoConfig($this->instance_id);

        if (!empty($article_info['keyword'])) {
            $seoconfig['seo_meta'] = $article_info['keyword']; // 关键词
        }
        if (!empty($article_info['summary'])) {
            $seoconfig['seo_desc'] = $article_info['summary'];
        }
        $this->assign("seoconfig", $seoconfig);
        
        return view($this->style . 'Articlecenter/articleContent');
    }
    
    public function articleList(){
        $class_id = request()->get('class_id', '');
        $this->assign("class_id", $class_id);
        return view($this->style."Articlecenter/articleList");
    }
}