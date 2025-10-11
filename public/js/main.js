const OverlayScrollbars = OverlayScrollbarsGlobal.OverlayScrollbars;

/* Menu */
const $menu = document.querySelector('.menu');
if ($menu) {
  const $menuOpen = $menu.querySelector('.menu__open');
  $menuOpen.addEventListener('click', () => {
    $menu.classList.add('menu--active');
    document.body.classList.add('body--lock');
  });

  const $menuClose = $menu.querySelector('.menu__close');
  $menuClose.addEventListener('click', () => {
    $menu.classList.remove('menu--active');
    document.body.classList.remove('body--lock');
  });
}

/* Dropdown */
const $dropdowns = document.querySelectorAll('.dropdown');
$dropdowns.forEach($filter => {
  const $btn = $filter.querySelector('.dropdown__btn');
  $btn.addEventListener('click', () => $filter.classList.toggle('dropdown--active'));
});

window.addEventListener('click', (e) => {
  const $activeDropdown = document.querySelector('.dropdown--active');
  const isInner = e.target.closest('.dropdown') && !e.target.classList.contains('dropdown');
  if (!$activeDropdown || isInner) {
    return;
  }

  $activeDropdown.classList.remove('dropdown--active');
});

/* Header */
const $header = document.querySelector('.header');
if ($header) {
  window.addEventListener('scroll', () => {
    const height = $header.offsetHeight + 20;
    if (window.scrollY > height && !$header.classList.contains('header--fixed')) {
      $header.classList.add('header--fixed');
    } else if (window.scrollY <= height && $header.classList.contains('header--fixed')) {
      $header.classList.remove('header--fixed');
    }
  });
}

/* Shave.js */
!function (e, t) { "object" == typeof exports && "undefined" != typeof module ? module.exports = t() : "function" == typeof define && define.amd ? define(t) : (e = "undefined" != typeof globalThis ? globalThis : e || self).shave = t() }(this, function () { "use strict"; function q(e, t) { var n = "function" == typeof Symbol && e[Symbol.iterator]; if (!n) return e; var o, r, i = n.call(e), a = []; try { for (; (void 0 === t || 0 < t--) && !(o = i.next()).done;)a.push(o.value) } catch (e) { r = { error: e } } finally { try { o && !o.done && (n = i.return) && n.call(i) } finally { if (r) throw r.error } } return a } function T(e, t, n) { if (n || 2 === arguments.length) for (var o, r = 0, i = t.length; r < i; r++)!o && r in t || ((o = o || Array.prototype.slice.call(t, 0, r))[r] = t[r]); return e.concat(o || Array.prototype.slice.call(t)) } return function (e, t, n) { if (void 0 === n && (n = {}), void 0 === t || isNaN(t)) throw Error("maxHeight is required"); var o = "string" == typeof (e = e) ? T([], q(document.querySelectorAll(e)), !1) : "length" in e ? T([], q(e), !1) : [e]; if (o.length) for (var r = void 0 === (e = n.character) ? "…" : e, i = void 0 === (e = n.classname) ? "js-shave" : e, e = void 0 === (e = n.spaces) || e, a = n.charclassname, l = void 0 === a ? "js-shave-char" : a, c = void 0 === (a = n.link) ? {} : a, s = "boolean" != typeof e || e, f = c && "{}" !== JSON.stringify(c) && c.href, d = f ? "a" : "span", h = 0; h < o.length; h += 1) { var u = o[h], v = u.style, y = u.querySelector("." + i), m = void 0 === u.textContent ? "innerText" : "textContent", y = (y && (u.removeChild(u.querySelector("." + l)), u[m] = u[m]), u[m]), p = s ? y.split(" ") : y; if (!(p.length < 2)) { var y = v.height, g = (v.height = "auto", v.maxHeight); if (v.maxHeight = "none", !(u.offsetHeight <= t)) { var x, b = f && c.textContent ? c.textContent : r, j = document.createElement(d), C = { className: l, textContent: b }; for (x in C) j[x] = C[x], j.textContent = r; if (f) for (var A in c) j[A] = c[A]; for (var E, H = p.length - 1, S = 0; S < H;)E = S + H + 1 >> 1, u[m] = s ? p.slice(0, E).join(" ") : p.slice(0, E), u.insertAdjacentElement("beforeend", j), u.offsetHeight > t ? H = E - 1 : S = E; u[m] = s ? p.slice(0, H).join(" ") : p.slice(0, H), u.insertAdjacentElement("beforeend", j); var b = s ? " ".concat(p.slice(H).join(" ")) : p.slice(H), b = document.createTextNode(b), N = document.createElement("span"); N.classList.add(i), N.style.display = "none", N.appendChild(b), u.insertAdjacentElement("beforeend", N) } v.height = y, v.maxHeight = g } } } });

