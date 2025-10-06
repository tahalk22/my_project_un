<template>
    <div class="logo-card">
      <div class="logo-symbol">
        <div class="outer-circle"></div>
  
        <div class="orbiting-hands">
          <div class="hand hand-1">
            <svg class="hand-svg" viewBox="0 0 100 100">
              <path class="hand-path"
                d="M50,10 C60,25 80,30 85,45 C90,60 75,75 60,85 C45,95 30,90 20,75 C10,60 15,40 25,30 C35,20 40,5 50,10 Z" />
            </svg>
          </div>
          <div class="hand hand-2">
            <svg class="hand-svg" viewBox="0 0 100 100">
              <path class="hand-path"
                d="M50,10 C60,25 80,30 85,45 C90,60 75,75 60,85 C45,95 30,90 20,75 C10,60 15,40 25,30 C35,20 40,5 50,10 Z" />
            </svg>
          </div>
          <div class="hand hand-3">
            <svg class="hand-svg" viewBox="0 0 100 100">
              <path class="hand-path"
                d="M50,10 C60,25 80,30 85,45 C90,60 75,75 60,85 C45,95 30,90 20,75 C10,60 15,40 25,30 C35,20 40,5 50,10 Z" />
            </svg>
          </div>
          <div class="hand hand-4">
            <svg class="hand-svg" viewBox="0 0 100 100">
              <path class="hand-path"
                d="M50,10 C60,25 80,30 85,45 C90,60 75,75 60,85 C45,95 30,90 20,75 C10,60 15,40 25,30 C35,20 40,5 50,10 Z" />
            </svg>
          </div>
          <div class="hand hand-5">
            <svg class="hand-svg" viewBox="0 0 100 100">
              <path class="hand-path"
                d="M50,10 C60,25 80,30 85,45 C90,60 75,75 60,85 C45,95 30,90 20,75 C10,60 15,40 25,30 C35,20 40,5 50,10 Z" />
            </svg>
          </div>
        </div>
  
        <div class="inner-orbiting-hands-container">
          <div class="inner-orbiting-hands">
            <div class="inner-hand hand-6">
              <svg class="hand-svg" viewBox="0 0 100 100">
                <path class="hand-path"
                  d="M50,10 C60,25 80,30 85,45 C90,60 75,75 60,85 C45,95 30,90 20,75 C10,60 15,40 25,30 C35,20 40,5 50,10 Z" />
              </svg>
            </div>
            <div class="inner-hand hand-7">
              <svg class="hand-svg" viewBox="0 0 100 100">
                <path class="hand-path"
                  d="M50,10 C60,25 80,30 85,45 C90,60 75,75 60,85 C45,95 30,90 20,75 C10,60 15,40 25,30 C35,20 40,5 50,10 Z" />
              </svg>
            </div>
            <div class="inner-hand hand-8">
              <svg class="hand-svg" viewBox="0 0 100 100">
                <path class="hand-path"
                  d="M50,10 C60,25 80,30 85,45 C90,60 75,75 60,85 C45,95 30,90 20,75 C10,60 15,40 25,30 C35,20 40,5 50,10 Z" />
              </svg>
            </div>
            <div class="inner-hand hand-9">
              <svg class="hand-svg" viewBox="0 0 100 100">
                <path class="hand-path"
                  d="M50,10 C60,25 80,30 85,45 C90,60 75,75 60,85 C45,95 30,90 20,75 C10,60 15,40 25,30 C35,20 40,5 50,10 Z" />
              </svg>
            </div>
            <div class="inner-hand hand-10">
              <svg class="hand-svg" viewBox="0 0 100 100">
                <path class="hand-path"
                  d="M50,10 C60,25 80,30 85,45 C90,60 75,75 60,85 C45,95 30,90 20,75 C10,60 15,40 25,30 C35,20 40,5 50,10 Z" />
              </svg>
            </div>
          </div>
        </div>
  
        <div class="community-core">
          <div class="core-inner"></div>
          <div class="core-ring ring-1"></div>
          <div class="core-ring ring-2"></div>
          <div class="core-ring ring-3"></div>
          <div class="core-ring ring-4"></div>
        </div>
      </div>
  
      <div class="logo-text">
        <div class="main-text">ملتقى ليبيا الدولي</div>
        <div class="sub-text">للتأمين التكافلي</div>
        <div class="year-text">2025</div>
      </div>
    </div>
  </template>
  
  <script>
 
  </script>
  
  <style    scoped>
  @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@700;800;900&display=swap');
  
  :root {
    --primary-dark: #0A2E5A;
    --primary-main: #0d3b7a;
    --primary-light: #1a56a5;
    --gold-main: #D4AF37;
    --gold-light: #f0d37d;
    --accent-1: #2a5c9d;
    --accent-2: #3a6cb0;
    --accent-3: #4a7cc3;
    --accent-4: #5a8cd6;
    --accent-5: #6a9ce9;
    --accent-6: #7aacfc;
    --accent-7: #8abcff;
    --accent-8: #9accff;
    --accent-9: #aadcff;
  }
  
  .logo-card {
    background: white;
    border-radius: 24px;
    box-shadow: 0 12px 40px rgba(10, 46, 90, 0.12);
    padding: 30px;
    width: 420px; /* تم تصغير الحجم قليلاً */
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: all 0.3s ease;
    margin: 0 auto; /* لتوسيط المكون */
  }
  
  .logo-symbol {
    width: 240px; /* تصغير الحجم */
    height: 240px; /* تصغير الحجم */
    position: relative;
    margin-bottom: 25px;
  }
  
  .outer-circle {
    position: absolute;
    width: 100%;
    height: 100%;
    border: 5px solid var(--primary-dark);
    border-radius: 50%;
    box-sizing: border-box;
    background: radial-gradient(circle at center, white 65%, rgba(212, 175, 55, 0.1) 100%);
  }
  
  .orbiting-hands {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    transform: rotate(0deg);
    transition: transform 1s ease;
    will-change: transform;
  }
  
  .inner-orbiting-hands-container {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
  }
  
  .inner-orbiting-hands {
    position: absolute;
    width: 140px; /* تصغير الحجم */
    height: 140px; /* تصغير الحجم */
    top: 50%;
    left: 50%;
    margin-top: -70px;
    margin-left: -70px;
    transform: rotate(0deg);
    transition: transform 1s ease;
    will-change: transform;
  }
  
  .logo-card:hover .orbiting-hands,
  .logo-card:hover .inner-orbiting-hands {
    animation: rotate-forever 60s linear infinite;
  }
  
  .hand {
    position: absolute;
    width: 45px; /* تصغير الحجم */
    height: 45px; /* تصغير الحجم */
    top: 0;
    left: 50%;
    transform-origin: center 120px; /* تعديل لنقطة التحول */
    transform: translateX(-50%) rotate(var(--tilt-angle));
    animation: float-hand 4s ease-in-out infinite;
    transition: all 0.3s ease;
    z-index: 2;
  }
  
  .inner-hand {
    position: absolute;
    width: 35px; /* تصغير الحجم */
    height: 35px; /* تصغير الحجم */
    top: 0;
    left: 50%;
    transform-origin: center 70px; /* تعديل لنقطة التحول */
    transform: translateX(-50%) rotate(var(--tilt-angle));
    animation: float-hand 4s ease-in-out infinite;
    transition: all 0.3s ease;
    z-index: 2;
  }
  
  .hand-svg {
    width: 100%;
    height: 100%;
    transition: all 0.3s ease;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
  }
  
  .hand-path {
    fill: currentColor;
    transition: all 0.3s ease;
  }
  
  .hand:hover,
  .inner-hand:hover {
    transform: translateX(-50%) rotate(var(--tilt-angle)) scale(1.15);
    z-index: 3;
  }
  
  .hand:hover .hand-path,
  .inner-hand:hover .hand-path {
    fill: var(--gold-main);
  }
  
  /* تصميم الأيادي المحسن */
  .hand-1 {
    transform: translateX(-50%) rotate(15deg);
    --tilt-angle: 15deg;
    color: var(--accent-1);
    animation-delay: 0.1s;
  }
  
  .hand-2 {
    transform: translateX(-50%) rotate(87deg);
    --tilt-angle: 87deg;
    color:  red ;
    animation-delay: 0.3s;
  }
  
  .hand-3 {
    transform: translateX(-50%) rotate(159deg);
    --tilt-angle: 159deg;
    color: var(--accent-3);
    animation-delay: 0.5s;
  }
  
  .hand-4 {
    transform: translateX(-50%) rotate(231deg);
    --tilt-angle: 231deg;
    color: var(--accent-4);
    animation-delay: 0.7s;
  }
  
  .hand-5 {
    transform: translateX(-50%) rotate(303deg);
    --tilt-angle: 303deg;
    color: var(--accent-5);
    animation-delay: 0.9s;
  }
  
  .hand-6 {
    transform: translateX(-50%) rotate(51deg);
    --tilt-angle: 51deg;
    color: var(--accent-6);
    animation-delay: 0.2s;
  }
  
  .hand-7 {
    transform: translateX(-50%) rotate(123deg);
    --tilt-angle: 123deg;
    color: var(--accent-7);
    animation-delay: 0.4s;
  }
  
  .hand-8 {
    transform: translateX(-50%) rotate(195deg);
    --tilt-angle: 195deg;
    color: var(--accent-8);
    animation-delay: 0.6s;
  }
  
  .hand-9 {
    transform: translateX(-50%) rotate(267deg);
    --tilt-angle: 267deg;
    color: var(--accent-9);
    animation-delay: 0.8s;
  }
  
  .hand-10 {
    transform: translateX(-50%) rotate(339deg);
    --tilt-angle: 339deg;
    color: var(--gold-light);
    animation-delay: 1s;
  }
  
  .community-core {
    position: absolute;
    width: 70px; /* تصغير الحجم */
    height: 70px; /* تصغير الحجم */
    background: var(--primary-dark);
    border-radius: 50%;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    box-shadow: 0 0 0 12px rgba(10, 46, 90, 0.1),
      inset 0 0 20px rgba(0, 0, 0, 0.2),
      0 5px 20px rgba(0, 0, 0, 0.2);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 10;
    transition: all 0.3s ease;
  }
  
  .community-core:hover {
    transform: translate(-50%, -50%) scale(1.05);
    box-shadow: 0 0 0 15px rgba(10, 46, 90, 0.15),
      inset 0 0 25px rgba(0, 0, 0, 0.25),
      0 7px 25px rgba(0, 0, 0, 0.25);
  }
  
  .core-inner {
    width: 28px; /* تصغير الحجم */
    height: 28px; /* تصغير الحجم */
    background: var(--gold-main);
    border-radius: 50%;
    animation: pulse 2s ease-in-out infinite alternate;
    box-shadow: 0 0 15px var(--gold-main);
  }
  
  .logo-text {
    text-align: center;
    margin-top: 15px;
  }
  
  .main-text {
    font-size: 36px; /* تصغير الحجم */
    font-weight: 900;
    color: var(--primary-dark);
    line-height: 1.3;
    letter-spacing: -0.5px;
    margin-bottom: 5px;
    transition: all 0.3s ease;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
  }
  
  .sub-text {
    font-size: 24px; /* تصغير الحجم */
    font-weight: 700;
    color: var(--primary-light);
    letter-spacing: -0.3px;
    transition: all 0.3s ease;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
  }
  
  .year-text {
    font-size: 22px; /* تصغير الحجم */
    font-weight: 700;
    color: var(--gold-main);
    margin-top: 12px;
    display: inline-block;
    padding: 5px 15px;
    border-radius: 18px;
    background: rgba(212, 175, 55, 0.1);
    transition: all 0.3s ease;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
  }
  
  .logo-card:hover .main-text {
    color: var(--primary-main);
    text-shadow: 0 4px 8px rgba(10, 46, 90, 0.1);
  }
  
  .logo-card:hover .sub-text {
    color: var(--primary-dark);
  }
  
  .logo-card:hover .year-text {
    background: rgba(212, 175, 55, 0.2);
    transform: scale(1.05);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }
  
  .core-ring {
    position: absolute;
    top: 50%;
    left: 50%;
    border-radius: 50%;
    border: 2px solid var(--gold-main);
    transform: translate(-50%, -50%);
    animation: ring-pulse 5s ease-in-out infinite;
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.5s ease;
  }
  
  .community-core:hover .core-ring {
    opacity: 0.4;
  }
  
  .ring-1 {
    width: 120px; /* تصغير الحجم */
    height: 120px; /* تصغير الحجم */
    animation-delay: 0s;
  }
  
  .ring-2 {
    width: 160px; /* تصغير الحجم */
    height: 160px; /* تصغير الحجم */
    animation-delay: 0.5s;
  }
  
  .ring-3 {
    width: 200px; /* تصغير الحجم */
    height: 200px; /* تصغير الحجم */
    animation-delay: 1s;
  }
  
  .ring-4 {
    width: 240px; /* تصغير الحجم */
    height: 240px; /* تصغير الحجم */
    animation-delay: 1.5s;
  }
  
  @keyframes ring-pulse {
    0% {
      transform: translate(-50%, -50%) scale(1);
      opacity: 0.4;
    }
  
    50% {
      transform: translate(-50%, -50%) scale(1.06);
      opacity: 0.3;
    }
  
    100% {
      transform: translate(-50%, -50%) scale(1);
      opacity: 0.4;
    }
  }
  
  @keyframes float-hand {
  
    0%,
    100% {
      transform: translateX(-50%) rotate(var(--tilt-angle)) translateY(0);
    }
  
    50% {
      transform: translateX(-50%) rotate(var(--tilt-angle)) translateY(-10px);
    }
  }
  
  @keyframes pulse {
    0% {
      transform: scale(1);
      opacity: 0.8;
      box-shadow: 0 0 15px var(--gold-main);
    }
  
    100% {
      transform: scale(1.15);
      opacity: 1;
      box-shadow: 0 0 25px var(--gold-main);
    }
  }
  
  @keyframes rotate-forever {
    0% {
      transform: rotate(0deg);
    }
  
    100% {
      transform: rotate(360deg);
    }
  }
  
  @media print {
    .logo-card {
      box-shadow: none !important;
      page-break-inside: avoid;
      break-inside: avoid;
      width: 100% !important;
      max-width: 100%;
      padding: 20mm;
    }
  
    .main-text,
    .sub-text,
    .year-text {
      text-shadow: none !important;
    }
  
    .hand,
    .inner-hand,
    .community-core,
    .core-ring,
    .core-inner,
    .logo-symbol {
      animation: none !important;
      transition: none !important;
    }
  
    .core-ring {
      opacity: 0.4 !important;
    }
  
    .logo-card:hover .orbiting-hands,
    .logo-card:hover .inner-orbiting-hands {
      animation: none !important;
    }
  
    .logo-card:hover .main-text,
    .logo-card:hover .sub-text,
    .logo-card:hover .year-text {
      transform: none !important;
      box-shadow: none !important;
      color: inherit !important;
      background: none !important;
    }
  }
  </style>