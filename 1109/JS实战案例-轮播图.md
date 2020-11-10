## 一、实战前的知识总结

轮播图是页面中常见的形式，支持手动切换、自动切换、手动和自动互换、无缝滑入等。朱老师分享了思路和核心代码，我受益匪浅。

### 1、激活状态的获取和切换

无论是轮播的图片或按钮都涉及激活状态的切换，只有一个是激活状态，这是轮播图核心代码之一。老师用了四个封装函数实现了激活图片获取、激活按钮获取、激活按钮设置和激活图片设置。获取激活状态比较巧妙地使用了数组过滤函数filter，通过查找类名包括active即代表激活元素。

```javascript
// 获取激活图片
function getActiveImg(imgs) { return Array.from(imgs).filter(img => img.classList.contains('active')); }
```

关于激活按钮和激活图片的两个函数，我认为不合理

> 1. 设置一个时要遍历另一个激活状态，我感觉是多余的，因为图片和按钮是同步激活的，我改进为直接设置同位置的图片和按钮激活，至于激活哪一个位置，由按钮和切换事件来决定。
> 2. 另外数组查询是需要时间的，一次切换时间短，但自动切换时则是大量，这样会用不少时间来进行数组查询。

```javascript
// 设置激活图片和按钮
function setActive(imgs, btns, index) {
  //   对index要进行检验，防止非法值
  for (let i = 0; i < imgs.length; i++) {
    if (index === i) {
      //   清除当前图片激活，设置新的激活
      getActiveImg(imgs).pop().classList.remove('active');
      imgs[index].classList.add('active');
      //   清除当前按钮激活，设置新的激活
      getActiveBtn(btns.children).pop().classList.remove('active');
      btns.children[index].classList.add('active');
      break;
    }
  }
}
```

> **提醒重要的一点:** 我没按老师处理的方式为每个按钮绑定事件，按钮换图或自动换图都是采用事件委托代理，要注意检验非法值，它可能点击父元素下非按钮区域，此时我们要过滤掉。

### 2、 事件派生器使用注意

我刚才自动切换时绑定到左右切换的父元素上，即想傅事件委托，则发现自动切换，后用console.log打印事件信息，发现事件的target和currentTarget为空。这时我想到上面处理按钮换图就处理了点击非按钮区域的问题，由于我左右是一行，它绑定事件委托，就不知道事件传递到哪个子元素了，所以事件委托一定要事件绑定者上。如我是通过右侧切换模拟自动切换，所以我绑定到了右侧切换按钮上。

```javascript
//   不要绑定事件委托代理，因为无法预知它操作位置,这里具体到右侧切换按钮来模拟实现自动切换，可实现代码复用
//   不要绑定click事件，因为它会冒泡到上级事件，在事件再根据事件来处理非常麻烦。这里使用图片几乎不用的事件，减少干扰
qiehuan.lastElementChild.addEventListener('blur', btnHuan, false);
```

### 3、 手动和自动切换

有了上面激活状态的获取和切换，手动切换只要给按钮和左右切换绑定事件就可以了，只是要注意第一张和最后一张的处理就可以。自动切换则可以模拟点击右侧切换按钮就可以了。但这个存在问题就是手动和自动换图未分开处理，会导致二者相互影响，达不到我我们想的： **手动时想停止自动切换，不操作后等待一定时间再自动切换** 。停止自动切换很简单，直接clearInterval(time1)就可以了，再启动也很简单，再设置setInterval()进行事件派发就可以了，问题是二者存在以下干扰

