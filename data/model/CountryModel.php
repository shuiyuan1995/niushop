<?php
/**
 * Created by PhpStorm.
 * User: whisper
 * Date: 2019/4/26
 * Time: 10:07
 */

namespace data\model;

use data\model\BaseModel as BaseModel;

class CountryModel extends BaseModel
{
    protected $table = 'sys_country';

    protected $pk = 'id';
}