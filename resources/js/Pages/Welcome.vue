<template>
  <GuestLayout :canLogin="canLogin" :settings="settings" :hideHeader="true" :hideFooter="true">
    <Head :title="`${heroDisplayName} - Portfolio`" />

    <main class="min-h-dvh flex flex-col relative z-10 bg-background text-foreground transition-colors duration-300">
      <!-- Top Flickering Grid Background (Exact Magic UI Stipple Fade) -->
      <div class="absolute inset-0 top-0 left-0 right-0 h-[120px] overflow-hidden z-0 pointer-events-none">
        <FlickeringGrid
          class="h-full w-full"
          :squareSize="2"
          :gridGap="2"
          style="mask-image: linear-gradient(to bottom, black 20%, transparent 100%); -webkit-mask-image: linear-gradient(to bottom, black 20%, transparent 100%);"
        />
      </div>

      <!-- Main Centered Layout Container matching portfolio/src/app/layout.tsx -->
      <div class="relative z-10 w-full max-w-2xl min-w-0 mx-auto py-8 sm:py-16 md:py-24 pb-28 sm:pb-32 px-4 sm:px-6 flex flex-col gap-10 sm:gap-14 overflow-hidden">

        <!-- 1. HERO SECTION -->
        <section id="hero" class="w-full min-w-0">
          <div class="mx-auto w-full max-w-2xl space-y-6">
            <div class="gap-4 sm:gap-2 gap-y-6 flex flex-col md:flex-row justify-between items-start md:items-center">
              <!-- Left: Greeting, Title & Bio -->
              <div class="gap-2.5 flex flex-col order-2 md:order-1 flex-1 min-w-0">
                <BlurFade :delay="BLUR_FADE_DELAY" :yOffset="8" blur="8px">
                  <h1 class="text-3xl font-semibold tracking-tighter sm:text-4xl lg:text-5xl text-foreground text-balance">
                    Hi, I'm {{ heroFirstName }} 👋
                  </h1>
                </BlurFade>
                <BlurFade :delay="BLUR_FADE_DELAY" :yOffset="8" blur="8px">
                  <p class="text-muted-foreground max-w-[600px] text-sm sm:text-base md:text-lg lg:text-xl font-normal leading-relaxed text-pretty break-words">
                    {{ heroBio }}
                  </p>
                </BlurFade>

                <!-- Resume / CV Action Link -->
                <BlurFade v-if="resumeUrl" :delay="BLUR_FADE_DELAY * 1.5" :yOffset="8" blur="8px" class="pt-1 flex items-center gap-3">
                  <button
                    type="button"
                    @click="openResume"
                    class="h-8 px-3 rounded-lg border border-border bg-card/80 hover:bg-muted text-foreground text-xs font-semibold inline-flex items-center gap-1.5 shadow-2xs transition-colors group/resume cursor-pointer"
                  >
                    <FileText class="size-3.5 text-muted-foreground group-hover/resume:text-foreground transition-colors" />
                    <span>Resume / CV</span>
                    <ArrowUpRight class="size-3 text-muted-foreground group-hover/resume:translate-x-0.5 group-hover/resume:-translate-y-0.5 transition-transform" />
                  </button>
                </BlurFade>
              </div>

              <!-- Right: Circular Avatar with Ring Border -->
              <BlurFade :delay="BLUR_FADE_DELAY" class="order-1 md:order-2 shrink-0">
                <div class="size-20 sm:size-24 md:size-32 border border-border rounded-full shadow-lg ring-4 ring-muted overflow-hidden flex items-center justify-center bg-card select-none">
                  <img
                    v-if="profileImageUrl && !avatarError"
                    :src="profileImageUrl"
                    :alt="heroDisplayName"
                    class="w-full h-full object-cover"
                    @error="avatarError = true"
                  />
                  <span v-else class="text-xl sm:text-2xl md:text-3xl font-bold text-foreground">
                    {{ userInitials }}
                  </span>
                </div>
              </BlurFade>
            </div>
          </div>
        </section>

        <!-- 2. ABOUT SECTION -->
        <section id="about" class="w-full min-w-0">
          <div class="flex min-h-0 flex-col gap-y-3 sm:gap-y-4">
            <BlurFade :delay="BLUR_FADE_DELAY * 3">
              <h2 class="text-xl font-bold tracking-tight text-foreground">About</h2>
            </BlurFade>
            <BlurFade :delay="BLUR_FADE_DELAY * 4">
              <div class="prose max-w-full text-pretty font-sans leading-relaxed text-muted-foreground dark:prose-invert text-xs sm:text-sm md:text-base break-words">
                <p v-if="hasHtmlAbout" v-html="aboutText"></p>
                <p v-else class="whitespace-pre-line">{{ aboutText }}</p>
              </div>
            </BlurFade>
          </div>
        </section>

        <!-- 2.5 GITHUB ACTIVITY SECTION -->
        <BlurFade :delay="BLUR_FADE_DELAY * 4.5">
          <section id="github-activity" class="w-full min-w-0 max-w-full overflow-hidden">
            <GitHubHeatmap :githubUrl="githubProfileUrl" :username="githubUsername" />
          </section>
        </BlurFade>

        <!-- 3. WORK EXPERIENCE SECTION (Clean Accordion Style from portfolio) -->
        <section id="work" class="w-full min-w-0">
          <div class="flex min-h-0 flex-col gap-y-6">
            <BlurFade :delay="BLUR_FADE_DELAY * 5">
              <h2 class="text-xl font-bold tracking-tight text-foreground">Work Experience</h2>
            </BlurFade>

            <BlurFade :delay="BLUR_FADE_DELAY * 6">
              <div class="w-full grid gap-4">
              <div
                v-for="(company, cIdx) in companyExperiences"
                :key="company.id || cIdx"
                class="w-full border-b border-border/60 pb-4 last:border-b-0 last:pb-0"
              >
                <div
                  v-for="(role, rIdx) in company.roles"
                  :key="role.id || rIdx"
                  class="group cursor-pointer"
                  @click="toggleRole(cIdx, rIdx)"
                >
                  <div class="flex items-start justify-between gap-x-3 w-full text-left">
                    <div class="flex items-start gap-x-3 flex-1 min-w-0">
                      <!-- Circular Company Avatar -->
                      <div
                        class="size-8 sm:size-9 md:size-10 p-1 border rounded-full shadow ring-2 ring-border bg-card flex items-center justify-center font-bold text-xs shrink-0 select-none overflow-hidden mt-0.5"
                      >
                        <img
                          v-if="company.logo"
                          :src="company.logo"
                          :alt="company.company"
                          class="size-full object-contain rounded-full"
                          loading="lazy"
                        />
                        <span v-else :class="company.logoTextClass || 'text-foreground'">{{ company.logoText }}</span>
                      </div>

                      <div class="flex-1 min-w-0 flex flex-col">
                        <div class="font-semibold text-sm sm:text-base leading-snug flex items-center gap-1.5 text-foreground flex-wrap">
                          <span>{{ company.company }}</span>
                          <span class="relative inline-flex items-center size-3.5 shrink-0">
                            <ChevronRight
                              class="absolute size-3.5 shrink-0 text-muted-foreground stroke-2 transition-transform duration-200"
                              :class="{ 'rotate-90 text-foreground': role.isOpen, 'group-hover:translate-x-0.5': !role.isOpen }"
                            />
                          </span>
                        </div>
                        <div class="font-sans text-xs sm:text-sm text-muted-foreground mt-0.5 leading-normal">
                          {{ role.role }}
                        </div>
                        <!-- Period on mobile: cleanly placed below role -->
                        <div class="sm:hidden text-[11px] tabular-nums text-muted-foreground/80 mt-1 select-none">
                          {{ role.period }}
                        </div>
                      </div>
                    </div>

                    <!-- Period Right-Aligned for Desktop / Tablet -->
                    <div class="hidden sm:block text-xs tabular-nums text-muted-foreground text-right shrink-0 select-none pt-0.5">
                      <span>{{ role.period }}</span>
                    </div>
                  </div>

                  <!-- Expandable Role Content (Clean Single Paragraph like reference) -->
                  <div
                    v-if="role.isOpen"
                    class="mt-2.5 ml-0 sm:ml-11 md:ml-13 text-xs sm:text-sm text-muted-foreground leading-relaxed break-words"
                    @click.stop
                  >
                    <p class="leading-relaxed text-muted-foreground font-normal">
                      {{ role.description }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </BlurFade>
          </div>
        </section>

        <!-- 4. EDUCATION SECTION -->
        <section v-if="educationList && educationList.length" id="education" class="w-full min-w-0">
          <div class="flex min-h-0 flex-col gap-y-6">
            <BlurFade :delay="BLUR_FADE_DELAY * 7">
              <h2 class="text-xl font-bold tracking-tight text-foreground">Education</h2>
            </BlurFade>

            <div class="flex flex-col gap-6">
              <BlurFade
                v-for="(edu, index) in educationList"
                :key="edu.id"
                :delay="BLUR_FADE_DELAY * 8 + index * 0.05"
              >
                <div class="flex items-start justify-between gap-x-3 group">
                  <div class="flex items-start gap-x-3 flex-1 min-w-0">
                    <div class="size-8 sm:size-9 md:size-10 p-1 border rounded-full shadow ring-2 ring-border bg-card flex items-center justify-center font-bold text-xs shrink-0 select-none overflow-hidden mt-0.5">
                      <img
                        v-if="edu.logo"
                        :src="edu.logo"
                        :alt="edu.institution"
                        class="size-full object-contain rounded-full"
                        loading="lazy"
                      />
                      <span v-else class="text-foreground">{{ edu.logoText }}</span>
                    </div>
                    <div class="flex-1 min-w-0 flex flex-col">
                      <div class="font-semibold text-sm sm:text-base leading-snug text-foreground">
                        {{ edu.institution }}
                      </div>
                      <div class="font-sans text-xs sm:text-sm text-muted-foreground mt-0.5 leading-normal">
                        {{ edu.degree }}
                      </div>
                      <!-- Period on mobile: cleanly placed below degree -->
                      <div class="sm:hidden text-[11px] tabular-nums text-muted-foreground/80 mt-1 select-none">
                        {{ edu.period }}
                      </div>
                    </div>
                  </div>
                  <!-- Period on Desktop / Tablet -->
                  <div class="hidden sm:block text-xs tabular-nums text-muted-foreground text-right shrink-0 select-none pt-0.5">
                    <span>{{ edu.period }}</span>
                  </div>
                </div>
              </BlurFade>
            </div>
          </div>
        </section>

        <!-- 5. CERTIFICATIONS SECTION -->
        <section v-if="certificationList && certificationList.length" id="certifications" class="w-full min-w-0">
          <div class="flex min-h-0 flex-col gap-y-6">
            <BlurFade :delay="BLUR_FADE_DELAY * 8.5">
              <h2 class="text-xl font-bold tracking-tight text-foreground">Certifications &amp; Training</h2>
            </BlurFade>

            <div class="flex flex-col gap-6">
              <BlurFade
                v-for="(cert, index) in certificationList"
                :key="cert.id"
                :delay="BLUR_FADE_DELAY * 8.8 + index * 0.05"
              >
                <div class="flex items-start justify-between gap-x-3 group">
                  <div class="flex items-start gap-x-3 flex-1 min-w-0">
                    <div class="size-8 sm:size-9 md:size-10 p-1 border rounded-full shadow ring-2 ring-border bg-card flex items-center justify-center font-bold text-xs shrink-0 select-none overflow-hidden mt-0.5">
                      <img
                        v-if="cert.logo"
                        :src="cert.logo"
                        :alt="cert.institution"
                        class="size-full object-contain rounded-full"
                        loading="lazy"
                      />
                      <span v-else class="text-foreground">{{ cert.logoText }}</span>
                    </div>
                    <div class="flex-1 min-w-0 flex flex-col">
                      <div class="font-semibold text-sm sm:text-base leading-snug text-foreground">
                        {{ cert.institution }}
                      </div>
                      <div class="font-sans text-xs sm:text-sm text-muted-foreground mt-0.5 leading-normal">
                        {{ cert.title || cert.degree }}
                      </div>
                      <!-- Period on mobile: cleanly placed below -->
                      <div class="sm:hidden text-[11px] tabular-nums text-muted-foreground/80 mt-1 select-none">
                        {{ cert.period }}
                      </div>
                    </div>
                  </div>
                  <!-- Period on Desktop / Tablet -->
                  <div class="hidden sm:block text-xs tabular-nums text-muted-foreground text-right shrink-0 select-none pt-0.5">
                    <span>{{ cert.period }}</span>
                  </div>
                </div>
              </BlurFade>
            </div>
          </div>
        </section>

        <!-- 5. SKILLS SECTION (Clean Badges from portfolio) -->
        <section id="skills">
          <div class="flex min-h-0 flex-col gap-y-4">
            <BlurFade :delay="BLUR_FADE_DELAY * 9">
              <h2 class="text-xl font-bold tracking-tight text-foreground">Skills</h2>
            </BlurFade>

            <div class="flex flex-wrap gap-2">
              <BlurFade
                v-for="(skill, id) in visibleSkills"
                :key="skill.name"
                :delay="BLUR_FADE_DELAY * 10 + id * 0.05"
              >
                <div
                  class="border bg-background border-border ring-2 ring-border/20 rounded-xl h-8 w-fit px-4 flex items-center gap-2 hover:bg-muted/40 transition-colors"
                >
                  <TechIcon v-if="skill.icon" :name="skill.icon" size="size-4" class="rounded overflow-hidden object-contain shrink-0" />
                  <span class="text-foreground text-sm font-medium">{{ skill.name }}</span>
                </div>
              </BlurFade>
            </div>

            <!-- Show more / Show less toggle -->
            <div v-if="displaySkills.length > 12" class="pt-1">
              <button
                type="button"
                @click="showAllSkills = !showAllSkills"
                class="text-xs font-medium text-muted-foreground hover:text-foreground underline underline-offset-4 cursor-pointer transition-colors"
              >
                {{ showAllSkills ? 'Show less' : 'Show more...' }}
              </button>
            </div>
          </div>
        </section>

        <!-- 6. PROJECTS SECTION (Exact Divider with Badge & Cards from portfolio) -->
        <section id="projects">
          <div class="flex min-h-0 flex-col gap-y-8">
            <BlurFade :delay="BLUR_FADE_DELAY * 11">
              <!-- Header with Linear-Gradient Divider -->
              <div class="flex flex-col gap-y-4 items-center justify-center">
                <div class="flex items-center w-full">
                  <div class="flex-1 h-px bg-gradient-to-r from-transparent via-border to-transparent"></div>
                  <div class="border border-border bg-primary z-10 rounded-xl px-4 py-1 shadow-xs">
                    <span class="text-primary-foreground text-sm font-medium">My Projects</span>
                  </div>
                  <div class="flex-1 h-px bg-gradient-to-l from-transparent via-border to-transparent"></div>
                </div>

                <div class="flex flex-col gap-y-3 items-center justify-center text-center">
                  <h2 class="text-3xl font-bold tracking-tighter sm:text-4xl text-foreground">
                    Check out my latest work
                  </h2>
                  <p class="text-muted-foreground md:text-lg/relaxed lg:text-base/relaxed text-balance max-w-lg">
                    I've worked on a variety of projects, from simple websites to complex web applications. Here are a few of my favorites.
                  </p>
                </div>
              </div>
            </BlurFade>

            <!-- 2-Column Grid of Project Cards matching portfolio/src/components/project-card.tsx -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 max-w-[800px] mx-auto auto-rows-fr w-full">
              <BlurFade
                v-for="(project, id) in displayedProjects"
                :key="project.id"
                :delay="BLUR_FADE_DELAY * 12 + id * 0.05"
                class="h-full"
              >
                <div
                  class="flex flex-col h-full border border-border bg-card rounded-xl overflow-hidden hover:ring-2 hover:ring-muted/50 transition-all duration-200 group"
                >
                  <!-- Thumbnail / Media with Live Badges -->
                  <div class="relative shrink-0 w-full aspect-video overflow-hidden bg-muted">
                    <img
                      :src="project.image_path || project.image_url || getProjectFallbackImage(project)"
                      :alt="project.title"
                      class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                      @error="onProjectImgError"
                    />

                    <!-- Top Right Live Website / Source Badges -->
                    <div class="absolute top-2 right-2 flex flex-wrap gap-1.5">
                      <a
                        v-if="getProjectDemoUrl(project)"
                        :href="getProjectDemoUrl(project)"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex items-center gap-1 text-[11px] font-semibold bg-black/80 text-white hover:bg-black px-2 py-0.5 rounded-md backdrop-blur-xs shadow-xs"
                      >
                        <Globe class="size-3" />
                        <span>Live</span>
                      </a>
                      <a
                        v-if="getProjectGithubUrl(project)"
                        :href="getProjectGithubUrl(project)"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex items-center gap-1 text-[11px] font-semibold bg-black/80 text-white hover:bg-black px-2 py-0.5 rounded-md backdrop-blur-xs shadow-xs"
                      >
                        <FolderGit2 class="size-3" />
                        <span>Source</span>
                      </a>
                    </div>
                  </div>

                  <!-- Card Body -->
                  <div class="p-5 flex flex-col gap-2.5 flex-1">
                    <div class="flex items-start justify-between gap-2">
                      <div class="flex flex-col gap-0.5">
                        <h3 class="font-semibold text-foreground text-sm sm:text-base">
                          {{ project.title }}
                        </h3>
                        <time v-if="project.date || project.period" class="text-xs text-muted-foreground tabular-nums">
                          {{ project.date || project.period }}
                        </time>
                      </div>
                    </div>

                    <p class="text-xs flex-1 text-muted-foreground leading-relaxed line-clamp-3">
                      {{ project.summary || project.short_description || project.description }}
                    </p>

                    <!-- Tech Stack Outline Badges -->
                    <div class="flex flex-wrap gap-1 mt-auto pt-2">
                      <span
                        v-for="tag in getProjectTags(project)"
                        :key="tag"
                        class="text-[11px] font-medium border border-border h-6 w-fit px-2 rounded-md bg-muted/40 text-muted-foreground inline-flex items-center"
                      >
                        {{ tag }}
                      </span>
                    </div>
                  </div>
                </div>
              </BlurFade>
            </div>

            <!-- Show All / Show Less Projects Button -->
            <div v-if="projects && projects.length > 6" class="text-center pt-2">
              <button
                @click="showAllProjects = !showAllProjects"
                class="px-4 py-2 text-xs font-semibold rounded-xl border border-border bg-card text-foreground hover:bg-muted transition-all cursor-pointer shadow-xs"
              >
                {{ showAllProjects ? 'Show Less' : `View All Projects (${projects.length})` }}
              </button>
            </div>
          </div>
        </section>

        <!-- 7. ARTICLES & CMS SECTION (Clean Timeline/Publication Style) -->
        <section v-if="articles && articles.length" id="articles">
          <div class="flex min-h-0 flex-col gap-y-8">
            <BlurFade :delay="BLUR_FADE_DELAY * 13">
              <div class="flex flex-col gap-y-4 items-center justify-center">
                <div class="flex items-center w-full">
                  <div class="flex-1 h-px bg-gradient-to-r from-transparent via-border to-transparent"></div>
                  <div class="border border-border bg-primary z-10 rounded-xl px-4 py-1 shadow-xs">
                    <span class="text-primary-foreground text-sm font-medium">Articles</span>
                  </div>
                  <div class="flex-1 h-px bg-gradient-to-l from-transparent via-border to-transparent"></div>
                </div>

                <div class="flex flex-col gap-y-3 items-center justify-center text-center">
                  <h2 class="text-3xl font-bold tracking-tighter sm:text-4xl text-foreground">
                    Latest Writings & Engineering Notes
                  </h2>
                </div>
              </div>
            </BlurFade>

            <div class="flex flex-col gap-3">
              <BlurFade
                v-for="(article, id) in articles"
                :key="article.id"
                :delay="BLUR_FADE_DELAY * 13.5 + id * 0.05"
              >
                <Link
                  :href="route('blog.show', article.slug || article.id)"
                  class="flex items-center justify-between p-4 rounded-xl border border-border bg-card hover:border-muted-foreground/30 transition-all group"
                >
                  <div class="flex flex-col gap-1 min-w-0 flex-1 pr-4">
                    <h3 class="font-semibold text-sm sm:text-base text-foreground group-hover:text-blue-500 transition-colors truncate">
                      {{ article.title }}
                    </h3>
                    <p v-if="article.excerpt" class="text-xs text-muted-foreground line-clamp-1">
                      {{ article.excerpt }}
                    </p>
                  </div>
                  <div class="flex items-center gap-3 shrink-0">
                    <span v-if="article.published_at || article.created_at" class="text-xs text-muted-foreground tabular-nums">
                      {{ formatDate(article.published_at || article.created_at) }}
                    </span>
                    <ArrowUpRight class="size-4 text-muted-foreground group-hover:text-foreground transition-colors" />
                  </div>
                </Link>
              </BlurFade>
            </div>

            <div class="flex justify-center mt-2">
              <Link
                :href="route('blog.index')"
                class="text-sm font-medium text-muted-foreground hover:text-foreground inline-flex items-center gap-1.5 transition-colors group"
              >
                <span>View all posts</span>
                <ChevronRight class="size-4 group-hover:translate-x-0.5 transition-transform" />
              </Link>
            </div>
          </div>
        </section>

        <!-- 8. FLOATING TESTIMONIALS SECTION (Infinite Marquee with 5-Stars & Avatars) -->
        <BlurFade :delay="BLUR_FADE_DELAY * 14">
          <section id="testimonials" class="w-full">
            <FloatingTestimonials :testimonials="testimonials" />
          </section>
        </BlurFade>

        <!-- 9. CONTACT SECTION (Exact Card & Flickering Grid from portfolio/src/components/section/contact-section.tsx) -->
        <BlurFade :delay="BLUR_FADE_DELAY * 16">
          <section id="contact" class="w-full min-w-0 pt-2">
            <div class="border border-border rounded-xl pt-9 pb-6 px-5 sm:pt-12 sm:pb-8 sm:px-8 md:pt-14 md:pb-10 md:px-10 relative bg-card text-center min-w-0 overflow-visible">
              <!-- Floating Pill Badge on Top Edge -->
              <div class="absolute -top-3.5 border border-border bg-primary z-10 rounded-xl px-4 py-1 left-1/2 -translate-x-1/2 shadow-xs select-none">
                <span class="text-primary-foreground text-sm font-medium">Contact</span>
              </div>

              <!-- Flickering Grid Background -->
              <div class="absolute inset-0 top-0 left-0 right-0 h-1/2 rounded-xl overflow-hidden pointer-events-none">
                <FlickeringGrid
                  class="h-full w-full"
                  :squareSize="2"
                  :gridGap="2"
                  style="mask-image: linear-gradient(to bottom, black, transparent); -webkit-mask-image: linear-gradient(to bottom, black, transparent);"
                />
              </div>

              <div class="relative flex flex-col items-center gap-3 sm:gap-4 text-center z-10 min-w-0">
                <h2 class="text-2xl font-bold tracking-tighter sm:text-4xl md:text-5xl text-foreground text-balance">
                  {{ contactHeadlineTitle }}
                </h2>

                <p v-if="formattedContactSubtitle" v-html="formattedContactSubtitle" class="mx-auto max-w-lg text-muted-foreground text-balance text-xs sm:text-base leading-relaxed break-words"></p>

                <p v-else class="mx-auto max-w-lg text-muted-foreground text-balance text-xs sm:text-base leading-relaxed break-words">
                  Wanna chat? Let's
                  <a
                    :href="calMeetingUrl"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="text-blue-500 hover:underline underline-offset-4 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring rounded-sm font-medium"
                  >
                    schedule a meet!
                  </a>
                  or drop an
                  <a
                    :href="`mailto:${contactEmail}`"
                    class="text-blue-500 hover:underline underline-offset-4 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring rounded-sm font-medium"
                  >
                    email
                  </a>. I will be ignoring all soliciting.
                </p>
              </div>
            </div>
          </section>
        </BlurFade>

      </div>
    </main>

    <!-- Floating Bottom Navigation Dock (Exact navbar.tsx from portfolio) -->
    <MagicDock :settings="settings" />
  </GuestLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import FlickeringGrid from '@/Components/FlickeringGrid.vue';
import BlurFade from '@/Components/BlurFade.vue';
import MagicDock from '@/Components/MagicDock.vue';
import FloatingTestimonials from '@/Components/FloatingTestimonials.vue';
import TechIcon from '@/Components/TechIcon.vue';
import GitHubHeatmap from '@/Components/GitHubHeatmap.vue';
import { usePortfolioStore } from '@/stores/usePortfolioStore';
import {
  ArrowUpRight,
  ChevronRight,
  Globe,
  FolderGit2,
  FileText,
} from 'lucide-vue-next';

const BLUR_FADE_DELAY = 0.04;

const props = defineProps({
  projects: Array,
  skills: Array,
  experiences: Array,
  testimonials: Array,
  articles: Array,
  settings: Object,
  canLogin: Boolean,
});

const avatarError = ref(false);
const showAllProjects = ref(false);
const showAllSkills = ref(false);

const githubProfileUrl = computed(() => {
  return props.settings?.github_url || 'https://github.com/KashifKhan456';
});

const githubUsername = computed(() => {
  const url = githubProfileUrl.value;
  const parts = url.split('/').filter(Boolean);
  return parts[parts.length - 1] || 'KashifKhan456';
});

const resumeUrl = computed(() => {
  return props.settings?.resume_url && props.settings.resume_url !== '#' ? props.settings.resume_url : '';
});

const portfolioStore = usePortfolioStore();

function openResume() {
  if (resumeUrl.value) {
    portfolioStore.openResumeModal(resumeUrl.value, `${heroDisplayName.value} — Resume / CV`);
  }
}

// ----------------------------------------------------------------------
// Hero Section Information
// ----------------------------------------------------------------------
const heroDisplayName = computed(() => {
  let name = props.settings?.hero_title_1 || 'Kashif Khan';
  name = name.replace(/^(hey|hi|hello),?\s*(i'm|i am)?\s*/i, '').trim();
  return name || 'Kashif Khan';
});

const heroFirstName = computed(() => {
  const parts = heroDisplayName.value.split(/\s+/);
  return parts[0] || 'Kashif';
});

const userInitials = computed(() => {
  const parts = heroDisplayName.value.split(/\s+/);
  if (parts.length >= 2) {
    return `${parts[0][0]}${parts[1][0]}`.toUpperCase();
  }
  return heroDisplayName.value.substring(0, 2).toUpperCase() || 'KK';
});

const profileImageUrl = computed(() => {
  return props.settings?.avatar_url || props.settings?.profile_image || '';
});

const heroBio = computed(() => {
  return (
    props.settings?.hero_subtitle ||
    props.settings?.hero_title_2 ||
    'Full Stack Software Engineer with 3.5+ years of experience building and scaling production web applications across Laravel, React.js, and Vue.js.'
  );
});

const defaultAbout = 'Full Stack Software Engineer with 3.5+ years of experience building and scaling web applications across Laravel, React.js, and Vue.js. Proven track record leading development teams and architecting production systems including a real-time EPOS platform, secure RBAC-driven CRM systems, and maintainable e-commerce, auction, and LMS platforms from requirements through deployment.\n\nSkilled in RESTful API design, clean architecture, database optimization, and third-party integrations (Stripe, AWS S3, SendGrid). Strong advocate for TDD and accessibility (WCAG 2.2), combining solid technical execution with Agile leadership and a track record of mentoring teams and shipping on schedule.';

const aboutText = computed(() => {
  return props.settings?.about_text || props.settings?.bio || defaultAbout;
});

const hasHtmlAbout = computed(() => {
  return typeof aboutText.value === 'string' && /<[a-z][\s\S]*>/i.test(aboutText.value);
});

const contactHeadlineTitle = computed(() => {
  return props.settings?.contact_headline_title || 'Get in Touch';
});

const contactSubtitle = computed(() => {
  return props.settings?.contact_subtitle || '';
});


const formattedContactSubtitle = computed(() => {
  if (!contactSubtitle.value) return '';
  let text = contactSubtitle.value;

  const calLink = `<a href="${calMeetingUrl.value}" target="_blank" rel="noopener noreferrer" class="text-blue-500 hover:underline underline-offset-4 font-medium">schedule a meet!</a>`;
  const emailLink = `<a href="mailto:${contactEmail.value}" class="text-blue-500 hover:underline underline-offset-4 font-medium">email</a>`;

  text = text.replace(/\{cal\}/gi, calLink);
  text = text.replace(/\{email\}/gi, emailLink);

  return text;
});

// ----------------------------------------------------------------------
// Work Experience Data & Dynamic DB Integration
// ----------------------------------------------------------------------
const defaultExperiences = [
  {
    id: 'meshsq',
    company: 'Meshsq Pvt Ltd',
    logoText: 'MP',
    roles: [
      {
        id: 'meshsq-dev',
        role: 'Full Stack Developer',
        workType: 'Full-time',
        location: 'Rawalpindi, Pakistan',
        period: 'April 20, 2026 – Present',
        isOpen: false,
        description: 'Contributing to the end-to-end engineering of DocHyve, an enterprise web platform designed to streamline digital workflows and collaborative operations. Responsible for designing and maintaining robust backend RESTful APIs, complex business logic, and transactional database architecture, while constructing reusable, high-performance UI components with a strong focus on usability and system responsiveness. Actively collaborate across agile sprints to translate product requirements into maintainable features, conduct thorough code reviews, and enforce rigorous software engineering standards.',
        tags: ['Laravel', 'React.js', 'Tailwind CSS', 'RESTful APIs', 'Git']
      }
    ]
  },
  {
    id: 'goritmi',
    company: 'Goritmi Pvt Ltd',
    logoText: 'GP',
    roles: [
      {
        id: 'goritmi-lead',
        role: 'Senior Software Developer | Team Lead',
        workType: 'Full-time',
        location: 'Peshawar, Pakistan',
        period: 'Sept 1, 2025 – 1 April, 2026',
        isOpen: false,
        description: 'Led a cross-functional engineering team in architecting and delivering an enterprise Electronic Point of Sale (EPOS) and Kitchen Display System engineered for high-volume hospitality environments. Spearheaded core modules including real-time order dispatch, cashier shift auditing, dynamic promotional engines, automated thermal receipt printing, and live inventory depletion tracking. Engineered bi-directional WebSocket channels for real-time customer and kitchen status synchronizations, integrated secure payment gateways, and dramatically enhanced throughput via advanced database indexing, caching strategies, and modular clean architecture.',
        tags: ['Laravel', 'Vue.js', 'Tailwind CSS', 'Stripe', 'SendGrid', 'AWS S3', 'EPOS System', 'RESTful APIs']
      }
    ]
  },
  {
    id: 'cloud-rexpo',
    company: 'Cloud Rexpo',
    logoText: 'CR',
    roles: [
      {
        id: 'rexpo-dev',
        role: 'Laravel Developer',
        workType: 'Full-time',
        location: 'Rawalpindi, Pakistan',
        period: 'May, 2025 – 30 Aug, 2025',
        isOpen: false,
        description: 'Contributed to the engineering and modernization of a high-traffic Real Estate CRM platform. Collaborated closely with senior developers to refactor legacy codebases, resolve complex system bottlenecks, and integrate critical third-party services including automated payment handling, bidirectional Google Calendar scheduling, cloud asset storage, and transaction-driven email notifications. Architected a granular role-based access control (RBAC) engine alongside real-time user notification queues, significantly accelerating response times and improving cross-team operational transparency.',
        tags: ['Laravel', 'Stripe', 'Google Calendar', 'AWS S3', 'SendGrid', 'RBAC', 'RESTful APIs']
      }
    ]
  },
  {
    id: 'techinn360',
    company: 'Techinn360',
    logoText: 'TI',
    roles: [
      {
        id: 'techinn-dev',
        role: 'Full Stack Developer',
        workType: 'Full-time',
        location: 'Rawalpindi, Pakistan',
        period: 'June, 2024 – May 2025',
        isOpen: false,
        description: 'Architected and deployed multiple customer-facing web platforms, including an international automotive e-commerce marketplace serving clients across the UAE and GCC region, a real-time speed auction bidding engine, and an interactive learning management system. Focused heavily on high-traffic performance optimization, complex frontend state orchestration, and search visibility, achieving a perfect 100 SEO score, 96 Best Practices, and 93 Accessibility rating on Google Lighthouse under WCAG 2.2 guidelines. Championed Test-Driven Development (TDD) and iterative Scrum ceremonies to consistently ship reliable, production-ready releases.',
        tags: ['Laravel', 'Vue.js', 'React', 'TDD', 'Agile/Scrum', 'WCAG 2.2', 'SEO', 'E-Commerce']
      }
    ]
  },
  {
    id: 'tritech',
    company: 'TriTech Soft Solutions',
    logoText: 'TS',
    roles: [
      {
        id: 'tritech-dev',
        role: 'Junior Laravel Developer',
        workType: 'Full-time',
        location: 'Mardan, Pakistan',
        period: 'March, 2023 – June 2024',
        isOpen: false,
        description: 'Developed and maintained dynamic web applications and core customer relationship management (CRM) systems with an emphasis on reliable API architectures and database efficiency. Built and documented modular RESTful API endpoints, implemented transactional business logic, and designed interactive user interfaces that improved client workflow productivity. Managed schema migrations, optimized relational database queries, and collaborated actively across Git version-controlled agile environments to maintain high code quality.',
        tags: ['Laravel', 'JavaScript', 'React.js', 'Vue.js', 'RESTful APIs', 'Git', 'MySQL']
      }
    ]
  }
];

function extractTechTags(exp) {
  let techs = exp.technologies;
  if (typeof techs === 'string' && techs.trim()) {
    try {
      techs = JSON.parse(techs);
    } catch (e) {
      techs = techs.split(',').map(s => s.trim()).filter(Boolean);
    }
  }
  if (Array.isArray(techs) && techs.length) return techs;
  return [];
}

function isEducationExp(exp) {
  const c = (exp.company || '').toLowerCase();
  const r = (exp.role || exp.title || '').toLowerCase();
  const t = (exp.type || '').toLowerCase();
  return t === 'education' || c.includes('university') || c.includes('college') || r.includes('bachelor') || r.includes('degree');
}

function isCertificationExp(exp) {
  const c = (exp.company || '').toLowerCase();
  const r = (exp.role || exp.title || '').toLowerCase();
  const t = (exp.type || '').toLowerCase();
  return t === 'certification' || c.includes('nftp') || c.includes('training') || c.includes('freelancing') || r.includes('certification') || r.includes('training');
}

const companyExperiences = ref(defaultExperiences);

if (props.experiences && props.experiences.length) {
  const workItems = props.experiences.filter(exp => !isEducationExp(exp) && !isCertificationExp(exp));
  if (workItems.length) {
    companyExperiences.value = workItems.map((exp, idx) => {
      const logoInitials = exp.company
        ? exp.company.split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase()
        : 'EXP';

      const tagsList = extractTechTags(exp);

      return {
        id: exp.id || `db-exp-${idx}`,
        company: exp.company || 'Company Name',
        logo: exp.logo || null,
        logoText: logoInitials,
        roles: [
          {
            id: `role-${exp.id || idx}`,
            role: exp.role || exp.title || 'Software Engineer',
            workType: exp.work_type || 'Full-time',
            location: exp.location || '',
            period: exp.period || '2024 — Present',
            isOpen: false,
            description: exp.description || '',
            tags: tagsList
          }
        ]
      };
    });
  }
}

function toggleRole(companyIdx, roleIdx) {
  const comp = companyExperiences.value[companyIdx];
  if (comp && comp.roles && comp.roles[roleIdx]) {
    comp.roles[roleIdx].isOpen = !comp.roles[roleIdx].isOpen;
  }
}

// ----------------------------------------------------------------------
// Education Section Data
// ----------------------------------------------------------------------
const defaultEducation = [
  {
    id: 'uet-mardan',
    institution: 'University of Engineering and Technology Mardan',
    degree: 'Bachelor of Computer Software Engineering',
    period: '2020 – 2024',
    logoText: 'UET',
    description: 'Specialized in Software Architecture, Relational Databases, Algorithms, and Object-Oriented Software Design.'
  }
];

const educationList = computed(() => {
  if (props.experiences && props.experiences.length) {
    const eduItems = props.experiences.filter(exp => isEducationExp(exp));
    if (eduItems.length) {
      return eduItems.map((exp, idx) => ({
        id: exp.id || `edu-${idx}`,
        institution: exp.company || 'University of Engineering and Technology Mardan',
        degree: exp.role || exp.title || 'Bachelor of Computer Software Engineering',
        period: exp.period || '2020 – 2024',
        logo: exp.logo || null,
        logoText: exp.company ? exp.company.split(' ').map(w => w[0]).join('').substring(0, 3).toUpperCase() : 'UET',
        description: exp.description || ''
      }));
    }
  }
  return defaultEducation;
});

// ----------------------------------------------------------------------
// Certifications & Training Section Data
// ----------------------------------------------------------------------
const defaultCertifications = [
  {
    id: 'nftp',
    institution: 'National Freelancing Training Program (NFTP)',
    title: 'Full Stack Development Certification & Training',
    period: 'Dec 09, 2022 – March 2023',
    logoText: 'NFTP',
    description: 'Completed industry-aligned full-stack web software training, agile project delivery, PHP, and JavaScript.'
  }
];

const certificationList = computed(() => {
  if (props.experiences && props.experiences.length) {
    const certItems = props.experiences.filter(exp => isCertificationExp(exp));
    if (certItems.length) {
      return certItems.map((exp, idx) => ({
        id: exp.id || `cert-${idx}`,
        institution: exp.company || 'National Freelancing Training Program (NFTP)',
        title: exp.role || exp.title || 'Full Stack Training Certification',
        period: exp.period || 'Dec 09, 2022 – March 2023',
        logo: exp.logo || null,
        logoText: exp.company ? exp.company.split(' ').map(w => w[0]).join('').substring(0, 4).toUpperCase() : 'NFTP',
        description: exp.description || ''
      }));
    }
  }
  return defaultCertifications;
});

// ----------------------------------------------------------------------
// Skills Badges Data
// ----------------------------------------------------------------------
const defaultSkills = [
  { name: 'Laravel', icon: 'laravel' },
  { name: 'Vue.js', icon: 'vue' },
  { name: 'React', icon: 'react' },
  { name: 'TypeScript', icon: 'typescript' },
  { name: 'JavaScript', icon: 'javascript' },
  { name: 'PHP', icon: 'php' },
  { name: 'Node.js', icon: 'node' },
  { name: 'Next.js', icon: 'next' },
  { name: 'Inertia.js', icon: 'inertia' },
  { name: 'Tailwind CSS', icon: 'tailwind' },
  { name: 'PostgreSQL', icon: 'postgres' },
  { name: 'MySQL', icon: 'mysql' },
  { name: 'Docker', icon: 'docker' },
  { name: 'Redis', icon: 'redis' },
  { name: 'AWS S3', icon: 'aws' },
  { name: 'Git/GitHub', icon: 'git' },
];

const displaySkills = computed(() => {
  if (props.skills && props.skills.length > 0) {
    return props.skills.map(s => {
      let iconName = (s.icon || s.name || '').toLowerCase();
      if (iconName.includes('server') || iconName.includes('php') || iconName.includes('laravel')) iconName = 'laravel';
      else if (iconName.includes('vue')) iconName = 'vue';
      else if (iconName.includes('react')) iconName = 'react';
      else if (iconName.includes('tailwind')) iconName = 'tailwind';
      else if (iconName.includes('database') || iconName.includes('sql')) iconName = 'mysql';
      else if (iconName.includes('docker')) iconName = 'docker';
      else if (iconName.includes('git')) iconName = 'git';
      else if (iconName.includes('node')) iconName = 'node';
      else if (iconName.includes('js') || iconName.includes('javascript')) iconName = 'javascript';
      else if (iconName.includes('ts') || iconName.includes('typescript')) iconName = 'typescript';
      else if (iconName.includes('next')) iconName = 'next';
      else if (iconName.includes('inertia')) iconName = 'inertia';
      else if (iconName.includes('aws')) iconName = 'aws';
      else if (iconName.includes('redis')) iconName = 'redis';
      return {
        name: s.name || s.title,
        icon: iconName,
      };
    });
  }
  return defaultSkills;
});

const visibleSkills = computed(() => {
  if (showAllSkills.value) return displaySkills.value;
  return displaySkills.value.slice(0, 12);
});

// ----------------------------------------------------------------------
// Projects Data
// ----------------------------------------------------------------------
const displayedProjects = computed(() => {
  const list = props.projects || [];
  if (showAllProjects.value) return list;
  return list.slice(0, 6);
});

function getProjectTags(project) {
  const stack = project.tech_stack || project.technologies;
  if (Array.isArray(stack)) {
    return stack.slice(0, 5);
  }
  if (typeof stack === 'string') {
    try {
      const parsed = JSON.parse(stack);
      if (Array.isArray(parsed)) return parsed.slice(0, 5);
    } catch (e) {
      return stack.split(',').map(s => s.trim()).filter(Boolean).slice(0, 5);
    }
  }
  if (project.category) return [project.category];
  return ['Full Stack'];
}

function getProjectDemoUrl(project) {
  return project.demo_url || project.live_url || project.url || '';
}

function getProjectGithubUrl(project) {
  return project.github_url || project.repo_url || '';
}

function getProjectFallbackImage(project) {
  return 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=600&q=80';
}

function onProjectImgError(e) {
  if (e.target) {
    e.target.src = 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=600&q=80';
  }
}



function formatDate(dateStr) {
  if (!dateStr) return '';
  const d = new Date(dateStr);
  return d.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
}

// ----------------------------------------------------------------------
// Contact Section Data
// ----------------------------------------------------------------------
const calMeetingUrl = computed(() => {
  return props.settings?.cal_url || props.settings?.booking_url || 'https://cal.com/kashif-khan';
});

const contactEmail = computed(() => {
  return props.settings?.contact_email || 'kashif.tech.317@gmail.com';
});
</script>
