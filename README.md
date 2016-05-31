# RainbowPHP
RainbowPHP 是专门针对PHP7 LNMP环境下开发restful接口而创作的。亲测在实现同样代码逻辑的前提下，RainbowPHP的QPS为Lumen的三至五倍。

#RainbowPHP的构成
作者研究过CI Larvel等知名框架，结合各个框架的优点，整合多个优秀组件而成。
0.1版本的初步规划整个框架分为路由/MVC/Database/模板/日志这几部分。其中Database使用了Laravel的EloquentORM,这是目前作者觉得使用最趁手的ORM,目前版本只做了 Eloquent ORM 的简单集成；下个版本会对EloquentORM进行大幅优化以提升其性能，并引入PDO,适应中小型项目的需要。模板部分使用了symfony的twig模板，下个会增加对原生PHP模板的支持。路由、日志部分由作者自己编写,路由部分实现了简单的restful路由并可以单独引起用,单独引用请标注来源作者。

#RainbowPHP的用法



#RainbowPHP的来源
作者本人很喜欢CI框架的高效，但对于其组件很少，已经不能满足需要；Laravel/Lumen
框架自身开发速度很快，目前在世界范围内广发流行，但由于其系统庞大，导致其性能不高。作者本人在实际生产环境中使用Lumen开发一个大型项目，QPS始终未能达到50.故而有了自己创作一个高性能restful开发框架的想法，这个框架目前花费了我半个月的业余时间。有不足之处，希望大家不吝赐教，作者将长期维护这一项目。

#联系方式
PS如果有人对这一框架感兴趣，请联系作者 iris-xie  QQ 443833189 Gmail siqimochi0@gmail.com   RainbowPHP的git地址https://github.com/iris-xie/RainbowPHP.git
