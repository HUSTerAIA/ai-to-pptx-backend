# Ai-To-PPTX 后端项目说明
    1 Ai-To-PPTX的私有化部署后端版本.
    2 要求PHP和REDIS环境, 和当前目录下面的文件写入权限.
    3 目前内置4套PPTX模板, 你也可以按要求自己增加新的模板.
    4 如果你自己的模板, 在遇到导出为PPTX的时候, 有一些特性没有支持, 导致导出的PPTX的显示有不完整的地方, 可以联系我们.
    5 使用DeepSeek模型.

# Ai-To-PPTX 如何部署
    1 直接下载当前仓库代码到服务器
    2 要求使用PHP >= 7.4 和 REDIS, 可以在 config.inc.php 中修改这个端口号
    3 要求安装Redis服务器端和PHP的Redis扩展和Zip扩展
    3 配置好URL以后, 在前端项目的config.ts文件, 把项目后端URL修改为你自己的URL
    4 系统使用DeepSeek模型, 在 config.inc.php 中修改Deepseek的Key
    5 ./cache 和 ./output 两个目录要求可写
    6 如果你部署失败, 可以参考 Dockerfile 文件里面的部署过程

# Ai-To-PPTX Dockerfile部署说明
    1 把前端项目编译为静态文件, 目录为: /var/www/html , 同时在前端中把后端地址修改为 /aipptx/
    2 把后端项目的PHP文件放到 /var/www/html/aipptx 目录
    3 安装Redis服务器端和PHP的Redis扩展
    4 /var/www/html/aipptx/cache 和 /var/www/html/aipptx/output 两个目录要求可写

# Ai-To-PPTX Docker使用说明
    1 下载镜像: docker pull chatbookai/ai-to-pptx:0.2
    2 启动镜像: docker run -p 8080:80 chatbookai/ai-to-pptx:0.2
    3 开始使用: 在浏览器里面输入: http://localhost:8080
    4 列出镜像: docker ps -a
    5 进入镜像: docker exec -it <container_name_or_id> /bin/bash
    6 如果是在Docker Desktop中, 可以在Docker Hub中搜索 chatbookai/ai-to-pptx 就可以看到镜像, 下载以后, 启动的时候, 需要指定本地的端口为8080, 然后就可以在浏览器打开 http://localhost:8080
    7 注意: Docker的镜像中已经同时包含了前端和后端项目

# Ai-To-PPTX 开源协议
    1 本项目发行协议: [AGPL-3.0 License]
    2 根据GPL协议的内容, 您只有在修改了本系统代码的时候, 需要公开的代码仓库如Github上面, 开放你的修改内容.
    3 如果你不想公开代码的修改内容, 请联系我们取得商业授权.
    4 如果没有修改本系统的代码, 那么你一直可以使用, 在GPL授权协议下面使用本软件.
    5 你的系统需要对所有用户开放的你的源代码, 你修改后的代码也必须要采用GPL协议.
    6 如何你修改了本系统的代码, 你需要在代码和正式使用的系统中标记你使用的哪部分代码是我们的, 哪部分代码是你们自己开发的.你们自己开发的代码也需要采用GPL协议.
    7 GPL协议允许修改软件代码, 但没有允许你修改本系统的著作权人信息, 所以像版权归我们所有之类的标记, 不能去除.

# Ai-To-PPTX 开源版本限制性
    1 没有会员功能,不能让用户注册,计费和充值功能. 但是增加这些功能不难, 相信大家都会.
    2 目前只支持在PPTX的详细页面里面, 输出三个小节的情况, 如果是两个或是四个小节的情况, 暂时还没有做充分测试, 所以目前先保持三个小节的情况.
    3 没有移动端功能.
    4 更多特性,可以考虑采购商业版本.

# Ai-To-PPTX 交流群组
    QQ群: 186411255

# Ai-To-PPTX 商业用途
    开源商用: 无需联系,可以直接使用,需要在您官网页面底部增加您的开源库的URL(根据开源协议你需要公开你的源代码),GPL协议授权你可以修改代码,并共享你修改以后的代码,但没有授权你可以修改版权信息,所以版权信息不能修改. GPL协议允许修改软件代码, 但没有允许你修改本系统的著作权人信息, 所以像版权归我们所有之类的标记, 不能去除.
    闭源商用: 需要联系,额外取得商业授权,根据商业授权协议的内容,来决定你是否可以合法的修改版权信息.
    商业授权: 请单独联系. 允许购买商业授权的用户开展SAAS等会员收费业务,以及自用. 但是禁止以系统的方式出售给其它用户,即禁止二次销售. 
    模板开发: 如果计划购买商业授权的用户自已开发出一些特有的PPTX模板,可以共享给我们,经过审核收录以后,可以充抵一定的商业授权费用.
    技术服务: 可选项目,每年支付一次,主要用于软件二次开发商做二次开发的时候的技术咨询和服务,其它业务场景则不需要支付此费用,具体请咨询.
    额外说明: 本系统指的是计算机软件代码,系统里面带的模板并不是开源项目的一部分.虽然系统会自带四套模板供大家免费使用,但更多模板需要购买模板的授权.

