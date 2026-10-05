<template>
  <div class="flex h-screen overflow-hidden bg-background text-foreground">
    <!-- Collapsible Desktop Sidebar (Permanently fixed, full height) -->
    <aside
      :class="[
        'hidden lg:flex flex-col border-r bg-card text-card-foreground duration-300 ease-in-out h-full shrink-0 z-30',
        isCollapsed ? 'w-16' : 'w-64'
      ]"
    >
      <!-- Logo section -->
      <div 
        :class="[
          'h-16 flex items-center border-b shrink-0 transition-all duration-300 overflow-hidden',
          isCollapsed ? 'justify-center px-0' : 'px-4 gap-3'
        ]"
      >
        <div class="h-9 w-9 rounded-full bg-neutral-900 dark:bg-neutral-50 flex items-center justify-center shrink-0 overflow-hidden">
          <svg class="h-5 w-5 text-white dark:text-neutral-900" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
        <span v-if="!isCollapsed" class="font-semibold text-sm tracking-tight truncate">Kashif Khan Dev</span>
      </div>

      <!-- Navigation links -->
      <div :class="['flex-1 px-3 py-4 space-y-1', isCollapsed ? 'overflow-visible' : 'overflow-y-auto']">
        <Link
          v-for="item in navItems"
          :key="item.name"
          :href="item.route"
          :class="[
            'flex items-center rounded-md text-sm font-medium transition-all group relative',
            isCollapsed ? 'justify-center h-10 w-10 mx-auto px-0' : 'gap-3 px-3 py-2',
            item.active 
              ? 'bg-slate-900 text-white dark:bg-white dark:text-neutral-950 font-semibold shadow-xs' 
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 dark:text-neutral-400 dark:hover:text-neutral-50 dark:hover:bg-neutral-800'
          ]"
        >
          <component :is="item.icon" class="h-4 w-4 shrink-0" />
          <span v-if="!isCollapsed" class="truncate">{{ item.name }}</span>

          <!-- Tooltip for collapsed state -->
          <div 
            v-if="isCollapsed"
            class="absolute left-14 scale-0 group-hover:scale-100 transition-all rounded-md px-2 py-1 bg-white text-neutral-900 border border-neutral-200 dark:bg-neutral-900 dark:text-neutral-50 dark:border-neutral-800 text-xs font-semibold whitespace-nowrap shadow-lg z-50 pointer-events-none"
          >
            {{ item.name }}
          </div>
        </Link>
      </div>

      <!-- User Profile & Collapsible button -->
      <div class="border-t p-3 shrink-0 overflow-hidden">
        <div v-if="!isCollapsed" class="flex items-center justify-between gap-2">
          <div class="flex items-center gap-3 min-w-0">
            <div class="h-8 w-8 rounded-full bg-neutral-800 flex items-center justify-center text-white text-xs font-semibold shrink-0">
              {{ userInitials }}
            </div>
            <div class="flex-1 min-w-0">
              <h4 class="text-xs font-semibold truncate text-neutral-900 dark:text-neutral-50">{{ $page.props.auth.user.name }}</h4>
              <p class="text-[10px] text-muted-foreground truncate">{{ $page.props.auth.user.email }}</p>
            </div>
          </div>
          <button
            @click="isCollapsed = !isCollapsed"
            class="h-7 w-7 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800 flex items-center justify-center text-muted-foreground hover:text-foreground shrink-0 transition-colors"
          >
            <ChevronLeft class="h-4 w-4" />
          </button>
        </div>

        <div v-else class="flex flex-col items-center gap-2">
          <div class="h-8 w-8 rounded-full bg-neutral-800 flex items-center justify-center text-white text-xs font-semibold shrink-0">
            {{ userInitials }}
          </div>
          <button
            @click="isCollapsed = !isCollapsed"
            class="h-8 w-8 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800 flex items-center justify-center text-muted-foreground hover:text-foreground transition-colors"
          >
            <ChevronRight class="h-4 w-4" />
          </button>
        </div>
      </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden">
      <!-- Header Bar (Exact match to dashboard/resources/js/components/layout/Header.vue) -->
      <header class="h-16 border-b bg-background/95 backdrop-blur shrink-0 flex items-center justify-between px-4 lg:px-6 z-20">
        <div class="flex items-center gap-2 sm:gap-3 min-w-0">
          <!-- Mobile Hamburger Toggle (No background, matches icon toolbar) -->
          <button
            @click="isMobileMenuOpen = !isMobileMenuOpen"
            class="lg:hidden p-2 rounded-md text-neutral-600 dark:text-neutral-400 hover:text-slate-900 dark:hover:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors cursor-pointer shrink-0"
            aria-label="Toggle navigation menu"
          >
            <Menu v-if="!isMobileMenuOpen" class="h-5 w-5" />
            <X v-else class="h-5 w-5" />
          </button>

          <!-- Breadcrumbs -->
          <nav class="hidden md:flex items-center space-x-2 text-sm font-medium">
            <span class="text-muted-foreground">App</span>
            <ChevronRight class="h-3 w-3 text-muted-foreground" />
            <span class="text-foreground capitalize">{{ currentRouteTitle }}</span>
          </nav>
          <h1 class="md:hidden text-sm sm:text-base font-semibold capitalize truncate">{{ currentRouteTitle }}</h1>
        </div>

        <!-- Right-side actions -->
        <div class="flex items-center gap-2">
          <!-- Global Search Button -->
          <button
            @click="showSearchModal = true"
            class="relative h-9 w-9 md:w-60 justify-center md:justify-start px-0 md:px-3 text-neutral-600 dark:text-neutral-400 hover:text-slate-900 dark:hover:text-white text-xs font-medium rounded-md border border-neutral-300 dark:border-neutral-800 bg-white/80 dark:bg-neutral-900/60 hover:bg-neutral-100 dark:hover:bg-neutral-900 flex items-center transition-colors cursor-pointer"
          >
            <Search class="h-4 w-4 md:mr-2 shrink-0 text-neutral-500 dark:text-neutral-400" />
            <span class="hidden md:inline-flex">Search dashboard...</span>
            <kbd class="hidden md:inline-flex absolute right-1.5 top-1/2 -translate-y-1/2 h-5 pointer-events-none items-center justify-center gap-1 rounded-md border border-neutral-200 dark:border-neutral-800 bg-neutral-100 dark:bg-neutral-950 px-1.5 font-mono text-[10px] font-medium text-neutral-500 dark:text-neutral-400 opacity-100 select-none">
              ⌘K
            </kbd>
          </button>

          <!-- Theme Switcher Button -->
          <button
            @click="toggleTheme"
            class="h-9 w-9 rounded-md border border-neutral-200 dark:border-neutral-800 bg-white/80 dark:bg-neutral-900/60 hover:bg-neutral-100 dark:hover:bg-neutral-800 flex items-center justify-center text-neutral-600 dark:text-neutral-400 hover:text-slate-900 dark:hover:text-white transition-colors cursor-pointer shadow-xs"
            :title="isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
          >
            <Sun v-if="isDark" class="h-4 w-4 text-amber-400" />
            <Moon v-else class="h-4 w-4 text-indigo-600" />
          </button>

          <!-- Notifications Dropdown Button -->
          <div ref="notificationRef" class="relative">
            <button
              @click="showNotifications = !showNotifications"
              class="h-9 w-9 rounded-md hover:bg-neutral-100 dark:hover:bg-neutral-800 flex items-center justify-center relative text-neutral-600 dark:text-neutral-400 hover:text-slate-900 dark:hover:text-white transition-colors cursor-pointer"
              title="Notifications"
            >
              <Bell class="h-4 w-4" />
            </button>

            <!-- Notifications Dropdown Menu -->
            <div
              v-if="showNotifications"
              class="absolute right-0 mt-2 w-80 sm:w-88 rounded-md border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 text-neutral-900 dark:text-neutral-100 shadow-2xl p-3 z-50 space-y-2.5"
            >
              <div class="flex items-center justify-between px-1 pb-2 border-b border-neutral-200 dark:border-neutral-800/80">
                <div class="flex items-center gap-2">
                  <Bell class="h-3.5 w-3.5 text-indigo-500 dark:text-indigo-400" />
                  <span class="font-bold text-xs text-neutral-900 dark:text-white">Notifications</span>
                </div>
              </div>

              <!-- Empty Notification State -->
              <div class="py-6 text-center">
                <CheckCircle2 class="h-8 w-8 mx-auto text-neutral-400 dark:text-neutral-600 mb-2" />
                <p class="text-sm font-bold text-neutral-900 dark:text-white">All caught up!</p>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1 font-medium">No new notifications.</p>
              </div>
            </div>
          </div>

          <!-- User Avatar Menu -->
          <div ref="userMenuRef" class="relative">
            <button
              @click="showUserMenu = !showUserMenu"
              class="h-9 w-9 rounded-full flex items-center justify-center bg-neutral-100 dark:bg-neutral-800 text-neutral-900 dark:text-neutral-100 text-xs font-semibold border border-transparent hover:border-neutral-300 dark:hover:border-neutral-700 transition-all cursor-pointer"
            >
              {{ userInitials }}
            </button>

            <div
              v-if="showUserMenu"
              class="absolute right-0 mt-2 w-60 rounded-md border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 text-neutral-900 dark:text-neutral-100 shadow-2xl p-2 z-50 text-xs space-y-1"
            >
              <div class="flex flex-col gap-0.5 px-3 py-2 border-b border-neutral-200 dark:border-neutral-800/80 mb-1">
                <span class="font-bold text-xs text-neutral-900 dark:text-white truncate">{{ $page.props.auth.user.name }}</span>
                <span class="text-xs text-neutral-500 dark:text-neutral-400 font-normal truncate">{{ $page.props.auth.user.email }}</span>
              </div>
              <Link
                :href="route('home')"
                target="_blank"
                @click="showUserMenu = false"
                class="flex items-center justify-between px-3 py-2 rounded-md hover:bg-neutral-100 dark:hover:bg-neutral-900 text-neutral-700 hover:text-neutral-900 dark:text-neutral-200 dark:hover:text-white font-medium transition-colors"
              >
                <span>Public Portfolio</span>
                <ExternalLink class="h-3.5 w-3.5 text-neutral-400" />
              </Link>
              <Link
                :href="route('logout')"
                method="post"
                as="button"
                @click="showUserMenu = false"
                class="w-full flex items-center justify-between px-3 py-2 rounded-md text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/30 hover:text-red-700 dark:hover:text-red-300 font-semibold transition-colors cursor-pointer"
              >
                <span>Log out</span>
                <LogOut class="h-3.5 w-3.5" />
              </Link>
            </div>
          </div>
        </div>
      </header>

      <!-- Page Content -->
      <main class="flex-1 p-4 lg:p-8 overflow-y-auto">
        <div class="max-w-7xl mx-auto w-full">
          <slot />
        </div>
      </main>
    </div>

    <!-- Global Toast Container -->
    <ToastNotification />

    <!-- Command Palette / Global Search Modal -->
    <div
      v-if="showSearchModal"
      class="fixed inset-0 z-50 flex items-start justify-center pt-20 px-4 bg-black/60 backdrop-blur-sm"
      @click.self="showSearchModal = false"
    >
      <div class="w-full max-w-xl rounded-md border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 text-neutral-900 dark:text-neutral-100 shadow-2xl overflow-hidden flex flex-col">
        <!-- Search Input Bar -->
        <div class="flex items-center px-4 py-3 border-b border-neutral-200 dark:border-neutral-800 gap-3">
          <Search class="h-4 w-4 text-indigo-500 dark:text-indigo-400 shrink-0" />
          <input
            ref="searchInputRef"
            v-model="searchQuery"
            type="text"
            placeholder="Search commands, pages, or tools..."
            class="flex-1 bg-transparent text-sm text-neutral-900 dark:text-white placeholder-neutral-400 outline-none focus:outline-none focus:ring-0 ring-0 border-0 focus:border-none p-0 shadow-none"
          />
          <kbd
            @click="showSearchModal = false"
            class="px-2 py-0.5 text-[10px] font-mono font-semibold text-neutral-500 dark:text-neutral-400 bg-neutral-100 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-md cursor-pointer hover:text-neutral-900 dark:hover:text-white"
          >
            ESC
          </kbd>
        </div>

        <!-- Search Results / Commands List -->
        <div class="max-h-80 overflow-y-auto p-2 space-y-1">
          <div v-if="filteredSearchActions.length" class="space-y-1">
            <div class="px-2.5 py-1 text-[10px] font-bold text-neutral-400 uppercase tracking-wider">
              Quick Navigation & Pages
            </div>
            <button
              v-for="action in filteredSearchActions"
              :key="action.title"
              @click="navigateSearch(action)"
              class="w-full flex items-center justify-between p-2.5 rounded-md hover:bg-neutral-100 dark:hover:bg-neutral-900 text-left group transition-colors cursor-pointer"
            >
              <div class="flex items-center gap-3 min-w-0">
                <div class="p-2 rounded-md bg-neutral-100 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 text-neutral-500 dark:text-neutral-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 group-hover:border-indigo-300 dark:group-hover:border-indigo-800/80 transition-colors shrink-0">
                  <component :is="action.icon" class="h-4 w-4" />
                </div>
                <div class="min-w-0">
                  <div class="text-xs font-bold text-neutral-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors truncate">
                    {{ action.title }}
                  </div>
                  <div class="text-[11px] text-neutral-500 dark:text-neutral-400 truncate">
                    {{ action.desc }}
                  </div>
                </div>
              </div>
              <ChevronRight class="h-4 w-4 text-neutral-400 dark:text-neutral-600 group-hover:text-neutral-700 dark:group-hover:text-neutral-300 transition-colors shrink-0 ml-2" />
            </button>
          </div>

          <div v-else class="py-8 text-center text-neutral-400">
            <Search class="h-6 w-6 mx-auto text-neutral-300 dark:text-neutral-700 mb-2" />
            <p class="text-xs font-bold text-neutral-700 dark:text-neutral-300">No matching commands</p>
            <p class="text-[11px] text-neutral-400 mt-0.5">Try searching for "Projects", "Skills", "Inbox", or "Settings"</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Mobile Navigation Slide-out Drawer -->
    <Teleport to="body">
      <!-- Backdrop Blur Overlay -->
      <Transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition duration-150 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div
          v-if="isMobileMenuOpen"
          class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm lg:hidden"
          @click="isMobileMenuOpen = false"
        ></div>
      </Transition>

      <!-- Slide-out Sidebar Drawer -->
      <Transition
        enter-active-class="transition duration-300 ease-out transform"
        enter-from-class="-translate-x-full"
        enter-to-class="translate-x-0"
        leave-active-class="transition duration-200 ease-in transform"
        leave-from-class="translate-x-0"
        leave-to-class="-translate-x-full"
      >
        <aside
          v-if="isMobileMenuOpen"
          class="fixed inset-y-0 left-0 z-50 w-72 bg-white dark:bg-neutral-950 border-r border-slate-200 dark:border-neutral-800 text-slate-900 dark:text-neutral-100 flex flex-col shadow-2xl lg:hidden"
        >
          <!-- Logo & Close Header -->
          <div class="h-16 flex items-center justify-between px-4 border-b border-slate-200 dark:border-neutral-800 shrink-0">
            <div class="flex items-center gap-3">
              <div class="h-9 w-9 rounded-full bg-slate-900 dark:bg-neutral-50 flex items-center justify-center shrink-0 border border-slate-200 dark:border-neutral-800">
                <svg class="h-5 w-5 text-white dark:text-neutral-900" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
              <span class="font-bold text-sm tracking-tight text-slate-900 dark:text-white">Kashif Khan Dev</span>
            </div>

            <button
              @click="isMobileMenuOpen = false"
              class="p-2 text-slate-500 hover:text-slate-900 dark:text-neutral-400 dark:hover:text-white rounded-md hover:bg-slate-100 dark:hover:bg-neutral-900 transition-colors cursor-pointer"
            >
              <X class="h-5 w-5" />
            </button>
          </div>

          <!-- Mobile Navigation Links -->
          <div class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            <Link
              v-for="item in navItems"
              :key="item.name"
              :href="item.route"
              @click="isMobileMenuOpen = false"
              :class="[
                'flex items-center justify-between px-3 py-2 rounded-md text-sm font-medium transition-all',
                item.active 
                  ? 'bg-slate-900 text-white dark:bg-white dark:text-neutral-950 font-semibold shadow-xs' 
                  : 'text-slate-600 dark:text-neutral-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-neutral-900'
              ]"
            >
              <div class="flex items-center gap-3 min-w-0">
                <component :is="item.icon" class="h-4 w-4 shrink-0" />
                <span class="truncate">{{ item.name }}</span>
              </div>

              <!-- Unread inquiries badge pill -->
              <span
                v-if="item.name.toLowerCase().includes('inquir') && $page.props.unreadInquiriesCount > 0"
                class="px-2 py-0.5 text-[10px] font-black rounded-full bg-red-600 text-white shadow-xs"
              >
                {{ $page.props.unreadInquiriesCount }}
              </span>
            </Link>
          </div>

          <!-- Mobile User Profile & Footer -->
          <div class="border-t border-slate-200 dark:border-neutral-800 p-4 shrink-0 bg-slate-50/80 dark:bg-neutral-950">
            <div class="flex items-center gap-3">
              <div class="h-9 w-9 rounded-full bg-slate-900 dark:bg-neutral-800 flex items-center justify-center text-white text-xs font-semibold shrink-0 border border-slate-300 dark:border-neutral-700 shadow-xs">
                {{ userInitials }}
              </div>
              <div class="flex-1 min-w-0">
                <h4 class="text-xs font-semibold truncate text-slate-900 dark:text-white">{{ $page.props.auth.user.name }}</h4>
                <p class="text-[10px] text-slate-500 dark:text-neutral-400 truncate">{{ $page.props.auth.user.email }}</p>
              </div>
              <Link
                :href="route('logout')"
                method="post"
                as="button"
                class="p-2 text-red-500 hover:text-red-600 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-950/30 rounded-md transition-colors cursor-pointer"
                title="Log Out"
              >
                <LogOut class="h-4 w-4" />
              </Link>
            </div>
          </div>
        </aside>
      </Transition>
    </Teleport>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted, onUnmounted, nextTick } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import ToastNotification from '@/Components/ToastNotification.vue';
