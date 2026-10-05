<template>
  <div class="pointer-events-none fixed inset-x-0 bottom-2 sm:bottom-4 z-50 flex justify-center px-2 sm:px-4 select-none">
    <nav
      ref="dockContainerRef"
      @mousemove="onMouseMove"
      @mouseleave="onMouseLeave"
      class="dock-nav-entrance z-50 pointer-events-auto relative h-12 sm:h-14 p-1 sm:p-2 w-fit max-w-[calc(100vw-16px)] mx-auto flex items-end justify-center gap-1 sm:gap-2 rounded-full border border-border bg-card/90 backdrop-blur-3xl shadow-[0_0_10px_3px] shadow-primary/5 transition-colors overflow-visible"
      aria-label="Dock Navigation"
    >
      <!-- 1. Home -->
      <div class="relative group flex items-end justify-center">
        <a
          ref="icon0Ref"
          href="/"
          @click="handleHomeClick"
          class="dock-item"
          aria-label="Home"
        >
          <div
            ref="inner0Ref"
            class="flex items-center justify-center pointer-events-none"
          >
            <svg class="size-full stroke-[1.8]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
              <path d="M3 9.5L12 3l9 6.5V20a1 1 0 0 1-1 1h-5v-6h-4v6H4a1 1 0 0 1-1-1V9.5z"/>
            </svg>
          </div>
        </a>

        <div class="dock-tooltip">
          <span>Home</span>
          <div class="dock-arrow"></div>
        </div>
      </div>

      <!-- 2. Blog (Notebook icon from portfolio) -->
      <div class="relative group flex items-end justify-center">
        <a
          ref="icon1Ref"
          href="/blog"
          @click="handleBlogClick"
          class="dock-item"
          aria-label="Blog"
        >
          <div
            ref="inner1Ref"
            class="flex items-center justify-center pointer-events-none"
          >
            <svg class="size-full stroke-[1.8]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
              <path d="M2 6h4"/>
              <path d="M2 10h4"/>
              <path d="M2 14h4"/>
              <path d="M2 18h4"/>
              <rect width="16" height="20" x="4" y="2" rx="2"/>
              <path d="M16 2v20"/>
            </svg>
          </div>
        </a>

        <div class="dock-tooltip">
          <span>Blog</span>
          <div class="dock-arrow"></div>
        </div>
      </div>

      <!-- Separator 1 -->
      <div class="h-5 sm:h-6 m-auto w-px bg-border shrink-0 self-center"></div>

      <!-- 3. GitHub -->
      <div class="relative group flex items-end justify-center">
        <a
          ref="icon2Ref"
          :href="settings?.github_url || 'https://github.com/KashifKhan456'"
          target="_blank"
          rel="noopener noreferrer"
          class="dock-item"
          aria-label="GitHub"
        >
          <div
            ref="inner2Ref"
            class="flex items-center justify-center pointer-events-none"
          >
            <svg class="size-full fill-current" viewBox="0 0 24 24">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
            </svg>
          </div>
        </a>

        <div class="dock-tooltip">
          <span>GitHub</span>
          <div class="dock-arrow"></div>
        </div>
      </div>

      <!-- 4. LinkedIn -->
      <div class="relative group flex items-end justify-center">
        <a
          ref="icon3Ref"
          :href="settings?.linkedin_url || 'https://linkedin.com/in/kashif-khan456'"
          target="_blank"
          rel="noopener noreferrer"
          class="dock-item"
          aria-label="LinkedIn"
        >
          <div
            ref="inner3Ref"
            class="flex items-center justify-center pointer-events-none"
          >
            <svg class="size-full fill-current" viewBox="0 0 24 24">
              <path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 8.76c-.95 0-1.72-.77-1.72-1.72s.77-1.72 1.72-1.72 1.72.77 1.72 1.72-.77 1.72-1.72 1.72m1.39 9.74v-8.37H5.07v8.37h2.78z"/>
            </svg>
          </div>
        </a>

        <div class="dock-tooltip">
          <span>LinkedIn</span>
          <div class="dock-arrow"></div>
        </div>
      </div>

      <!-- 5. Twitter / X -->
      <div class="relative group flex items-end justify-center">
        <a
          ref="icon4Ref"
          :href="settings?.twitter_url || 'https://x.com/kashifkhan'"
          target="_blank"
          rel="noopener noreferrer"
          class="dock-item"
          aria-label="Twitter"
        >
          <div
            ref="inner4Ref"
            class="flex items-center justify-center pointer-events-none"
          >
            <svg class="size-full fill-current" viewBox="0 0 24 24">
              <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/>
            </svg>
          </div>
        </a>

        <div class="dock-tooltip">
          <span>Twitter</span>
          <div class="dock-arrow"></div>
        </div>
      </div>

      <!-- 6. Resume / CV Document -->
      <div class="relative group flex items-end justify-center">
        <a
          ref="icon5Ref"
          :href="settings?.resume_url || '#'"
          @click="handleResumeClick"
          class="dock-item cursor-pointer"
          aria-label="Resume / CV"
        >
          <div
            ref="inner5Ref"
            class="flex items-center justify-center pointer-events-none text-foreground"
          >
            <svg class="size-full stroke-[1.8]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
              <polyline points="14 2 14 8 20 8"/>
              <line x1="16" y1="13" x2="8" y2="13"/>
              <line x1="16" y1="17" x2="8" y2="17"/>
              <line x1="10" y1="9" x2="8" y2="9"/>
            </svg>
          </div>
        </a>

        <div class="dock-tooltip">
          <span>Resume / CV</span>
          <div class="dock-arrow"></div>
        </div>
      </div>

      <!-- Separator 2 -->
      <div class="h-5 sm:h-6 m-auto w-px bg-border shrink-0 self-center"></div>

      <!-- 7. Theme Toggle -->
      <div class="relative group flex items-end justify-center">
        <button
          ref="icon6Ref"
          type="button"
          @click="handleToggleTheme"
          class="dock-item cursor-pointer"
          :aria-label="isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
        >
          <div
            ref="inner6Ref"
            class="flex items-center justify-center pointer-events-none"
          >
            <svg class="size-full stroke-[1.8]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="4"/>
              <path d="M12 2v2"/>
              <path d="M12 20v2"/>
              <path d="m4.93 4.93 1.41 1.41"/>
              <path d="m17.66 17.66 1.41 1.41"/>
              <path d="M2 12h2"/>
              <path d="M20 12h2"/>
              <path d="m6.34 17.66-1.41 1.41"/>
              <path d="m19.07 4.93-1.41 1.41"/>
            </svg>
          </div>
        </button>

        <div class="dock-tooltip">
          <span>{{ isDark ? 'Light Mode' : 'Dark Mode' }}</span>
          <div class="dock-arrow"></div>
        </div>
      </div>
    </nav>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';
