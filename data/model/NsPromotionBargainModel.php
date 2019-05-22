<?php
/**
 * NewModel.php
 *
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2015-2025 山西牛酷信息科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: https://www.51buyan.com
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用。
 * 任何企业和个人不允许对程序代码以任何形式任何目的再发布。
 * =========================================================
 * @author : niuteam
 * @date : 2017.12.5
 * @version : v1.0.0.0
 */

namespace data\model;
use data\model\BaseModel as BaseModel;
/**
 * 砍价活动表
 */

class NsPromotionBargainModel extends BaseModel {

    protected $table = 'ns_promotion_bargain';
    protected $rule = [
        'bargain_id'  =>  '',
    ];
    protected $msg = [
        'bargain_id'  =>  '',
    ];
}