import { useToast } from '@/Composables/useToast';
import { useTheme } from '@/Composables/useTheme';
import {
  LayoutDashboard,
  Sparkles,
  MessageSquare,
  FolderGit2,
  Cpu,
  Briefcase,
  Mail,
  Settings as SettingsIcon,
  ChevronRight,
  ChevronLeft,
  Search,
  Bell,
  CheckCircle2,
  ExternalLink,
  LogOut,
  Menu,
  X,
  Sun,
  Moon,
  BookOpen,
  Quote
} from 'lucide-vue-next';

const page = usePage();
const { toast } = useToast();
const { isDark, toggleTheme, initTheme } = useTheme();
const isCollapsed = ref(false);
const isMobileMenuOpen = ref(false);
const showNotifications = ref(false);
const showUserMenu = ref(false);
const showSearchModal = ref(false);
const searchQuery = ref('');

onMounted(() => {
  initTheme();
});

watch(() => page.url, () => {
  isMobileMenuOpen.value = false;
});

const notificationRef = ref(null);
const userMenuRef = ref(null);
const searchInputRef = ref(null);

function handleClickOutside(event) {
  if (notificationRef.value && !notificationRef.value.contains(event.target)) {
    showNotifications.value = false;
  }
  if (userMenuRef.value && !userMenuRef.value.contains(event.target)) {
    showUserMenu.value = false;
  }
}

