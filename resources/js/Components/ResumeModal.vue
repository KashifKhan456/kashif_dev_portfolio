<template>
  <Teleport to="body">
    <Transition name="resume-modal-fade">
      <div
        v-if="store.isResumeModalOpen"
        class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 md:p-6"
        role="dialog"
        aria-modal="true"
        :aria-label="store.resumeModalTitle"
        @keydown.esc="close"
      >
        <!-- Backdrop with Blur -->
        <div
          class="fixed inset-0 bg-black/80 backdrop-blur-md transition-opacity duration-300"
          @click="close"
        ></div>

        <!-- Modal Window -->
        <div
          class="relative w-full max-w-5xl h-[92vh] sm:h-[90vh] bg-card border border-border rounded-2xl shadow-2xl overflow-hidden flex flex-col z-10 text-card-foreground transform transition-all duration-300 ring-1 ring-border/50"
          tabindex="-1"
          ref="modalCardRef"
        >
          <!-- Modal Header / Toolbar -->
          <div class="h-14 sm:h-16 px-4 sm:px-6 border-b border-border bg-card/90 backdrop-blur-md flex items-center justify-between gap-3 shrink-0">
            <!-- Left: Document Info -->
            <div class="flex items-center gap-2.5 min-w-0">
              <div class="size-8 sm:size-9 rounded-lg bg-primary/10 border border-primary/20 flex items-center justify-center shrink-0">
                <FileText class="size-4 sm:size-4.5 text-primary" />
              </div>
              <div class="min-w-0">
                <div class="flex items-center gap-2">
                  <h3 class="text-sm sm:text-base font-semibold text-foreground truncate">
                    {{ store.resumeModalTitle }}
                  </h3>
                  <span class="hidden xs:inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-muted border border-border text-muted-foreground uppercase tracking-wider">
                    {{ fileTypeBadge }}
                  </span>
                </div>
                <p class="text-[11px] text-muted-foreground truncate hidden sm:block">
                  {{ displayFilename }}
                </p>
              </div>
            </div>

            <!-- Right: Actions -->
            <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
              <!-- Open in New Tab / Native Viewer -->
              <a
                v-if="store.resumeModalUrl"
                :href="store.resumeModalUrl"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-primary text-primary-foreground hover:bg-primary/90 transition-all shadow-xs cursor-pointer"
                title="Open in new tab"
              >
                <ExternalLink class="size-3.5" />
                <span>Open</span>
              </a>

              <!-- Download Button -->
              <a
                v-if="store.resumeModalUrl"
                :href="store.resumeModalUrl"
                :download="downloadFilename"
                class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 rounded-lg text-xs font-medium border border-border bg-muted/60 hover:bg-muted text-foreground transition-all cursor-pointer"
                title="Download Document"
              >
                <Download class="size-3.5 text-muted-foreground" />
                <span class="hidden sm:inline">Download</span>
              </a>

              <!-- Close Button -->
              <button
                @click="close"
                class="size-8 sm:size-9 rounded-lg border border-border hover:bg-muted text-muted-foreground hover:text-foreground flex items-center justify-center transition-colors cursor-pointer ml-1"
                aria-label="Close resume viewer"
              >
                <X class="size-4" />
              </button>
            </div>
          </div>

          <!-- Document Viewer Area -->
          <div class="relative flex-1 w-full bg-muted/30 overflow-hidden flex items-center justify-center">
            <!-- Loading Indicator (Desktop only when iframe is loading) -->
            <div
              v-if="!isMobile && isLoading"
              class="absolute inset-0 flex flex-col items-center justify-center bg-card/60 backdrop-blur-xs z-10 gap-3"
            >
              <Loader2 class="size-8 text-primary animate-spin" />
              <p class="text-xs text-muted-foreground">Loading document preview...</p>
            </div>

            <!-- 1. Mobile-Optimized Viewer (Android & iOS touch screens where iframes block PDF rendering) -->
            <div
              v-if="isMobile && (isPdf || isEmbeddable)"
              class="flex-1 w-full h-full flex flex-col items-center justify-center p-6 text-center bg-card overflow-y-auto"
            >
              <div class="size-20 rounded-2xl bg-primary/10 border border-primary/20 flex items-center justify-center mb-5 text-primary shadow-sm ring-4 ring-primary/5">
                <FileText class="size-10 text-primary" />
              </div>

              <div class="max-w-sm space-y-1.5">
                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-primary/10 text-primary border border-primary/20 uppercase tracking-wider">
                  <span>{{ fileTypeBadge }}</span>
                </div>
                <h4 class="text-lg font-bold text-foreground tracking-tight pt-1">
                  {{ store.resumeModalTitle }}
                </h4>
                <p class="text-xs text-muted-foreground break-all line-clamp-2 px-2">
                  {{ displayFilename }}
                </p>
              </div>

              <div class="mt-6 flex flex-col gap-3 w-full max-w-xs">
                <!-- Big Primary Button: Open Fullscreen in Native Viewer -->
                <a
                  :href="store.resumeModalUrl"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="w-full inline-flex items-center justify-center gap-2.5 px-5 py-3.5 rounded-xl text-sm font-semibold bg-primary text-primary-foreground hover:bg-primary/90 transition-all shadow-md active:scale-95 cursor-pointer"
                >
                  <ExternalLink class="size-4.5" />
                  <span>Open & View PDF</span>
                </a>

                <!-- Secondary Button: Download PDF -->
                <a
                  :href="store.resumeModalUrl"
                  :download="downloadFilename"
                  class="w-full inline-flex items-center justify-center gap-2.5 px-5 py-3 rounded-xl text-sm font-semibold border border-border bg-muted/40 hover:bg-muted text-foreground transition-all active:scale-95 cursor-pointer"
                >
                  <Download class="size-4.5" />
                  <span>Download Resume</span>
                </a>
              </div>

              <p class="text-[11px] text-muted-foreground mt-5 max-w-xs leading-relaxed">
                💡 Tapping "Open & View PDF" launches the document in your phone's native PDF reader with zoom and crisp text.
              </p>
            </div>

            <!-- 2. Desktop PDF / Iframe Viewer -->
            <iframe
              v-else-if="!isMobile && (isPdf || isEmbeddable)"
              :src="embedUrl"
              class="w-full h-full border-0 bg-background"
              title="Resume Document Preview"
              @load="isLoading = false"
            ></iframe>

            <!-- 3. Fallback for Word (.doc, .docx) or non-PDF formats -->
            <div
              v-else
              class="max-w-md p-6 sm:p-8 text-center flex flex-col items-center gap-4 bg-card border border-border rounded-xl shadow-lg m-4"
            >
              <div class="size-14 rounded-2xl bg-primary/10 border border-primary/20 flex items-center justify-center text-primary">
                <FileText class="size-7" />
              </div>
              <div>
                <h4 class="text-base font-semibold text-foreground">
                  {{ isDocx ? 'Word Document Ready' : 'Document Ready to View' }}
                </h4>
                <p class="text-xs text-muted-foreground mt-1.5 leading-relaxed">
                  {{ isDocx 
                    ? 'Word documents (.doc/.docx) cannot be rendered natively inside the browser frame. You can download it directly or open it in your document app.' 
                    : 'This document can be opened in a new tab or downloaded directly to your device.' 
                  }}
                </p>
              </div>

              <div class="flex flex-wrap items-center justify-center gap-3 pt-2 w-full">
                <a
                  :href="store.resumeModalUrl"
                  :download="downloadFilename"
                  class="flex-1 min-w-[130px] inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-xs font-semibold bg-primary text-primary-foreground hover:bg-primary/90 transition-all shadow-sm"
                >
                  <Download class="size-4" />
                  <span>Download File</span>
                </a>
                <a
                  :href="store.resumeModalUrl"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="flex-1 min-w-[130px] inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-xs font-semibold border border-border bg-muted/60 hover:bg-muted text-foreground transition-colors"
                >
                  <ExternalLink class="size-4" />
                  <span>Open in Tab</span>
                </a>
              </div>
            </div>
          </div>

          <!-- Modal Footer status bar -->
          <div class="h-9 px-4 sm:px-6 border-t border-border bg-card/90 backdrop-blur-xs flex items-center justify-between text-[11px] text-muted-foreground shrink-0">
            <span class="flex items-center gap-1.5">
              <span class="size-1.5 rounded-full bg-emerald-500"></span>
              <span>Document ready</span>
            </span>
            <span class="text-[10px] hidden sm:inline">Press <kbd class="px-1.5 py-0.5 rounded border border-border bg-muted font-mono text-[10px]">Esc</kbd> to close</span>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { ref, computed, watch, onMounted, onUnmounted, nextTick } from 'vue';