> 1. 由于手动事件函数和自动事件函数都是click事件，需要在事件函数中区分是手动还是自动。
>    - 通过event.target和event.currentTarget可以区分，但是由于存在冒泡，同时会出现两次执行，一个是手动一个是自动，若此时处理很明显导致混乱
>    - 理解冒泡原理实质后，就是同名函数冒泡。我解决思路就是给事件派发器绑定另一个不常用事件如blur，则它又可以执行又不冒泡，明显达到我们的目的。
>
> 2. 手动停止后等待一定时间后重新启动自动切换？
>    - 第一种思路：在手动中停止定时器后，再能完setTimeOut来延时执行启动定时器。这个处理方案在测试中很难把控，每次手动都延时启动感觉会影响性能。
>    - 第二种思路：设置一个开关和全局定时器，开关在手动时为false,自动时为true。全局定时器间隔为10秒，手动操作后10秒内不操作将会被视为用户不手动换图了，会在每10秒检查开关，若开关关闭则启动定时器。这种思路目前解决问题效果还可以

```javascript
const ev = new Event('blur');
//   外层定时器是因用户手动换图导致自动切换停止，此时它就等待用户不点击时再等10秒再启用定时器
setInterval(() => {
  if (!timer)
    // 内层定时器就是自动换图，能完绑定右侧换图模拟自动换图
    time1 = setInterval(() => {
      timer = true;
      qiehuan.lastElementChild.dispatchEvent(ev);
    }, 3000);
}, 10000);
```



## 二、轮播图实战

>- 手动换图:下文按钮对应图片，点击则切换对应的图片；左右则前后换图。
>- 自动换图:默认3秒换一次图
>- 手动和自动切换:手动换图时停止自动换图，手动不换图后等10秒自动换图
>- 采用CSS3动画实现了左侧滑入效果。

