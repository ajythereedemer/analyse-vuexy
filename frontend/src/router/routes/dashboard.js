export default [
  {
    path: '/dashboard/analytics',
    name: 'dashboard-analytics',
    component: () => import('@/views/dashboard/analytics/Analytics.vue'),
  },
  {
    path: '/dashboard/ecommerce',
    name: 'dashboard-ecommerce',
    component: () => import('@/views/dashboard/ecommerce/Ecommerce.vue'),
  },
  {
    path: '/dashboard/multistep',
    name: 'dashboard-multistep',
    component: () => import('@/views/dashboard/multistep/multistep.vue'),
  },
  {
    path: '/dashboard/multistep-inner/:id',
    name: 'dashboard-multistep-update',
    component: () => import('@/views/dashboard/multistep/multistep-update.vue'),
  },
  {
    path: '/dashboard/multistep-inner',
    name: 'dashboard-multistep-insert',
    component: () => import('@/views/dashboard/multistep/multistep-insert.vue'),
  },
]
