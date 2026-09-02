/**
 * Dainik Bangladesher Kotha - Main Interactive Features & Layout Handlers
 */

document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  // 1. Sticky Header & Back to Top
  const navbar = document.querySelector('.navbar-wrapper');
  const backToTopBtn = document.getElementById('backToTopBtn');

  window.addEventListener('scroll', function () {
    if (window.scrollY > 150) {
      navbar?.classList.add('is-sticky');
    } else {
      navbar?.classList.remove('is-sticky');
    }

    if (backToTopBtn) {
      if (window.scrollY > 350) {
        backToTopBtn.classList.add('show');
      } else {
        backToTopBtn.classList.remove('show');
      }
    }
  });

  if (backToTopBtn) {
    backToTopBtn.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  // 2. Mobile Menu Drawer
  const mobileToggle = document.getElementById('mobileMenuToggle');
  const mainMenu = document.getElementById('mainMenu');
  const navBackdrop = document.getElementById('mobileNavBackdrop');

  if (mobileToggle && mainMenu && navBackdrop) {
    mobileToggle.addEventListener('click', function (e) {
      e.stopPropagation();
      mainMenu.classList.toggle('is-open');
      navBackdrop.classList.toggle('is-open');
    });

    navBackdrop.addEventListener('click', function () {
      mainMenu.classList.remove('is-open');
      navBackdrop.classList.remove('is-open');
      document.getElementById('topInfoOffcanvas')?.classList.remove('open');
      document.getElementById('districtFilterOffcanvas')?.classList.remove('open');
    });
  }

  // 3. Mobile Topbar Info Offcanvas Drawer
  const topbarInfoToggle = document.getElementById('topbarInfoToggle');
  const topInfoOffcanvas = document.getElementById('topInfoOffcanvas');
  const topbarOffcanvasClose = document.getElementById('topbarOffcanvasClose');

  if (topbarInfoToggle && topInfoOffcanvas) {
    topbarInfoToggle.addEventListener('click', function (e) {
      e.stopPropagation();
      topInfoOffcanvas.classList.add('open');
      if (navBackdrop) navBackdrop.classList.add('is-open');
    });

    topbarOffcanvasClose?.addEventListener('click', function () {
      topInfoOffcanvas.classList.remove('open');
      if (navBackdrop) navBackdrop.classList.remove('is-open');
    });
  }

  // 4. Mobile District Filter Offcanvas Drawer
  const mobileDistrictFilterToggle = document.getElementById('mobileDistrictFilterToggle');
  const districtFilterOffcanvas = document.getElementById('districtFilterOffcanvas');
  const districtFilterOffcanvasClose = document.getElementById('districtFilterOffcanvasClose');

  if (mobileDistrictFilterToggle && districtFilterOffcanvas) {
    mobileDistrictFilterToggle.addEventListener('click', function (e) {
      e.stopPropagation();
      districtFilterOffcanvas.classList.add('open');
      if (navBackdrop) navBackdrop.classList.add('is-open');
    });

    districtFilterOffcanvasClose?.addEventListener('click', function () {
      districtFilterOffcanvas.classList.remove('open');
      if (navBackdrop) navBackdrop.classList.remove('is-open');
    });
  }

  // 5. Mobile Sub-Menu Accordion Toggle
  const mobileParentMenuLinks = document.querySelectorAll('.main-menu .menu-item-has-children > a');
  mobileParentMenuLinks.forEach(function (link) {
    link.addEventListener('click', function (e) {
      if (window.innerWidth <= 991) {
        // If clicking link with href="#" or dropdown arrow, toggle accordion
        const parentLi = link.closest('.menu-item-has-children');
        const href = link.getAttribute('href');
        
        if (href === '#' || href === 'javascript:void(0);' || e.target.classList.contains('fa-angle-down')) {
          e.preventDefault();
          parentLi.classList.toggle('is-open');
        } else {
          // Check if user tapped right on arrow or parent container
          if (!parentLi.classList.contains('is-open')) {
            e.preventDefault();
            parentLi.classList.add('is-open');
          }
        }
      }
    });
  });

  // 4. Hero Section Tab Switching (সর্বশেষ, জনপ্রিয়, আলোচিত)
  const tabBtns = document.querySelectorAll('.hero-tab-btn, .tab-btn');
  const tabPanes = document.querySelectorAll('.hero-tab-pane, .tab-pane');

  tabBtns.forEach((btn) => {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      const targetTab = this.getAttribute('data-tab');

      tabBtns.forEach((b) => b.classList.remove('active'));
      tabPanes.forEach((p) => {
        p.classList.remove('active');
        p.style.display = 'none';
      });

      this.classList.add('active');
      const activePane = document.getElementById(targetTab);
      if (activePane) {
        activePane.classList.add('active');
        activePane.style.display = 'block';
      }
    });
  });

  // 5. Saradesh Division Filter Pills (Interactive Client & AJAX Filter)
  const divPills = document.querySelectorAll('.div-pill-btn');
  const districtCards = document.querySelectorAll('.district-news-card');

  divPills.forEach((pill) => {
    pill.addEventListener('click', function (e) {
      e.preventDefault();
      divPills.forEach((p) => p.classList.remove('active'));
      this.classList.add('active');

      const selectedDiv = this.getAttribute('data-division') || 'all';
      let visibleCount = 0;

      districtCards.forEach((card) => {
        const cardDiv = card.getAttribute('data-division');
        if (selectedDiv === 'all' || cardDiv === selectedDiv) {
          card.style.display = 'block';
          visibleCount++;
        } else {
          card.style.display = 'none';
        }
      });

      // If no cards match specific division, show all with badge highlight
      if (visibleCount === 0) {
        districtCards.forEach((card) => {
          card.style.display = 'block';
        });
      }
    });
  });

  // 6. Search Modal Popup
  const searchTrigger = document.getElementById('searchModalToggle') || document.getElementById('searchModalTrigger');
  const searchOverlay = document.getElementById('searchModalOverlay');
  const searchClose = document.getElementById('searchModalClose');
  const searchInput = document.getElementById('siteSearchInput');

  if (searchTrigger && searchOverlay) {
    searchTrigger.addEventListener('click', function (e) {
      e.preventDefault();
      searchOverlay.classList.add('open');
      searchInput?.focus();
    });

    searchClose?.addEventListener('click', function () {
      searchOverlay.classList.remove('open');
    });

    searchOverlay.addEventListener('click', function (e) {
      if (e.target === searchOverlay) {
        searchOverlay.classList.remove('open');
      }
    });
  }

  // 7. Video Modal Player
  const videoTriggers = document.querySelectorAll('[data-video-id]');
  const videoOverlay = document.getElementById('videoModalOverlay');
  const videoIframe = document.getElementById('videoModalIframe');
  const videoClose = document.getElementById('videoModalClose');

  videoTriggers.forEach((trigger) => {
    trigger.addEventListener('click', function (e) {
      e.preventDefault();
      const videoId = this.getAttribute('data-video-id');
      if (videoId && videoIframe && videoOverlay) {
        videoIframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
        videoOverlay.classList.add('open');
      }
    });
  });

  if (videoClose && videoOverlay) {
    const closeVideo = () => {
      videoOverlay.classList.remove('open');
      if (videoIframe) videoIframe.src = '';
    };

    videoClose.addEventListener('click', closeVideo);
    videoOverlay.addEventListener('click', (e) => {
      if (e.target === videoOverlay) closeVideo();
    });
  }

  // Close modals on Esc key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      searchOverlay?.classList.remove('open');
      topInfoOffcanvas?.classList.remove('open');
      navBackdrop?.classList.remove('is-open');
      if (videoOverlay?.classList.contains('open')) {
        videoOverlay.classList.remove('open');
        if (videoIframe) videoIframe.src = '';
      }
      document.getElementById('photoCardModal')?.classList.remove('open');
    }
  });

  // 8. Single Post Features (Font Resizer, Print, Copy Link)
  const fontIncrease = document.getElementById('fontIncreaseBtn');
  const fontDecrease = document.getElementById('fontDecreaseBtn');
  const articleBody = document.getElementById('articleBodyContent') || document.querySelector('.article-body-content');

  let currentFontSize = 1.05;
  if (fontIncrease && articleBody) {
    fontIncrease.addEventListener('click', () => {
      if (currentFontSize < 1.45) {
        currentFontSize += 0.08;
        articleBody.style.fontSize = `${currentFontSize}rem`;
      }
    });
  }

  if (fontDecrease && articleBody) {
    fontDecrease.addEventListener('click', () => {
      if (currentFontSize > 0.90) {
        currentFontSize -= 0.08;
        articleBody.style.fontSize = `${currentFontSize}rem`;
      }
    });
  }

  const printBtn = document.getElementById('printArticleBtn');
  if (printBtn) {
    printBtn.addEventListener('click', () => {
      window.print();
    });
  }

  // 8. Copy Link Button with Smooth Toast & Button State Feedback
  function showCopyToast(message) {
    let toast = document.getElementById('bdkCopyToast');
    if (!toast) {
      toast = document.createElement('div');
      toast.id = 'bdkCopyToast';
      toast.className = 'bdk-toast-notice';
      document.body.appendChild(toast);
    }
    toast.innerHTML = `<i class="fas fa-circle-check"></i> <span>${message || 'সংবাদের লিংক কপি হয়েছে!'}</span>`;
    toast.classList.add('show');
    clearTimeout(toast._timeout);
    toast._timeout = setTimeout(() => {
      toast.classList.remove('show');
    }, 2500);
  }

  function handleCopyAction(btn) {
    const url = window.location.href;
    const originalHtml = btn.innerHTML;

    function onCopiedSuccess() {
      btn.classList.add('copied');
      btn.innerHTML = '<i class="fas fa-check"></i> কপি হয়েছে!';
      showCopyToast('সংবাদের লিংক ক্লিপবোর্ডে কপি হয়েছে!');

      setTimeout(() => {
        btn.classList.remove('copied');
        btn.innerHTML = originalHtml;
      }, 2500);
    }

    if (navigator.clipboard && window.isSecureContext) {
      navigator.clipboard.writeText(url).then(onCopiedSuccess).catch(() => {
        fallbackCopy(url);
      });
    } else {
      fallbackCopy(url);
    }

    function fallbackCopy(text) {
      const textarea = document.createElement('textarea');
      textarea.value = text;
      textarea.style.position = 'fixed';
      textarea.style.opacity = '0';
      document.body.appendChild(textarea);
      textarea.focus();
      textarea.select();
      try {
        document.execCommand('copy');
        onCopiedSuccess();
      } catch (err) {
        prompt('লিংক কপি করতে Ctrl+C চাপুন:', text);
      }
      document.body.removeChild(textarea);
    }
  }

  // Attach to all copy buttons on single and photo story pages
  document.querySelectorAll('#copyLinkBtn, .share-copy, [data-copy-link]').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      handleCopyAction(btn);
    });
  });

  // 9. Photo Card Modal
  const generateCardBtn = document.getElementById('generatePhotoCardBtn');
  const cardModal = document.getElementById('photoCardModal');
  const cardModalClose = document.getElementById('photoCardModalClose');

  if (generateCardBtn && cardModal) {
    generateCardBtn.addEventListener('click', () => {
      cardModal.classList.add('open');
    });

    cardModalClose?.addEventListener('click', () => {
      cardModal.classList.remove('open');
    });
  }
});
