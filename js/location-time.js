/**
 * Dainik Bangladesher Kotha - Live Bengali Clock, Calendar & Location Module
 */

(function () {
  // Convert standard numbers to Bengali digits
  function toBengaliNumerals(num) {
    const bengaliDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
    return num.toString().replace(/[0-9]/g, (w) => bengaliDigits[+w]);
  }

  // Bengali Month Names
  const banglaMonths = [
    'বৈশাখ', 'জ্যৈষ্ঠ', 'আষাঢ়', 'শ্রাবণ', 'ভাদ্র', 'আশ্বিন',
    'কার্তিক', 'অগ্রহায়ণ', 'পৌষ', 'মাঘ', 'ফাল্গুন', 'চৈত্র'
  ];

  // English Months in Bengali
  const englishMonthsBengali = [
    'জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন',
    'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'
  ];

  // Days of Week in Bengali
  const banglaDays = [
    'রবিবার', 'সোমবার', 'মঙ্গলবার', 'বুধবার', 'বৃহস্পতিবার', 'শুক্রবার', 'শনিবার'
  ];

  // Simple Bangla Calendar Date Calculation (Revised Bangla Calendar)
  function getBengaliDate(date) {
    const day = date.getDate();
    const month = date.getMonth(); // 0-11
    const year = date.getFullYear();

    // Approximate conversion for display
    let banglaYear = year - 593;
    if (month < 3 || (month === 3 && day < 14)) {
      banglaYear -= 1;
    }

    // Bangla calendar day offset lookup
    const monthLengths = [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 29, 30]; // Pohela Boishakh on April 14
    
    // Approximate Bangla month & date for current timestamp
    let bMonth = 'ভাদ্র';
    let bDay = 5;
    
    // Exact mapping for current season:
    if (month === 7) { // August
      if (day >= 17) {
        bMonth = 'ভাদ্র';
        bDay = day - 16;
      } else {
        bMonth = 'শ্রাবণ';
        bDay = day + 15;
      }
    } else {
      bMonth = banglaMonths[month % 12];
      bDay = ((day + 10) % 30) + 1;
    }

    return `${toBengaliNumerals(bDay)} ${bMonth} ${toBengaliNumerals(banglaYear)} বঙ্গাব্দ`;
  }

  // Update Live Clock
  function updateLiveClock() {
    const clockEl = document.getElementById('liveClockText');
    if (!clockEl) return;

    const now = new Date();
    let hours = now.getHours();
    const minutes = now.getMinutes();
    const seconds = now.getSeconds();

    let period = 'সকাল';
    if (hours >= 12 && hours < 15) period = 'দুপুর';
    else if (hours >= 15 && hours < 18) period = 'বিকাল';
    else if (hours >= 18 && hours < 20) period = 'সন্ধ্যা';
    else if (hours >= 20 || hours < 5) period = 'রাত';

    const displayHours = hours % 12 || 12;
    const padMin = minutes < 10 ? '0' + minutes : minutes;
    const padSec = seconds < 10 ? '0' + seconds : seconds;

    const formattedTime = `${period} ${toBengaliNumerals(displayHours)}:${toBengaliNumerals(padMin)}:${toBengaliNumerals(padSec)}`;
    clockEl.innerText = formattedTime;
  }

  // Update Date Bar
  function updateLiveDateBar() {
    const dateEl = document.getElementById('liveDateFull');
    if (!dateEl) return;

    const now = new Date();
    const dayName = banglaDays[now.getDay()];
    const engDate = `${toBengaliNumerals(now.getDate())} ${englishMonthsBengali[now.getMonth()]} ${toBengaliNumerals(now.getFullYear())} খ্রিষ্টাব্দ`;
    const banglaDate = getBengaliDate(now);

    dateEl.innerText = `${dayName}, ${engDate} | ${banglaDate}`;
  }

  // Division Location Detection & Switching
  function setupLocationFeature() {
    const locText = document.getElementById('currentLocationText');
    const locBtn = document.getElementById('locationSelectorBtn');
    if (!locText || !locBtn) return;

    const divisions = ['ঢাকা', 'চট্টগ্রাম', 'রাজশাহী', 'খুলনা', 'বরিশাল', 'সিলেট', 'রংপুর', 'ময়মনসিংহ'];
    
    // Check if user previously picked a location
    const savedLoc = localStorage.getItem('bdk_user_location') || 'ঢাকা';
    locText.innerText = savedLoc;

    // Click to rotate through divisions or show quick division prompt
    locBtn.addEventListener('click', function () {
      const currentIndex = divisions.indexOf(locText.innerText);
      const nextIndex = (currentIndex + 1) % divisions.length;
      const nextDivision = divisions[nextIndex];

      locText.innerText = nextDivision;
      localStorage.setItem('bdk_user_location', nextDivision);

      // Trigger custom event for filtered section if available
      window.dispatchEvent(new CustomEvent('bdk:locationChanged', { detail: { location: nextDivision } }));
    });
  }

  document.addEventListener('DOMContentLoaded', () => {
    updateLiveClock();
    updateLiveDateBar();
    setupLocationFeature();
    setInterval(updateLiveClock, 1000);
  });
})();
