<?php

class SchemaController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Schema Controller
	|--------------------------------------------------------------------------
	|
	| 目标部署环境为虚拟主机空间，所以考虑使用简单的数据库创建方式。
	|
	| 本类的作用是直接通过 GET 请求，创建数据库 
	|
	| 创建所有表，以及测试数据 GET /schema/up 
	| 销毁所有表 GET /schema/down
	|
	*/
    
    public function getIndex()
	{
        return "Whooops!";
	}

	public function getUp()
	{
        $this->create_users();
        $this->create_password_reminders();
        $this->create_articles();
        $this->create_article_comments();
        $this->create_article_comment_digg();
        $this->create_categories();
        $this->create_news();
        $this->create_news_comments();
        $this->create_news_digg();
        $this->create_groups();
        $this->create_group_user();
        $this->create_posts();
        $this->create_post_comments();
        $this->create_questions();
        $this->create_answers();
        $this->create_answer_comments();
        $this->create_answer_attitude();
        $this->create_sources();
        $this->create_source_comments();
        $this->create_fields();
        $this->create_originals();
        $this->create_translations();
        $this->create_series();
        $this->create_activities();
        $this->create_activity_comments();
        $this->create_activity_user();
        $this->create_tasks();
        $this->create_task_user();
        
        $this->create_tags();
        $this->create_article_tag();
        $this->create_news_tag();
        $this->create_post_tag();
        $this->create_question_tag();
        $this->create_source_tag();
        $this->create_activity_tag();
        $this->create_task_tag();
        
        $this->create_notices();
        
        $this->create_test_data();
	}
    
    public function getDown()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reminders');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('article_comments');
        Schema::dropIfExists('article_comment_digg');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('news');
        Schema::dropIfExists('news_comments');
        Schema::dropIfExists('news_digg');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('group_user');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('post_comments');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('answers');
        Schema::dropIfExists('answer_comments');
        Schema::dropIfExists('answer_attitude');
        Schema::dropIfExists('sources');
        Schema::dropIfExists('source_comments');
        Schema::dropIfExists('fields');
        Schema::dropIfExists('originals');
        Schema::dropIfExists('translations');
        Schema::dropIfExists('series');
        Schema::dropIfExists('activities');
        Schema::dropIfExists('activity_comments');
        Schema::dropIfExists('activity_user');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('task_user');
        
        Schema::dropIfExists('tags');
        Schema::dropIfExists('article_tag');
        Schema::dropIfExists('news_tag');
        Schema::dropIfExists('post_tag');
        Schema::dropIfExists('question_tag');
        Schema::dropIfExists('source_tag');
        Schema::dropIfExists('activity_tag');
        Schema::dropIfExists('task_tag');
        
        Schema::dropIfExists('notices');
        
        echo "Drop all tables!";
    }
    
    public function create_users()
    {
        // TODO: 结构还需完善，需要详细考量
        // MEMO: 关系不考虑实现
        // MEMO: 数据冗余先不考虑
    
        Schema::create('users', function($table) {
            $table->increments('id');
            $table->string('email', 64); // need
            $table->string('password', 64);
            $table->string('username', 32);
            $table->string('title', 64);
            $table->string('avatar', 256);
            
            $table->string('intro', 1024);


            // TODO: 旧密码, 分开表
            // 兼容旧系统
            //
            // $table->string('old_password', 64);
            
            
            // 权限等级
            // 考虑设置默认值
            // TODO: 0为不活动账号 默认值为1 其他情况按照大小判断
            $table->integer('permission')->default(1);
            
            // 冗余数据
            $table->integer('notice_count')->default(0); // 未读通知数量
            $table->integer('post_count')->default(0); // 发帖数量
            $table->integer('news_count')->default(0); // 发帖数量
            $table->integer('question_count')->default(0); // 提问数量
            $table->integer('answer_count')->default(0); // 回答数量
            
            // 翻译与任务
            
            $table->timestamps();
            
            // 索引
            $table->unique('email');
            $table->unique('username');
        });
        echo "Create the users table!";
        echo '<br />';
    }
    
    public function create_password_reminders()
    {
        Schema::create('password_reminders', function($table)
		{
			$table->string('email');
			$table->string('token');
			$table->timestamp('created_at');
		});
        echo "Create the password_reminders table!";
        echo '<br />';
    }
    
    public function create_notices()
    {
        // TODO:
        Schema::create('notices', function($table) {
            $table->increments('id');
            
            $table->integer('user_id');
            $table->text('content');
    
            $table->timestamps();
        });
        echo "Create the notices table!";
        echo '<br />';
    }
    
    public function create_articles()
    {
        // TODO: 文章 tag
        Schema::create('articles', function($table) {
            $table->increments('id');
            $table->string('title', 128);
            
            $table->integer('author_id');
            $table->string('author_name', 32);
            
            $table->text('abstract'); // 纯文字
            $table->text('content'); // html
            $table->text('markdown'); // markdown
            
            $table->integer('category_id');
            $table->string('category_name', 64);
            
            // 缩略图
            $table->string('thumbnail', 256);
            
            $table->integer('status')->default(0); // 状态
            
            $table->integer('comment_count')->default(0); // 评论数
    
            $table->timestamps();
            
        });
        echo "Create the articles table!";
        echo '<br />';
        
    }
    
    public function create_article_comments()
    {
        Schema::create('article_comments', function($table) {
            $table->increments('id');
            
            $table->integer('article_id');
            
            $table->integer('author_id');
            $table->string('author_name', 32);
            
            $table->text('content');
            $table->text('markdown');
            
            $table->integer('digg_count')->default(0);
            
            // TODO: 楼层
    
            $table->timestamps();
            
        });
        echo "Create the article_comments table!";
        echo '<br />';
        
    }
    
    public function create_article_comment_digg()
    {
        Schema::create('article_comment_digg', function($table) {
            $table->increments('id');
            
            $table->integer('article_comment_id');
            $table->integer('user_id');

            $table->timestamps();
            
        });
        echo "Create the article_comment_digg table!";
        echo '<br />';
    }
    
    public function create_categories()
    {
        Schema::create('categories', function($table) {
            $table->increments('id');
            
            $table->string('name', 64);
            $table->text('descr');
            $table->integer('parent_id')->default(0);
            $table->integer('article_count')->default(0);

            $table->timestamps();
        });
        echo "Create the categories table!";
        echo '<br />';
    }
    
    public function create_news()
    {
        // 麻痹的， news 不可数名词 
        Schema::create('news', function($table) {
            $table->increments('id');
            
            $table->string('title', 128);
            $table->string('link', 256);
            
            
            $table->integer('courier_id');
            $table->string('courier_name', 32);
            
            $table->text('abstract'); // 摘要 纯文字
            
            $table->integer('status')->default(0); // 状态
            
            // TODO: 评论数
            $table->integer('comment_count')->default(0);
            $table->integer('digg_count')->default(0);
    
            $table->timestamps();
            
        });
        echo "Create the news table!";
        echo '<br />';
    }
    
    public function create_news_comments()
    {
        Schema::create('news_comments', function($table) {
            $table->increments('id');
            
            $table->integer('news_id');
            
            $table->integer('author_id');
            $table->string('author_name', 32);
            
            $table->text('content');
            $table->text('markdown');
            
            // TODO: 楼层
    
            $table->timestamps();
            
        });
        echo "Create the news_comments table!";
        echo '<br />';
    }
    
    public function create_news_digg()
    {
        Schema::create('news_digg', function($table) {
            $table->increments('id');
            
            $table->integer('news_id');
            $table->integer('user_id');

            $table->timestamps();
            
        });
        echo "Create the news_digg table!";
        echo '<br />';
    }
    
    
    public function create_groups()
    {
        Schema::create('groups', function($table) {
            $table->increments('id');
            
            $table->string('name', 64);
            $table->string('pic', 256);
            $table->text('descr');
            
            // TODO:组长，管理员，统计数据（冗余数据），
            
            $table->integer('status')->default(0);
            $table->integer('member_count')->default(0); // 成员人数
            
            $table->timestamps();
            
        });
        echo "Create the groups table!";
        echo '<br />';
        
        
    }
    
    public function create_group_user()
    {
        Schema::create('group_user', function($table) {
            $table->increments('id');
            
            $table->integer('group_id');
            $table->integer('user_id');
    
            $table->timestamps();
        });
        echo "Create the group_user table!";
        echo '<br />';
    }
    
    
    public function create_posts()
    {
        Schema::create('posts', function($table) {
            $table->increments('id');
            
            $table->string('title', 128);
            
            $table->integer('group_id');
            $table->string('group_name', 64); // 冗余字段
            
            $table->integer('author_id');
            $table->string('author_name', 32);
            
            // TODO: 楼层冗余数据
            
            $table->text('content');
            $table->text('markdown');
            
            $table->integer('status')->default(0); // 状态
            $table->integer('comment_count')->default(0); // 评论数
    
            $table->timestamps();
        });
        echo "Create the posts table!";
        echo '<br />';
        
           
    }
    public function create_post_comments()
    {
        // MEMO: 指名回帖使用扁平结构，使用 '@' 通知 
        // TODO: '@' 的实现
        Schema::create('post_comments', function($table) {
            $table->increments('id');
            
            $table->integer('post_id');
            
            $table->integer('author_id');
            $table->string('author_name', 32);
            
            $table->text('content');
            $table->text('markdown');
            
            // TODO: 楼层
    
            $table->timestamps();
            
        });
        echo "Create the post_comments table!";
        echo '<br />';
        
    }
    
    
    
    public function create_questions()
    {
        Schema::create('questions', function($table) {
            $table->increments('id');
            
            $table->string('title', 256);
            
            $table->integer('asker_id');
            $table->string('asker_name', 32);
            
            // TODO: 冗余数据，回答数目
            $table->integer('answer_count')->default(0);
            
            $table->integer('status')->default(0); // 状态
            
            
            $table->timestamps();
            
        });
        echo "Create the questions table!";
        echo '<br />';
    
    }
    
    public function create_answers()
    {
        Schema::create('answers', function($table) {
            $table->increments('id');
            
            $table->integer('question_id');
            
            $table->integer('author_id');
            $table->string('author_name', 32);
            
            $table->text('content');
            $table->text('markdown');
            
            // TODO: 楼层 Oppose Support
            // $table->integer('digg')->default(0);
            $table->integer('comment_count')->default(0);
            
            // 态度
            $table->integer('attitude')->default(0);
            
            $table->integer('status')->default(0); // 状态
    
            $table->timestamps();
            
        });
        echo "Create the answers table!";
        echo '<br />';
    
    }
    
    public function create_answer_comments()
    {
        // TODO: 回答评论
        Schema::create('answer_comments', function($table) {
            $table->increments('id');
            
            $table->integer('answer_id');
            
            $table->integer('author_id');
            $table->string('author_name', 32);
            
            $table->string('content', 512); // 只有纯文本
            
            $table->timestamps();
        });
        echo "Create the answer_comments table!";
        echo '<br />';
    }
    
    public function create_answer_attitude()
    {
        Schema::create('answer_attitude', function($table) {
            $table->increments('id');
            
            $table->integer('answer_id');
            $table->integer('user_id');
            
            $table->integer('type'); // 1: 赞同 2: 反对  
            
            $table->timestamps();
        });
        echo "Create the answer_attitude table!";
        echo '<br />';
    }
    
    public function create_sources()
    {
        Schema::create('sources', function($table) {
            $table->increments('id');
            
            $table->string('orig_title', 256);
            $table->string('tran_title', 256);
            
            $table->string('orig_link', 256);

            $table->integer('para_count');
            $table->integer('tran_count');
            
            $table->integer('courier_id');
            $table->string('courier_name', 32);
            
            $table->integer('field_id');
            
            $table->integer('comment_count')->default(0);
            $table->integer('status')->default(0);

            $table->timestamps();
        });
        echo "Create the sources table!";
        echo '<br />';
    }
    
    public function create_source_comments()
    {
        Schema::create('source_comments', function($table) {
            $table->increments('id');
            
            $table->integer('source_id');
            
            $table->integer('author_id');
            $table->string('author_name', 32);
            
            $table->text('content');
            $table->text('markdown');
            
            $table->timestamps();
        });
        echo "Create the source_comments table!";
        echo '<br />';
    }
    
    public function create_fields()
    {
        Schema::create('fields', function($table) {
            $table->increments('id');
            
            $table->string('name', 64);
            $table->integer('source_count')->default(0);

            $table->timestamps();
        });
        echo "Create the fields table!";
        echo '<br />';
    }
    
    public function create_originals()
    {
        Schema::create('originals', function($table) {
            $table->increments('id');
            
            $table->integer('source_id');
            
            $table->text('content');
            $table->text('markdown');

            $table->integer('order');
            $table->integer('tran_count')->default(0);

            $table->timestamps();
        });
        echo "Create the originals table!";
        echo '<br />';
    }
    
    public function create_translations()
    {
        Schema::create('translations', function($table) {
            $table->increments('id');
            
            $table->integer('original_id');
            
            $table->text('content');
            $table->text('markdown');
            
            $table->integer('author_id');
            $table->string('author_name', 32);

            $table->integer('digg_count')->default(0);

            $table->timestamps();
        });
        echo "Create the translations table!";
        echo '<br />';
    }
    
    public function create_series()
    {
        
        Schema::create('series', function($table) {
            $table->increments('id');
            
            $table->string('name', 32);
            $table->string('pic', 256);
            $table->text('descr');

            $table->integer('activity_count')->default(0);
            $table->timestamps();
        });
        echo "Create the series table!";
        echo '<br />';
    }
    
    public function create_activities()
    {
        Schema::create('activities', function($table) {
            $table->increments('id');
            
            $table->integer('series_id');
            
            $table->string('title', 256);
            $table->string('organizer', 128);
            
            $table->timestamp('start_at');
            $table->timestamp('end_at');

            $table->string('location', 128);
            
            $table->text('descr'); // 描述
            
            $table->integer('sponsor_id');
            $table->string('sponsor_name', 32);
            
            // 冗余字段
            $table->integer('comment_count')->default(0);
            $table->integer('status')->default(0);

    
            $table->timestamps();
        });
        echo "Create the activities table!";
        echo '<br />';
    }
    
    public function create_activity_comments()
    {
        Schema::create('activity_comments', function($table) {
            $table->increments('id');
            
            $table->integer('activity_id');
            
            $table->integer('author_id');
            $table->string('author_name', 32);
            
            $table->text('content');
            $table->text('markdown');
            
            // TODO: 楼层
    
            $table->timestamps();
            
        });
        echo "Create the activity_comments table!";
        echo '<br />';
    }
    
    public function create_activity_user()
    {
        Schema::create('activity_user', function($table) {
            $table->increments('id');
            
            $table->integer('activity_id');
            $table->integer('user_id');
    
            $table->timestamps();
        });
        echo "Create the activity_user table!";
        echo '<br />';
    }
    
    public function create_tasks()
    {
        Schema::create('tasks', function($table) {
            $table->increments('id');
            
            $table->string('title', 256);
            
            $table->text('descr'); // 描述
            $table->text('hidden'); // 描述
            
            $table->timestamp('start_at');
            $table->timestamp('end_at');
            
            $table->integer('publisher_id');
            $table->string('publisher_name', 32);
            
            $table->integer('executor_id');
            $table->string('executor_name', 32);
            
            
            $table->integer('status')->default(0);
    
            $table->timestamps();
        });
        echo "Create the tasks table!";
        echo '<br />';
    }
    
    public function create_task_user()
    {
        Schema::create('task_user', function($table) {
            $table->increments('id');

            $table->integer('task_id');
            $table->integer('user_id');
            
            $table->integer('type')->default(0); // 0: 申请 1: 承接
    
            $table->timestamps();
        });
        echo "Create the task_user table!";
        echo '<br />';
    }
    
    public function create_tags()
    {
        
        Schema::create('tags', function($table) {
            $table->increments('id');
            
            $table->string('tag', 32);
            
            // 冗余字段
            // 引用计数
            $table->integer('refer_count')->default(1);
    
            $table->timestamps();
            
        });
        echo "Create the tags table!";
        echo '<br />';
    }
    
    public function create_article_tag()
    {
        Schema::create('article_tag', function($table) {
            $table->increments('id');
            
            $table->integer('article_id');
            $table->integer('tag_id');
    
            $table->timestamps();
        });
        echo "Create the article_tag table!";
        echo '<br />';
    }
    
    
    public function create_news_tag()
    {
        Schema::create('news_tag', function($table) {
            $table->increments('id');
            
            $table->integer('news_id');
            $table->integer('tag_id');
    
            $table->timestamps();
        });
        echo "Create the news_tag table!";
        echo '<br />';
    }
    
    public function create_post_tag()
    {
        Schema::create('post_tag', function($table) {
            $table->increments('id');
            
            $table->integer('post_id');
            $table->integer('tag_id');
    
            $table->timestamps();
        });
        echo "Create the post_tag table!";
        echo '<br />';
    }
    
    public function create_question_tag()
    {
        Schema::create('question_tag', function($table) {
            $table->increments('id');
            
            $table->integer('question_id');
            $table->integer('tag_id');
    
            $table->timestamps();
        });
        echo "Create the question_tag table!";
        echo '<br />';
    }
    
    public function create_source_tag()
    {
        Schema::create('source_tag', function($table) {
            $table->increments('id');
            
            $table->integer('source_id');
            $table->integer('tag_id');
    
            $table->timestamps();
        });
        echo "Create the source_tag table!";
        echo '<br />';
    }
    
    public function create_activity_tag()
    {
        Schema::create('activity_tag', function($table) {
            $table->increments('id');
            
            $table->integer('activity_id');
            $table->integer('tag_id');
    
            $table->timestamps();
        });
        echo "Create the activity_tag table!";
        echo '<br />';
    }
    
    public function create_task_tag()
    {
        Schema::create('task_tag', function($table) {
            $table->increments('id');
            
            $table->integer('task_id');
            $table->integer('tag_id');
    
            $table->timestamps();
        });
        echo "Create the task_tag table!";
        echo '<br />';
    }
    
    public function create_user_verification()
    {
        // DROPED
        // TODO: 新用户注册验证
        // Verify code
        
        // 过期时间：
        //$table->timestamp('added_on');
    }
    
    
    
    public function create_test_data()
    {
        // 生成测试数据
        
        DB::table('users')->insert(array(
            'email' => 'test@test.com',
            'username' => 'test',
            'avatar' => 'http://www.gravatar.com/avatar/'.md5('test@test.com'),
            'password' => Hash::make('test'),
            'permission' => 90,
            
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));        
        echo "Insert test user!";
        echo '<br />';
        
        DB::table('users')->insert(array(
            'email' => 'test1@test.com',
            'username' => 'test1',
            'password' => Hash::make('test1'),
            'permission' => 0,
            
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));        
        echo "Insert test1 user!";
        echo '<br />';
        
        DB::table('users')->insert(array(
            'email' => 'test2@test.com',
            'username' => 'test2',
            'password' => Hash::make('test2'),
            'permission' => 1,
            
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));        
        echo "Insert test2 user!";
        echo '<br />';
        
        $content_raw = <<<EOS
		<p>第六届中国 R 语言会议（北京会场）于 2013 年 5 月 18 日 ~ 19 日在中国人民大学国学馆113、114教室成功召开。会议由中国人民大学应用统计科学研究中心、中国人民大学统计学院、北京大学商务智能研究中心、统计之都（<a href="http://cos.name">cos.name</a>）主办。在两天的会议时间里，参会者齐聚一堂，就 R 语言在互联网、商业、统计、生物、制药、可视化等诸多方面的应用进行了深入的探讨。</p>
<p><a href="http://cos.name/wp-content/uploads/2013/05/6th-china-r-bj.jpg"><img class="aligncenter size-large wp-image-7851" alt="6th-china-r-bj" src="http://cos.name/wp-content/uploads/2013/05/6th-china-r-bj-500x332.jpg" width="500" height="332"></a></p>
<h2>会议概况</h2>
<p>本次会议报名非常火爆，报名人数超过600人，约有 400 多名参会者前来参会，规模再创历届之最。参会者主要来自各大高校、科研机构、企业和事业单位，全体参会者所在单位汇总如下。</p>
<p>高校和研究所：</p>
<blockquote>
<div>
<p>中央财经大学、中南大学、中山大学、中国农业科学院、中国社会科学院、中国石油大学、中国科学技术信息研究所、中国科学院北京基因组研究所、中国科学院大学、中国科学院南京地理与湖泊研究所、中国矿业大学（北京）、中国农业大学、中国科学技术大学、中国传媒大学、中国地质大学（北京）、浙江大学、浙江工商大学、芝加哥大学、燕山大学、医学信息研究所、香港城市大学、西南财经大学、微软互联网工程院，北京大学、温岭市委党校、天津医科大学、天津农学院、天津财经大学、天津大学、上海大学、山西医科大学、山西财经大学、中国人民大学、清华大学、南方医科大学、南开大学、内蒙古财经大学、内蒙古科技大学、宁波工程学院、华中农业大学、吉林大学、华北电力大学、河南大学、国防科技大学、第三军医大学、对外经济贸易大学、北京邮电大学、北京语言大学、北京协和医学院、北京师范大学、北京理工大学、北京林业大学、北京航空航天大学、北京交通大学、北京工商大学、北京大学、华侨大学、University&nbsp;of&nbsp;Birmingham、University&nbsp;of&nbsp;Nebraska、Rice&nbsp;University、Iowa&nbsp;State&nbsp;University</p>
</div>
</blockquote>
<p><span id="more-7846"></span></p>
<p>企业、事业单位：</p>
<div>
<blockquote><p>Allianz、Amazon、Arvato&nbsp;China、Australian&nbsp;Curriculum,&nbsp;Assessment&nbsp;and&nbsp;Reporting&nbsp;Authority、EBAY、IBM、IMS、Lenovo、Madhouse、Merck、MVC、OMD、Opera&nbsp;solutions、Reyagroup、SAS、VHS、阿里巴巴、艾恩康医疗咨询有限公司、艾瑞咨询集团爱立信（中国）有限公司、爱奇艺、爱生活科技有限公司、安捷达（北京）顾问有效公司、奥浦诺管理咨询（上海）有限公司、百度、北京大学人民医院、北京东方国信科技股份有限公司、北京汉林信通、北京京诚鼎宇管理系统有限公司、北京柯莱特信息技术有限公司、北京洛神科技有限公司北京趣拿软件科技有限公司、北京瑞斯康达科技发展股份有限公司、北京市机械工业管理局党校（北京京城机电控股有限责任公司培训中心）、北京数海时代分析技术有限公司、北京随时传媒有限公司、北京网达信联科技发展有限公司、北京网元圣唐娱乐科技有限公司、北京伟们市场策划顾问有限公司、北京新浪广告有限公司、北京新媒传信科技有限公司、北京雪球科技有限公司、北京亿企通信息技术有限公司、北京永洪商智科技有限公司、北京掌汇天下科技有限公司、北京质量协会、北京致联必达信息咨询有限公司、博彦科技集团、才联智通、财新传媒、创腾科技、当当网、到到网、德勤华永会计师事务所（特殊普通合伙）北京分所、豆瓣、凡客诚品、风行、阜外心血管病医院、高血压研究所、广州乐聚信息技术有限公司、广州生物医药与健康研究院、国家气象中心、国家卫生和计划生育委员会、国家邮政局发展研究中心、果壳网、宏源证券、互动巅峰（好大夫在线）、华大基因研究院、疾控中心、京东商城、居然之家电子商务公司、军事医学科学院网络中心、零点研究咨询集团、美团网、美味书签(北京)信息技术有限公司、鹏元资信、品友互动、品有互动、汽车之家、钱方银通科技有限公司、去哪儿网、人民搜索、人人网、软通动力、瑞安、赛仕软件、桑德环境、山西省肿瘤医院、上海艾瑞市场咨询有限公司、上海伯豪生物技术有限公司、上海万达信息、上海文脉数据技术有限公司、深圳华大基因研究院、神州数码、数明科技(武汉)有限公司、数艺智库——中国传媒大学调查统计研究所、搜狗、搜狐、苏宁易购、随视传媒、泰山投资、淘宝网、腾讯、天际网、天津神舟通用数据技术有限公司、天津市智博通信工程有限责任公司、天津自然博物馆、天相投资顾问有限公司、豌豆荚、网略智慧、威盛电子、析数软件、新浪、新浪微博、杏树林、亚信、亚信联创科技（中国）有限公司、银华基金、永安期货股份有限公司、用友软件、有康爱帮、智联招聘、中国电信技术创新中心、中国国际航空公司、中国环境科学研究院、中国惠普有限公司、中国农业发展银行、中国外运、中国系统集成在线、中国医学科学院药用植物研究所、中国移动、中金数据系统有限公司、中经社控股、中科院沈阳应用生态研究所、中粮我买网、中信所、重庆绿色智能技术研究院、自由职业、字节跳动</p></blockquote>
<h2>会议内容</h2>
<p>本次会议讨论的主题涵盖了 R 语言在科学研究领域、推荐系统、机器学习、网络文本挖掘、大规模数据分析、数据可视化动态交互、高性能计算、互联网研究等众多方面的最新进展，共包含嘉宾致辞、18 场精彩的报告、2个Lighting Talk和现场赠书，会场反响热烈。会议的流程和主要内容摘录如下。</p>
<h3>1、吴喜之教授和会议主席陈昱致辞</h3>
<h3>2、赵彦云院长致辞</h3>
<h3>3、谢益辉——R包那些事儿</h3>
<p>演讲介绍了演讲者开发8个R包的感想。演讲分享了如下几个感想：1、“好玩”是最强生产力。演讲者因为动态图的有趣，开发了animation包；2、需求源于小处。 演讲者由于做助教改学生作业的苦恼，开发了规范R代码的formatR。又为了实现文字、图形和计算的一体化，开发了自动化报告的knitr。演讲者还结合自己的经历，向大家分享了“善易者不卜”和“暗推销”的威力。</p>
<h3>4、Graham Williams——Data Mining with Rattle and R</h3>
<p>演讲者是Rattle的作者，Rattle 是一个非常优秀的数据挖掘方法集合体。演讲介绍了Rattle在R中的应用。目前，Rattle 在R语言上有了更多的数据挖掘的二次开发以及封装，在实际的挖掘项目中能够有效的提高项目的速度。</p>
<h3>5、谢邦昌、刘思喆——DataMing云端决策平台CDMS Smart Score II——以R为基础</h3>
<p>演讲介绍了云端计算的背景和广阔的发展潜力，以及目前各大企业在应对云端计算上的方式以及不足。演讲着重介绍了云端决策平台CDMS Smart Score II，并与其他类似平台进行对比，显示了CDMS Smart Score II广阔的应用前景。</p>
<h3>6、John Maindonald——Rethinking Data Analysis and Data Analysis Tools</h3>
<p>第一届中国R语言会议时，我们就邀请了 Maindonald 教授进行网络报告，5年后的今天，演讲者受邀参与了R语言会议的现场报告。演讲从高处介绍了数据分析的发展以及R语言的应用，并介绍了为何选择Ｒ语言作为数据分析工具，以及R语言与其他软件的对比情况。演讲还指出了R语言需要提高的地方，用户希望能有更多的强大的工具，需要调用C语言来满足更高的速度要求等。</p>
<h3>7、李舰、周扬——禽流感分析中的R——MSToolkit, Rweibo, html5vis的介绍</h3>
<p>演讲分享了在工作中的案例，展示了R语言在满足客户个性化需求和解决新颖性问题的作用。有情怀的演讲者分享了基于Shiny、 GoogleVis和html5vis的可交互的可视化图形，图形中时间维度的增加，充分的展现以往静态分析难以一并展现的时间特性。并以禽流感的传播和PM2.5为实例，介绍了在可交互的界面友好的动态图形上的信息呈现。</p>
<h3>8、张晓华——displayHTS: a R package for displaying data and results from high-throughput screening experiments</h3>
<p>演讲介绍了演讲者团队开发的displayHTS包，展示了其在高通量筛选试验中的应用以及图形的展示。张晓华老师还特别指出，这个软件包的开发者是一位年仅16岁的学生，以此鼓励在场听众积极参与到开发R包的行列中。</p>
<h3>9、第一场 Lightning Talk</h3>
<p>Lighting Talk环节的设置旨在沟通招聘者和求职者。该环节主持人为林祯舜博士，林博士分享了“善R者不愁工作”的理念，并“致敬我们曾经使用过的R版本”。之后分别由Merck的张晓华先生、万达信息的肖凯先生、中信银行的顾小波先生、Careerfocus的葛华云女士、数明科技的刘兵先生以及浙江大学软件学院金融数据分析的杭诚方教授，依次讲述各自单位对不同层次人才的需求。业界和学界对数据分析、数据挖掘或者Data Scientist人才的需求，由此可见一斑。</p>
<h3>10、现场抽奖赠书</h3>
<p>中国人民大学出版社、西安交通大学出版社、华章图书和图灵出版社以及王汉生教授分别向本次R语言会议赠送了R语言及数据分析相关的图书，用于现场抽奖赠书。魏太云和高涛主持本环节，并分别基于报名序号以及座位号随机抽取参会者，现场赠书。</p>
<h3>11、张常有、张先轶——Julia语言介绍</h3>
<p>Julia是一个新的高性能动态高级编程语言，提供了精度和分布式并行运行方式，高效支持外部函数的调用。演讲依次介绍了Julia语言的基本语法、外部函数调用、并行计算以及基于Julia语言搭建的协作云平台，向大家展示了Julia语言在计算效率和并行计算上的优势。</p>
<h3>12、肖楠——Web Scraping with R</h3>
<p>演讲详细的讲述了定向爬虫如何在R语言架构下的使用，分别阐述了R语言爬虫的平台选择、爬虫相关R包总结分析、异常处理以及并行化计算等方面。该报告详细的分析了基于R语言爬虫的各个阶段，是杀人越货，居家旅行必备之良器。</p>
<h3>13、庄宝童——机器学习在互联网广告中的应用</h3>
<p>演讲详细介绍了互联网广告中各阶段的主要研究方向和主要算法。演讲总结了互联网广告在各大著名网站收入的占比信息。互联网广告使到广告商-广告平台-用户三方各得其所，演讲中分别对互联网广告的三方参与者的研究进行了介绍，并对实践中的问题提出了自己的解决方式。</p>
<h3>14、李忠、潘佳鸣——R在ebay大数据分析中的应用</h3>
<p>演讲演示两个利用R来分析 eBay 大数据的应用案例。第一个案例演示了如何对 eBay 的移动用户购买行为进行深度分析，从三个不同的视角（地理分布，性别，年龄段）分析了用户数量，订单量，购买频率，购买金额，购买类别和购后评价，最后演示了如何分析和展现用户的保持率。第二个案例演示了如何对 eBay 的系统错误日志进行分类，为更好的为后台人员解决问题提供了支持。</p>
<h3>15、第二场 Lightning Talk</h3>
<p>该环节的主持人依旧由动感的林祯舜博士主持，林博士继第一天“致青春”后，今天果断转向“那些年-我们一起追的R版本”。标题进化者林博士今天确定的标题是：“学R不思则罔，思R不学则殆”，给人以深思。只知道学习却不思考，就会因为迷惑而无所适从；只知道思考却不去学习，就会对所有事情一知半解、不懂装懂。对于R学习，更是如此。</p>
<p><a href="http://cos.name/wp-content/uploads/2013/05/Learning_R.png"><img class="aligncenter size-large wp-image-7849" alt="Learning_R" src="http://cos.name/wp-content/uploads/2013/05/Learning_R-500x305.png" width="500" height="305"></a>之后分别有阿里巴巴的郝智恒先生、eBay潘佳鸣先生、京东商城赵灿女士、百度侯俊琦先生、豆瓣稳国柱先生、Springer 出版社的 Niels P. Thomas 先生以及Supstat邓一硕先生依次讲述各自单位对不同层次人才的需求，会议现场更有参会者向心仪单位投递了简历，会下的交流更是火热。</p>
<h3>16、稳国柱——R的工程实践和Data Scientist</h3>
<p>演讲首先介绍了，在面对大数据量时，R的向量化运算的优势。并对R面对并行化运算时的特点进行了分析，给出了并行计算最合理的包搭配，之后展示了对Rpark的探索。演讲提议将Ｒ语言运用到它最擅长的领域，而不是将Ｒ语言万能化。演讲在第二部分通过三个层次的场景分析，阐述了豆瓣对Data Scientist职位的思考，演讲总结的“合格的人才符合职位，优秀的人才定义职位”引起与会者的广泛思考。</p>
<h3>17、王浩——用户产生内容的质量评价与智能排序</h3>
<p>演讲讲授了如何对UGC的质量进行评价以及智能排序方面的研究。已有的内容质量评价方法，主要包括利用众包的投票机制（如Digg 和Reddit），以及基于用户间互动的社交关系（如Facebook 的Newsfeed 和新浪微博智能排序）。这些方法，主要借助于用户消费内容后的自然反馈来评价内容质量。在实际的工作中，演讲者展示了借助于机器学习技术，基于UGC 的文字内容本身，对其进行质量评估，并针对具体的UGC 展示场景进行智能排序。</p>
<h3>18、王汉生——On the ultrahigh dimensional linear discriminant analysis problem with a diverging number of classes</h3>
<p>演讲介绍了对类别数超多情况下的线性判别分析问题研究。例如每个人写字的习惯不太一样，同样的字会有非常多的写法，于是就有了目前类别发散问题。演讲中的研究提出的解决办法是根据现有的特征，每个观测（字）两两擂台赛，根据观测的所有得分的累计来判断它的类别。该研究方法对类别数非常多的判别分类问题提出了新颖的解决方式。</p>
<h3>19、周庭锐——移动应用里的线上行为：一个R的尝试</h3>
<p>演讲展示了数据结构中同时包含结构的定量数据与非结构的文本数据的解决方式，即利用R语言中RMongo 包来整合数据，并展示了对一个200万用户数据的行为分析。以及讨论了在分析过程所遭遇的两个最主要的运算问题：内存不足，以及多线程脚本返回列表的汇总问题的处理方法。</p>
<h3>20、李欣海——用R和WinBUGS实现贝叶斯分级模型</h3>
<p>演讲介绍了分级模型的思想以及基于朱鹮的研究讲授其在R中的实现。分级模型在近十年中有较大的发展，逐渐成为描述物种分布的主流方法。贝叶斯方法通过MCMC 估计每个模型的参数，是当前分级模型参数估计的主要方法。研究者一般用R 整理数据，然后通过R2WinBUGS 包调用WinBUGS 进行参数估计和模型选择。最后利用MCMC 算出的参数在R 中进行模型验证。本研究以朱鹮在陕西汉中地区95 个流域的营巢数为因变量，分析每个流域的环境变量和野外调查对营巢数的影响。</p>
<h3>21、王贺——网络舆情监测：基于R语言的网络文本挖掘与数据可视化</h3>
<p>演讲者在完成一个文本信息抓取的作业的基础上，深入研究了网络文本挖掘、文本分析以及数据可视化方面，并由此形成了自己的研究。演讲分别展示了网络文本挖掘的过程，并抓取了“PM2.5”话题的微博数据，以此建立了词与词之间的关系，并使用社会网络分析软件Gephi 绘制关系图，对文本信息进行了可视化演示。演讲还进一步分析了网上商城的用户评价的文本数据，使用LDA 模型对评论进行浅层语义分析，并由此获取了评论的主题。与会者就文本分析的应用前景进行了广泛的讨论。</p>
<h3>22、关菁菁——Data cloning: easy maximum likelihood estimation for complex models: an application to zero-inflated responses of Internet ads</h3>
<p>该演讲是对互联网广告的点击行为的进行预测研究。针对互联网广告中广告点击次数为0大量存在，演讲者提出了使用零膨胀泊松回归对预测用户的点击行为，并通过使用Data Cloning的思想来估计模型系数，为预测用户对互联网广告的点击行为提出了自己的研究思路和解决方式。</p>
<h2>资源下载</h2>
<p>经演讲者的授权同意，已将所有同意公开的幻灯片加了超链接供大家下载学习（请遵循<a href="http://creativecommons.org/licenses/by-nc-sa/3.0/deed.zh" target="_blank">CC 3.0协议</a>：署名-非商业性使用-相同方式共享）。</p>
<ul>
<li><a href="http://dl.dropboxusercontent.com/u/15335397/slides/ChinaR-2013-Yihui-Xie.html">谢益辉：R包那些事儿</a></li>
<li><a href="http://cos.name/wp-content/uploads/2013/05/130518_graham_china_r_conference_beijing.pdf">GRAHAM WILLIAMS：DATA MINING WITH RATTLE AND R</a></li>
<li><a href="http://cos.name/wp-content/uploads/2013/05/DATA-MINING雲端決策平台CDMS-Smart-Score-II-以-R-為基礎-REVISED.pptx">DATA MINING雲端決策平台CDMS Smart Score II——以 R 為基礎</a></li>
<li><a href="http://cos.name/wp-content/uploads/2013/05/John-Maindonald.pdf">John Maindonald：Rethinking Data Analysis and Data Analysis Tools</a></li>
<li><a href="http://cos.name/wp-content/uploads/2013/05/lijian_ChinaR20130518.ppt">李舰、周扬：禽流感分析中的R——MSToolkit, Rweibo, html5vis的介绍</a>（<a href="http://cos.name/wp-content/uploads/2013/05/lijian_ChinaR20130518.7z">代码</a>）</li>
<li><a href="http://cos.name/wp-content/uploads/2013/05/Rconference.Zhang_.Xiaohua.pptx">张晓华：DISPLAYHTS: A R PACKAGE FOR DISPLAYING DATA AND RESULTS FROM HIGH-THROUGHPUT SCREENING EXPERIMENTS</a></li>
<li><a href="http://cos.name/wp-content/uploads/2013/05/changyou-Julia-20130518.pdf">张常有、张先轶：JULIA语言介绍</a></li>
<li><a href="http://cos.name/wp-content/uploads/2013/05/Web-Scraping-with-R-XiaoNan.pdf">肖楠：WEB SCRAPING WITH R</a></li>
<li>庄宝童：机器学习在互联网广告中的应用</li>
<li><a href="http://cos.name/wp-content/uploads/2013/05/R-Case-Study-from-EBAY-DDI.pptx">李忠、潘佳鸣：R在EBAY大数据分析中的应用</a></li>
<li><a href="http://cos.name/wp-content/uploads/2013/05/第六届R会议-阿稳.pdf">稳国柱：R的工程实践和DATA SCIENTIST</a></li>
<li><a href="http://cos.name/wp-content/uploads/2013/05/quality-evaluation-and-ordering-of-user-generated-content-wanghao.pdf">王浩：用户产生内容的质量评价与智能排序</a></li>
<li><a href="http://cos.name/wp-content/uploads/2013/05/Wang.pdf">王汉生：ON THE ULTRAHIGH DIMENSIONAL LINEAR DISCRIMINANT ANALYSIS PROBLEM WITH A DIVERGING NUMBER OF CLASSES</a></li>
<li><a href="http://cos.name/wp-content/uploads/2013/05/Hierarchical-modeling-with-R.pdf">李欣海：用R和WinBUGS实现贝叶斯分级模型</a></li>
<li><a href="http://cos.name/wp-content/uploads/2013/05/网络舆情监测_王贺_201305.rar">王贺：网络舆情监测：基于R语言的网络文本挖掘与数据可视化</a></li>
</ul>
<h2>感想和建议</h2>
<p>第六届R语言会在完成两天所有的日程安排后，顺利闭幕。两天的会议，深化了与会者各界之间的交流和讨论。</p>
<p>历届的R语言会议都不只是一个会议，更是一个大聚会。来自四面八方的Ｒ爱好者汇聚在一起，分享知识、聚集智慧、沉淀情感。于是才会有“相聚，缩短了距离；分享，交融了智慧；相识，艰难了离别”。</p>
<p>多届R语言会议参与者郝智恒会后发表微博：</p>
<blockquote><p>“统计之都社群真正实现了由学生创建，从服务学生，到服务社会，学生进入业界又返回来回馈的良性循环。这对一个完全靠捐助运营的网站来说真的实属不易。每一年R语言的参会者都越来越多，业界的分享也越来越多，除了大数据话题渐热，我觉得大家都是带着感情来的。真情无价。”</p></blockquote>
<p>与之遥相呼应的是，本届R语言会议秘书长高涛，在参加2009年第二届R语言会议之后表示：</p>
<blockquote><p>“这是我第一次感觉到一个圈子里面的人是如此真诚、善意与专业！”</p></blockquote>
<p>最后，才有了本届会议筹备组成员——冷静同学，在会议结束后扔出的一句</p>
<blockquote><p>“醉笑陪君三万场，不诉离殇”！</p></blockquote>
<p>如果您对于中国R语言会议还有任何感想、意见或建议，欢迎您在本页面、<a href="http://renren.com/cosname" target="_blank">统计之都人人网页面</a>或<a href="http://weibo.com/cosname" target="_blank">统计之都新浪微博</a>留言，我们会尽力在今后对会议质量进行进一步的改善。</p>
</div>
EOS;
        
        DB::table('articles')->insert(array(
            'title' => "第六届中国R语言会议（北京）纪要",
            
            'author_id' => 1,
            'author_name' => 'test',
            
            'category_id' => 1,
            
            'abstract' => "第六届中国 R 语言会议（北京会场）于 2013 年 5 月 18 日 ~ 19 日在中国人民大学国学馆113、114教室成功召开。会议由中国人民大学应用统计科学研究中心、中国人民大学统计学院、北京大学商务智能研究中心、统计之都（cos.name）主办。在两天的会议时间里，参会者齐聚一堂，就 R 语言在互联网、商业、统计、生物、制药、可视化等诸多方面的应用进行了深入的探讨。",
            'content' => $content_raw,
            'thumbnail' => "http://cos.name/wp-content/uploads/2013/05/6th-china-r-bj-500x332.jpg",
        ));        
        echo "Insert long test articles !";
        echo '<br />';
        
        for ($i=1; $i<=10; $i++) {
            DB::table('articles')->insert(array(
                'title' => "title $i",
                
                'author_id' => 1,
                'author_name' => 'test',
                
                'category_id' => $i/2,
                
                'abstract' => "abstract $i",
                'content' => "content content content $i",
            ));        
            echo "Insert test articles $i !";
            echo '<br />';
        }
        
        for ($i=1; $i<=5; $i++) {
            DB::table('article_comments')->insert(array(
                'article_id' => 1,
                
                'author_id' => 1,
                'author_name' => 'test',

                'content' => "article $i comment comment  $i <br/> comment",
                
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));        
            echo "Insert test article comment $i!";
            echo '<br />';
        }
        
        for ($i=1; $i<=10; $i++) {
            DB::table('news')->insert(array(
                'title' => "news title $i",
                'link' => "http://news_url",
                
                'courier_id' => 1,
                'courier_name' => 'test',

                'abstract' => "news abstract $i ",
                
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));        
            echo "Insert test news $i!";
            echo '<br />';
        }
        
        DB::table('news_digg')->insert(array(
            'news_id' => 1,
            'user_id' => 1,

            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));        
        echo "Insert test news_digg !";
        echo '<br />';
        
        for ($i=1; $i<=5; $i++) {
            DB::table('news_comments')->insert(array(
                'news_id' => 1,
                
                'author_id' => 1,
                'author_name' => 'test',

                'content' => "news content $i ",
                
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));        
            echo "Insert test news comment $i!";
            echo '<br />';
        }
        
        for ($i=1; $i<=5; $i++) {
            DB::table('groups')->insert(array(
                'name' => "测试小组$i",
                'pic' => '/img/test_group_pic.jpg',
                'descr' => "测试小组描述<br />换行换行",
                
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));        
            echo "Insert test group $i!";
            echo '<br />';
        }
        
        DB::table('group_user')->insert(array(
            'user_id' => 1,
            'group_id' => 1,
            
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));        
        echo "Insert test group_user 1 relation !";
        echo '<br />';
        
        DB::table('group_user')->insert(array(
            'user_id' => 2,
            'group_id' => 1,
            
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));        
        echo "Insert test group_user 2 relation !";
        echo '<br />';
        
        for ($i=1; $i<=10; $i++) {
            DB::table('posts')->insert(array(
                'title' => "post title $i",
                
                'group_id' => 1,
                'group_name' => '测试小组1',
                'author_id' => 1,
                'author_name' => 'test',

                'content' => "post $i content content content $i <br/> post content content content",
                
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));        
            echo "Insert test post $i!";
            echo '<br />';
        }
        
        for ($i=1; $i<=5; $i++) {
            DB::table('post_comments')->insert(array(
                'post_id' => 1,
                
                'author_id' => 1,
                'author_name' => 'test',

                'content' => "post $i comment comment  $i <br/> comment",
                
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));        
            echo "Insert test post comment $i!";
            echo '<br />';
        }
        
        // questions
        for ($i=1; $i<=10; $i++) {
            DB::table('questions')->insert(array(
                'title' => "question title $i",
                
                'asker_id' => 1,
                'asker_name' => 'test',
                
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));        
            echo "Insert question $i!";
            echo '<br />';
        }
        
        for ($i=1; $i<=10; $i++) {
            DB::table('answers')->insert(array(
                'question_id' => 1,
                
                'author_id' => 1,
                'author_name' => 'test',
                
                'content'=>"answer content $i",
                
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));        
            echo "Insert answer $i!";
            echo '<br />';
        }
        
        for ($i=1; $i<=10; $i++) {
            DB::table('answer_comments')->insert(array(
                'answer_id' => 1,
                
                'author_id' => 1,
                'author_name' => 'test',
                
                'content'=>"answer answer_comment $i",
                
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));        
            echo "Insert answer_comment $i!";
            echo '<br />';
        }
        
        for ($i=1; $i<=6; $i++) {
            DB::table('sources')->insert(array(

                'orig_title' => "test source",
                'tran_title' => "测试源",
                'orig_link' => "orig-url",
                
                'para_count' => 3,
                'tran_count' => 1,
                'courier_id' => 1,
                'courier_name' => 'test',

                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));        
            echo "Insert sources $i!";
            echo '<br />';
        }
        
        for ($i=1; $i<=3; $i++) {
            DB::table('originals')->insert(array(
                'source_id' => 1,
                
                'order' => $i,
                
                'content'=>"original $i",
                
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));        
            echo "Insert originals $i!";
            echo '<br />';
        }
        
        for ($i=1; $i<=3; $i++) {
            DB::table('translations')->insert(array(
                'original_id' => 1,
                
                'author_id' => 1,
                'author_name' => 'test',
                
                'content'=>"translations $i",
                
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));        
            echo "Insert translations $i!";
            echo '<br />';
        }
        
        for ($i=1; $i<=5; $i++) {
            DB::table('activities')->insert(array(
                'series_id' => 1,
                
                'title' => "活动 $i",
                
                'organizer' => "活动组织者$i",
                
                
                'start_at' => date('Y-m-d H:i:s'),
                'end_at' => date('Y-m-d H:i:s'),
                
                'location' => "活动地点$i",
                'descr' => "活动 描述 $i",
                
                'sponsor_id' => 1,
                'sponsor_name' => 'test',
                
                'status' => 1,

                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));        
            echo "Insert test activity $i!";
            echo '<br />';
        }
        
        for ($i=1; $i<=5; $i++) {
            DB::table('activity_comments')->insert(array(
                'activity_id' => 1,
                
                'author_id' => 1,
                'author_name' => 'test',

                'content' => "activity $i comment comment  $i <br/> comment",
                
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));        
            echo "Insert test activity comment $i!";
            echo '<br />';
        }
        
        for ($i=1; $i<=3; $i++) {
            DB::table('series')->insert(array(
                'name' => "系列 $i",
                'pic' => "http://series_pic$i",
                'descr'=>"系列 描述 $i",
                
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));        
            echo "Insert series $i!";
            echo '<br />';
        }
        
        
        for ($i=1; $i<=5; $i++) {
            DB::table('tags')->insert(array(
                'tag' => "测试标签$i",

                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));        
            echo "Insert test tag $i!";
            echo '<br />';
        }
        
        
        DB::table('article_tag')->insert(array(
            'article_id' => 1,
            'tag_id' => 1,

            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));        
        echo "Insert test article_tag !";
        echo '<br />';
        
        DB::table('news_tag')->insert(array(
            'news_id' => 1,
            'tag_id' => 1,

            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));        
        echo "Insert test news_tag !";
        echo '<br />';
        
        DB::table('post_tag')->insert(array(
            'post_id' => 1,
            'tag_id' => 1,

            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));        
        echo "Insert test post_tag !";
        echo '<br />';
        
        DB::table('question_tag')->insert(array(
            'question_id' => 1,
            'tag_id' => 1,

            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));        
        echo "Insert test question_tag !";
        echo '<br />';
        
        DB::table('source_tag')->insert(array(
            'source_id' => 1,
            'tag_id' => 1,

            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));        
        echo "Insert test source_tag !";
        echo '<br />';
        
        
        for ($i=1; $i<=5; $i++) {
            DB::table('notices')->insert(array(
                'user_id' => 1,
                'content' => "test notice $i",

                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));        
            echo "Insert test notice $i!";
            echo '<br />';
        }
        
        for ($i=1; $i<=5; $i++) {
            DB::table('categories')->insert(array(
                
                'name' => "测试栏目$i",
                'descr' => "测试栏目$i 描述",

                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));        
            echo "Insert test category $i!";
            echo '<br />';
        }
        
    }
    
    
    

}