import { defineStore } from 'pinia';

export const usePortfolioStore = defineStore('portfolio', {
  state: () => ({
    isResumeModalOpen: false,
    resumeModalUrl: '',
    resumeModalTitle: 'Resume / Curriculum Vitae',
  }),

  actions: {
    openResumeModal(url, title = 'Resume / Curriculum Vitae') {
      if (url) {
        this.resumeModalUrl = url;
      }
      if (title) {
        this.resumeModalTitle = title;
      }
      this.isResumeModalOpen = true;
    },
    closeResumeModal() {
      this.isResumeModalOpen = false;
    },
  },
});