import { useTheme } from '@/Composables/useTheme';
import { usePortfolioStore } from '@/stores/usePortfolioStore';

const props = defineProps({
  settings: Object,
});

const emit = defineEmits(['toggle-theme']);
const { isDark, toggleTheme } = useTheme();
const portfolioStore = usePortfolioStore();

// Exact parameters from portfolio/src/components/magicui/dock.tsx
const DEFAULT_MAGNIFICATION = 60;
const DEFAULT_DISTANCE = 100;
const BASE_SIZE = 40;
const ICON_SIZE_RATIO = 0.5;

function getBaseSize() {
  if (typeof window !== 'undefined' && window.innerWidth < 640) {
    return 34;
  }
  return 40;
}

function getMaxMagnification() {
  if (typeof window !== 'undefined' && window.innerWidth < 640) {
    return 48;
  }
  return 60;
}

// Exact roots of 0.1*r^2 + 12*r + 150 = 0: r1 = -14.174243, r2 = -105.825757
const LAMBDA_1 = -14.174243;
const LAMBDA_2 = -105.825757;
const INV_LAMBDA_DIFF = 1 / (LAMBDA_2 - LAMBDA_1);

const dockContainerRef = ref(null);
const icon0Ref = ref(null);
const icon1Ref = ref(null);
const icon2Ref = ref(null);
const icon3Ref = ref(null);
const icon4Ref = ref(null);
const icon5Ref = ref(null);
const icon6Ref = ref(null);

const inner0Ref = ref(null);
const inner1Ref = ref(null);
const inner2Ref = ref(null);
const inner3Ref = ref(null);
const inner4Ref = ref(null);
const inner5Ref = ref(null);
const inner6Ref = ref(null);

const NUM_ICONS = 7;

// Physics state for each icon: current size and velocity
const springs = Array.from({ length: NUM_ICONS }, () => ({
  current: 40,
  velocity: 0,
}));

function getIconRefs() {
  return [
    icon0Ref.value,
    icon1Ref.value,
    icon2Ref.value,
    icon3Ref.value,
    icon4Ref.value,
    icon5Ref.value,
    icon6Ref.value,
  ];
}