function handleKeyDown(e) {
  if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
    e.preventDefault();
    showSearchModal.value = !showSearchModal.value;
  } else if (e.key === 'Escape' && showSearchModal.value) {
    showSearchModal.value = false;
  }
}

watch(showSearchModal, (val) => {
  if (val) {
    nextTick(() => {
      searchInputRef.value?.focus();
    });
  } else {
    searchQuery.value = '';
  }
});

onMounted(() => {
  document.addEventListener('click', handleClickOutside);
  window.addEventListener('keydown', handleKeyDown);
});

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
  window.removeEventListener('keydown', handleKeyDown);
});

const searchActions = computed(() => [
  { title: 'Admin Dashboard', desc: 'Main overview & portfolio statistics', routeName: 'admin.dashboard', icon: LayoutDashboard },
  { title: 'Hero Section Editor', desc: 'Customize main landing text & code frame', routeName: 'admin.hero.index', icon: Sparkles },
  { title: 'Contact Section Manager', desc: 'Customize contact pitch, email & form preview', routeName: 'admin.contact.index', icon: MessageSquare },
  { title: 'Projects Manager', desc: 'Create, edit & manage portfolio projects', routeName: 'admin.projects.index', icon: FolderGit2 },
  { title: 'Articles CMS', desc: 'Publish engineering writeups & technical articles', routeName: 'admin.articles.index', icon: BookOpen },
  { title: 'Client Testimonials', desc: 'Manage client endorsements & recommendations', routeName: 'admin.testimonials.index', icon: Quote },
  { title: 'Skills Matrix', desc: 'Manage tech stack icons ticker & proficiency', routeName: 'admin.skills.index', icon: Cpu },
  { title: 'Experience Timeline', desc: 'Career background & work milestones', routeName: 'admin.experiences.index', icon: Briefcase },
  { title: 'Settings', desc: 'Social links, resume URL & portfolio stats', routeName: 'admin.settings.index', icon: SettingsIcon },
]);

