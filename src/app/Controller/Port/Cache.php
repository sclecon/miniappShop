<?php

namespace App\Controller\Port;

use App\Annotation\Validator;
use App\Cache\Clear\ClearCache;
use App\Cache\Rules\CategoryCache;
use App\Cache\Rules\CollectCache;
use App\Cache\Rules\TagCache;
use App\Controller\BaseSupport\BaseSupportController;
use App\Middleware\User\AuthenticationMiddleware;
use App\Annotation\ApiRouter;

/**
 * @ApiRouter(router="port/cache", method="get", intro="缓存管理", middleware={AuthenticationMiddleware::class})
 */
class Cache extends BaseSupportController
{
    /**
     * @ApiRouter(router="clear", method="put", intro="清空缓存")
     * @Validator(attribute="key", required=false, rule="string", intro="缓存key，默认为空")
     */
    public function clear(){
        $user_id = (int) $this->request->getAttribute('user_id');
        $cacheKey = '';
        $keys = ['tag', 'collect', 'category'];
        $key = $this->request->input('key');
        if ($key && in_array($key, $keys) === false){
            return $this->error('没有找到相关的缓存数据');
        }
        if ($key === 'tag'){
            $cacheKey = TagCache::instance()->getAllTagCache();
        } else if ($key === 'collect'){
            $cacheKey = CollectCache::instance()->getMenuListCache($user_id);
        } else if ($key === 'category'){
            $cacheKey = CategoryCache::instance()->getAllKey();
        }
        ClearCache::instance()->clear($cacheKey);
        return $this->success('清除缓存成功');
    }
}