function getInnerRefs() {
  return [
    inner0Ref.value,
    inner1Ref.value,
    inner2Ref.value,
    inner3Ref.value,
    inner4Ref.value,
    inner5Ref.value,
    inner6Ref.value,
  ];
}

let mouseX = Infinity;
let animFrameId = null;
let lastTimestamp = 0;

function updatePhysics(now) {
  if (!lastTimestamp) lastTimestamp = now;
  let dt = (now - lastTimestamp) / 1000;
  lastTimestamp = now;
  if (dt > 0.05) dt = 0.05; // clamp delta time

  const iconEls = getIconRefs();
  const innerEls = getInnerRefs();
  let isMoving = false;

  const currentBase = getBaseSize();
  const currentMaxMag = getMaxMagnification();

  for (let i = 0; i < NUM_ICONS; i++) {
    const el = iconEls[i];
    const sp = springs[i];
    if (!el) continue;

    // Linear transform matching reference:
    let target = currentBase;
    if (mouseX !== Infinity) {
      const rect = el.getBoundingClientRect();
      const centerX = rect.left + rect.width / 2;
      const dist = Math.abs(mouseX - centerX);

      if (dist < DEFAULT_DISTANCE) {
        const factor = 1 - dist / DEFAULT_DISTANCE;
        target = currentBase + (currentMaxMag - currentBase) * factor;
      }
    }

    target = Math.max(currentBase, Math.min(currentMaxMag, target));

    // Exact closed-form ODE analytical solution for overdamped Framer Motion spring:
    // y(t) = C1 * e^(r1 * t) + C2 * e^(r2 * t)
    // v(t) = r1 * C1 * e^(r1 * t) + r2 * C2 * e^(r2 * t)
    const y0 = sp.current - target;
    const v0 = sp.velocity;

    const e1 = Math.exp(LAMBDA_1 * dt);
    const e2 = Math.exp(LAMBDA_2 * dt);

    const c2 = (v0 - LAMBDA_1 * y0) * INV_LAMBDA_DIFF;
    const c1 = y0 - c2;

    const y1 = c1 * e1 + c2 * e2;
    const v1 = LAMBDA_1 * c1 * e1 + LAMBDA_2 * c2 * e2;

    sp.current = target + y1;
    sp.velocity = v1;

    // Guaranteed physical bounds
    sp.current = Math.max(currentBase, Math.min(currentMaxMag, sp.current));

    if (Math.abs(sp.current - target) > 0.05 || Math.abs(sp.velocity) > 0.1) {
      isMoving = true;
    } else {
      sp.current = target;
      sp.velocity = 0;
    }

    // Direct DOM write for 120 FPS native hardware fluid acceleration
    el.style.width = `${sp.current}px`;
    el.style.height = `${sp.current}px`;

    const inner = innerEls[i];
    if (inner) {
      const iconPx = Math.round(sp.current * ICON_SIZE_RATIO);
      inner.style.width = `${iconPx}px`;
      inner.style.height = `${iconPx}px`;
    }
  }

  if (isMoving || mouseX !== Infinity) {
    animFrameId = requestAnimationFrame(updatePhysics);
  } else {
    animFrameId = null;
    lastTimestamp = 0;
  }
}

function onMouseMove(e) {
  if (typeof window !== 'undefined' && (window.innerWidth < 640 || window.matchMedia('(hover: none)').matches)) {
    mouseX = Infinity;
    return;
  }
  mouseX = e.clientX;
  if (!animFrameId) {
    lastTimestamp = performance.now();
    animFrameId = requestAnimationFrame(updatePhysics);
  }
}

function onMouseLeave() {
  mouseX = Infinity;
  if (!animFrameId) {
    lastTimestamp = performance.now();
    animFrameId = requestAnimationFrame(updatePhysics);
  }
}

function handleToggleTheme() {
  toggleTheme();
  emit('toggle-theme');
}

function scrollTo(selector) {
  const el = document.querySelector(selector);
  if (el) {
    el.scrollIntoView({ behavior: 'smooth' });
    history.pushState(null, '', selector);
  }
}

function handleHomeClick(e) {
  e.preventDefault();
  if (typeof window !== 'undefined' && (window.location.pathname === '/' || window.location.pathname === '')) {
    scrollTo('#hero');
  } else {
    router.visit('/');
  }
}