const filteredSearchActions = computed(() => {
  if (!searchQuery.value.trim()) return searchActions.value;
  const q = searchQuery.value.toLowerCase();
  return searchActions.value.filter(
    item => item.title.toLowerCase().includes(q) || item.desc.toLowerCase().includes(q)
  );
});

function navigateSearch(action) {
  showSearchModal.value = false;
  searchQuery.value = '';
  router.visit(route(action.routeName));
}

function markAllNotificationsRead() {
  showNotifications.value = false;
}

function formatRelativeTime(dateStr) {
  if (!dateStr) return '';
  const date = new Date(dateStr);
  const now = new Date();
  const diffInSecs = Math.floor((now - date) / 1000);

  if (diffInSecs < 60) return 'Just now';
  if (diffInSecs < 3600) return `${Math.floor(diffInSecs / 60)}m ago`;
  if (diffInSecs < 86400) return `${Math.floor(diffInSecs / 3600)}h ago`;
  return `${Math.floor(diffInSecs / 86400)}d ago`;
}

watch(
  () => page.props.flash,
  (flash) => {
    if (flash?.success) {
      toast({
        title: 'Success',
        description: flash.success,
        type: 'success',
      });
    }
    if (flash?.error) {
      toast({
        title: 'Error',
        description: flash.error,
        type: 'error',
      });
    }
  },
  { immediate: true, deep: true }
);

