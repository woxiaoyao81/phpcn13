### 一、学到的新认识
本意味CSS属性值简写和相对单位已经很熟悉了，结果老师讲课后，我又接触了几个陌生的概念
#### 1. outline
>翻译是"轮廓"。也许你奇怪不就是一个属性而已嘛，但我在做前端布局调整时最难的就是**定位元素边界**，只有知道边界才能知道布局问题出在哪，如不居中是因为它本身样式不对还是父元素样式不对。以前我最常用**border**定边界，今天发现老师用outline介绍盒模型时就发现新的技能了，然后百度下border和outline的区别。**二者最大区别：** 其实老师已经讲到就是border会影响元素的盒模型从而影响整体布局，而outline则不占空间，对整体布局没有影响，非常适合定位元素边界来**排查布局的问题**。

#### 2. 属性值简写的要素和顺序
>其实在做前端时经常属性值简写，这里我特别注意老师讲的属性值顺序，如padding、margin和background-position值是有**顺序**，还要特别记忆，而border、outline这些复合属性值则**顺序无关**，而我在font这个复合属性值时本以为也无关，结果却是与顺序有关。此时我就思考**顺序有关或无关是从哪可以查到**，还有更深入的就是**简写的要素哪些可以忽略**，如border:solid red;是可以的。学习就要打破沙锅问到底，正好有这些明师，培训结束了就没地方提问了。相信你也想知道答案，可继续看本文，我在第三节已经分析。

#### 3. background-clip:content-box
>content-box一出现就让我就想到以前经常遇到**box-sizing:content-box**。它们有之间有什么区别呢？经查得出如下结论：
>- **box-sizing**是指**如何计算盒模型的总宽度和总高度**，就是我们设置元素的**width和height**到底指哪些。标准盒模型其**默认值**是**content-box**。即
**width = content width;**
**height = content height**
若是**border-box**则计算是这样的：
**width = border-left + padding-left + content width + padding-right + border-right**
**heigth = border-top + padding-top + content heigth + padding-bottom + border-bottom**
>- **background-clip**指定**元素背景所在的区域**。默认值**border-box**,还可取**content-box**，**padding-box**。至于text取值可以忽略，它兼容性不好。
**border-box:** 表示元素的背景从border区域（包括border）以内开始保留背景
**padding-box:** 表示元素的背景从padding区域(包括padding)以内开始保留
**content-box:** 表示元素的背景从内容区域以内开始保留

#### 4. em和rem
>相对单位，布局自适应知识之一,重点要掌握它们的本质，究竟是相对谁来计算。

### 二、属性值简写
>- 属性值简写便于阅读，目前学到常见有font,border,padding、margin和background，以后要学的flex和grid等也是。最常见的简写如下演示

```html
/* font-size: 20px;
    font-style: italic;
    font-weight: bolder;
    font-family: Tahoma; */
/* font属性值简写 顺序不是无关 要素可以忽略部分 */
font: italic bolder 40px Tahoma;
/* font: bolder 30px Tahoma; */
/* font: 30px Tahoma; */
font: 30px; /*无效*/

/* border-width: 2px;
    border-style: solid;
    border-color: seagreen; */
/* border简写 顺序无关,要素可以任选一个或多个，不过没有style则默认为none即不显示，但它仍然占空间*/
border: 10px solid seagreen;
/* border: solid 10px seagreen; */
/* border: solid 10px; */
/* border:10px; */
line-height: 200px;

/* padding-top: 10px;
padding-right: 15px;
padding-bottom: 20px;
padding-right: 25px; */
/* padding简写 顺序:上 右 下 左 */
padding: 10px 15px 20px 25px;
padding: 10px 15px 20px; /* 上是10px 左右是15px 下是20px */
padding: 10px 15px; /* 上下是10px 左右是15px */
padding: 10px; /* 上下左右都是10px */
/* margin简写  顺序同padding */
margin: 10px 15px 20px 25px;

background-image: url(https://img.php.cn/upload/course/000/000/003/5a530c9c6c775990.jpg);
background-repeat: no-repeat;
/* 简写 顺序:x轴 y轴 它的顺序可通过left、top、bottom和right指写，默认是left top */
background-position: 20px 30px;
/* background-position:right 20px bottom 10px  */

```

#### 效果<https://codepen.io/woxiaoyao81/pen/abZOjMZ>


### 三、属性值简写的要素和顺序(重点)
>- **简写要素** 简写要素是否可以忽略要依据语法定义，**常见查询定义的平台就是MDN**。如**outline的语法**定义<https://developer.mozilla.org/zh-CN/docs/Web/CSS/outline>是 **
**[ <'outline-color'> || <'outline-style'> || <'outline-width'> ]**  
*中括号[]表示要素组合，尖括号<>是要素，||表示或关系*。**意味简写值组合可以是这些要素中一个或多个，即可以忽略任何要素**。如下：
outline:red solid;
outline:dotted 2px;
不过为了显示要注意**outline-style要设置，其默认是none**,相同语法定义有border。
再看下**font的语法**定义<https://developer.mozilla.org/zh-CN/docs/Web/CSS/font> 
**[ [ <'font-style'>  <font-variant-css21> || <'font-weight'> || <'font-stretch'> ]? <'font-size'> [ / <'line-height'> ]? <'font-family'> ]** 
除了前面讲的符号，又出现了**问号?** 它和正则表达式中意义差不多，就是**匹配零次或一次**。从中可以看出font-size和font-family是必要的要素，不可忽略，其它可以忽略。

