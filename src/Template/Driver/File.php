<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

    namespace Think\Template\Driver;

    use Think\Exception;

    class File
    {
        /**
         * 写入编译缓存
         * @string $cacheFile 缓存的文件名
         * @string $content 缓存的内容
         *
         * @return void|array
         */
        public function write($cacheFile, $content)
        {
            // 检测模板目录
            $dir = dirname($cacheFile);
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            // 生成模板缓存文件
            if (false === file_put_contents($cacheFile, $content)) {
                throw new Exception('cache write error :' . $cacheFile, 11602);
            }
        }

        /**
         * 读取编译编译
         * @string $cacheFile 缓存的文件名
         * @array $vars 变量数组
         *
         * @return void
         */
        public function read($cacheFile, $vars = [])
        {
            if (!empty($vars) && is_array($vars)) {
                // 模板阵列变量分解成为独立变量
                extract($vars, EXTR_OVERWRITE);
            }
            //载入模版缓存文件
            include $cacheFile;
        }

        /**
         * 检查编译缓存是否有效
         * @array $templates 用到的模板文件及更新时间列表
         * @string $cacheFile 缓存的文件名
         * @int $cacheTime 缓存时间
         *
         * @return boolean
         */
        public function check($cacheFile, $cacheTime)
        {
            if (0 != $cacheTime && time() > filemtime($cacheFile) + $cacheTime) {
                // 缓存是否在有效期
                return false;
            }
            return true;
        }
    }
