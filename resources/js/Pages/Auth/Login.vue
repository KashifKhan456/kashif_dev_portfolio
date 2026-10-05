<template>
  <div class="min-h-screen bg-black text-white flex items-center justify-center p-4 relative font-sans selection:bg-neutral-800 selection:text-white">
    <Head title="Admin Login - Kashif Khan Portfolio" />

    <div class="w-full max-w-md space-y-6">
      <!-- Back to Portfolio Link -->
      <div class="text-left">
        <Link href="/" class="text-xs text-neutral-400 hover:text-white font-semibold inline-flex items-center space-x-1.5 transition-colors">
          <span>&larr;</span>
          <span>Back to Portfolio</span>
        </Link>
      </div>

      <!-- Main Login Card -->
      <div class="bg-neutral-950 p-8 sm:p-10 rounded-md border border-neutral-800 shadow-2xl space-y-6 relative">
        <!-- Header -->
        <div class="text-center space-y-2">
          <div class="inline-flex w-10 h-10 rounded-md bg-white text-black font-extrabold text-sm items-center justify-center shadow-md mb-2">
            KK
          </div>
          <h2 class="text-2xl font-extrabold text-white tracking-tight">Admin CMS Portal</h2>
          <p class="text-xs text-neutral-400">Sign in to manage portfolio content, skills & inquiries.</p>
        </div>

        <div v-if="status" class="p-3 rounded-md bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs text-center font-medium">
          {{ status }}
        </div>

        <!-- Form -->
        <form @submit.prevent="submit" class="space-y-4">
          <div>
            <label for="email" class="block text-xs font-semibold text-neutral-300 mb-1.5">Email Address</label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              required
              autofocus
              autocomplete="username"
              placeholder="name@example.com"
              class="w-full px-4 py-2.5 rounded-md bg-black border border-neutral-800 text-white text-xs placeholder-neutral-500 focus:outline-none focus:border-white transition-colors"
            />
            <span v-if="form.errors.email" class="text-xs text-rose-400 mt-1 block">{{ form.errors.email }}</span>
          </div>

          <div>
            <div class="flex items-center justify-between mb-1.5">
              <label for="password" class="block text-xs font-semibold text-neutral-300">Password</label>
              <Link v-if="canResetPassword" :href="route('password.request')" class="text-[11px] text-neutral-400 hover:text-white transition-colors">
                Forgot password?
              </Link>
            </div>
            <input
              id="password"
              v-model="form.password"
              type="password"
              required
              autocomplete="current-password"
              placeholder="••••••••"
              class="w-full px-4 py-2.5 rounded-md bg-black border border-neutral-800 text-white text-xs placeholder-neutral-500 focus:outline-none focus:border-white transition-colors"
            />
            <span v-if="form.errors.password" class="text-xs text-rose-400 mt-1 block">{{ form.errors.password }}</span>
          </div>

          <div class="flex items-center justify-between pt-1">
            <label class="flex items-center space-x-2 text-xs text-neutral-300 cursor-pointer select-none">
              <input
                v-model="form.remember"
                type="checkbox"
                class="h-4 w-4 rounded-[3px] border border-neutral-600 bg-neutral-900 text-blue-500 checked:bg-blue-500 checked:border-blue-500 focus:ring-0 focus:ring-offset-0 cursor-pointer"
              />
              <span>Remember me</span>
            </label>
          </div>

          <button
            type="submit"
            :disabled="form.processing"
            class="w-full py-3 rounded-md bg-white hover:bg-neutral-200 text-black font-bold text-xs shadow-md transition-all disabled:opacity-50 mt-2 cursor-pointer flex items-center justify-center"
          >
            <span v-if="form.processing" class="inline-flex items-center space-x-2">
              <svg class="animate-spin w-4 h-4 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <span>Signing in...</span>
            </span>
            <span v-else>Log In to Dashboard</span>
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>
