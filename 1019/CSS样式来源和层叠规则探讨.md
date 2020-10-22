### 一、学习的新知识

这节课知识在我作业<https://www.php.cn/blog/detail/24407.html>基本都已经讲过了，本文在基础上更详细分析了层叠规则和源码顺序的影响，算是对那个作业的补充和完善。

### 二、样式来源

首先更正上次作业中样式来源的说法，它应该包括：**用户代理样式**(浏览器样式或默认样式)、**继承样式**和**用户自定义样式**三个部分。
>- **用户代理样式(user agent stylesheet)** 目前用户代理主要是浏览器，也可以称其为浏览器样式或默认样式。可在chrome开发者工具中Elements面板的Styles和Computed查询。**关键字initial**。
>- **继承样式** 样式分为可继承和不可继承，如font-size、color都是可继承，而margin和padding是不可继承，是否继承可通过mdn查询(技巧:**属性 mdn**可快速查询)。**关键字inherit**。
>- **用户自定义样式** 所谓用户就是开发者定义的样式，包括**引用优秀样式**和**自定义样式**。

```html
<style>
  body { font-size: 20px; color: red; }
  /* 1. 继承样式 */
  p { font-size: inherit; color: inherit; }
  /* 2. 用户代理样式 */
  p { font-size: initial; color: initial; }
  /* 3. 用户自定义样式 */
  p { font-size: 22px; color: green; }
</style>
<body>
  <p>元素属性值的来源的总结</p>
</body>
```

### 三、层叠规则探讨

#### 1、基本选择器层叠规则 

基本选择器主要是指单选择器，常见有:**标签选择器tag** 、 **类选择器class** 、**id选择器**和**属性选择器[]**。

>- 基本选择器优先级:**tag < class或属性 < id**。经测试属性选择器和类选择器是相同优先级。
>- **仅仅是在覆盖元素样式时考虑优先级，叠加时不考虑优先级,全部有效** !!!
>- **优先级高覆盖优先级低的，相同优先级时后写覆盖前写** !!!
>- 伪类是class级别，计算优先级时按类来看待。
>- 伪元素是tag级别，但它是定义伪元素的样式，目前伪元素访问只能通过伪元素，它没有class和id。

```html
<style>
  #page-title { color: red; }              /* ID选择器 */
  .title { color: green; }                 /* 类选择器 */
  [class='title'] { color: slateblue; }    /* 属性选择器 */
  h1 { color: skyblue; font-size: 2rem; }  /* 标签选择器 */
</style>
<body>
  <h1 id="page-title" class="title">CSS选择器和优先级</h1>
</body>
```

#### 2、复合选择器层叠规则

复合选择器是由多个单选择器组成的，主要包括:
>1. 后代选择器,以空格隔开，代表子元素、孙元素...
>2. 子选择器，以>连接，代表子元素
>3. 兄弟选择器，以+连接，代表兄弟后一个元素；若~表示所有兄弟元素
>4. 群组选择器，以逗号隔开，表示多个元素
>5. x-child或x-of-type的复合选择器

复合选择器优先级规则:
>**计算格式:** id的个数,class或属性的个数,tag的个数
>**判别规则:** 从id开始比较，若相等则依次向后比较，不等时大者为高，比较结束。
>**覆盖规则:** 优先级高覆盖优先级低的，相同优先级时后写覆盖前写!!!

```html
/* 0,1,3  因0,1,3>0,0,4，前者优先级高生效  */
:root body header h1 { color: red; }
/* 0,0,4 */
html body header h1 { color: skyblue; }
/* 0,1,3 相同优先级时，后写覆盖前写的 */
body header.page-header h1 { color: green; }
```

#### 3、源码顺序

前面已经介绍了顺序是在优先级相同时，后写的覆盖前写的，而这里要说的源码顺序是指**元素有多态时**，定义其多态样式有时要有**一定顺序**，否则会导致有些状态样式不生效。这里介绍以链接元素a的四个状态:**访问link**、**已经访问visited**、**停留hover**和**点击未释放active**。它们样式源码顺序要按link、visited、hover和active顺序。这个要写出来，是因为我以前以为它们只是伪类，表示状态，不用管顺序，今天听老师讲课后，经过测试的确如此。

```html
<style>
  .nav a { color: initial; text-decoration: none; }
  a:link { color: skyblue; }
  a:visited { color: red; }
  a:hover { color: violet; }
  a:active { color: orange; text-decoration: underline; }
</style>
<body>
  <nav id="page-nav" class="nav">
    <li><a href="">首页</a></li>
    <li><a href="">公司简介</a></li>
    <li><a href="">主要特色</a></li>
    <li><a href="">登录</a></li>
  </nav>
</body>
```

### 四、学习后总结
>- 学习前端要多访问**MDN**，查询技巧是： **关键字 mdn** ,可快速找到自己需要查询的知识。
>- 样式来源可分为默认样式、继承样式和自定义样式。
>- 层叠时，元素的不同声明直接叠加，不需要考虑优先级，相同声明时要考虑优先级。
>- 覆盖时，优先级高覆盖优先级低的，相同优先级时后写覆盖先写的
>- 元素有多态时，要注意顺序，若是要特定顺序则必需按顺序定义样式。