# Ai-To-PPTX 商用版本
    1 暂时停止了商用版本的开发
    2 何时重新启动, 另行通知
 
 ---

## 项目概览
这是一个基于**AI技术自动生成PowerPoint演示文稿**的后端系统，使用**DeepSeek模型**进行内容生成，支持从Markdown大纲到PPTX文件的完整转换流程。

## 核心目录结构分析

### 1. **根目录文件**
- **config.inc.php** - 核心配置文件
  - Redis连接配置
  - DeepSeek API配置(API_URL, API_KEY, API_MODE)
  - 内置4套PPT模板配置
  - CORS跨域设置

- **generateOutline.php** - 大纲生成接口
  - 根据用户输入主题生成PPT大纲
  - 使用流式输出，实时返回AI生成内容
  - 生成6个章节，每章节3-5个子章节，每子章节3个小节

- **generateContent.php** - 内容生成接口（核心文件）
  - 将大纲扩展为详细内容
  - 实现实时流式生成和进度反馈
  - 分页处理，支持实时页面计数
  - 使用Redis缓存生成过程和结果

- **asyncPptInfo.php** - 异步PPT信息获取
  - 获取PPT生成状态和进度
  - 模板信息管理

- **downloadPptx.php** - PPTX下载接口
  - 从Redis获取生成的数据
  - 调用AiToPPTX库生成实际的PPTX文件

- **downloadPptxFile.php** - 文件下载服务
- **randomTemplates.php** - 随机模板选择
- **saveConfig.php** - 配置保存

### 2. **AiToPPTX/ 核心库目录**
这是项目的核心PPT生成引擎：

- **include.inc.php** - 主要入口文件
- **`lib/`目录** - 核心功能模块：
  - functions.inc.php - 基础工具函数
  - AiToPptx_MakePresentationXml.php - 生成PPT主文档
  - AiToPptx_MakeSingleSlide.php - 单页幻灯片生成
  - AiToPptx_MakeThemeXml.php - 主题样式生成
  - AiToPptx_DrawSingleObject.php - 图形对象绘制
  - 其他XML结构生成模块

- **`xml/`目录** - PPT的XML模板文件

### 3. **json/ 模板目录**
包含4套内置PPT模板：
- 课程学习汇报
- 读书分享演示  
- 蓝色通用商务
- 蓝色工作汇报总结

每套模板包含`.json`配置文件和`.png`预览图

### 4. **example/ 示例目录**
- generate_pptx_from_json.php - 从JSON生成PPTX的示例
- `markdown_to_pptx_content_json.php` - Markdown转换示例
- `redis.php` - Redis使用示例

### 5. **BusinessLicense/ 商业授权目录**
包含软件商业授权协议文档

## 技术架构特点

### 1. **流式生成架构**
- 采用Server-Sent Events (SSE)实现实时流式输出
- 支持生成进度实时反馈
- 分页处理，避免长时间等待

### 2. **缓存机制**
- 使用Redis缓存生成过程和结果
- 支持断点续传和状态恢复
- 自动清理过期数据

### 3. **模板化设计**
- 预置多套PPT模板
- JSON格式模板配置
- 支持自定义模板扩展

### 4. **AI集成**
- 集成DeepSeek大语言模型
- 两阶段生成：大纲生成 → 内容扩展
- 智能内容结构化处理

## 工作流程

1. **大纲生成阶段** (generateOutline.php)
   - 用户输入主题 → AI生成结构化大纲

2. **内容扩展阶段** (generateContent.php)  
   - 大纲内容扩展 → 详细PPT内容生成

3. **PPTX生成阶段** (downloadPptx.php)
   - JSON数据 → XML结构 → PPTX文件

4. **文件下载** (downloadPptxFile.php)
   - 提供最终PPTX文件下载

## 部署要求
- **PHP >= 7.4**
- **Redis服务器**
- **PHP扩展**: Redis扩展、Zip扩展  
- **目录权限**: `./cache`和`./output`目录需要写权限
- **DeepSeek API Key**配置

这个项目实现了从AI生成内容到最终PPT文件的完整链路，是一个功能完整的AI驱动的PPT生成系统。