import { usePortfolioStore } from '@/stores/usePortfolioStore';
import { FileText, Download, ExternalLink, X, Loader2 } from 'lucide-vue-next';

const store = usePortfolioStore();
const isLoading = ref(true);
const modalCardRef = ref(null);
const isMobile = ref(false);

function updateDeviceType() {
  if (typeof window !== 'undefined') {
    isMobile.value =
      window.innerWidth < 640 ||
      /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent || '');
  }
}

function close() {
  store.closeResumeModal();
}

function handleKeydown(e) {
  if (e.key === 'Escape' && store.isResumeModalOpen) {
    close();
  }
}

watch(
  () => store.isResumeModalOpen,
  (isOpen) => {
    if (isOpen) {
      updateDeviceType();
      isLoading.value = true;
      document.body.style.overflow = 'hidden';
      window.addEventListener('keydown', handleKeydown);
      nextTick(() => {
        modalCardRef.value?.focus();
      });
    } else {
      document.body.style.overflow = '';
      window.removeEventListener('keydown', handleKeydown);
    }
  }
);

onMounted(() => {
  updateDeviceType();
  if (typeof window !== 'undefined') {
    window.addEventListener('resize', updateDeviceType);
  }
});

onUnmounted(() => {
  if (typeof window !== 'undefined') {
    window.removeEventListener('resize', updateDeviceType);
  }
  document.body.style.overflow = '';
  window.removeEventListener('keydown', handleKeydown);
});