const userInitials = computed(() => {
  const name = page.props.auth.user?.name || 'KK';
  const parts = name.trim().split(/\s+/);
  if (parts.length >= 2) {
    return `${parts[0][0]}${parts[1][0]}`.toUpperCase();
  }
  return name.substring(0, 2).toUpperCase();
});

const currentRouteTitle = computed(() => {
  if (route().current('admin.dashboard')) return 'Admin Dashboard';
  if (route().current('admin.hero.*')) return 'Hero & About Editor';
  if (route().current('admin.contact.*')) return 'Contact Section Manager';
  if (route().current('admin.projects.*')) return 'Projects Manager';
  if (route().current('admin.articles.*')) return 'Articles CMS';
  if (route().current('admin.testimonials.*')) return 'Client Testimonials';
  if (route().current('admin.skills.*')) return 'Skills Matrix';
  if (route().current('admin.experiences.*')) return 'Experience Timeline';
  if (route().current('admin.settings.*')) return 'Settings';
  return 'Dashboard';
});

const navItems = computed(() => [
  { name: 'Dashboard', route: route('admin.dashboard'), active: route().current('admin.dashboard'), icon: LayoutDashboard },
  { name: 'Hero & About', route: route('admin.hero.index'), active: route().current('admin.hero.*'), icon: Sparkles },
  { name: 'Contact Section', route: route('admin.contact.index'), active: route().current('admin.contact.*'), icon: MessageSquare },
  { name: 'Projects Manager', route: route('admin.projects.index'), active: route().current('admin.projects.*'), icon: FolderGit2 },
  { name: 'Articles CMS', route: route('admin.articles.index'), active: route().current('admin.articles.*'), icon: BookOpen },
  { name: 'Testimonials', route: route('admin.testimonials.index'), active: route().current('admin.testimonials.*'), icon: Quote },
  { name: 'Skills Matrix', route: route('admin.skills.index'), active: route().current('admin.skills.*'), icon: Cpu },
  { name: 'Experience Timeline', route: route('admin.experiences.index'), active: route().current('admin.experiences.*'), icon: Briefcase },
  { name: 'Settings', route: route('admin.settings.index'), active: route().current('admin.settings.*'), icon: SettingsIcon },
]);
</script>
