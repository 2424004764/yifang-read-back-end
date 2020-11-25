# 一些问题

## 是否可以合法使用书籍？

## 后端如何保存电子书信息呢？
    是将每个章节都保存为一条记录？
    书的章节内容可以保存到

## 需要同步客户端的内容
    1.当前阅读进度，精确到页，但每个设备的分辨率都不一样，所以不能是页的颗粒度，这个有待商榷
    2.我添加到书架的书


## 后续需要补充的点
    1.对书的评价
    2.书签
    3.笔记

只提供接口，后台（vue + element-ui）和前端（uniapp）独立。
打算等前端的阅读功能完善了，再动后台管理的东西
目前适配H5、app、微信小程序（主）。其它端暂时没有测试
万事开头难，现在准备使用以前未使用过的controller、service、repository、entity的架构，
对各种查询方法、数据库操作有点不知道放那一层了
controller用来调度service
service用来处理业务逻辑、调用repository
repository用来操作数据库
entity是表映射类文件

# yifang-read-back-end
阅读程序后端，使用 进程常驻的swoole + 高性能的yii2框架+ 关系型数据库MySQL5.7 + 正在学习 全文分布式检索引擎elasticsearch

2020年11月21日13:09:09   
现在已完成的功能：
* 前端传入的参数可进行单个效验，有错误就返回
* 基础的菜单、书籍列表、书籍详情、书籍章节、章节内容详情接口
* 基本的数据表   

分层设计：
* 控制层：Controller：负责调用Service
* 服务层：Service：负责处理业务逻辑
* 仓库层：Repository：负责对数据库操作
* 实体层：Entity：和表一一对应   
一个请求常规流程是：先到Controller层，Controller对传递的参数先进行效验，效验不通过则直接返回错误信息   
不往下执行，参数效验完后，调用对应的Service处理，Service在对数据做完处理后，再去调用相应Repository，Repository再去调用相应的Entity的操作数据库的方法   
所有的对数据库的操作都放在Repository中统一管理，而我对每个Repository都继承了一个父Repository，这个父Repository实现了一个通过的查找数据的方法，这样就不必再每个子Repository中写一遍获取Item的方法了   
相应的基础的Controller、Service、Entity都有一个自己的父类，在父类中实现了一些基础方法   
比如在基础的Controller中，就实现了通用的向前端返回json数据的方法   
在上文中有讲到在Controller层中对参数进行效验，效验的方法是对现有的效验类DynamicModel类的扩展   
对每个单个字段的效验方式，仅仅是配置上的小区别 可参看：\app\common\utilValidatorsForm

***   
2020年11月24日17:36:32   
需要接入单元测试   
***
2020年11月25日11:42:50   
开启php-fpm opcache   
请求时间由300ms降至40ms   
配置如下：   
   zend_extension="opcache.so"   
   opcache.memory_consumption=128   
   opcache.interned_strings_buffer=8   
   opcache.max_accelerated_files=4000   
   opcache.revalidate_freq=60   
   opcache.enable_cli=1   

配置文件php.ini 的1767行左右  
效果   可以看到 除了第一次请求115ms  后面的请求基本在30ms左右
![](http://cdn.fologde.com/Image10.png)    
![](http://cdn.fologde.com/Image11.png)

***
