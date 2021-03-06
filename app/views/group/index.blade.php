@extends('layout')
@section('content')
<div class="row-fluid">
<div class="span8">
<legend>群组</legend>
    <div class="row-fluid">
    <?php 
        $group_count = count($groups);
    ?>
    <div class="span6">
        @for ($i = 0; $i < ceil($group_count/2); $i++)
        <div class="media group-list">
          <a class="pull-left" href="/group/{{ $groups[$i]->id }}">
            <img src="/img/test_group_pic.jpg">
          </a>
          <div class="media-body">
            <h4 class="media-heading"><a href="/group/{{ $groups[$i]->id }}">{{ e($groups[$i]->name) }}</a><small>{{ $groups[$i]->member_count }}人加入</small></h4>
            <p>{{ e($groups[$i]->descr) }}</p>
          </div>
        </div>
        @endfor
    </div>
    <div class="span6">
        @for ($i = ceil($group_count/2); $i < $group_count ; $i++)
        <div class="media group-list">
          <a class="pull-left" href="/group/{{ $groups[$i]->id }}">
            <img src="/img/test_group_pic.jpg">
          </a>
          <div class="media-body">
            <h4 class="media-heading"><a href="/group/{{ $groups[$i]->id }}">{{ e($groups[$i]->name) }}</a><small>{{ $groups[$i]->member_count }}人加入</small></h4>
            <p>{{ e($groups[$i]->descr) }}</p>
          </div>
        </div>
        @endfor
    </div>
    </div>
</div>

  <div class="span4 sidebar">
    <p>
    <a class="btn btn-large btn-block btn-primary" href="/group/apply">申请建立小组</a>
    </p>
    <div class="sidebar-plate">
        <legend>推荐小组</legend>
        <?php $groups = Group::orderBy('created_at', 'desc')->take(3)->get(); ?>
        @if(!$groups->isEmpty())
        <ul class="sidebar-ul unstyled">
            @foreach ($groups as $group)
            <li>
                <a class="pull-left" href="/group/{{$group->id}}"><img src="{{$group->pic}}" /></a>
                <div class="sidebar-ul-body">
                    <a href="/group/{{$group->id}}">{{e($group->name)}}</a><span>{{ $group->member_count }}人加入</span>
                    <p>{{ e(Str::limit($group->descr, 10)) }}</p>
                </div>
            </li>
            @endforeach
        </ul>
        @endif
    </div>
    <div class="sidebar-plate">
        <legend>热门标签</legend>
        <?php $tags = Tag::orderBy('refer_count', 'desc')->take(7)->get() ?>
        @if(!$tags->isEmpty())
        
            @foreach ($tags as $tag)
            <a href="{{ URL::route('tag_detail', array($tag->id)) }}"><span class="label label-inverse">{{ e($tag->tag) }}</span></a>
            @endforeach
        
        @endif
    </div>
    
    <div class="sidebar-plate">
        <legend>近期活动</legend>
        <ul class="sidebar-ul unstyled">
            <li>
                <div class="sidebar-ul-body">
                    <a href="">R沙龙</a><span>15人参加</span>
                    <p>本期R沙龙，主要内容是</p>
                </div>
            </li>
            <li>
                <div class="sidebar-ul-body">
                    <a href="">R沙龙</a><span>15人参加</span>
                    <p>本期R沙龙，主要内容是</p>
                </div>
            </li>
            <li>
                <div class="sidebar-ul-body">
                    <a href="">R沙龙</a><span>15人参加</span>
                    <p>本期R沙龙，主要内容是</p>
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
  </div>
</div>
@endsection