/* News */
shave('.news-item__text', 80);

const $news = document.querySelector('.news');
if ($news) {
  const $pagination = $news.querySelector('.news__pagination');
  if ($pagination) {
    $news.classList.add('news--pagination');
  }
}

/* File field */
const $inputs = document.querySelectorAll('.js-file-input');
$inputs.forEach($input => {
  $input.addEventListener('change', () => {
    const output = $input.dataset.fileOutput;
    if (!output) {
      return;
    }

    const $value = document.querySelector(`.js-file-value[data-file-output="${output}"]`);
    $value.innerText = $input.files[0].name;
  });
});

/* Select */
const $selects = document.querySelectorAll('.select-field');
$selects.forEach($select => {
  const $easySelect = createElem('div', 'easy-select');
  $select.parentNode.insertBefore($easySelect, $select);
  $select.classList.add('easy-select__input');
  $easySelect.append($select);
  $easySelect.tabIndex = 1;

  /* Field */
  const $easySelectField = createElem('div', 'easy-select__field');
  $easySelectField.innerText = $select.options[0].innerText;
  $easySelectField.addEventListener('click', () => {
    $easySelectList.classList.toggle('easy-select__list--active');
  });
  $easySelect.append($easySelectField);

  /* Items */
  const $options = $select.querySelectorAll('option');
  const $easySelectList = createElem('div', 'easy-select__list');
  $options.forEach(($option, index) => {
    const $item = createElem('div', 'easy-select__item', {
      innerText: $option.innerText,
    });

    if ($option.value === '') {
      $item.classList.add('easy-select__item--placeholder');
    }

    $item.dataset.selectIndex = index;
    $item.addEventListener('click', () => {
      $select.selectedIndex = +$item.dataset.selectIndex;
      $easySelectField.innerText = $item.innerText;
      $easySelect.blur();
      $easySelectList.classList.remove('easy-select__list--active');
    });

    $item.addEventListener('mouseover', () => {
      const oldHoverItem = $easySelect.querySelector('.easy-select__item--hover');
      if (oldHoverItem) {
        oldHoverItem.classList.remove('easy-select__item--hover');
      }
      $item.classList.add('easy-select__item--hover');
    });

    $easySelectList.append($item);
  });
  $easySelect.append($easySelectList);

  /* Close when click outside */
  window.addEventListener('click', e => {
    if (!e.target.classList.contains('easy-select') && !e.target.closest('.easy-select')) {
      $easySelectList.classList.remove('easy-select__list--active');
    }
  });

  /* Key controls */
  $easySelect.addEventListener('keyup', e => {
    if (e.code === 'Enter') {
      $easySelectList.classList.toggle('easy-select__list--active');
    }

    if (e.code === 'Escape') {
      $easySelectList.classList.remove('easy-select__list--active');
    }
  });

  OverlayScrollbars($easySelectList, {});
});

/* Input only numbers */
const $numInputs = document.querySelectorAll('.input--num');
$numInputs.forEach($input => {
  setInputFilter($input, (value) => {
    return /^-?\d*[.,]?\d*$/.test(value);
  });
});

/* Product */
const $products = document.querySelectorAll('.product');
$products.forEach($product => {
  const $navSlider = $product.querySelector('.product__nav-slider');
  const $bigSlider = $product.querySelector('.product__big-slider')
  const navSlider = new Swiper($navSlider, {
    direction: 'horizontal',
    slidesPerView: 'auto',
    breakpoints: {
      768: {
        direction: 'vertical',
      }
    }
  });

  const bigSlider = new Swiper($bigSlider, {
    slidesPerView: 'auto',
    spaceBetween: 0,
    thumbs: {
      swiper: navSlider,
    },
    navigation: {
      prevEl: '.product__slider-prev',
      nextEl: '.product__slider-next',
      clickable: true,
    },
  });

  window.addEventListener('resize', () => {
    if ((window.innerWidth >= 768 && navSlider.params.direction !== 'vertical') ||
      (window.innerWidth < 768 && navSlider.params.direction !== 'horizontal')) {
      navSlider.update();
    }
  });

  navSlider.on('click', () => {
    const $clickedSlide = bigSlider.el.querySelectorAll('.swiper-slide')[navSlider.clickedIndex];
    if (!$clickedSlide.classList.contains('product__big-slide--video')) {
      return;
    }

    const $video = $clickedSlide.querySelector('.product__big-slide-video');
    const url = $video.dataset.src;
    if (!url) {
      return;
    }

    let $iframe;
    if (url.includes('rutube.ru')) {
      $iframe = createRutubeFrame(url);
    } else if (url.includes('mail.ru')) {
      $iframe = createMailFrame(url);
    } else {
      $iframe = createYTFrame(url);
    }

    const popup = createPopup(`
      <div class="popup__video">${$iframe.outerHTML}</div>
    `);
    popup.show();
  });


  /* Video */
  bigSlider.on('slideChange', () => {
    const $activeSlide = bigSlider.el.querySelectorAll('.swiper-slide')[bigSlider.activeIndex];
    if (!$activeSlide.classList.contains('product__big-slide--video')) {
      return;
    }

    bigSlider.slideTo(bigSlider.previousIndex);
  });
});