const isPdf = computed(() => {
  const url = (store.resumeModalUrl || '').toLowerCase();
  return url.endsWith('.pdf') || url.includes('.pdf?') || url.includes('/resumes/');
});

const isDocx = computed(() => {
  const url = (store.resumeModalUrl || '').toLowerCase();
  return url.endsWith('.doc') || url.endsWith('.docx') || url.includes('.doc?') || url.includes('.docx?');
});

const isEmbeddable = computed(() => {
  const url = (store.resumeModalUrl || '').toLowerCase();
  return isPdf.value || url.includes('drive.google.com') || url.includes('docs.google.com');
});

const embedUrl = computed(() => {
  const rawUrl = store.resumeModalUrl || '';
  if (!rawUrl) return '';

  // Google Drive preview link transformation
  if (rawUrl.includes('drive.google.com/file/d/')) {
    return rawUrl.replace(/\/view(\?.*)?$/, '/preview');
  }

  // PDF direct view toolbar parameter
  if (isPdf.value) {
    const separator = rawUrl.includes('#') ? '&' : '#';
    return `${rawUrl}${separator}toolbar=1&navpanes=0`;
  }

  return rawUrl;
});

const fileTypeBadge = computed(() => {
  if (isPdf.value) return 'PDF Document';
  if (isDocx.value) return 'DOC Document';
  return 'Document';
});

const displayFilename = computed(() => {
  const url = store.resumeModalUrl || '';
  if (!url) return '';
  const clean = url.split('#')[0].split('?')[0];
  const parts = clean.split('/');
  return parts[parts.length - 1] || 'Resume.pdf';
});

const downloadFilename = computed(() => {
  return displayFilename.value || 'Kashif_Khan_Resume.pdf';
});
</script>

<style scoped>
.resume-modal-fade-enter-active,
.resume-modal-fade-leave-active {
  transition: opacity 0.25s ease, transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}

.resume-modal-fade-enter-from,
.resume-modal-fade-leave-to {
  opacity: 0;
}

.resume-modal-fade-enter-from .relative,
.resume-modal-fade-leave-to .relative {
  transform: scale(0.96) translateY(8px);
}
</style>
