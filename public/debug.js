document.addEventListener('DOMContentLoaded', () => {
  /* ----------------------------------------------
     Tab Activation
  ---------------------------------------------- */
  const tabsRoot = document.getElementById('tabs');
  if (tabsRoot) {
    const tabLinks = tabsRoot.querySelectorAll('ul > li > a[href^="#error-tabs-"]');
    const panels = tabsRoot.querySelectorAll('div[id^="error-tabs-"]');

    function activate(hash) {
      for (const a of tabLinks) {
        const li = a.parentElement;
        li.classList.toggle('active', a.getAttribute('href') === hash);
      }
      for (const p of panels) {
        p.classList.toggle('active', `#${p.id}` === hash);
      }
    }

    for (const a of tabLinks) {
      a.addEventListener('click', e => {
        e.preventDefault();
        activate(a.getAttribute('href'));
      });
    }

    if (tabLinks.length > 0) {
      activate(tabLinks[0].getAttribute('href'));
    }
  }

  /* ----------------------------------------------
     Pretty-print Enhancer (single-line focus + toggle)
  ---------------------------------------------- */
  const CONTEXT_BEFORE = 7;
  const CONTEXT_AFTER = 5;

  const blocks = document.querySelectorAll('pre.prettyprint');
  for (const pre of blocks) {
    const cls = pre.className || '';
    const hlMatch = cls.match(/highlight:(\d+):(\d+)/);
    const lineFocus = hlMatch ? Number.parseInt(hlMatch[2], 10) : null;

    const rawText = pre.textContent.replaceAll('\r\n', '\n');
    const lines = rawText.split('\n');
    const total = lines.length;

    const escapeHtml = str => str
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('\t', '    ');

    function buildFragment(start, end) {
      const fragments = [];
      for (let i = start; i <= end; i++) {
        const isHighlight = i === lineFocus;
        const safeLine = escapeHtml(lines[i - 1] || ' ');
        fragments.push(
            `<span class="code-line${isHighlight ? ' hl' : ''}">${safeLine}</span>`
        );
      }
      return fragments;
    }

    function scrollHighlight() {
      const target = pre.querySelector('.code-line.hl');
      if (target) {
        requestAnimationFrame(() => {
          pre.scrollTo({
            top: target.offsetTop - pre.clientHeight / 2,
            behavior: 'instant',
          });
        });
      }
    }

    function injectToggle(label, handler) {
      const btn = document.createElement('button');
      btn.className = 'expand-toggle';
      btn.textContent = label;
      btn.addEventListener('click', e => {
        e.preventDefault();
        e.stopPropagation();
        handler();
      });
      pre.appendChild(btn);
    }

    function renderCompact() {
      const rangeStart = lineFocus ? Math.max(1, lineFocus - CONTEXT_BEFORE) : 1;
      const rangeEnd = lineFocus ? Math.min(total, lineFocus + CONTEXT_AFTER) : total;
      const fragments = buildFragment(rangeStart, rangeEnd);

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

    renderCompact();
  }
});
