<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta charset="utf-8">
  <title>
  Patabugen / WYMEditor Plugins 
  / source  / plugins / image_float / jquery.wymeditor.image_float.js
 &mdash; Bitbucket
</title>
  <link rel="icon" type="image/png" href="https://d3oaxc4q5k2d6q.cloudfront.net/m/7689068cb84b/img/favicon.png">
  <meta id="bb-canon-url" name="bb-canon-url" content="https://bitbucket.org">
  
  
<link rel="stylesheet" href="https://d3oaxc4q5k2d6q.cloudfront.net/m/7689068cb84b/compressed/css/3f1c1224c6cd.css" type="text/css" />
<link rel="stylesheet" href="https://d3oaxc4q5k2d6q.cloudfront.net/m/7689068cb84b/compressed/css/1177b451c4a1.css" type="text/css" />

  <!--[if lt IE 9]><link rel="stylesheet" href="https://d3oaxc4q5k2d6q.cloudfront.net/m/7689068cb84b/css/aui/aui-ie.css" media="all"><![endif]-->
  <!--[if IE 9]><link rel="stylesheet" href="https://d3oaxc4q5k2d6q.cloudfront.net/m/7689068cb84b/css/aui/aui-ie9.css" media="all"><![endif]-->
  <!--[if IE]><link rel="stylesheet" href="https://d3oaxc4q5k2d6q.cloudfront.net/m/7689068cb84b/css/aui-overrides-ie.css" media="all"><![endif]-->
  <meta name="description" content=""/>
  <link rel="search" type="application/opensearchdescription+xml" href="/opensearch.xml" title="Bitbucket" />
  
  <link href="/Patabugen/wymeditor-plugins/rss" rel="alternate nofollow" type="application/rss+xml" title="RSS feed for WYMEditor Plugins" />

<script type="text/javascript">var NREUMQ=NREUMQ||[];NREUMQ.push(["mark","firstbyte",new Date().getTime()]);</script></head>
<body class="production "
      >
<script type="text/javascript" src="https://d3oaxc4q5k2d6q.cloudfront.net/m/7689068cb84b/compressed/js/e98deabf8a2e.js"></script>
<div id="page">
  <div id="wrapper">
    
    <header id="header" role="banner">
      
        
      
      <nav class="aui-header aui-dropdown2-trigger-group" role="navigation">
        <div class="aui-header-inner">
          <div class="aui-header-primary">
            <h1 class="aui-header-logo aui-header-logo-bitbucket">
              <a href="/" class="aui-nav-imagelink" id="logo-link">
                <span class="aui-header-logo-device">Bitbucket</span>
              </a>
            </h1>
            
            <script id="repo-dropdown-template" type="text/html">
  

