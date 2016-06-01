#RainbowPHP简介
RainbowPHP 是专门针对PHP7 LNMP环境下开发restful接口而创作的。亲测在实现同样代码逻辑的前提下，RainbowPHP的QPS为Lumen的三至五倍。目前，在生产环境中，单次响应系统所用耗时被控制在了80ms以内。

#RainbowPHP的构成
作者研究过CI Laravel symfony等知名框架，结合各个框架的优点，整合多个优秀组件而成。
0.1版本的初步规划整个框架分为路由/MVC/Database/模板/日志/Cors这几部分。其中Database使用了Laravel的EloquentORM,这是目前作者觉得使用最趁手的ORM,目前版本只做了 Eloquent ORM的简单集成；下个版本会对EloquentORM进行大幅优化以提升其性能，并引入PDO,适应中小型项目的需要。模板部分使用了symfony的twig模板；下个版本会增加对原生PHP模板的支持。响应类采用了symfony的HTTP基础类库，未来会对这一类库大幅优化，提高性能。路由/日志/Cors部分由作者自己编写,路由部分实现了简单的restful路由并可以单独引起用,单独引用请标注来源及作者。
下个版本的内容：PDO集成，原生PHP模板集成，eventlistener事件模块开发,EloquentORM性能优化，HTTP基础类库性能优化，针对视频直播等的流文件传输类库开发。

#RainbowPHP的用法
RainbowPHP的目录分为四部分，app/public/storage/vendor目录，下面逐一介绍：
--注意，RainbowPHP遵守psr-4规范，目录结构与命名空间保持一致，所以在此规定，所有需要composer自动加载的类库，其命名空间/目录/类名均采用大驼峰命名法，即首字母大写，多词组成词每个词首字母也大写；方法名小驼峰命名法，即首字母小写，多词组成词每第二个以后的每个词首字母也大写；控制器名称后加Controller,用以标注其与普通类的区别；方法名不添加默认后缀。
##app目录
app目录是这个网站的主目录，是我们配置文件，程序代码，中间件，未来程序中自定义的service，都在这一目录中，理论上如果你写的是一个纯restful后端服务响应，只需将这一文件间拷贝走即可。
app目录目前有四个文件夹，分别是Config--配置文件所在目录，Middleware--中间件所在目录,Routes--路由坐在地址，Http--程序代码主目录，包含MVC主要功能的Controllers/Models/Views均在这个目录。不过需要注意的是，个人并不推荐将模板需要引入的外部文件放入app\Http\Views目录中，而是应当放入public目录中，即与index.php处在同一目录。当然程序员可以根据自身需求扩展这一目录结构，譬如在app目录下增加Services目录 用于放置常用单独功能组件。
##public目录
public目录中index.php是该框架的单一入口文件，.htaccess文件为apache服务器定义了重写规则，resources目录是该框架默认方式模板引用的外部文件所在，程序要可以根据自己的需要自由放置。
##




#RainbowPHP的来源
作者本人很喜欢CI框架的高效，但CI组件很少，其使用的PHP版本过于落后，已经不能满足需要；CI3作者并未结果过，并不好评价。Laravel/Lumen
框架自身开发速度很快，目前在世界范围内广发流行，但由于其系统庞大，导致其性能不高；作者本人很敬佩symofny框架的作者，在此向大神致敬，他将java的spring框架的思想带入了PHP世界，使PHP也有了自己的企业级框架，但我个人认为PHP的优势就在于他的专注于WEB开发，强行让PHP做他不擅长的事并不是一个非常好的思路，当然symfony框架本身非常优秀，对于响应速度要求不高的企业用户我个人还是非常推荐的。之所以想创作这样一个高性能的RESTFUL框架，是因为作者本人在实际生产环境中使用Lumen开发一个大型项目，无论如何优化，QPS始终未能达到50左右，还因为这件事让无辜的架构师背锅，内心非常过意不去，故而有了自己创作一个高性能restful开发框架的想法。这个框架目前花费了我半个月的业余时间，目前仍是Beta版本，有不足之处，希望大家不吝赐教。作者将长期维护这一项目，如有志同道合的PHPer想和我一起开发这一项目，联系方式如下。

#联系方式
PS如果有人对这一框架感兴趣，请联系作者 iris-xie  QQ 443833189 Gmail siqimochi0@gmail.com     RainbowPHP的git地址https://github.com/iris-xie/RainbowPHP.git