function handleBlogClick(e) {
  e.preventDefault();
  if (typeof window !== 'undefined' && (window.location.pathname === '/blog' || window.location.pathname === '/articles')) {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  } else {
    router.visit('/blog');
  }
}

function handleBentoClick(e) {
  if (!props.settings?.bento_url) {
    e.preventDefault();
    if (typeof window !== 'undefined' && (window.location.pathname === '/' || window.location.pathname === '')) {
      scrollTo('#projects');
    } else {
      router.visit('/#projects');
    }
  }
}

function handleResumeClick(e) {
  e.preventDefault();
  const url = props.settings?.resume_url;
  if (url && url !== '#') {
    portfolioStore.openResumeModal(url, 'Kashif Khan — Resume / CV');
  }
}

function applySizes() {
  if (typeof window !== 'undefined' && (window.innerWidth < 640 || window.matchMedia('(hover: none)').matches)) {
    mouseX = Infinity;
  }
  const base = getBaseSize();
  const iconEls = getIconRefs();
  const innerEls = getInnerRefs();
  springs.forEach(sp => {
    sp.current = base;
    sp.velocity = 0;
  });
  iconEls.forEach(el => {
    if (el) {
      el.style.width = `${base}px`;
      el.style.height = `${base}px`;
    }
  });
  innerEls.forEach(inner => {
    if (inner) {
      const iconPx = Math.round(base * ICON_SIZE_RATIO);
      inner.style.width = `${iconPx}px`;
      inner.style.height = `${iconPx}px`;
    }
  });
}

onMounted(() => {
  applySizes();
  window.addEventListener('resize', applySizes);
});

onUnmounted(() => {
  window.removeEventListener('resize', applySizes);
  if (animFrameId) {
    cancelAnimationFrame(animFrameId);
    animFrameId = null;
  }
});
</script>

<style scoped>
/* Exact DockIcon styling matching portfolio/src/components/navbar.tsx */
.dock-item {
  position: relative;
  display: flex;
  aspect-ratio: 1 / 1;
  align-items: center;
  justify-content: center;
  border-radius: 9999px;
  background-color: hsl(var(--background));
  color: hsl(var(--muted-foreground));
  border: 1px solid hsl(var(--border));
  backdrop-filter: blur(24px);
  cursor: pointer;
  flex-shrink: 0;
  width: 34px;
  height: 34px;
  min-width: 34px;
  min-height: 34px;
  max-width: 60px;
  max-height: 60px;
  box-sizing: border-box;
  transition: background-color 150ms ease,
              color 150ms ease,
              border-color 150ms ease;
  will-change: width, height;
}

@media (min-width: 640px) {
  .dock-item {
    width: 40px;
    height: 40px;
    min-width: 40px;
    min-height: 40px;
  }
}

/* Desktop-only hover states and tooltip display */
@media (min-width: 640px) and (hover: hover) and (pointer: fine) {
  .dock-item:hover {
    color: hsl(var(--foreground));
    background-color: hsl(var(--muted));
  }

  .group:hover .dock-tooltip {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
  }
}

/* Strictly disable hover styles and hide tooltips on mobile screens and touch devices */
@media (max-width: 639px), (hover: none) {
  .dock-tooltip {
    display: none !important;
  }

  .dock-item:hover {
    color: hsl(var(--muted-foreground));
    background-color: hsl(var(--background));
  }
}

.dock-item:active {
  filter: brightness(0.9);
}

/* Tooltip matching Shadcn / Magic UI */
.dock-tooltip {
  position: absolute;
  bottom: calc(100% + 12px);
  left: 50%;
  transform: translateX(-50%) translateY(4px);
  padding: 0.35rem 0.75rem;
  border-radius: 0.75rem;
  background-color: hsl(var(--primary));
  color: hsl(var(--primary-foreground));
  font-size: 0.75rem;
  font-weight: 500;
  line-height: 1;
  white-space: nowrap;
  pointer-events: none;
  opacity: 0;
  transition: opacity 100ms ease, transform 100ms ease;
  box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.3);
  z-index: 60;
  display: flex;
  align-items: center;
  justify-content: center;
}

.dock-arrow {
  position: absolute;
  top: 100%;
  left: 50%;
  transform: translateX(-50%);
  width: 0;
  height: 0;
  border-left: 4px solid transparent;
  border-right: 4px solid transparent;
  border-top: 5px solid hsl(var(--primary));
}

.dock-nav-entrance {
  animation: dockFloatIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) 0.15s both;
}

@keyframes dockFloatIn {
  from {
    opacity: 0;
    transform: translateY(24px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
