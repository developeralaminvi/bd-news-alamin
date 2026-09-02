/**
 * Dynamic Weather & Prayer Times Widget
 * Uses: OpenWeatherMap Free API (weather) + Aladhan Free API (prayer times)
 * Config: bdkApiConfig is localized from PHP via wp_localize_script()
 *
 * @package BD_News_Alamin
 */

(function () {
  'use strict';

  // Bengali numeral converter
  function toBengaliNum(n) {
    const digits = { '0': '০', '1': '১', '2': '২', '3': '৩', '4': '৪', '5': '৫', '6': '৬', '7': '৭', '8': '৮', '9': '৯' };
    return String(n).replace(/[0-9]/g, d => digits[d]);
  }

  // Get Bengali time-of-day period (AM/PM equivalent)
  function getBengaliPeriod(hour24) {
    const h = parseInt(hour24, 10);
    if (h >= 4  && h < 6)  return 'ভোর';       // 4–5:59 AM
    if (h >= 6  && h < 12) return 'সকাল';      // 6–11:59 AM
    if (h >= 12 && h < 15) return 'দুপুর';     // 12–2:59 PM
    if (h >= 15 && h < 18) return 'বিকাল';     // 3–5:59 PM
    if (h >= 18 && h < 20) return 'সন্ধ্যা';  // 6–7:59 PM
    return 'রাত';                              // 8 PM – 3:59 AM
  }

  // Convert 24h HH:MM → Bengali 12h with period
  // e.g. "17:35" → "বিকাল ৫:৩৫"
  function fmtTimeBN(timeStr) {
    if (!timeStr) return '';
    const [hStr, mStr] = timeStr.split(':');
    const h24  = parseInt(hStr, 10);
    const h12  = h24 % 12 || 12;              // 0→12, 13→1, etc.
    const period = getBengaliPeriod(h24);
    return `${period} ${toBengaliNum(h12)}:${toBengaliNum(mStr.padStart(2, '0'))}`;
  }

  // Map prayer key to Bengali name
  const prayerNames = {
    Fajr:    'ফজর',
    Sunrise: 'সূর্যোদয়',
    Dhuhr:   'যোহর',
    Asr:     'আসর',
    Maghrib: 'মাগরিব',
    Isha:    'ইশা',
  };

  // Weather icon mapping (OWM icon code -> FA icon class + color)
  function getWeatherIconInfo(iconCode) {
    if (!iconCode) return { icon: 'fa-cloud', color: '#94a3b8' };
    const c = iconCode.slice(0, 2);
    const map = {
      '01': { icon: 'fa-sun',          color: '#f59e0b' },  // clear sky
      '02': { icon: 'fa-cloud-sun',    color: '#f59e0b' },  // few clouds
      '03': { icon: 'fa-cloud',        color: '#94a3b8' },  // scattered
      '04': { icon: 'fa-cloud',        color: '#64748b' },  // broken clouds
      '09': { icon: 'fa-cloud-drizzle',color: '#60a5fa' },  // shower rain
      '10': { icon: 'fa-cloud-rain',   color: '#3b82f6' },  // rain
      '11': { icon: 'fa-bolt',         color: '#f59e0b' },  // thunderstorm
      '13': { icon: 'fa-snowflake',    color: '#bae6fd' },  // snow
      '50': { icon: 'fa-smog',         color: '#94a3b8' },  // mist/fog
    };
    return map[c] || { icon: 'fa-cloud', color: '#94a3b8' };
  }

  // Bengali weather description
  function getWeatherDesc(desc) {
    const map = {
      'clear sky':           'পরিষ্কার আকাশ',
      'few clouds':          'আংশিক মেঘলা',
      'scattered clouds':    'ছড়ানো মেঘ',
      'broken clouds':       'মেঘাচ্ছন্ন',
      'shower rain':         'গুঁড়ি গুঁড়ি বৃষ্টি',
      'rain':                'বৃষ্টি',
      'light rain':          'হালকা বৃষ্টি',
      'moderate rain':       'মাঝারি বৃষ্টি',
      'heavy intensity rain':'ভারী বৃষ্টি',
      'thunderstorm':        'বজ্রসহ বৃষ্টি',
      'snow':                'তুষারপাত',
      'mist':                'কুয়াশাচ্ছন্ন',
      'haze':                'ধোঁয়াশা',
      'fog':                 'ঘন কুয়াশা',
      'overcast clouds':     'সম্পূর্ণ মেঘাচ্ছন্ন',
    };
    return map[(desc || '').toLowerCase()] || desc;
  }

  /* ============================================================
   * WEATHER: fetch from OpenWeatherMap
   * ============================================================ */
  function loadWeather() {
    const apiKey = (window.bdkApiConfig && window.bdkApiConfig.owmKey) || '';
    const city   = (window.bdkApiConfig && window.bdkApiConfig.weatherCity) || 'Dhaka';

    if (!apiKey) {
      setWeatherText('ঢাকা — আজ মনোরম');
      return;
    }

    const url = `https://api.openweathermap.org/data/2.5/weather?q=${encodeURIComponent(city)},BD&appid=${apiKey}&units=metric&lang=en`;

    fetch(url)
      .then(r => r.json())
      .then(data => {
        if (!data || data.cod !== 200) {
          setWeatherText(`${city} — ডেটা পাওয়া যায়নি`);
          return;
        }
        const temp    = Math.round(data.main.temp);
        const desc    = getWeatherDesc(data.weather[0].description);
        const icon    = data.weather[0].icon;
        const info    = getWeatherIconInfo(icon);
        const cityBN  = city;
        const text    = `${cityBN} ${toBengaliNum(temp)}° সে. (${desc})`;
        setWeatherText(text, info);
      })
      .catch(() => setWeatherText(`${city} — সংযোগ ব্যর্থ`));
  }

  function setWeatherText(text, iconInfo) {
    const el     = document.getElementById('bdkWeatherText');
    const iconEl = document.getElementById('bdkWeatherIcon');

    if (el) el.textContent = text;
    if (iconEl && iconInfo) {
      // Remove all fa-* icon classes and re-set
      iconEl.className = 'fas ' + iconInfo.icon;
      iconEl.style.color = iconInfo.color;
    }

    // Also update mobile offcanvas
    const mob = document.getElementById('bdkWeatherMobile');
    if (mob) {
      const spanEl = mob.querySelector('span');
      if (spanEl) spanEl.textContent = text;
      const iEl = mob.querySelector('i');
      if (iEl && iconInfo) {
        iEl.className = 'fas ' + iconInfo.icon;
        iEl.style.color = iconInfo.color;
      }
    }
  }

  // Add minutes offset to "HH:MM" time string
  function addMinutesToTimeStr(timeStr, minutesToAdd) {
    if (!timeStr || !minutesToAdd) return timeStr;
    const [h, m] = timeStr.split(':').map(Number);
    const total = ((h * 60 + m + minutesToAdd) + 1440) % 1440;
    const newH = Math.floor(total / 60);
    const newM = total % 60;
    return `${String(newH).padStart(2, '0')}:${String(newM).padStart(2, '0')}`;
  }

  /* ============================================================
   * PRAYER: fetch from Aladhan API + countdown timer
   * ============================================================ */
  let prayerTimings = null;
  let countdownInterval = null;

  function loadPrayer() {
    const city    = (window.bdkApiConfig && window.bdkApiConfig.prayerCity) || 'Dhaka';
    const school  = (window.bdkApiConfig && window.bdkApiConfig.prayerSchool) || '1'; // 1 = Hanafi (Bangladesh standard)
    const today   = new Date();
    const day     = today.getDate();
    const month   = today.getMonth() + 1;
    const year    = today.getFullYear();

    // method 1 = University of Islamic Sciences, Karachi (Standard for South Asia/BD)
    // school 1 = Hanafi juristic calculation for Asr
    const url = `https://api.aladhan.com/v1/timingsByCity/${day}-${month}-${year}?city=${encodeURIComponent(city)}&country=BD&method=1&school=${school}`;

    fetch(url)
      .then(r => r.json())
      .then(data => {
        if (!data || data.code !== 200 || !data.data || !data.data.timings) {
          setPrayerText('নামাজের সময় পাওয়া যায়নি');
          return;
        }

        const raw = data.data.timings;
        const maghribOff = (window.bdkApiConfig && parseInt(window.bdkApiConfig.maghribOffset, 10)) || 3;
        const dhuhrOff   = (window.bdkApiConfig && parseInt(window.bdkApiConfig.dhuhrOffset, 10)) || 2;
        const ishaOff    = (window.bdkApiConfig && parseInt(window.bdkApiConfig.ishaOffset, 10)) || 2;
        const fajrOff    = (window.bdkApiConfig && parseInt(window.bdkApiConfig.fajrOffset, 10)) || 0;
        const asrOff     = (window.bdkApiConfig && parseInt(window.bdkApiConfig.asrOffset, 10)) || 0;

        // Apply Islamic Foundation Bangladesh safety offsets (ইহতিয়াত)
        prayerTimings = {
          Fajr:    addMinutesToTimeStr(raw.Fajr, fajrOff),
          Sunrise: raw.Sunrise,
          Dhuhr:   addMinutesToTimeStr(raw.Dhuhr, dhuhrOff),
          Asr:     addMinutesToTimeStr(raw.Asr, asrOff),
          Maghrib: addMinutesToTimeStr(raw.Maghrib, maghribOff),
          Isha:    addMinutesToTimeStr(raw.Isha, ishaOff),
        };

        updatePrayerDisplay();
        // Start countdown ticker
        if (countdownInterval) clearInterval(countdownInterval);
        countdownInterval = setInterval(updatePrayerDisplay, 30000); // refresh every 30s
      })
      .catch(() => setPrayerText('নামাজ: সংযোগ ব্যর্থ'));
  }

  function updatePrayerDisplay() {
    if (!prayerTimings) return;

    const now = new Date();
    const nowMin = now.getHours() * 60 + now.getMinutes();

    // Ordered prayer keys (excluding Midnight, Imsak etc)
    const keys = ['Fajr', 'Sunrise', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];

    let nextPrayer = null;
    let nextMin    = null;

    for (const key of keys) {
      if (!prayerTimings[key]) continue;
      const [hStr, mStr] = prayerTimings[key].split(':');
      const pMin = parseInt(hStr, 10) * 60 + parseInt(mStr, 10);
      if (pMin > nowMin) {
        nextPrayer = key;
        nextMin    = pMin;
        break;
      }
    }

    // If past Isha, wrap to Fajr (next day)
    if (!nextPrayer) {
      nextPrayer = 'Fajr';
      const [hStr, mStr] = (prayerTimings['Fajr'] || '05:00').split(':');
      nextMin = parseInt(hStr, 10) * 60 + parseInt(mStr, 10) + 24 * 60;
    }

    const remaining = nextMin - nowMin;
    const remH = Math.floor(remaining / 60);
    const remM = remaining % 60;
    const timeBN = fmtTimeBN(prayerTimings[nextPrayer] || '');
    const nameBN = prayerNames[nextPrayer] || nextPrayer;

    let countdownText = '';
    if (remH > 0) {
      countdownText = `(${toBengaliNum(remH)}ঘ ${toBengaliNum(remM)}মি বাকি)`;
    } else {
      countdownText = `(${toBengaliNum(remM)}মি বাকি)`;
    }

    setPrayerText(`${nameBN}: ${timeBN}`, countdownText);
  }

  function setPrayerText(mainText, countdown) {
    const el  = document.getElementById('bdkPrayerText');
    const cd  = document.getElementById('bdkPrayerCountdown');
    if (el) el.textContent = mainText;
    if (cd) cd.textContent = countdown || '';

    // Mobile
    const mob  = document.getElementById('bdkPrayerMobileText');
    const mobCd = document.getElementById('bdkPrayerMobileCountdown');
    if (mob)  mob.textContent  = mainText;
    if (mobCd) mobCd.textContent = countdown || '';
  }

  /* ============================================================
   * Init on DOMContentLoaded
   * ============================================================ */
  function init() {
    loadWeather();
    loadPrayer();
    // Refresh weather every 30 minutes
    setInterval(loadWeather, 30 * 60 * 1000);
    // Refresh prayer data every 6 hours (in case page is left open overnight)
    setInterval(loadPrayer, 6 * 60 * 60 * 1000);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
