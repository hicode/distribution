<div class="sidebar-plate">
            <legend>热门标签</legend>
            <?php $tags = Tag::orderBy('refer_count', 'desc')->take(7)->get() ?>
            @if(!$tags->isEmpty())
            
                @foreach ($tags as $tag)
                <a href="{{ URL::route('tag_detail', array($tag->id)) }}"><span class="label label-inverse">{{ $tag->tag }}</span></a>
                @endforeach
            
            @endif
        </div>
        <div class="sidebar-plate">
            <legend>最新文章</legend>
            
            <ul class="sidebar-ul unstyled">
                <li>
                    <a class="pull-left" href="/group/"><img class="article" src="http://cos.name/wp-content/uploads/2013/05/6th-china-r-bj-500x332.jpg" /></a>
                    <div class="sidebar-ul-body">
                        <a href="">第六届中国R语言会议（北京）纪要</a>
                        <p>本届R会议，主要内容是</p>
                    </div>
                </li>
                <li>
                    
                    <div class="sidebar-ul-body">
                        <a href="">第六届中国R语言会议（北京）纪要</a>
                        <p>本届R会议，主要内容是</p>
                    </div>
                </li>
                <li>
                    
                    <div class="sidebar-ul-body">
                        <a href="">第六届中国R语言会议（北京）纪要</a>
                        <p>本届R会议，主要内容是</p>
                    </div>
                </li>
            </ul>
        </div>
      
        <div class="sidebar-plate">
            <legend>友情链接</legend>
            <ul class="sidebar-ul">
                <li>
                    <div class="sidebar-ul-body">
                        <a href="" target="_blank">厦门大学数据挖掘研究中心</a>
                    </div>
                </li>
                <li>
                    <div class="sidebar-ul-body">
                        <a href="" target="_blank">厦门大学数据挖掘研究中心</a>
                    </div>
                </li>
                <li>
                    <div class="sidebar-ul-body">
                        <a href="" target="_blank">厦门大学数据挖掘研究中心</a>
                    </div>
                </li>
            </ul>
        </div>