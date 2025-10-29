document.addEventListener('DOMContentLoaded', function () {
  /* ----------------------------------------------
     Tab Activation
  ---------------------------------------------- */
  var tabsRoot = document.getElementById('tabs');
  if (tabsRoot) {
    var tabLinks = tabsRoot.querySelectorAll('ul > li > a[href^="#error-tabs-"]');
    var panels = tabsRoot.querySelectorAll('div[id^="error-tabs-"]');

    function activate(hash) {
      tabLinks.forEach(function (a) {
        var li = a.parentElement;
        li.classList.toggle('active', a.getAttribute('href') === hash);
      });
      panels.forEach(function (p) {
        p.classList.toggle('active', '#' + p.id === hash);
      });
    }

    tabLinks.forEach(function (a) {
      a.addEventListener('click', function (e) {
        e.preventDefault();
        activate(a.getAttribute('href'));
      });
    });

    if (tabLinks.length > 0) activate(tabLinks[0].getAttribute('href'));
  }

  /* ----------------------------------------------
     Pretty-print Enhancer (single-line focus + toggle)
  ---------------------------------------------- */
  var CONTEXT_BEFORE = 7;
  var CONTEXT_AFTER  = 5;

  var blocks = document.querySelectorAll('pre.prettyprint');
  blocks.forEach(function (pre) {
    var cls = pre.className || '';
    var hlMatch = cls.match(/highlight:(\d+):(\d+)/);
    var lineFocus = hlMatch ? parseInt(hlMatch[2], 10) : null;

    var rawText = pre.textContent.replace(/\r\n?/g, '\n');
    var lines = rawText.split('\n');
    var total = lines.length;

    function escapeHtml(str) {
      return str
          .replace(/&/g, '&amp;')
          .replace(/</g, '&lt;')
          .replace(/>/g, '&gt;')
          .replace(/\t/g, '    ');
    }

    function buildFragment(start, end) {
      var fragments = [];
      for (var i = start; i <= end; i++) {
        var isHighlight = i === lineFocus;
        var safeLine = escapeHtml(lines[i - 1] || ' ');
        fragments.push('<span class="code-line' + (isHighlight ? ' hl' : '') + '">' + safeLine + '</span>');
      }
      return fragments;
    }

    function scrollHighlight() {
      var target = pre.querySelector('.code-line.hl');
      if (target) {
        requestAnimationFrame(function () {
          pre.scrollTo({
            top: target.offsetTop - pre.clientHeight / 2,
            behavior: 'instant'
          });
        });
      }
    }

    function renderCompact() {
      var rangeStart = lineFocus ? Math.max(1, lineFocus - CONTEXT_BEFORE) : 1;
      var rangeEnd   = lineFocus ? Math.min(total, lineFocus + CONTEXT_AFTER) : total;
      var fragments = buildFragment(rangeStart, rangeEnd);

      if (rangeStart > 1) fragments.unshift('<span class="code-ellipsis">…</span>');
      if (rangeEnd < total) fragments.push('<span class="code-ellipsis">…</span>');

      pre.innerHTML = fragments.join('\n');
      injectToggle('Show full file', renderFull);
      scrollHighlight();
    }

    function renderFull() {
      pre.innerHTML = buildFragment(1, total).join('\n');
      injectToggle('Collapse', renderCompact);
      scrollHighlight();
    }

    function injectToggle(label, handler) {
      var btn = document.createElement('button');
      btn.className = 'expand-toggle';
      btn.textContent = label;
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        handler();
      });
      pre.appendChild(btn);
    }

    renderCompact();
  });
});