[[#hasViewed]]
  <div class="aui-dropdown2-section">
    <strong class="viewed">Recently viewed</strong>
    <ul class="aui-list-truncate">
      [[#viewed]]
        <li class="[[#is_private]]private[[/is_private]][[^is_private]]public[[/is_private]] repository">
          <a href="[[url]]" title="[[owner]]/[[name]]" class=" aui-icon-container">
            <img class="repo-avatar size16" src="[[{avatar}]]" alt="[[owner]]/[[name]] avatar"/>
            [[owner]] / [[name]]
          </a>
        </li>
      [[/viewed]]
    </ul>
  </div>
[[/hasViewed]]
[[#hasUpdated]]
<div class="aui-dropdown2-section">
  <strong class="updated">Recently updated</strong>
  <ul class="aui-list-truncate">
    [[#updated]]
    <li class="[[#is_private]]private[[/is_private]][[^is_private]]public[[/is_private]] repository">
      <a href="[[url]]" title="[[owner]]/[[name]]" class=" aui-icon-container">
        <img class="repo-avatar size16" src="[[{avatar}]]" alt="[[owner]]/[[name]] avatar"/>
        [[owner]] / [[name]]
      </a>
    </li>
    [[/updated]]
  </ul>
</div>
[[/hasUpdated]]

</script>
            <ul role="menu" class="aui-nav">
              
                <li>
                  <a href="/plans">
                      Pricing &amp; signup
                  </a>
                </li>
                <li>
                  <a href="/whats-new">
                    What's new
                  </a>
                </li>
              
            </ul>
            
          </div>
          <div class="aui-header-secondary">
            
            <ul role="menu" class="aui-nav">
              <li>
                <form action="/repo/all" method="get" class="aui-quicksearch">
                  <label for="search-query" class="assistive">owner/repository</label>
                  <input id="search-query" class="search" type="text" placeholder="owner/repository" name="name">
                </form>
              </li>
              <li>
                <a class="aui-dropdown2-trigger"aria-controls="header-help-dropdown" aria-owns="header-help-dropdown"
                   aria-haspopup="true" data-container="#header .aui-header-inner" href="#header-help-dropdown">
                  <span class="aui-icon aui-icon-small aui-iconfont-help">Help</span><span class="aui-icon-dropdown"></span>
                </a>
                <nav id="header-help-dropdown" class="aui-dropdown2 aui-style-default aui-dropdown2-in-header" aria-hidden="true">
                  <div class="aui-dropdown2-section">
                    <ul>
                      <li>
                        <a href="/whats-new" id="features-link">
                          What's new
                        </a>
                      </li>
                    </ul>
                  </div>
                  <div class="aui-dropdown2-section">
                    <ul>
                      <li>
                        <a class="support-ga"
                           data-support-gaq-page="DocumentationHome"
                           href="https://confluence.atlassian.com/display/BITBUCKET/bitbucket+Documentation+Home"
                           target="_blank">
                          Documentation
                        </a>
                      </li>
                      <li>
                        <a class="support-ga"
                           data-support-gaq-page="Documentation101"
                           href="https://confluence.atlassian.com/display/BITBUCKET/bitbucket+101"
                           target="_blank">
                          Bitbucket 101
                        </a>
                      </li>
                      <li>
                        <a class="support-ga"
                           data-support-gaq-page="DocumentationKB"
                           href="https://confluence.atlassian.com/display/BBKB/Bitbucket+Knowledge+Base+Home"
                           target="_blank">
                          Knowledge base
                        </a>
                      </li>
                    </ul>
                  </div>
                  <div class="aui-dropdown2-section">
                    <ul>
                      <li>
                        <a class="support-ga"
                           data-support-gaq-page="Answers"
                           href="https://answers.atlassian.com/tags/bitbucket/"
                           target="_blank">
                          Bitbucket on Atlassian Answers
                        </a>
                      </li>
                      <li>
                        <a class="support-ga"
                           data-support-gaq-page="Home"
                           href="/support">
                        Support
                      </a>
                      </li>
                    </ul>
                  </div>
                </nav>
              </li>
                
                  
                
              
                  <li>
                    <a class="aui-button aui-button-primary aui-style" href="/account/signup/">
                      Sign up
                    </a>
                  </li>
                <li id="user-options">
                  <a href="/account/signin/?next=/Patabugen/wymeditor-plugins/src/cd2ef9496458/plugins/image_float/jquery.wymeditor.image_float.js%3Fat%3Dmaster" class="aui-nav-link login-link">Log in</a>
                </li>
              
            </ul>
            
          </div>
        </div>
      </nav>
    </header>
      <header id="account-warning" role="banner"
              class="aui-message-banner warning ">
        <div class="center-content">
          <span class="aui-icon aui-icon-warning"></span>
          <span class="message">
            
          </span>
        </div>
      </header>
    
      <header id="aui-message-bar">
        
      </header>
    
    
  <header id="repo-warning" role="banner" class="aui-message-banner warning">
    <div class="center-content">
      <span class="aui-icon aui-icon-warning"></span>
      <span class="message">
      </span>
    </div>
  </header>
  <script id="repo-warning-template" type="text/html">
  




  This repository's ownership is pending transfer to <a href="/[[username]]">[[username]]</a>.
  Visit the <a href="/Patabugen/wymeditor-plugins/admin/transfer">transfer repository page</a> to view more details.


</script>
  <header id="repo-header" class="subhead row">
    <div class="center-content">
      <div class="repo-summary with-repo-watch">
        <a class="repo-avatar-link" href="/Patabugen/wymeditor-plugins">
          <span class="repo-avatar-container size64" title="Patabugen/WYMEditor Plugins">
  <img alt="Patabugen/WYMEditor Plugins" src="https://d3oaxc4q5k2d6q.cloudfront.net/m/7689068cb84b/img/language-avatars/js_64.png">
</span>

          
        </a>
        <h1><a class="repo-link" href="/Patabugen/wymeditor-plugins">WYMEditor Plugins</a></h1>
        <ul class="repo-metadata clearfix">
          <li>
            <a class="user" href="/Patabugen">
              <span class="icon user">User icon</span>
              <span>Patabugen</span>
            </a>
          </li>
          
          
          
        </ul>
      </div>
      <div id="repo-toolbar" class="bb-toolbar">
        
        <div class="aui-buttons">
          <a id="repo-clone-button" class="aui-button aui-style" href="https://bitbucket.org/Patabugen/wymeditor-plugins.git">
            <span class="icon clone">Clone icon</span>
            <span>Clone</span>
            <span class="aui-icon-dropdown"></span>
          </a>
          <a id="fork-button" class="aui-button aui-style"
             href="/Patabugen/wymeditor-plugins/fork">
            <span class="icon fork">Fork icon</span>
            <span>Fork</span>
          </a>
        </div>
        <div class="aui-buttons">
          <a id="compare-button" class="aui-button aui-style"
             href="/Patabugen/wymeditor-plugins/compare">
            <span class="icon compare">Compare icon</span>
            <span>Compare</span>
          </a>
          <a id="pull-request-button" class="aui-button aui-style"
             href="/Patabugen/wymeditor-plugins/pull-request/new">
            <span class="icon pull-request">Pull request icon</span>
            <span>Pull request</span>
          </a>
        </div>
        
        
        

<div id="repo-clone-dialog" class="clone-dialog hidden">
  
<div class="clone-url">
  <div class="aui-buttons">
    <a href="https://bitbucket.org/Patabugen/wymeditor-plugins.git"
       class="aui-button aui-style aui-dropdown2-trigger" aria-haspopup="true"
       aria-owns="clone-url-dropdown-header">
      <span class="dropdown-text">HTTPS</span>
    </a>
    <div id="clone-url-dropdown-header" class="aui-dropdown2 aui-style-default">
      <ul class="aui-list-truncate">
        <li>
          <a href="https://bitbucket.org/Patabugen/wymeditor-plugins.git"
            
              data-command="git clone https://bitbucket.org/Patabugen/wymeditor-plugins.git"
            
            class="item-link https">HTTPS
          </a>
        </li>
        <li>
          <a href="ssh://git@bitbucket.org/Patabugen/wymeditor-plugins.git"
            
              data-command="git clone git@bitbucket.org:Patabugen/wymeditor-plugins.git"
            
            class="item-link ssh">SSH
          </a>
        </li>
      </ul>
    </div>
    <input type="text" readonly="readonly" value="git clone https://bitbucket.org/Patabugen/wymeditor-plugins.git">
  </div>
  
  <p>Need help cloning? Visit
     <a href="https://confluence.atlassian.com/x/cgozDQ" target="_blank">Bitbucket 101</a>.</p>
  
</div>


  
  
  

<div class="clone-in-sourcetree sourcetree-windows"
  data-https-url="https://bitbucket.org/Patabugen/wymeditor-plugins.git"
  data-ssh-url="ssh://git@bitbucket.org/Patabugen/wymeditor-plugins.git">
  <p><button class="aui-button aui-style aui-button-primary">Clone in SourceTree</button></p>


  <p class="windows-text">
      
        <a href="http://www.sourcetreeapp.com" target="_blank">SourceTree</a>
        is a free Windows client by Atlassian for Git and Subversion.
      
  </p>
  <p class="mac-text">
      
        <a href="http://www.sourcetreeapp.com" target="_blank">SourceTree</a>
        is a free Mac client by Atlassian for Git, Mercurial, and Subversion.
      
  </p>
</div>

  
</div>

      </div>
    </div>
    <div class="clearfix"></div>
  </header>
  <nav id="repo-tabs" class="aui-navgroup aui-navgroup-horizontal aui-navgroup-horizontal-roomy">
    <div class="aui-navgroup-inner">
      <div class="aui-navgroup-primary">
        <ul class="aui-nav">
          
            <li>
              <a href="/Patabugen/wymeditor-plugins/overview" id="repo-overview-link">Overview</a>
            </li>
          
          
            <li class="aui-nav-selected">
              <a href="/Patabugen/wymeditor-plugins/src" id="repo-source-link">Source</a>
            </li>
          
          
            <li>
              <a href="/Patabugen/wymeditor-plugins/commits" id="repo-commits-link">
                Commits
              </a>
            </li>
          
          
            <li>
              <a href="/Patabugen/wymeditor-plugins/pull-requests" id="repo-pullrequests-link">
                Pull requests
                
                  
                
              </a>
            </li>
          
          
            
          
            <li id="issues-tab" class="
              
                
              
            ">
              <a href="/Patabugen/wymeditor-plugins/issues?status=new&amp;status=open" id="repo-issues-link">
                Issues
                
                  
                
              </a>
            </li>
            <li id="wiki-tab" class="
                
                  
                
              ">
              <a href="/Patabugen/wymeditor-plugins/wiki" id="repo-wiki-link">Wiki</a>
            </li>
          
            <li>
            <a href="/Patabugen/wymeditor-plugins/downloads" id="repo-downloads-link">
              Downloads
              
                
              
            </a>
            </li>
          
        </ul>
      </div>
      <div class="aui-navgroup-secondary">
        <ul class="aui-nav">
          
        </ul>
      </div>
    </div>
  </nav>

    <div id="content" role="main">
      
  <div id="repo-content">
    
  <div id="source-container">
    



<header id="source-path">
  
  <div class="labels labels-csv">
    
      <div class="aui-buttons">
        <button data-branches-tags-url="/api/1.0/repositories/Patabugen/wymeditor-plugins/branches-tags"
                class="aui-button aui-style branch-dialog-trigger" title="master">
          
            
              <span class="branch icon">Branch</span>
            
            <span class="name">master</span>
          
          <span class="aui-icon-dropdown"></span>
        </button>
      </div>
    
  </div>
  
  
    <div class="view-switcher">
      <div class="aui-buttons">
        
          <a href="/Patabugen/wymeditor-plugins/src/cd2ef9496458/plugins/image_float/jquery.wymeditor.image_float.js?at=master"
             class="aui-button aui-style pjax-trigger" aria-pressed="true">
            Source
          </a>
          <a href="/Patabugen/wymeditor-plugins/diff/plugins/image_float/jquery.wymeditor.image_float.js?diff2=cd2ef9496458&at=master"
             class="aui-button aui-style pjax-trigger"
             title="Diff to previous change">
            Diff
          </a>
          <a href="/Patabugen/wymeditor-plugins/history-node/cd2ef9496458/plugins/image_float/jquery.wymeditor.image_float.js?at=master"
             class="aui-button aui-style pjax-trigger">
            History
          </a>
        
      </div>
    </div>
  
  <h1>
    <a href="/Patabugen/wymeditor-plugins/src/cd2ef9496458?at=master"
       class="pjax-trigger" title="Patabugen/wymeditor-plugins at cd2ef9496458">WYMEditor Plugins</a> /
    
      
        
          
            <a href="/Patabugen/wymeditor-plugins/src/cd2ef9496458/plugins?at=master"
               class="pjax-trigger">plugins</a> /
          
        
      
    
      
        
          
            <a href="/Patabugen/wymeditor-plugins/src/cd2ef9496458/plugins/image_float?at=master"
               class="pjax-trigger">image_float</a> /
          
        
      
    
      
        
          <span>jquery.wymeditor.image_float.js</span>
        
      
    
  </h1>
  
    
    
  
  <div class="clearfix"></div>
</header>


  
    <div id="editor-container" class="maskable"
         data-owner="Patabugen"
         data-slug="wymeditor-plugins"
         data-is-writer="false"
         data-hash="cd2ef9496458a7014118f72bf9826fbaf05a04b9"
         data-branch="master"
         data-path="plugins/image_float/jquery.wymeditor.image_float.js"
         data-source-url="/api/2.0/repositories/Patabugen/wymeditor-plugins/src/cd2ef9496458a7014118f72bf9826fbaf05a04b9/plugins/image_float/jquery.wymeditor.image_float.js">
      <div id="source-view">
        <div class="toolbar">
          <div class="primary">
            <div class="aui-buttons">
              
                <button id="file-history-trigger" class="aui-button aui-style changeset-info"
                        data-changeset="cd2ef9496458a7014118f72bf9826fbaf05a04b9"
                        data-path="plugins/image_float/jquery.wymeditor.image_float.js"
                        data-current="cd2ef9496458a7014118f72bf9826fbaf05a04b9">
                  
                     

<img class="avatar avatar16" src="https://secure.gravatar.com/avatar/6d0920efade7a0cf9856e3ffab021963?d=https%3A%2F%2Fd3oaxc4q5k2d6q.cloudfront.net%2Fm%2F7689068cb84b%2Fimg%2Fdefault_avatar%2F16%2Fuser_blue.png&amp;s=16" alt="Sami Greenbury avatar" />
<span class="changeset-hash">cd2ef94</span>
<time datetime="2013-04-07T15:12:56+00:00" class="timestamp"></time>
<span class="aui-icon-dropdown"></span>

                  
                </button>
              
            </div>
          <a href="/Patabugen/wymeditor-plugins/full-commit/cd2ef9496458/plugins/image_float/jquery.wymeditor.image_float.js" id="full-commit-link"
              title="View full commit cd2ef94">Full commit</a>
          </div>
            <div class="secondary">
              <div class="aui-buttons">
                
                  <a href="/Patabugen/wymeditor-plugins/annotate/cd2ef9496458a7014118f72bf9826fbaf05a04b9/plugins/image_float/jquery.wymeditor.image_float.js?at=master"
                  class="aui-button aui-style pjax-trigger">Blame</a>
                
                
                  
                  <a id="embed-link" href="https://bitbucket.org/Patabugen/wymeditor-plugins/src/cd2ef9496458a7014118f72bf9826fbaf05a04b9/plugins/image_float/jquery.wymeditor.image_float.js?embed=t"
                    class="aui-button aui-style">Embed</a>
                
                <a href="/Patabugen/wymeditor-plugins/raw/cd2ef9496458a7014118f72bf9826fbaf05a04b9/plugins/image_float/jquery.wymeditor.image_float.js"
                  class="aui-button aui-style">Raw</a>
              </div>
              
                
              
            </div>
          <div class="clearfix"></div>
        </div>

        
          
            
              
                <div class="file-source">
                  <table class="highlighttable"><tr><td class="linenos"><div class="linenodiv"><pre><a href="#cl-1"> 1</a>
<a href="#cl-2"> 2</a>
<a href="#cl-3"> 3</a>
<a href="#cl-4"> 4</a>
<a href="#cl-5"> 5</a>
<a href="#cl-6"> 6</a>
<a href="#cl-7"> 7</a>
<a href="#cl-8"> 8</a>
<a href="#cl-9"> 9</a>
<a href="#cl-10">10</a>
<a href="#cl-11">11</a>
<a href="#cl-12">12</a>
<a href="#cl-13">13</a>
<a href="#cl-14">14</a>
<a href="#cl-15">15</a>
<a href="#cl-16">16</a>
<a href="#cl-17">17</a>
<a href="#cl-18">18</a>
<a href="#cl-19">19</a>
<a href="#cl-20">20</a>
<a href="#cl-21">21</a>
<a href="#cl-22">22</a>
<a href="#cl-23">23</a>
<a href="#cl-24">24</a>
<a href="#cl-25">25</a>
<a href="#cl-26">26</a>
<a href="#cl-27">27</a>
<a href="#cl-28">28</a>
<a href="#cl-29">29</a>
<a href="#cl-30">30</a>
<a href="#cl-31">31</a>
<a href="#cl-32">32</a>
<a href="#cl-33">33</a>
<a href="#cl-34">34</a>
<a href="#cl-35">35</a>
<a href="#cl-36">36</a>
<a href="#cl-37">37</a>
<a href="#cl-38">38</a>
<a href="#cl-39">39</a>
<a href="#cl-40">40</a>
<a href="#cl-41">41</a>
<a href="#cl-42">42</a>
<a href="#cl-43">43</a>
<a href="#cl-44">44</a>
<a href="#cl-45">45</a>
<a href="#cl-46">46</a>
<a href="#cl-47">47</a>
<a href="#cl-48">48</a>
<a href="#cl-49">49</a>
<a href="#cl-50">50</a>
<a href="#cl-51">51</a>
<a href="#cl-52">52</a>
<a href="#cl-53">53</a>
<a href="#cl-54">54</a>
<a href="#cl-55">55</a>
<a href="#cl-56">56</a>
<a href="#cl-57">57</a>
<a href="#cl-58">58</a>
<a href="#cl-59">59</a>
<a href="#cl-60">60</a>
<a href="#cl-61">61</a>
<a href="#cl-62">62</a>
<a href="#cl-63">63</a>
<a href="#cl-64">64</a>
<a href="#cl-65">65</a>
<a href="#cl-66">66</a>
<a href="#cl-67">67</a>
<a href="#cl-68">68</a>
<a href="#cl-69">69</a>
<a href="#cl-70">70</a>
<a href="#cl-71">71</a></pre></div></td><td class="code"><div class="highlight"><pre><a name="cl-1"></a><span class="cm">/*jslint evil: true */</span>
<a name="cl-2"></a><span class="cm">/**</span>
<a name="cl-3"></a><span class="cm">    WYMeditor.image_float</span>
<a name="cl-4"></a><span class="cm">    ====================</span>
<a name="cl-5"></a>
<a name="cl-6"></a><span class="cm">    A plugin to add a class to an image which can be used to set its float</span>
<a name="cl-7"></a><span class="cm">        </span>
<a name="cl-8"></a><span class="cm">        by Patabugen ( patabugen.co.uk )</span>
<a name="cl-9"></a><span class="cm">*/</span>
<a name="cl-10"></a>
<a name="cl-11"></a><span class="nx">WYMeditor</span><span class="p">.</span><span class="nx">editor</span><span class="p">.</span><span class="nx">prototype</span><span class="p">.</span><span class="nx">image_float</span> <span class="o">=</span> <span class="kd">function</span> <span class="p">()</span> <span class="p">{</span>
<a name="cl-12"></a>    <span class="kd">var</span> <span class="nx">wym</span> <span class="o">=</span> <span class="k">this</span><span class="p">,</span>
<a name="cl-13"></a>                <span class="nv">$box</span> <span class="o">=</span> <span class="nx">jQuery</span><span class="p">(</span><span class="k">this</span><span class="p">.</span><span class="nx">_box</span><span class="p">);</span>
<a name="cl-14"></a>                
<a name="cl-15"></a>        <span class="nx">options</span> <span class="o">=</span> <span class="p">{</span>
<a name="cl-16"></a>                
<a name="cl-17"></a>        <span class="p">}</span>
<a name="cl-18"></a>
<a name="cl-19"></a>        <span class="c1">//construct the buttons&#39; html</span>
<a name="cl-20"></a>    <span class="kd">var</span> <span class="nx">button_left</span> <span class="o">=</span> <span class="nb">String</span><span class="p">()</span> <span class="o">+</span>
<a name="cl-21"></a>        <span class="s2">&quot;&lt;li class=&#39;wym_tools_image_float_left&#39;&gt;&quot;</span> <span class="o">+</span>
<a name="cl-22"></a>            <span class="s2">&quot;&lt;a name=&#39;FloatLeft&#39; href=&#39;#&#39; &quot;</span> <span class="o">+</span>
<a name="cl-23"></a>                <span class="s2">&quot;style=&#39;background-image: url(&quot;</span> <span class="o">+</span>
<a name="cl-24"></a>                    <span class="nx">wym</span><span class="p">.</span><span class="nx">_options</span><span class="p">.</span><span class="nx">basePath</span> <span class="o">+</span>
<a name="cl-25"></a>                    <span class="s2">&quot;plugins/image_float/icons.png)&#39;&gt;&quot;</span> <span class="o">+</span>
<a name="cl-26"></a>                <span class="s2">&quot;{left}&quot;</span> <span class="o">+</span>
<a name="cl-27"></a>            <span class="s2">&quot;&lt;/a&gt;&quot;</span> <span class="o">+</span>
<a name="cl-28"></a>        <span class="s2">&quot;&lt;/li&gt;&quot;</span><span class="p">;</span>
<a name="cl-29"></a>    <span class="kd">var</span> <span class="nx">button_right</span> <span class="o">=</span> <span class="nb">String</span><span class="p">()</span> <span class="o">+</span>
<a name="cl-30"></a>        <span class="s2">&quot;&lt;li class=&#39;wym_tools_image_float_right&#39;&gt;&quot;</span> <span class="o">+</span>
<a name="cl-31"></a>            <span class="s2">&quot;&lt;a name=&#39;FloatRight&#39; href=&#39;#&#39; &quot;</span> <span class="o">+</span>
<a name="cl-32"></a>                <span class="s2">&quot;style=&#39;background-image: url(&quot;</span> <span class="o">+</span>
<a name="cl-33"></a>                    <span class="nx">wym</span><span class="p">.</span><span class="nx">_options</span><span class="p">.</span><span class="nx">basePath</span> <span class="o">+</span>
<a name="cl-34"></a>                    <span class="s2">&quot;plugins/image_float/icons.png); background-position: 0px -24px&#39;&gt;&quot;</span> <span class="o">+</span>
<a name="cl-35"></a>                <span class="s2">&quot;{right}&quot;</span> <span class="o">+</span>
<a name="cl-36"></a>            <span class="s2">&quot;&lt;/a&gt;&quot;</span> <span class="o">+</span>
<a name="cl-37"></a>        <span class="s2">&quot;&lt;/li&gt;&quot;</span><span class="p">;</span>
<a name="cl-38"></a>    <span class="kd">var</span> <span class="nx">button_none</span> <span class="o">=</span> <span class="nb">String</span><span class="p">()</span> <span class="o">+</span>
<a name="cl-39"></a>        <span class="s2">&quot;&lt;li class=&#39;wym_tools_image_float_none&#39;&gt;&quot;</span> <span class="o">+</span>
<a name="cl-40"></a>            <span class="s2">&quot;&lt;a name=&#39;FloatNone&#39; href=&#39;#&#39; &quot;</span> <span class="o">+</span>
<a name="cl-41"></a>                <span class="s2">&quot;style=&#39;background-image: url(&quot;</span> <span class="o">+</span>
<a name="cl-42"></a>                    <span class="nx">wym</span><span class="p">.</span><span class="nx">_options</span><span class="p">.</span><span class="nx">basePath</span> <span class="o">+</span>
<a name="cl-43"></a>                    <span class="s2">&quot;plugins/image_float/icons.png); background-position: 0px -48px&#39;&gt;&quot;</span> <span class="o">+</span>
<a name="cl-44"></a>                <span class="s2">&quot;{none}&quot;</span> <span class="o">+</span>
<a name="cl-45"></a>            <span class="s2">&quot;&lt;/a&gt;&quot;</span> <span class="o">+</span>
<a name="cl-46"></a>        <span class="s2">&quot;&lt;/li&gt;&quot;</span><span class="p">;</span>
<a name="cl-47"></a>                
<a name="cl-48"></a>        <span class="kd">var</span> <span class="nx">html</span> <span class="o">=</span> <span class="nx">button_left</span> <span class="o">+</span> <span class="nx">button_right</span> <span class="o">+</span> <span class="nx">button_none</span><span class="p">;</span>
<a name="cl-49"></a>    <span class="c1">//add the button to the tools box</span>
<a name="cl-50"></a>    <span class="nv">$box.find</span><span class="p">(</span><span class="nx">wym</span><span class="p">.</span><span class="nx">_options</span><span class="p">.</span><span class="nx">toolsSelector</span> <span class="o">+</span> <span class="nx">wym</span><span class="p">.</span><span class="nx">_options</span><span class="p">.</span><span class="nx">toolsListSelector</span><span class="p">)</span>
<a name="cl-51"></a>        <span class="p">.</span><span class="nx">append</span><span class="p">(</span><span class="nx">html</span><span class="p">);</span>
<a name="cl-52"></a>                
<a name="cl-53"></a>    <span class="nv">$box.find</span><span class="p">(</span><span class="s1">&#39;li.wym_tools_image_float_left a&#39;</span><span class="p">).</span><span class="nx">click</span><span class="p">(</span><span class="kd">function</span><span class="p">()</span> <span class="p">{</span>
<a name="cl-54"></a>                <span class="kd">var</span> <span class="nx">container</span> <span class="o">=</span> <span class="nx">wym</span><span class="p">.</span><span class="nx">container</span><span class="p">();</span>
<a name="cl-55"></a>                <span class="nx">$</span><span class="p">(</span><span class="nx">container</span><span class="p">).</span><span class="nx">find</span><span class="p">(</span><span class="s1">&#39;img&#39;</span><span class="p">).</span><span class="nx">removeClass</span><span class="p">(</span><span class="s1">&#39;float_left float_right&#39;</span><span class="p">);</span>
<a name="cl-56"></a>                <span class="nx">$</span><span class="p">(</span><span class="nx">container</span><span class="p">).</span><span class="nx">find</span><span class="p">(</span><span class="s1">&#39;img&#39;</span><span class="p">).</span><span class="nx">addClass</span><span class="p">(</span><span class="s1">&#39;float_left&#39;</span><span class="p">);</span>
<a name="cl-57"></a>                <span class="k">return</span> <span class="kc">false</span><span class="p">;</span>
<a name="cl-58"></a>        <span class="p">});</span>
<a name="cl-59"></a>    <span class="nv">$box.find</span><span class="p">(</span><span class="s1">&#39;li.wym_tools_image_float_right a&#39;</span><span class="p">).</span><span class="nx">click</span><span class="p">(</span><span class="kd">function</span><span class="p">()</span> <span class="p">{</span>
<a name="cl-60"></a>                <span class="kd">var</span> <span class="nx">container</span> <span class="o">=</span> <span class="nx">wym</span><span class="p">.</span><span class="nx">container</span><span class="p">();</span>
<a name="cl-61"></a>                <span class="nx">$</span><span class="p">(</span><span class="nx">container</span><span class="p">).</span><span class="nx">find</span><span class="p">(</span><span class="s1">&#39;img&#39;</span><span class="p">).</span><span class="nx">removeClass</span><span class="p">(</span><span class="s1">&#39;float_left float_right&#39;</span><span class="p">);</span>
<a name="cl-62"></a>                <span class="nx">$</span><span class="p">(</span><span class="nx">container</span><span class="p">).</span><span class="nx">find</span><span class="p">(</span><span class="s1">&#39;img&#39;</span><span class="p">).</span><span class="nx">addClass</span><span class="p">(</span><span class="s1">&#39;float_right&#39;</span><span class="p">);</span>
<a name="cl-63"></a>                <span class="k">return</span> <span class="kc">false</span><span class="p">;</span>
<a name="cl-64"></a>        <span class="p">});</span>
<a name="cl-65"></a>    <span class="nv">$box.find</span><span class="p">(</span><span class="s1">&#39;li.wym_tools_image_float_none a&#39;</span><span class="p">).</span><span class="nx">click</span><span class="p">(</span><span class="kd">function</span><span class="p">()</span> <span class="p">{</span>
<a name="cl-66"></a>                <span class="kd">var</span> <span class="nx">container</span> <span class="o">=</span> <span class="nx">wym</span><span class="p">.</span><span class="nx">container</span><span class="p">();</span>
<a name="cl-67"></a>                <span class="c1">// Here we just remove the classes</span>
<a name="cl-68"></a>                <span class="nx">$</span><span class="p">(</span><span class="nx">container</span><span class="p">).</span><span class="nx">find</span><span class="p">(</span><span class="s1">&#39;img&#39;</span><span class="p">).</span><span class="nx">removeClass</span><span class="p">(</span><span class="s1">&#39;float_left float_right&#39;</span><span class="p">);</span>
<a name="cl-69"></a>                <span class="k">return</span> <span class="kc">false</span><span class="p">;</span>
<a name="cl-70"></a>        <span class="p">});</span>
<a name="cl-71"></a><span class="p">};</span>
</pre></div>
</td></tr></table>
                </div>
              
            
          
        
      </div>
    </div>
  


  <script id="source-changeset" type="text/html">
  

<a href="/Patabugen/wymeditor-plugins/src/[[raw_node]]/plugins/image_float/jquery.wymeditor.image_float.js?at=master"
   class="[[#selected]]highlight[[/selected]]"
   data-hash="[[node]]">
  [[#author.username]]
    <img class="avatar avatar16" src="[[author.avatar]]"/>
    <span class="author" title="[[raw_author]]">[[author.display_name]]</span>
  [[/author.username]]
  [[^author.username]]
    <img class="avatar avatar16" src="https://d3oaxc4q5k2d6q.cloudfront.net/m/7689068cb84b/img/default_avatar/16/user_blue.png"/>
    <span class="author unmapped" title="[[raw_author]]">[[author]]</span>
  [[/author.username]]
  <time datetime="[[utctimestamp]]" data-title="true">[[utctimestamp]]</time>
  <span class="message">[[message]]</span>
</a>

</script>
  <script id="embed-template" type="text/html">
  

<form class="aui embed">
  <label for="embed-code">Embed this source in another page:</label>
  <input type="text" readonly="true" value="&lt;script src=&quot;[[url]]&quot;&gt;&lt;/script&gt;" id="embed-code">
</form>

</script>
  <script id="edit-form-template" type="text/html">
  


<form class="edit-form aui"
      data-repository="[[owner]]/[[slug]]"
      data-destination-repository="[[destinationOwner]]/[[destinationSlug]]"
      data-local-id="[[localID]]"
      data-is-writer="[[#isWriter]]true[[/isWriter]][[^isWriter]]false[[/isWriter]]"
      data-is-pull-request="[[#isPullRequest]]true[[/isPullRequest]][[^isPullRequest]]false[[/isPullRequest]]"
      data-hash="[[hash]]"
      data-branch="[[branch]]"
      data-path="[[path]]"
      data-preview-url="/xhr/[[owner]]/[[slug]]/preview/[[hash]]/[[encodedPath]]"
      data-preview-error="We had trouble generating your preview."
      data-unsaved-changes-error="Your changes will be lost. Are you sure you want to leave?">
  <div class="toolbar clearfix">
    <div class="primary">
      <h2>
        
          Editing <strong>[[path]]</strong> on branch: <strong>[[branch]]</strong>
        
      </h2>
    </div>
    <div class="secondary">
      <div class="hunk-nav aui-buttons">
        <button class="prev-hunk-button aui-button aui-button aui-style"
              disabled="disabled" aria-disabled="true" title="previous change">&#x25B2;</button>
        <button class="next-hunk-button aui-button aui-button aui-style"
              disabled="disabled" aria-disabled="true" title="next change">&#x25BC;</button>
      </div>
    </div>
  </div>
  <div class="file-editor">
    <textarea id="id_source">[[content]]</textarea>
  </div>
  <div class="preview-pane"></div>
  <div class="toolbar footer-toolbar clearfix">
    <div class="primary">
      <div id="syntax-mode" class="field">
        <label for="id_syntax-mode">Syntax mode:</label>
        <select id="id_syntax-mode">
          [[#syntaxes]]
            <option value="[[#mime]][[mime]][[/mime]][[^mime]][[mode]][[/mime]]">[[label]]</option>
          [[/syntaxes]]
        </select>
      </div>
      <div id="indent-mode" class="field">
        <label for="id_indent-mode">Indent mode:</label>
        <select id="id_indent-mode">
          <option value="tabs">Tabs</option>
          <option value="spaces">Spaces</option>
        </select>
      </div>
      <div id="indent-size" class="field">
        <label for="id_indent-size">Indent size:</label>
        <select id="id_indent-size">
          <option value="2">2</option>
          <option value="4">4</option>
          <option value="8">8</option>
        </select>
      </div>
    </div>
    <div class="secondary">
      <button class="preview-button aui-button aui-style"
              disabled="disabled" aria-disabled="true"
              data-preview-label="View diff"
              data-edit-label="Edit file">View diff</button>
      <button class="save-button aui-button aui-button-primary aui-style"
              disabled="disabled" aria-disabled="true">Commit</button>
      <a class="cancel-link" href="#">Cancel</a>
    </div>
  </div>
</form>

</script>
  <script id="commit-form-template" type="text/html">
  

<form class="aui commit-form"
      data-title="Commit changes"
      data-default-message="[[filename]] edited online with Bitbucket"
      data-fork-error="We had trouble creating your fork."
      data-commit-error="We had trouble committing your changes."
      data-pull-request-error="We had trouble creating your pull request."
      data-update-error="We had trouble updating your pull request."
      data-branch-conflict-error="A branch with that name already exists."
      data-forking-message="Forking repository"
      data-committing-message="Committing changes"
      data-merging-message="Branching and merging changes"
      data-creating-pr-message="Creating pull request"
      data-updating-pr-message="Updating pull request"
      data-cta-label="Commit"
      data-cancel-label="Cancel">
  <div class="aui-message error hidden">
    <span class="aui-icon icon-error"></span>
    <span class="message"></span>
  </div>
  [[^isWriter]]
    <div class="aui-message info">
      <span class="aui-icon icon-info"></span>
      <p class="title">
        
          You don't have write access to this repository.
        
      </p>
      <span class="message">
        
          We'll create a fork for your changes and submit a
          pull request back to this repository.
        
      </span>
    </div>
  [[/isWriter]]
  <div class="field-group">
    <label for="id_message">Commit message</label>
    <textarea id="id_message" class="textarea"></textarea>
  </div>
  [[^isPullRequest]]
    [[#isWriter]]
      <fieldset class="group">
        <div class="checkbox">
          <input id="id_create-pullrequest" class="checkbox" type="checkbox">
          <label for="id_create-pullrequest">Create a pull request for this change</label>
        </div>
      </fieldset>
      <div id="pr-fields">
        <div id="branch-name-group" class="field-group">
          <label for="id_branch-name">Branch name</label>
          <input type="text" id="id_branch-name" class="text">
        </div>
        <div id="reviewers-group" class="field-group"
              data-api-url="/[[owner]]/[[slug]]/pull-request/xhr/reviewer/:reviewer_name">
          <label for="participants">Reviewers</label>
          <select id="participants" name="reviewers" multiple></select>
          <div class="error"></div>
          
        </div>
      </div>
    [[/isWriter]]
  [[/isPullRequest]]
  <button type="submit" id="id_submit">Commit</button>
</form>

</script>
  <script id="merge-message-template" type="text/html">
  Merged [[hash]] into [[branch]]

[[message]]

</script>
  <script id="commit-merge-error-template" type="text/html">
  



  We had trouble merging your changes. We stored them on the <strong>[[branch]]</strong> branch, so feel free to
  <a href="/[[owner]]/[[slug]]/full-commit/[[hash]]/[[path]]?at=[[encodedBranch]]">view them</a> or
  <a href="#" class="create-pull-request-link">create a pull request</a>.


</script>
  
<script id="mention-result" type="text/html">
  
<img class="avatar avatar24" src="[[avatar_url]]">
[[#display_name]]
  <span class="display-name">[[&display_name]]</span> <small class="username">[[&username]]</small>
[[/display_name]]
[[^display_name]]
  <span class="username">[[&username]]</span>
[[/display_name]]
[[#is_teammate]][[^is_team]]
  <span class="aui-lozenge aui-lozenge-complete aui-lozenge-subtle">teammate</span>
[[/is_team]][[/is_teammate]]

</script>
<script id="mention-call-to-action" type="text/html">
  
[[^query]]
<li class="bb-typeahead-item">Begin typing to search for a user</li>
[[/query]]
[[#query]]
<li class="bb-typeahead-item">Continue typing to search for a user</li>
[[/query]]

</script>
<script id="mention-no-results" type="text/html">
  
[[^searching]]
<li class="bb-typeahead-item">Found no matching users for <em>[[query]]</em>.</li>
[[/searching]]
[[#searching]]
<li class="bb-typeahead-item bb-typeahead-searching">Searching for <em>[[query]]</em>.</li>
[[/searching]]

</script>




<div class="mask"></div>



  <script id="branch-dialog-template" type="text/html">
  

<div class="tabbed-filter-widget branch-dialog">
  <div class="tabbed-filter">
    <input placeholder="Filter branches" class="filter-box" autosave="branch-dropdown-2520780" type="text">
    [[^ignoreTags]]
      <div class="aui-tabs horizontal-tabs aui-tabs-disabled filter-tabs">
        <ul class="tabs-menu">
          <li class="menu-item active-tab"><a href="#branches">Branches</a></li>
          <li class="menu-item"><a href="#tags">Tags</a></li>
        </ul>
      </div>
    [[/ignoreTags]]
  </div>
  
    <div class="tab-pane active-pane" id="branches" data-filter-placeholder="Filter branches">
      <ol class="filter-list">
        <li class="empty-msg">No matching branches</li>
        [[#branches]]
          
            [[#hasMultipleHeads]]
              [[#heads]]
                <li class="comprev filter-item">
                  <a class="pjax-trigger" href="/Patabugen/wymeditor-plugins/src/[[changeset]]/plugins/image_float/jquery.wymeditor.image_float.js?at=[[safeName]]"
                     title="[[name]]">
                    [[name]] ([[shortChangeset]])
                  </a>
                </li>
              [[/heads]]
            [[/hasMultipleHeads]]
            [[^hasMultipleHeads]]
              <li class="comprev filter-item">
                <a class="pjax-trigger" href="/Patabugen/wymeditor-plugins/src/[[changeset]]/plugins/image_float/jquery.wymeditor.image_float.js?at=[[safeName]]" title="[[name]]">
                  [[name]]
                </a>
              </li>
            [[/hasMultipleHeads]]
          
        [[/branches]]
      </ol>
    </div>
    <div class="tab-pane" id="tags" data-filter-placeholder="Filter tags">
      <ol class="filter-list">
        <li class="empty-msg">No matching tags</li>
        [[#tags]]
          <li class="comprev filter-item">
            <a class="pjax-trigger" href="/Patabugen/wymeditor-plugins/src/[[changeset]]/plugins/image_float/jquery.wymeditor.image_float.js?at=[[safeName]]" title="[[name]]">
              [[name]]
            </a>
          </li>
        [[/tags]]
      </ol>
    </div>
  
</div>

</script>



  

<script type="text/javascript" src="https://d3oaxc4q5k2d6q.cloudfront.net/m/7689068cb84b/compressed/js/3188c55ac0c0.js"></script>




  </div>

  </div>
  

<form id="file-search-form" action="#"
  
  data-revision="cd2ef9496458a7014118f72bf9826fbaf05a04b9"
  data-branch="master">
  <input type="text" id="file-search-query" class="loading">
  <div id="filtered-files"></div>
  <div class="tip"><em>Tip:</em> Filter by directory path e.g. <strong>/media app.js</strong> to search for public<strong>/media/app.js</strong>.</div>
  <div class="tip"><em>Tip:</em> Use camelCasing e.g. <strong>ProjME</strong> to search for <strong>ProjectModifiedE</strong>vent.java.</div>
  <div class="tip"><em>Tip:</em> Filter by extension type e.g. <strong>/repo .js</strong> to search for all <strong>.js</strong> files in the <strong>/repo</strong> directory.</div>
  <div class="tip"><em>Tip:</em> Separate your search with spaces e.g. <strong>/ssh pom.xml</strong> to search for src<strong>/ssh/pom.xml</strong>.</div>
  <div class="tip"><em>Tip:</em> Use ↑ and ↓ arrow keys to navigate and <strong>return</strong> to view the file.</div>
  <div class="tip mod-osx"><em>Tip:</em> You can also navigate files with <strong>Ctrl+j</strong> <em>(next)</em> and <strong>Ctrl+k</strong> <em>(previous)</em> and view the file with <strong>Ctrl+o</strong>.</div>
  <div class="tip mod-win"><em>Tip:</em> You can also navigate files with <strong>Alt+j</strong> <em>(next)</em> and <strong>Alt+k</strong> <em>(previous)</em> and view the file with <strong>Alt+o</strong>.</div>
  <script id="filtered-files-template" type="text/html">
  

<table class="aui bb-list">
  <thead>
    <tr class="assistive">
      <th class="name">Filename</th>
    </tr>
  </thead>
  <tbody>
    [[#files]]
    <tr class="iterable-item">
      <td class="name [[#isDirectory]]directory[[/isDirectory]]">
        <a href="/Patabugen/wymeditor-plugins/src/[[node]]/[[name]][[#branch]]?at=[[branch]][[/branch]]"
           title="[[name]]" class="execute" tabindex="-1">
          [[&highlightedName]]
        </a>
      </td>
    </tr>
    [[/files]]
  </tbody>
</table>

</script>
</form>


    </div>
  </div>
  <footer id="footer" role="contentinfo">
    <section class="footer-body">
      <ul>
        <li>
          <a class="support-ga"
               data-support-gaq-page="Blog"
               href="http://blog.bitbucket.org">
            Blog
          </a>
        </li>
        <li>
          <a class="support-ga"
               data-support-gaq-page="KnownIssues"
               href="//bitbucket.org/site/master/issues">
            Report a bug
          </a>
        </li>
        <li>
          <a class="support-ga"
               data-support-gaq-page="Home"
               href="/support">
            Support
          </a>
        </li>
        <li>
          <a class="support-ga"
               data-support-gaq-page="DocumentationHome"
               href="//confluence.atlassian.com/display/BITBUCKET">
            Documentation
          </a>
        </li>
        <li>
          <a class="support-ga"
               data-support-gaq-page="DocumentationAPI"
               href="//confluence.atlassian.com/x/IYBGDQ">
            API
          </a>
        </li>
        <li>
          <a class="support-ga"
               data-support-gaq-page="GoogleGroups"
               href="//groups.google.com/group/bitbucket-users">
            Forum
          </a>
        </li>
        <li>
          <a class="support-ga"
               data-support-gaq-page="SiteStatus"
               href="http://status.bitbucket.org/">
            Server status
          </a>
        </li>
        <li>
          <a class="support-ga"
               data-support-gaq-page="EndUserAgreement"
               href="//www.atlassian.com/end-user-agreement/">
            Terms of service
          </a>
        </li>
        <li>
          <a class="support-ga"
               data-support-gaq-page="PrivacyPolicy"
               href="//www.atlassian.com/company/privacy/">
            Privacy policy
          </a>
        </li>
      </ul>
      <ul>
        
          
            <li>English</li>
          
        
        <li>
          <a class="support-ga"
             data-support-gaq-page="GitDocumentation"
             href="http://git-scm.com/">
            Git 1.8.2.3
          </a>
        </li>
        <li>
          <a class="support-ga"
             data-support-gaq-page="HgDocumentation"
             href="http://mercurial.selenic.com/">
            Mercurial 2.2.2
          </a>
        </li>
        <li>
          <a class="support-ga"
             data-support-gaq-page="DjangoDocumentation"
             href="https://www.djangoproject.com/">
            Django 1.3.7
          </a>
        </li>
        <li>
          <a class="support-ga"
             data-support-gaq-page="PythonDocumentation"
             href="http://www.python.org/">
            Python 2.7.3
          </a>
        </li>
        <li>
          <a class="support-ga"
             data-support-gaq-page="DeployedVersion"
             href="#">98236b4980d2 / 7689068cb84b @ bitbucket03
          </a>
        </li>
      </ul>
      <ul>
        <li>
          <a id="atlassian-footer-link"
             href="http://www.atlassian.com?utm=bitbucket_footer">
            Atlassian
          </a>
        </li>
        <li>
          <a id="atlassian-git-tools-link"
             href="http://www.atlassian.com/git">
            Our other git tools
          </a>
        </li>
      </ul>
    </section>
  </footer>
  
</div>

<script type="text/javascript" src="https://d3oaxc4q5k2d6q.cloudfront.net/m/7689068cb84b/compressed/js/f6424dda39b1.js"></script>

<!-- This script exists purely for the benefit of our selenium tests -->
<script>
  setTimeout(function () {
    BB.JsLoaded = true;
  }, 3000);
</script>



<script>
  (function () {
    BB = window.BB || {};

    // Base URL to use for non-CNAME URLs.
    BB.baseUrl = 'https://bitbucket.org';

    BB.images = {
      invitation: 'https://d3oaxc4q5k2d6q.cloudfront.net/m/7689068cb84b/img/icons/fugue/card_address.png',
      noAvatar: 'https://d3oaxc4q5k2d6q.cloudfront.net/m/7689068cb84b/img/default_avatar/16/user_blue.png'
    };

    BB.user = {"isKbdShortcutsEnabled": true, "isSshEnabled": false, "isAuthenticated": false};

    var repo = {},
        prefix = null,
        changeset = null,
        pullrequest = null,
        pullrequestAuthor = null;

    
      repo.id = 2520780;
      repo.scm = 'git';
      repo.readonly = false;

      

      
        repo.language = 'javascript';
        repo.pygmentsLanguage = 'javascript';
      

      
        repo.slug = 'wymeditor\u002Dplugins';
      

      
        repo.owner = {};
        repo.owner.username = 'Patabugen';
        repo.owner.is_team = false;
      

      
        repo.creator = {};
        repo.creator.username = 'Patabugen';
      

      
        changeset = 'cd2ef9496458a7014118f72bf9826fbaf05a04b9';
      

      
    

    if (repo) {
      BB.repo = repo;

      // Coerce `BB.repo` to a string to get
      // "davidchambers/mango" or whatever.
      BB.repo.toString = function () {
        return BB.cname ? this.slug : '{owner.username}/{slug}'.format(this);
      };

      if (prefix) {
        BB.prefix = prefix;
      }

      if (changeset) {
        BB.changeset = changeset;
      }

      if (pullrequest) {
        BB.pullrequest = pullrequest;
        BB.pullrequestAuthor = pullrequestAuthor;
      }
    }

    var gaCommands = [];

    // Track the main pageview to the Bitbucket GA account.
    gaCommands.push(['_trackPageview']);
    // Track the main pageview to the Atlassian GA account.
    gaCommands.push(['atl._trackPageview']);

    

    

    _.each(gaCommands, function (command) {
      BB.gaqPush(command);
    });
  })();
</script>

<script>
  (function () {
    var ga = document.createElement('script');
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    ga.setAttribute('async', 'true');
    document.documentElement.firstChild.appendChild(ga);
  }());
</script>



<script type="text/javascript">if(!NREUMQ.f){NREUMQ.f=function(){NREUMQ.push(["load",new Date().getTime()]);var e=document.createElement("script");e.type="text/javascript";e.src=(("http:"===document.location.protocol)?"http:":"https:")+"//"+"d1ros97qkrwjf5.cloudfront.net/42/eum/rum.js";document.body.appendChild(e);if(NREUMQ.a)NREUMQ.a();};NREUMQ.a=window.onload;window.onload=NREUMQ.f;};NREUMQ.push(["nrfj","beacon-1.newrelic.com","7d4a9813d0","295788","MgMDYhcHDUJVVEIKWAtJJ0MLBRdYW1kZAV4RBBRVDgMXH1VHRhAZFwMRWVdIFVhRQEVZUQwKBFQXCRRCUQ==",0,564,new Date().getTime(),"","","","",""]);</script></body>
</html>