>- **简写顺序** 我们知道margin、padding、background-postion属性简写是有顺序，而border和outline复合属性是无顺序的。而要想知道**是否有顺序还是要看MDN语法定义**，如
outline各要素是**或关系**，简写要素是**无序的**。
而font简写要素见上面定义，其中font-style、font-weight和font-stretch是**无序**的，但它们组合和font-size是**有序**的，剩下的就好理解了，可以按我思路分析简写要素是否有顺序。

>- 上面列举都是**复合属性**，而对**单值属性**的顺序含义则是要看MDN详细说明了，如**padding语法**定义<https://developer.mozilla.org/zh-CN/docs/Web/CSS/padding>
**[ \<length\> | \<percentage\> ]{1,4}**
解释就是要素是长度或百分比，个数是1到4。**没有或关系就是有顺序的**，具体顺序有链接文章中有详细介绍，无论1个值、2个值、3个值和4个值都介绍非常清楚。

```html
 /* border简写 顺序无关,要素可以任选一个或多个，不过没有style则默认为none即不显示，但它仍然占空间*/
border: 10px solid seagreen;
/* border: solid 10px seagreen; */

 /* padding简写 顺序:上 右 下 左 */
padding: 10px 15px 20px 25px;
padding: 10px 15px 20px; /* 上是10px 左右是15px 下是20px */
padding: 10px 15px; /* 上下是10px 左右是15px */
padding: 10px; /* 上下左右都是10px */

/* font简写 顺序部分无序，有部分有序，要素也是部分可忽略*/
 font: italic bolder 40px Tahoma;
 /* font: bolder 30px Tahoma; */
/* font: 30px Tahoma; */
```

### 四、相对单位em和rem(重点)
多端布局要求自适应，其中相对单位em和rem是重点，正如小程序端的rpx相对单位，使用它们可以快速适应不同端、不同设备。下面几个概念一定要记清楚
#### 1. em是当前字号的相对单位 
>不知同学们是否还记得朱老师在上课提出的疑问：**em是等于当前元素的font-size，再用它设置当前元素fong-size为什么没报错？** 我开始想到是它在解析时执行二个过程，如font-size:0.8em时，就是第一次时em是默认值，如视频中提到的16px，而第一次则16px*0.8=12.8px，也就是em等于当前元素的**font-size最终结果**,**一般情况**下就是我们在chrome浏览器**Elements面板的Computed所看到的计算结果**。

> **上面结论对吗？** 上面结论是我上课时认为的，但在**写本文时感觉只能是对了一部分**，如果是这样就很像编程中递归出现死循环。百度时我看这篇文章<http://caibaojian.com/rem-vs-em.html>，和老师提的差不多，不过我注意了其中一点，就是**父元素**。浏览器解析em时处理方法有否可能有**两种方式**：
①**font-size值中有em时，则它等于父元素的font-size，因为它是继承元素!!**
②**解析非继承元素如padding、margin等值中有em时，则是等于本元素的font-size**
以上认识不知道是否正确，欢迎老师和其它同仁批评指正。

> **font-size小于12px时，浏览器如何处理em和当前元素的font-size** 我们知道当font-size小于12px时， 如10px，此时浏览器显示时将替换为12px，那么此时**em是等于10px还是12px?** 其实在第一点我就特别提示是**一般情况**下em是等于Elements面板Computed计算结果，若是小于12px**替换为12px仅仅是影响显示时font-size**，而**真正的em仍然是根据10px来计算**。这点要注意。

#### 2. rem是根元素字体大小
>rem是根据html的字体大小来决定的，一般在使用中有以下几个技巧
>-  **将html的font-size设置为0.625em，body的font-size设置为1.6rem,，便于获取整数的大小。如1.8rem就是18px。**
>-  **一般元素的font-size要以rem为单位，而padding和margin则以em为单位**
>-  **设置html属性时推荐使用:root伪类代表它，因为并不是所有文档根元素都是html**
>-  **不是所有属性值单位都采用相对单位，如border和position一般采用px来定义**

```html
:root {font-size: 0.625em; }
*{font-size: 1.6rem;}
.box:last-of-type{
font-size: 2rem;
padding: 1em;

height: 200px;
background-clip:content-box;
background-color: seagreen;
background-image: none;
}
```

#### 效果<https://codepen.io/woxiaoyao81/pen/abZOjMZ>

### 五、学习的总结
>- 属性值简写便于阅读，但要注意**属性要素是否可以忽略**和**顺序是有序还是无序**。
>- em和rem使用自适应多端，但要认清**它们大小等于谁一定**。px常用于border和position。
>- margin、padding只能设置宽度不能设置样式和颜色，它是**透明的**；而border可设置宽度、样式和颜色。
>- 学会用**outline定位元素边界**，排查布局的问题，而border不适合定位元素边界，因为它占空间，影响布局，而outline只是轮廓，不影响布局。
>- 关于background-position中xy轴(0,0)分析见以后定位文章，提醒的是它是变化的，默认为盒模型border内left top即左上为(0,0)。

源码在我的博客<https://www.php.cn/blog/freegroup.html>
         Gitee<https://gitee.com/freegroup81/phpcn13>