```html
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }
  a {
    text-decoration: none;
    color: #666;
  }
  :root {
    font-size: 1vw;
  }

  @keyframes fadeInLeft {
    0% {
      opacity: 0;
      transform: translateX(-120px);
    }
    100% {
      opacity: 1;
      transform: translateX(0);
    }
  }

  .container {
    width: 60vw;
    height: 20vw;
    margin: 1em auto;
    overflow: hidden;

    position: relative;
  }
  h3 {
    width: 60vw;
    margin: 1em auto;
    text-align: center;
  }
  /* 轮播图片 */
  .container .imgs img {
    position: absolute;
    left: 0;
    top: 0;

    width: 100%;
    height: 100%;

    display: none;
  }
  .container .imgs img.active {
    display: block;
    animation: fadeInLeft 1s;
  }

  /* 轮播按钮 */
  .container .btns {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0.5em;

    width: 8em;
    padding: 0.2em;
    border-radius: 1em;
    margin: auto;
    text-align: center;
    background-color: #3333339f;
  }
  .container .btns a {
    /* padding: 0.5em; */
    display: inline-block;
    padding: 0.5em;
    border-radius: 50%;
    background-color: #ffffff5f;
    margin: 0 0.2em;
  }
  .container .btns a.active {
    background-color: #ffffff;
  }

  /* 轮播切换 */
  .container .qiehuan {
    position: absolute;
    left: 0;
    right: 0;
    top: 8vw;

    display: flex;
    padding: 0 1em;
    justify-content: space-between;
  }
  .container .qiehuan a {
    display: inline-block;
    color: white;
    font-size: 2em;
    width: 1.5em;
    height: 1.5em;
    border-radius: 50%;
    text-align: center;
    background-color: #ffffff5f;
  }
</style>
<div class="container">
  <div class="imgs">
    <img src="banner/banner1.jpg" alt="" class="active" data-index="1" />
    <img src="banner/banner2.jpg" alt="" data-index="2" />
    <img src="banner/banner3.jpg" alt="" data-index="3" />
    <img src="banner/banner4.jpg" alt="" data-index="4" />
  </div>
  <div class="btns">
  </div>
  <div class="qiehuan">
    <a href="#" data-action="prev">&lt;</a>
    <a href="#" data-action="next">&gt;</a>
  </div>
</div>
<h3>自动换图时间为3秒，用户操作会停止自动换图，当用户不操作，等待10秒又自动换图。</h3>
<script>
  const imgs = document.querySelectorAll('.container .imgs img');
  const btns = document.querySelector('.container .btns');
  const qiehuan = document.querySelector('.container .qiehuan');

  // 根据图片自动创建按钮
  const frag = document.createDocumentFragment();
  for (let i = 0; i < imgs.length; i++) {
    const a = document.createElement('a');
    a.href = '#';
    a.dataset.index = i + 1;
    if (i == 0) a.classList.add('active');
    frag.appendChild(a);
  }
  btns.appendChild(frag);

  //   当用户通过按钮或左右切换按钮时，要禁用事件派发器
  let timer = false;
  let time1 = null;

  // 按钮切换图片
  btns.addEventListener('click', btnSet, false);
  function btnSet(ev) {
    // 按钮切换图片时要清除定时器，
    clearInterval(time1);
    // 激活等待功能
    timer = false;
    // 切换图片
    let index = ev.target.dataset.index - 1;
    setActive(imgs, btns, index);
  }

  // 左右切换图片
  qiehuan.addEventListener('click', btnHuan, false);
  function btnHuan() {
    //   事件派发器不能绑定click，否则需要更多代码来区分是点击还是自动事件
    if (event.type == 'click') {
      clearInterval(time1);
      timer = false;
    }
    // 左右切换图片
    let action = event.target.dataset.action;
    let index = getActiveImg(imgs).pop().dataset.index - 1;
    if (action == 'prev') index = index == 0 ? imgs.length - 1 : index - 1;
    if (action == 'next') index = index == imgs.length - 1 ? 0 : index + 1;
    setActive(imgs, btns, index);
  }

  // 定义公共函数
  // 1.获取激活图片
  function getActiveImg(imgs) {
    return Array.from(imgs).filter(img => img.classList.contains('active'));
  }
  // 2、获取激活按钮
  function getActiveBtn(btns) {
    return Array.from(btns).filter(btn => btn.classList.contains('active'));
  }
  // 3、设置激活图片和按钮
  function setActive(imgs, btns, index) {
    //   对index要进行检验，防止非法值
    for (let i = 0; i < imgs.length; i++) {
      if (index === i) {
        //   清除当前图片激活，设置新的激活
        getActiveImg(imgs).pop().classList.remove('active');
        imgs[index].classList.add('active');
        //   清除当前按钮激活，设置新的激活
        getActiveBtn(btns.children).pop().classList.remove('active');
        btns.children[index].classList.add('active');
        break;
      }
    }
  }
  // setActive(imgs,btns,2);

  //   派发器要注意几点
  //   1.不要绑定事件委托代理，因为无法预知它操作位置,这里具体到右侧切换按钮来模拟实现自动切换，可实现代码复用
  //   2.不要绑定click事件，因为它会冒泡到上级事件，在事件再根据事件来处理非常麻烦。这里使用图片几乎不用事件，减少干扰
  qiehuan.lastElementChild.addEventListener('blur', btnHuan, false);
  const ev = new Event('blur');
  //   外层定时器是因用户手动换图导致自动切换停止，此时它就等待用户不点击时再等10秒再启用定时器
  setInterval(() => {
    if (!timer)
      // 内层定时器就是自动换图，能完绑定右侧换图模拟自动换图
      time1 = setInterval(() => {
        timer = true;
        qiehuan.lastElementChild.dispatchEvent(ev);
      }, 3000);
  }, 10000);
</script>
```
![lenbo](lenbo.gif)

### Codepen演示 <https://codepen.io/woxiaoyao81/full/NWrOZpb>

## 三、实战总结

>- 页面布局时要先用 **点位** 来调整布局，然后再用动态代码生成，如轮播图中下方多个按钮。
>- dataset自定义数据属性是在同步不同元素行为时常用技巧。
>- 数组的过滤函数是返回指定条件的新数组，在查找时非常实用
>- 解决思路比上来直接写代码更重要，好的思路可以事半功倍，不好的解决方法只会增加代码量。
