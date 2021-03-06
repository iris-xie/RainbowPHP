#RainbowPHP Brief Introduction
Rainbow PHP is created specifically for the development of the restful interface under PHP7-LNMP environment.Pro-test the code in the context of achieving the same logic, QPS of RainbowPHP is three to five times against Lumen/Laravel.Currently, in a production environment, the response time to RainbowPHP system cosumed is controlled in less than 80ms.<br/><br/>
RainbowPHP 是专门针对PHP7 LNMP环境下开发restful接口而创作的。亲测在实现同样代码逻辑的前提下，RainbowPHP的QPS为Lumen的三至五倍。目前，在生产环境中，单次响应系统所用耗时被控制在了80ms以内。

#RainbowPHP Components
Author have studied the CI Laravel symfony other well-known framework, combined with the advantages of each frame, integrate multiple excellent components to this RainbowPHP framework.<br/><br/>
作者研究过CI Laravel symfony等知名框架，结合各个框架的优点，整合多个优秀组件写出了本框架。
##System Components
Preliminary Planning 0.1 version of the framework is divided into Routing / Database / template / log / Cors/ HTTP-foundation  these parts.Database part uses the Eloquent ORM of Laravel, which is currently the most conveniently ORM in my mind;  but the current version just finished the Eloquent ORM simple integration, The next version will be a substantial EloquentORM optimized to improve its performance, and introduce PDO, to meet the needs of small and medium projects.Templates part using symfony template twig, and the next version will add support for native PHP templates.HTTP-foundation class using the symfony HTTP-foundation class library, Author will greatly optimize the library to improve performance infuture.Routing / log / Cors are written  by the author himself, routing section achieves a simple and restful routing that can cause a separate, single quote, please indicate the source and author when you do.<br/><br/>
0.1版本的初步规划整个框架分为路由/MVC/Database/模板/日志/Cors/HTTP-foundation这几部分。其中Database使用了Laravel的EloquentORM,这是目前作者觉得使用最趁手的ORM;目前版本只做了EloquentORM的简单集成,下个版本会对EloquentORM进行大幅优化以提升其性能，并引入PDO,适应中小型项目的需要。模板部分使用了symfony的twig模板,下个版本会增加对原生PHP模板的支持。响应类采用了symfony的HTTP基础类库，未来会对这一类库大幅优化，提高性能。路由/日志/Cors部分由作者自己编写,路由部分实现了简单的restful路由并可以单独引起用,单独引用请标注来源及作者。<br/><br/>
##The Content in next version：
PDO integration, native PHP template integration, eventlistener event module development, EloquentORM performance optimization, HTTP HTTP-foundation class library performance optimization, file transfer class library development for video stream etc, route cache feature development.<br/><br/>
PDO集成，原生PHP模板集成，eventlistener事件模块开发,EloquentORM性能优化，HTTP基础类库性能优化，针对视频直播等的流文件传输类库开发,路由缓存功能开发。<br/><br/>

#RainbowPHP Usage
##Naming Conventions
Note, Rainbow PHP comply psr-4 specification, the directory structure is consistent with the namespace。So this provision, all need composer automatically loaded library, its namespace / directory / class names are used in upper camel case, that the first letter capitalized, multi-word word is also the first letter of each word capitalized;Method names are used in lower camel case, that is the first letter lowercase, each multi-word word word per second after the first letter also capitalized;The controller names must add Controller suffix, used to identify and distinguish its normal class; do not add the default method name suffixes.<br/><br/>
注意，RainbowPHP遵守psr-4规范，目录结构与命名空间保持一致。所以在此规定，所有需要composer自动加载的类库，其命名空间/目录/类名均采用大驼峰命名法，即首字母大写，多词组成词每个词首字母也大写；方法名小驼峰命名法，即首字母小写，多词组成词每第二个以后的每个词首字母也大写；控制器名称后加Controller,用以标注其与普通类的区别；方法名不添加默认后缀。<br/><br/>

Rainbow PHP directory is divided into four parts, app / public / storage / vendor directory, one by one the following description:<br/><br/>
RainbowPHP的目录分为四部分，app/public/storage/vendor目录，下面逐一介绍：<br/><br/>

##App Directory
app directory is the home directory of the site ，that our configuration files, codes, middlewares, future programs customized service, are in this directory.Theoretically, if you are writing a pure new restful backend service response, simply copy files from this directory.app directory currently has four folders, which are Config-- configuration file directory, Middleware-- Middleware directory, Routes-- routing directory, Http-- code home directory, in which the main functions Controllers MVC / Models / Views exist. But note that the author does not recommend an external file to templates should be introduced into the app \ Http \ Views directory, but should be placed in the public directory, that is in the same directory with index.php.Of course, programmers can extend this directory structure according to their needs, such as increasing the Services Directory for placing separate functional components commonly used in the app directory.<br/><br/>