/* Tabs */
const $tabsLists = document.querySelectorAll('.tabs');
$tabsLists.forEach($tabs => {
  const $btns = $tabs.querySelectorAll('.tabs__btn');
  $btns.forEach(($btn, index) => {
    $btn.addEventListener('click', () => {
      const $oldActiveBtn = $tabs.querySelector('.tabs__btn--active');
      const $oldActiveTab = $tabs.querySelector('.tabs__item--active');
      const $newActiveBtn = $tabs.querySelectorAll('.tabs__btn')[index];
      const $newActiveTab = $tabs.querySelectorAll('.tabs__item')[index];

      $oldActiveTab.classList.remove('tabs__item--active');
      $oldActiveBtn.classList.remove('tabs__btn--active');

      $newActiveBtn.classList.add('tabs__btn--active');
      $newActiveTab.classList.add('tabs__item--active');
    });
  });
});

/* Smooth scroll */
const $anchors = document.querySelectorAll('a[href*="#"]');
$anchors.forEach($anchor => {
  $anchor.addEventListener('click', e => {
    const id = $anchor.getAttribute('href');
    const headerHeight = document.querySelector('.header').offsetHeight;

    if (id[0] === '#') {
      e.preventDefault();
    }

    if (id === '#') {
      return;
    }

    const $elem = document.querySelector(id);
    if ($elem) {
      const additionOffset = -2;
      const offsetTop = $elem.getBoundingClientRect().top - headerHeight - additionOffset;
      window.scrollBy({ top: (offsetTop), left: 0, behavior: 'smooth' });
    }
  });
});


function createYTFrame(url) {
  const $iframe = document.createElement('iframe');
  $iframe.setAttribute('src', `${url}?autoplay=1&enablejsapi=1&rel=0`);
  $iframe.setAttribute('autoplay', '');
  $iframe.setAttribute('frameborder', '0');
  $iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');
  $iframe.setAttribute('allowfullscreen', '');

  return $iframe;
}

function createRutubeFrame(url) {
  const $iframe = document.createElement('iframe');
  $iframe.setAttribute('src', `${url}`);
  $iframe.setAttribute('allow', 'clipboard-write; autoplay');
  $iframe.setAttribute('frameborder', '0');
  $iframe.setAttribute('webkitAllowFullScreen', '');
  $iframe.setAttribute('mozallowfullscreen', '');
  $iframe.setAttribute('allowFullScreen', '');

  return $iframe;
}

function createMailFrame(url) {
  const $iframe = document.createElement('iframe');
  $iframe.setAttribute('src', `${url}`);
  $iframe.setAttribute('frameborder', '0');
  $iframe.setAttribute('scrolling', 'no');
  $iframe.setAttribute('webkitallowfullscreen', '');
  $iframe.setAttribute('mozallowfullscreen', '');
  $iframe.setAttribute('allowfullscreen', '');

  return $iframe;
}

/* Popup */
function createPopup($content, className = '') {
  const $closeBtn = createElem('button', 'popup__close');

  const $popupContent = createElem('div', 'popup__content', {
    innerHTML: $content,
  });
  $popupContent.appendChild($closeBtn);

  const $popup = createElem('div', `popup ${className}`);
  $popup.appendChild($popupContent);

  $popup.addEventListener('click', (e) => {
    if ($popup === e.target) {
      closePopup($popup);
    }
  });
  $closeBtn.addEventListener('click', () => closePopup($popup), { once: true });

  return {
    el: $popup,
    close: () => closePopup($popup),
    show: () => showPopup($popup)
  };
}

function closePopup($popup) {
  $popup.classList.remove('popup--active');
  setTimeout(() => $popup.remove(), 1000);
}

function showPopup($popup) {
  document.body.append($popup);
  $popup.classList.add('popup--show');
  setTimeout(() => $popup.classList.add('popup--active'), 50);
}


function setInputFilter(textbox, inputFilter) {
  ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop", "focusout"].forEach(function (event) {
    textbox.addEventListener(event, function () {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      }

      else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      }

      else {
        this.value = "";
      }
    });
  });
}

function createElem(type, className, options) {
  const $elem = document.createElement(type);
  $elem.className = className;
  for (let key in options) {
    $elem[key] = options[key];
  }

  return $elem;
}