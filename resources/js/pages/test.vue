<template>
  <div class="min-h-screen bg-slate-50">
    <!-- Header -->
    <header class="border-b border-slate-200 bg-white">
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-3xl font-semibold text-slate-900">Integrations</h1>
            <p class="mt-1 text-sm text-slate-600">Connect your favorite tools and services</p>
          </div>
          <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700">
            {{ connectedCount }} Connected

            {{ successMessage ?? 'nothing here' }}
          </span>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
      <!-- Search -->
      <div class="mb-8">
        <div class="relative">
          <Search class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" />
          <input v-model="searchQuery" type="text" placeholder="Search integrations..."
            class="w-full rounded-lg border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-900 placeholder-slate-500 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200" />
        </div>
      </div>

      <!-- Integration Cards Grid -->
      <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <div v-for="integration in filteredIntegrations" :key="integration.id"
          class="group relative overflow-hidden rounded-xl border border-slate-200 bg-white p-6 transition-all hover:shadow-lg">
          <!-- Badge -->
          <span v-if="integration.badge"
            class="absolute right-4 top-4 rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-medium text-indigo-700">
            {{ integration.badge }}
          </span>

          <!-- Icon -->
          <div
            class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-slate-100 text-slate-700 transition-colors group-hover:bg-indigo-50 group-hover:text-indigo-600">
            <component :is="integration.icon" class="h-6 w-6" />
          </div>

          <!-- Content -->
          <div class="mb-4">
            <h3 class="mb-2 text-lg font-semibold text-slate-900">{{ integration.name }}</h3>
            <p class="text-sm text-slate-600">{{ integration.description }}</p>
          </div>

          <!-- Connect/Disconnect Buttons -->
          <div v-if="connectedIntegrations.has(integration.id)" class="flex items-center justify-between gap-2">
            <div
              class="flex items-center gap-1.5 rounded-md bg-emerald-50 px-3 py-1.5 text-sm font-medium text-emerald-700">
              <Check class="h-3.5 w-3.5" />
              Connected
            </div>
            <button @click="handleDisconnect(integration.id)"
              class="h-8 rounded-md px-3 text-xs font-medium text-slate-600 transition-colors hover:bg-red-50 hover:text-red-600">
              Disconnect
            </button>
          </div>
          <button v-else @click="handleConnect(integration.id)"
            class="w-full rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-slate-800">
            Connect
          </button>
        </div>
      </div>

      <!-- Empty State -->
      <div v-if="filteredIntegrations.length === 0" class="py-12 text-center">
        <p class="text-slate-600">No integrations found matching your search.</p>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import {
  Search,
  Github,
  MessageSquare,
  Mail,
  FileText,
  Calendar,
  Database,
  Code2,
  Headphones,
  Lock,
  Check,
} from 'lucide-vue-next'

const integrations = [
  {
    id: 'slack',
    name: 'Slack',
    description: 'Team communication and notifications',
    icon: MessageSquare,
    connected: false,
  },
  {
    id: 'github',
    name: 'GitHub',
    description: 'Code repositories and version control',
    icon: Github,
    connected: true,
  },
  {
    id: 'gmail',
    name: 'Gmail',
    description: 'Email integration and sync',
    icon: Mail,
    connected: false,
  },
  {
    id: 'notion',
    name: 'Notion',
    description: 'Workspace and documentation',
    icon: FileText,
    connected: true,
  },
  {
    id: 'google-calendar',
    name: 'Google Calendar',
    description: 'Schedule and calendar management',
    icon: Calendar,
    connected: false,
  },
  {
    id: 'postgres',
    name: 'PostgreSQL',
    description: 'Database integration and queries',
    icon: Database,
    connected: false,
    badge: 'Popular',
  },
  {
    id: 'vscode',
    name: 'VS Code',
    description: 'Editor integrations and extensions',
    icon: Code2,
    connected: false,
  },
  {
    id: 'zendesk',
    name: 'Zendesk',
    description: 'Customer support and ticketing',
    icon: Headphones,
    connected: false,
  },
  {
    id: 'auth0',
    name: 'Auth0',
    description: 'Authentication and identity management',
    icon: Lock,
    connected: false,
    badge: 'Recommended',
  },
]

const searchQuery = ref('')
const connectedIntegrations = ref(new Set(integrations.filter((i) => i.connected).map((i) => i.id)))

const filteredIntegrations = computed(() => {
  return integrations.filter((integration) => {
    const matchesSearch =
      integration.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      integration.description.toLowerCase().includes(searchQuery.value.toLowerCase())
    return matchesSearch
  })
})

const connectedCount = computed(() => connectedIntegrations.value.size)

const handleConnect = (id) => {
  connectedIntegrations.value.add(id)
}

const handleDisconnect = (id) => {
  connectedIntegrations.value.delete(id)
}

const propsData = defineProps({
  successMessage: String
})
</script>