app目录是这个网站的主目录，是我们配置文件，程序代码，中间件，未来程序中自定义的service，都在这一目录中。理论上如果你写的是一个纯restful后端服务响应，只需将这一文件间拷贝走即可。app目录目前有四个文件夹，分别是Config--配置文件所在目录，Middleware--中间件所在目录,Routes--路由所在目录，Http--程序代码主目录，包含MVC主要功能的Controllers/Models/Views均在这个目录。不过需要注意的是，个人并不推荐将模板需要引入的外部文件放入app\Http\Views目录中，而是应当放入public目录中，即与index.php处在同一目录。当然程序员可以根据自身需求扩展这一目录结构，譬如在app目录下增加Services目录，用于放置常用单独功能组件。
##Public Directory
In public directory index.php file is a single entry of the framework, .htaccess file defines rewrite rules for the apache server, resources directory is an default directory for external file of the template, which can be freely positioned according to programmer's needs.<br/><br/>
public目录中index.php是该框架的单一入口文件，.htaccess文件为apache服务器定义了重写规则，resources目录是该框架默认方式模板引用的外部文件所在，程序员要可以根据自己的需要自由放置。<br/><br/>
##Storage Directory
Storage directory is used to store temporary files / log file / directory and cache files. This directory can be deleted at any time to clear the cache, it will regenerate the directory in the system startup, please do not place code / resources and take a long time stored file in this directory .<br/><br/>
storage目录是框架用于储存临时文件/日志文件/及缓存文件的目录。这个目录可以随时删除来清除缓存，在系统启动的时候会重新生成这一目录，请不要将代码/以及需要长时间存放的资源放置与此目录。<br/><br/>
##Vendor Directory
vendor directory does not need to do any settings, its contents are automatically generated by composer, students familiar with composer can easily get started.PS, change the contents of the directory vendor is not a good habit, that wheel wheels, the transformation of the wheels will lose the original meaning of the use of the wheel, so  author hope not to change any code in vendor.Our framework is the core directory vendor / Rainbow PHP, if some students are interested in this framework source code, please read the detailed contents of this catalog.<br/><br/>
vendor目录并不需要做任何设置，它里面的内容由composer自动生成，熟悉composer的同学可以轻松上手。PS，更改vendor目录里的内容并不是一个良好的习惯，轮子就是轮子，改造轮子就丧失了原本使用轮子的意义，所以希望大家轻易不要改变vendor里的代码。我们的框架的核心目录是vendor/RainbowPHP,如果有些同学对本框架源码感兴趣，请详细阅读本目录中的内容。<br/><br/>

#Why do I Write RainbowPHP
Author like efficiency of CI framework, but CI modules are rare , PHP version too far behind its use, can not meet the my need; author didnot write by CI3, cannot give good evaluation.Laravel / Lumen is  a fast development framework, currently very popular in the world, but because of its large system, resulting in its efficiency performance is not high.I admire author of symfony framework, in tribute to this great God, he brought thought of java spring framework into the PHP world, so PHP also has its own enterprise-wide framework.But I personally think that PHP's advantage is that PHP focuse on WEB development, force PHP to do what PHP is not good at  is not a very good idea.Of course symfony framework itself is very good, to the response speed of less demanding business users I personally very recommend symfony framework.Direct cause that I wanted to create such a high-performance RESTFUL framework, is that I used Lumen to develop a large-scale project in the actual production environment, no matter how optimized, QPS had not been able to reach about 50, and therefore have a  idea of creating high-performance restful framework.This framework prototype currently spend half of my spare time, is still a Beta version, there are shortcomings, I hope the wing.On the long-term maintenance of this project, if like-minded PHPer and I want to develop this project together, contact the following.<br/><br/>
作者本人很喜欢CI框架的高效，但CI组件很少，其使用的PHP版本过于落后，已经不能满足需要；CI3作者并未接触过，并不好评价。Laravel/Lumen
框架自身开发速度很快，目前在世界范围内广发流行，但由于其系统庞大，导致其性能不高。作者本人很敬佩symofny框架的作者，在此向大神致敬，他将java的spring框架的思想带入了PHP世界，使PHP也有了自己的企业级框架。但我个人认为PHP的优势就在于他的专注于WEB开发，强行让PHP做他不擅长的事并不是一个非常好的思路。当然symfony框架本身非常优秀，对于响应速度要求不高的企业用户我个人还是非常推荐的。想创作这样一个高性能的RESTFUL框架的直接原因，是因为作者本人在实际生产环境中使用Lumen开发一个大型项目，无论如何优化，QPS始终未能达到50左右，故而有了自己创作一个高性能restful开发框架的想法。这个框架原型目前花费了我半个月的业余时间，目前仍是Beta版本，有不足之处，希望大家不吝赐教。作者将长期维护这一项目，如有志同道合的PHPer想和我一起开发这一项目，联系方式如下。<br/><br/>

#Contact information
PS If someone is interested in this frame, please contact the author iris-xie QQ 443833189 Gmail siqimochi0@gmail.com
RainbowPHP the git address https://github.com/iris-xie/RainbowPHP.git<br/><br/>
PS如果有人对这一框架感兴趣，请联系作者 iris-xie  QQ 443833189 Gmail siqimochi0@gmail.com     RainbowPHP的git地址https://github.com/iris-xie/RainbowPHP.git
