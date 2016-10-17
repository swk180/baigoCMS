<?php
return "<h3>常见问题</h3>
    <p>&nbsp;</p>
    <h4>问：经常出现令牌错误是什么原因？如何解决？</h4>

    <p>答：令牌是本系统的一种安全机制，每 5 分钟滚动更新一次，出现令牌错误的原因一般是开启了两个以上的管理窗口，也有可能是暂时性网络故障造成的。如果遇到令牌错误的问题，可将警告窗口关闭，将已经输入的内容妥善保存后，刷新当前页面便可解决。如果输入的内容较多，也可等待 5 分钟，系统再次更新令牌后再提交。</p>

    <p>&nbsp;</p>
    <div class=\"text-right\">
        <a href=\"#top\">
            <span class=\"glyphicon glyphicon-chevron-up\"></span>
            top
        </a>
    </div>
    <hr>
    <p>&nbsp;</p>

    <div>
        <h4>问：安装过程中出现“数据库无法连接”和“数据库名错误”错误如何解决？</h4>

        <p>答：安装过程中出现的“数据库无法连接”和“数据库名错误”错误又可能是系统提前生成了数据库配置文件，而配置文件的数据又不符合实际情况，解决方法是修改 ./config/opt_dbconfig.php 文件，填入正确的数据库信息，也可以删除该文件重新运行安装程序。</p>
    </div>

    <p>&nbsp;</p>
    <div class=\"text-right\">
        <a href=\"#top\">
            <span class=\"glyphicon glyphicon-chevron-up\"></span>
            top
        </a>
    </div>
    <hr>
    <p>&nbsp;</p>

    <div>
        <h4>问：在批量导入用户时，有时候可能会出现文字乱码，这是什么原因，如何解决？</h4>

        <p>答：批量导入用户时，正常情况下，系统会自动检测原始文件所使用的字符编码。特殊情况下，如：原始文件为少数语种，可能会出现文字乱码，此时可在右侧手动选择原始文件的字符编码，每一种字符编码所代表的含义，可点击“查看编码帮助”。</p>
    </div>";