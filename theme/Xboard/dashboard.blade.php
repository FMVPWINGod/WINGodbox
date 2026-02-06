<!doctype html>
<html lang="zh-CN">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no" />
  <title>{{$title}}</title>
  <script type="module" crossorigin src="/theme/{{$theme}}/assets/umi.js"></script>
</head>

<body>

  <script>
    window.routerBase = "/";
    window.settings = {
      title: '{{$title}}',
      assets_path: '/theme/{{$theme}}/assets',
      theme: {
        color: '{{ $theme_config['theme_color'] ?? "default" }}',
      },
      version: '{{$version}}',
      background_url: '{{$theme_config['background_url']}}',
      description: '{{$description}}',
      i18n: [
        'zh-CN',
        'en-US',
        'ja-JP',
        'vi-VN',
        'ko-KR',
        'zh-TW',
        'fa-IR'
      ],
      logo: '{{$logo}}'
    }
  </script>
  <script>
    (function () {
      const hasAuth = () => Boolean(window.localStorage && localStorage.getItem('authorization'));
      const isNoticeRoute = () => {
        const current = `${window.location.pathname}${window.location.hash || ''}`;
        return /notice|announcement|公告/i.test(current);
      };

      if (hasAuth() || !isNoticeRoute()) {
        return;
      }

      const loginText = /^(登录|登入|Login|Sign in)$/i;
      const clickedFlag = '__noticeLoginAutoClicked__';

      const clickLoginTrigger = () => {
        if (window[clickedFlag]) {
          return;
        }
        const candidates = Array.from(
          document.querySelectorAll('button, a, [role="button"], .btn, .n-button')
        );
        const target = candidates.find((el) => loginText.test((el.textContent || '').trim()));
        if (target) {
          window[clickedFlag] = true;
          target.click();
          return true;
        }
        return false;
      };

      const observer = new MutationObserver(() => {
        if (clickLoginTrigger()) {
          observer.disconnect();
        }
      });

      observer.observe(document.documentElement, { childList: true, subtree: true });
      window.addEventListener('load', () => {
        clickLoginTrigger();
      });
    })();
  </script>
  <div id="app"></div>
  {!! $theme_config['custom_html'] !!}
</body>

</html>
