# RenewSEO - 面向 TypeRenew 的轻量 SEO 中心插件
本插件是一款面向 TypeRenew 的轻量 SEO 中心插件，适配 PHP 8 与 MySQL 8，围绕站点收录、页面元信息、规范链接、结构化数据、主动推送与日志监控，提供一套默认可用、便于统一管理的 SEO 能力组合。

## 功能特性
- **站点文件自动生成与同步**
  - 自动生成 `robots.txt`
  - 自动生成 `sitemap.xml`
  - 支持 `sitemap.txt`
  - 支持 IndexNow 密钥文件写入
  - 内容、分类、链接结构变更后自动重建
- **页面 SEO 元信息增强**
  - 单篇文章/页面自定义 SEO 标题、描述、关键词
  - 支持自定义 Canonical 地址
  - 支持自定义 OG 图片与 Robots Meta
  - 描述为空时自动生成摘要
  - 图片缺少 `alt` 时可自动补全
- **规范化与收录控制**
  - Canonical 主机统一
  - `page=1` 去重
  - 跟踪参数剥离
  - 末尾斜杠统一策略
  - 支持搜索页、404 页、标签页、作者页、分页页等 `noindex` 控制
- **社交分享与结构化数据**
  - Open Graph 与 Twitter Card 标签输出
  - Article / WebPage 结构化数据
  - BreadcrumbList 面包屑结构化数据
  - WebSite SearchAction 站内搜索结构化数据
  - 可选发布时间/更新时间时间因子输出
- **主动推送与收录通知**
  - 支持百度普通推送
  - 支持百度快速收录推送回退
  - 支持 IndexNow 推送
  - 支持 Bing Webmaster 批量推送
  - 支持内容发布、编辑、删除、状态变更后的自动调度
- **日志与后台管理**
  - 后台统一 SEO 中心面板
  - 文件状态与预览查看
  - 运行日志记录
  - 404 访问记录
  - 日志自动清理

## 适用场景
- 基于 TypeRenew 构建的个人博客、内容站、小型资讯站
- 希望统一管理 `robots.txt`、Sitemap、页面 Meta 与推送配置的站点
- 需要在后台完成基础 SEO 配置，而不想手动维护根目录静态文件的场景
- 希望在保持 TypeRenew 轻量内核风格的前提下补齐常用 SEO 能力的站点

## 安装方式
1. 将插件目录上传到站点的 `/usr/plugins/` 目录
2. 确保目录名称为 `RenewSEO`
3. 登录后台，进入“控制台 -> 插件”
4. 找到并启用 `RenewSEO`
5. 启用后，在左侧导航中进入“SEO 中心”面板完成配置

## 面板说明
插件后台面板主要包含以下模块：

- **概览与全局**
  - 插件启停
  - 缓存与面板显示数量
  - 日志保留时长
  - 404 记录与自动清理
- **爬虫与收录**
  - Robots 默认策略
  - 指定爬虫放行或拒绝
  - 屏蔽路径配置
  - Sitemap 开关、拆分数量与附加地址
- **页面 SEO**
  - Canonical 规则
  - OG 与默认图片
  - 图片 `alt` 自动补全
  - 结构化数据与时间因子
  - 各类页面 `noindex` 策略
- **主动推送**
  - 百度推送
  - IndexNow 推送
  - Bing 推送
  - 异步推送与请求超时设置
- **文件与日志**
  - `robots.txt` 与 Sitemap 状态
  - 最近运行日志
  - 最近 404 记录

## 内容编辑能力
在文章和独立页面编辑界面中，插件会额外提供以下字段：

- SEO 标题
- SEO 描述
- SEO 关键词
- Canonical 覆盖地址
- OG 图片地址
- Robots Meta 策略

适合对重点页面进行单独优化，不必完全依赖全局默认规则。

## 自动生成文件
插件会按配置接管并维护以下站点根目录文件：

- `robots.txt`
- `sitemap.xml`
- `sitemap.txt`
- `sitemap-*.xml`
- `IndexNowKey.txt` 这一类密钥校验文件

说明：
- 插件仅会覆盖自己生成并可识别的托管文件
- 若根目录存在同名但并非插件托管的文件，插件会停止接管并保留原文件
- 停用插件后，会尝试清理由插件生成的 SEO 文件

## 目录结构
```text
RenewSEO/
├── assets/              # 后台面板静态资源
├── view/                # 后台视图模板
├── Plugin.php           # 插件主入口与 Hook 注册
├── Settings.php         # 配置默认值、归一化与读写
├── Panel.php            # 后台 SEO 中心面板
├── Action.php           # 面板操作与异步入口
├── Meta.php             # Meta、Canonical、OG、Schema 输出
├── Files.php            # robots/sitemap/密钥文件生成与同步
├── Push.php             # 百度、IndexNow、Bing 推送调度
├── Log.php              # 运行日志与 404 记录
├── Text.php             # 文本与转义辅助
└── view/                # 面板表单与日志视图
```

## 注意事项
- 本插件提供的是常用 SEO 基础能力，不替代专业 SEO 平台、站长平台或外部抓取分析工具
- 启用主动推送前，请先确认站点 URL、路由与 Canonical 规则已经稳定
- 若站点原本手动维护了 `robots.txt` 或 Sitemap，请先确认是否需要交给插件统一接管
- 如果主题或其他插件也会输出 Meta、Canonical、OG 或 Schema，请留意重复输出问题
- IndexNow、Bing、百度推送依赖外部网络请求，若服务器无法访问对应接口，任务会记录失败日志

## 开源许可协议
本项目基于 GNU General Public License 2.0 协议开源。

核心条款：
- 可以自由使用、修改、分发本软件
- 分发时必须保留原始版权声明和许可证
- 修改后的版本必须以相同协议开源
- 不提供任何担保，作者不承担使用本软件产生的任何责任

完整协议文本见 [LICENSE](LICENSE) 文件或访问 [GNU GPL 2.0](https://www.gnu.org/licenses/old-licenses/gpl-2.0.html)。
