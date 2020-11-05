## 一、学习的新知识

对于字符串和数组方法经常是用到时才百度下，然后参考写出代码，今天通过朱老师总结字符串和数组方法，也算是对它们有了比较全面认识了。

>- **数组的map、filter和reduce方法的学习** 这些方法极大提高了数组的使用，要求都要掌握，其实不难，主要是没实例讲解，下面都有了
>- **Array.prototype.join.call(str,\'\*\')** 调用数组的join方法对字符串进行合并操作，解决了字符串默认不支持数组join方法。老师形它为 **"借用"** 。太经典了，我又测试了String.prototype.substr.call操作数组，也成功了，这个借用值得研究下。
>- **构造函数原型对象prototype** 这个是拓展知识了，也是JS高级操作之一，如用它重定义内置函数，我改造了join()默认用逗号连接数组的行为。实在是巧妙，有能力可以继续学习。
>- **字符串即是数组** 对于老师的这个提法，我进行验证测试，完全成立，字符串可以看成每个字符为成员的数组，编号从0开始，不过反过来则不行。

## 二、字符串和数组相关的常用操作

### 1、concat拼接字符串或合并数组

都不影响原来的字符串或数组，返回值是新的字符串或数组。数组拼接时若没参数则相当于拷贝成一个新数组。

```javascript
let str1 = 'Hello www.php.cn';
let str2 = 'woxiaoyao';
let arr1 = [1, 2, 3, 4, 5, 6];
let arr2 = ['Man', 'Woman'];
console.log('str1 = %s  ,str2 = %s  ,str1+str2 = %s', str1, str2, str1.concat(str2));
console.log(arr1.concat(arr2));
console.log(arr1);
console.log(arr2);
```

### 2、slice和substr取字符串的子串或数组成员

字符串对slice和substr都支持，数组只支持slice，对于substr不直接支持，通过"借用"可间接支持，不过此时将数组先join成字符串，再执行字符串的substr，意义不是很大，这里就是当成研究。

>- slice支持数组和字符串，原理都是从索引提取字串或成员
>- slice和substr的索引支持负值，字符串编号同时存在正向0,1,....，也有反向-1,-2,...。这点和CSS的grid布局时列或行号相似。
>- slice没有第二个参数则取到结束。
>- slice使用是要注意结果中**不包括结束索引**的对应的成员。

```javascript
// 语法: slice(开始索引,结束索引), 返回结果中不包括结束索引的对应的成员,不写第二参数,默认取到结束。
// 语法：substr(startIndex, length(不能为负,如果为负转为0,返回空))
// 索引支持负数，最后个对应-1(和grid的列号和行号相似，在正向编号也有反向编号)
console.log('str => %s  ,string slice => ', str1, str1.slice(0, 5));
console.log('str => %s  ,string slice => ', str1, str1.slice(-6));
console.log('str => %s  ,string substr => ', str1, str1.substr(0, 5));
//   substr是字符串方法，对数组直接使用则报错。
console.log('arr => %s   ,array slice => ', arr1, arr1.slice(0, 5));
//   console.log('arr => %s   ,array substr => ', arr1, arr1.substr(0, 5));
//  通过String.prototype.substr.call调用数组时，此时数组相当于先join转为逗号分隔的字符串。
console.log('arr => %s   ,array substr => ', arr1, String.prototype.substr.call(arr1, 3, 2));
```

### 3、indexOf查找

 >- 返回子字符串在原始的字符串出现的索引,找不到返回 -1， 
 >- 第二个参数指定查询的起始位置。
 >- 对数组无效。

```javascript
console.log('indexof => ', str2.indexOf('a'));
console.log('indexof => ', str2.lastIndexOf('a'));
```

### 4、split和join实现字符串和数组转换

>- **split('分隔符')** 将字符串打散,转为数组。常用于处理格式化数据非常方便,例如url, email
>- **join('分隔符')** 将数组转成字符串。以指定分隔符分隔，默认是逗号。

```javascript
console.log(str1.split('.'));
console.log(arr1.join());
```

### 5、toUpperCase和toLowerCase字符串的大小写转换

常用在用户输入格式的统一处理或条件循环控制时条件的统一格式(如防止大小写导致条件不成立)。

```javascript
res = str1.toUpperCase();
console.log(res);
console.log(res.toLowerCase());
res = str1.substr(0, 5).toUpperCase().concat(" ", str.substr(-6));
console.log(res);
```

### 6、trim去掉字符串二边的多余的空格

字符串独有的方法。

```javascript
let psw = "  root888 ";
console.log(psw.length);
res = psw.trim().length;
console.log(res);
```

## 三、数组要掌握的常用操作

### 1、出入栈

>- 栈: 后进先出(LIFO),最后添加的最先出去
>- 队: 先进先出(FIFO), 最先进入的最先出来
>- 都是"增删"受限,只允许在一端进行,要么在尾部, 要么是头部
>- 栈操作有:push和pop(从尾部)，unshift和shift(从头部)

```javascript
console.log('尾部入栈操作 =>', arr1.push(11), arr1);
console.log('尾部出栈操作 =>', arr1.pop(), arr1);
console.log('头部入栈操作 =>', arr1.unshift(11), arr1);
console.log('头部出栈操作 =>', arr1.shift(), arr1);
```

> **队列:**
>- push+shift：尾部开始的先进先出队列
>- unshift+pop：头部开始的先进先出队列

```javascript
// push+shift
console.log('尾部入栈操作 =>', arr1.push(11), arr1);
console.log('头部出栈操作 =>', arr1.shift(), arr1);
// unshift+pop
console.log('头部入栈操作 =>', arr1.unshift(11), arr1);
console.log('尾部出栈操作 =>', arr1.pop(), arr1);
```

### 2、splice实现数组增删改

> **最强大的数组方法**,通过不同的参数,可以轻松实现 **"增删改"** 。
>- 这个方法是直接在 **原始数组上操作** ,要当心
>- 语法 : slice(开始索引, 删除的数量, 插入的元素)

```javascript
// 删除
// 一个参数
let arr = [1, 2, 3, 4, 5];
res = arr.splice(2);
//   返回的是删除的元素
console.log(res);
console.log(arr);
// 适合一分为二
console.log(arr.concat(res));
// 二个参数,第二个是删除的数量
arr = [1, 2, 3, 4, 5];
arr.splice(1, 2);
console.log(arr);
// 更新操作
arr = [1, 2, 3, 4, 5];
// 将2,3,更新成: 88,99
arr.splice(1, 2, 88, 99);
console.log(arr);
// 新增操作: 只要第二个参数为0, 就是新增
arr = [1, 2, 3, 4, 5];
arr.splice(1, 0, 88, 99);
console.log(arr);
```

### 3、sort排序

默认将成员都做为字符串, 按字母表的顺序,也是直接改写了原数组。其中要关注数值数组时排序的问题，要通过自定义排序规则重新定义它的行为，实现数组也能正常排序。

```javascript
arr = ['p', 'b', 'a'];
arr.sort();
console.log(arr);
// 对于纯数值排序会有问题
arr = [10, 9, 22, 1];
arr.sort();
// 为什么结果不对, 因为自动将成员转为string
console.log(arr);
// sort(callback): 用这个回调函数自定义排序规则，为什么a-b就实现了数字比较？
arr.sort((a, b) => a - b);
console.log(arr);
```

### 4、forEach和map遍历数组

>- forEach((item,index,arr)=>{...})
>- map((item,index,arr)=>{...}),与forEach()不一样,有返回值

```javascript
arr = [1, 2, 3, 4, 5];
res = arr.forEach(item => console.log(item));
//  forEach()没有返回值
console.log(res);
res = arr.map(item => item * 2);
console.log(res);
```

### 5、filter过滤方法

> **filter(callback):**  对每个成员逐一处理,返回处理结果为true的成员组成的新数组

```javascript
arr = [1, 2, 3, 4, 5];
// 返回数组中的奇数, 直接过滤掉偶数, 可以被2整除
res = arr.filter(item => item % 2);
console.log(res);
```

### 6、reduce归并方法

> **reduce(callback, init):**  逐个依次的处理每个成员,并最终合并成一个值返回，init是初始值，主要应用就是数组求和和大量字符串拼接

```javascript
// arr 求和
res = arr.reduce((a, b) => a + b);
// 第二个参数表示从哪个初始开始操作,当前是0
res = arr.reduce((a, b) => a + b, 0);
console.log(res);
// 如果不想从0开始累加, 例如点赞数,想从50000开始
res = arr.reduce((a, b) => a + b, 50000);
res = arr.reduce((a, b) => a + b, 55610);
console.log("点赞: ", res, "次");
```

## 四、几点拓展

### 1、字符串即是数组

这个很好测试，如字符串str="hello www.php.cn"，str[0]就是'h'，其实slice既是字符串的方法，又是数组方法，尤其是通过索引来访问，就很明确的说字符串就是数组。

### 2、借用方法

无论是Array.prototype.join.call()还是String.prototype.substr.call()都是"借用"方法，为什么要单独提出来，因为我感觉它挺好用的，它们格式都是 **"对象.prototype.方法.call(借用对象,...参数)"** 

>- **对象**可以是内置对象，也可以是自定义对象
>- **方法**是对象的方法，也是借用对象要借用的方法，因为借用对象不支持这种方法，所有需要向支持方法的对象借用。
>- **借用对象** 就是要借用方法的对象。如上面列举的substr方法，它的对象是String，数组是不支持substr的，此时数组就是借用对象。
>- **参数** 这里参数是借用方法的参数，只是相比原方法，它多了个借用对象的参数。

### 3、构造函数原型对象prototype

学习构造函数原型对象prototype是JS高级操作，目前我也只是入门，只是为了写本文才查阅了相关资料，简单明白几下几点，更高深待日后研究到这方面再说。

>- prototype是每个对象都有的
>- prototype使您有能力向对象添加属性和方法
>- 通过内置对象的prototype属性可以改变内置方法

```javascript
// 修改join默认使用逗号拼接，连接符现在为%.
Array.prototype.join = function () {
return this.reduce((a, b) => a + '%' + b);
};
console.log(arr1.join());
```

## 五、学习后的总结

>- 字符串就是数组，数组则不是字符串。对于它们使用可参考上面常用方法的介绍。
>- 数组的splice、map、filter和reduce方法要掌握
>- JS的"方法借用"和prototype的知识，在能力情况下可以深入探讨下，这是走向高级JS之路，网上说Javascript高级程序设计提到了，以后有机会要认真学习下。